<?php

namespace Database\Factories;

use App\Enums\BookStatus;
use App\Models\Book;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => fake()->word(),
            'author' => fake()->name(),
            'publication_year' => fake()->year(),
            'publisher' => fake()->company(),
            'status' => fake()->randomElement(BookStatus::cases()),

            'client_id' => function (array $attributes) {
                return $attributes['status'] === BookStatus::BORROWED ? Client::factory() : null;
            },
        ];
    }
}
