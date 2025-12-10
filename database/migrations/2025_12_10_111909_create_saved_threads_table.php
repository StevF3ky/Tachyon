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
    Schema::create('saved_threads', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('thread_id')->constrained()->onDelete('cascade');
        $table->timestamps();

        // Mencegah duplikat (user tidak bisa save thread yang sama 2x)
        $table->unique(['user_id', 'thread_id']);
    });
}

    public function down(): void
    {
        Schema::dropIfExists('saved_threads');
    }
};
