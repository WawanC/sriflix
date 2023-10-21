<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movie_genres_pivot', function (Blueprint $table) {
            $table->uuid("movie_id");
            $table->integer("movie_genre_id");
            $table->foreign("movie_id")->references("id")->on("movies")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("movie_genre_id")->references("id")->on("movie_genres")->onDelete("cascade")->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_genres_pivot');
    }
};
