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
        Schema::create('seri_penulis', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('seri_id')->index();
            $table->integer('penulis_id')->index();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('seri_id')->references('id')->on('seri');
            $table->foreign('penulis_id')->references('id')->on('penulis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seri_penulis');
    }
};
