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
        Schema::create('peminjaman_volume', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('peminjaman_id')->index();
            $table->integer('volume_id')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('peminjaman_id')->references('id')->on('peminjaman');
            $table->foreign('volume_id')->references('id')->on('volume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_volume');
    }
};
