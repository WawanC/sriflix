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
        Schema::create('featured_movies', function (Blueprint $table) {
            $table->uuid("id")
                ->primary();
            $table->uuid("movie_id");
            $table->foreign("movie_id")
                ->references("id")
                ->on("movies")
                ->onDelete("cascade")
                ->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('featured_movies');
    }
};
