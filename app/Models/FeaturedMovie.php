<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeaturedMovie extends Model
{
    use HasUuids;

    public $timestamps = false;
    protected $fillable = ['movie_id'];

    public function movies(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }
}
