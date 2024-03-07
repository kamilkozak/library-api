<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Book */
class ShowBookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'author' => $this->author,
            'publication_year' => $this->publication_year,
            'publisher' => $this->publisher,
            'status' => $this->status,

            'client' => new ClientResource($this->whenLoaded('client')),
        ];
    }
}
