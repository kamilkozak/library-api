<?php

namespace App\Http\Controllers;

use App\Enums\BookStatus;
use App\Http\Requests\BorrowBookRequest;
use App\Http\Resources\IndexBookResource;
use App\Http\Resources\ShowBookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class BookController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $books = QueryBuilder::for(Book::class)
            ->allowedFilters([
                AllowedFilter::exact('title'),
                AllowedFilter::exact('author'),
                AllowedFilter::exact('client.first_name'),
                AllowedFilter::exact('client.last_name'),
            ])
            ->with('client');

        return IndexBookResource::collection($books->paginate(config('app.per_page')));
    }

    public function show(Book $book): ShowBookResource
    {
        $book->load('client');

        return new ShowBookResource($book);
    }

    public function borrow(BorrowBookRequest $request, Book $book): JsonResponse
    {
        if ($book->status === BookStatus::BORROWED) {
            throw new UnprocessableEntityHttpException('This book is already borrowed.');
        }

        $book->client_id = $request->validated('client_id');
        $book->status = BookStatus::BORROWED;
        $book->save();
        $book->load('client');

        return (new ShowBookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function return(Book $book): JsonResponse
    {
        $book->client_id = null;
        $book->status = BookStatus::AVAILABLE;
        $book->save();

        return (new ShowBookResource($book))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
