<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $clients = Client::paginate();

        return ClientResource::collection($clients);
    }

    public function show(Client $client): ClientResource
    {
        $client->load('books');

        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request): JsonResponse
    {
        $client = Client::create($request->validated());

        return (new ClientResource($client))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Client $client): JsonResponse
    {
        $client->delete();

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
