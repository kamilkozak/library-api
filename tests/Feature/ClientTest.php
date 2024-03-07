<?php

namespace Tests\Feature;

use App\Http\Controllers\ClientController;
use App\Models\Client;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class ClientTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_clients_can_be_listed(): void
    {
        $clients = Client::factory()->count(2)->create();

        $response = $this->getJson(action([ClientController::class, 'index']));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonCount($clients->count(), 'data');
    }

    public function test_client_can_be_shown(): void
    {
        $client = Client::factory()->create();

        $response = $this->getJson(action([ClientController::class, 'show'], ['client' => $client->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonPath('data.last_name', $client->last_name);
    }

    public function test_client_can_be_created(): void
    {
        $clientData = Client::factory()->make()->toArray();

        $response = $this->postJson(action([ClientController::class, 'store']), $clientData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonPath('data.last_name', $clientData['last_name']);
    }

    public function test_client_can_be_deleted(): void
    {
        $client = Client::factory()->create();

        $response = $this->deleteJson(action([ClientController::class, 'destroy'], $client));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertSoftDeleted(Client::class, ['last_name' => $client->last_name]);
    }
}
