<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Movie extends Model
{
    use HasUuids;

    public $timestamps = false;

    protected $fillable = [
        "title", "description", "picture_url", "video_url", "backdrop_url"
    ];

    public function movie_reviews(): HasMany
    {
        return $this->hasMany(MovieReview::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, "movie_genres_pivot");
    }

    public function featured_movie(): HasOne
    {
        return $this->hasOne(FeaturedMovie::class);
    }
}
