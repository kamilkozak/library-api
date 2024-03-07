<?php

namespace Tests\Feature;

use App\Enums\BookStatus;
use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Models\Client;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class BookTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_books_can_be_listed(): void
    {
        $books = Book::factory()->count(2)->create();

        $response = $this->getJson(action([BookController::class, 'index']));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount($books->count(), 'data');
    }

    public function test_book_can_be_shown(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson(action([BookController::class, 'show'], $book));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('data.title', $book->title);
    }

    public function test_book_can_be_borrowed(): void
    {
        $book = Book::factory()->create(['status' => BookStatus::AVAILABLE]);
        $client = Client::factory()->create();

        $response = $this->putJson(action([BookController::class, 'borrow'], $book), ['client_id' => $client->id]);

        $response->assertStatus(Response::HTTP_ACCEPTED);
        $response->assertJsonPath('data.title', $book->title);
        $response->assertJsonPath('data.client.last_name', $client->last_name);
    }

    public function test_unreturned_book_cannot_be_borrowed(): void
    {
        $book = Book::factory()->create(['status' => BookStatus::BORROWED]);
        $client = Client::factory()->create();

        $response = $this->putJson(action([BookController::class, 'borrow'], $book), ['client_id' => $client->id]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_book_can_be_returned(): void
    {
        $book = Book::factory()->create(['status' => BookStatus::BORROWED]);

        $response = $this->putJson(action([BookController::class, 'return'], $book));

        $response->assertStatus(Response::HTTP_ACCEPTED);
        $response->assertJsonPath('data.title', $book->title);
        $response->assertJsonPath('data.client', null);
    }
}
