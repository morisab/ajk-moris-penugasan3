<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seri_genre', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('seri_id')->index();
            $table->integer('genre_id')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('seri_id')->references('id')->on('seri');
            $table->foreign('genre_id')->references('id')->on('genre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seri_genre');
    }
};
