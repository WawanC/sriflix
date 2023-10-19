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
        Schema::create('movie_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string("comment")->nullable(true);
            $table->integer("rating");
            $table->uuid("movie_id");
            $table->foreign("movie_id")->references("id")->on("movies")
                ->onDelete('cascade')->onUpdate('cascade');
            $table->uuid("user_id");
            $table->foreign("user_id")->references("id")->on("users")
                ->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_reviews');
    }
};
