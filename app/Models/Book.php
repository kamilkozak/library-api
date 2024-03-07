<?php

namespace App\Models;

use App\Enums\BookStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $author
 * @property int $publication_year
 * @property string $publisher
 * @property int|null $client_id
 * @property BookStatus $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Client|null $client
 *
 * @method static \Database\Factories\BookFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Book newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Book query()
 *
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['status' => BookStatus::class];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
