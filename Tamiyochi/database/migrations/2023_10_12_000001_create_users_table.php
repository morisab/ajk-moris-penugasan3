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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('kabupaten_id')->index();
            $table->string('name', 128);
            $table->string('email', 128)->index();
            $table->string('no_telp', 128);
            $table->string('user_type', 128);
            $table->integer('age');
            $table->string('image_url', 128);
            $table->string('password', 64);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('kabupaten_id')->references('id')->on('kabupaten');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
