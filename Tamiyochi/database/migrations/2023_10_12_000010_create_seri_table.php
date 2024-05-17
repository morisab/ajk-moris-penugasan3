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
        Schema::create('seri', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('penerbit_id');
            $table->string('judul', 128);
            $table->text('sinopsis');
            $table->string('tahun_terbit', 128);
            $table->string('skor', 128);
            $table->string('foto', 128);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('penerbit_id')->references('id')->on('penerbit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seri');
    }
};
