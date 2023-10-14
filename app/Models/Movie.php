<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        "title", "description", "picture_url", "video_url"
    ];

    public function movie_reviews(): HasMany
    {
        return $this->hasMany(MovieReview::class);
    }
}
