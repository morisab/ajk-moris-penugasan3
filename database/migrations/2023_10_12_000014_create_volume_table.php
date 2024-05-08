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
        Schema::create('volume', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('seri_id');
            $table->integer('volume');
            $table->integer('jumlah_tersedia');
            $table->integer('harga_sewa');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('seri_id')->references('id')->on('seri');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volume');
    }
};
