<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovieReview extends Model
{
    use HasUuids;

    protected $fillable = ["comment", "rating", "movie_id", "user_id"];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
