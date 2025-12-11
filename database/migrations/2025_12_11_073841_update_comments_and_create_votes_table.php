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
        // 1. Update Comments Table (Tambah kolom parent_id untuk Reply)
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
        });

        // 2. Buat Table Votes (Polymorphic: Bisa untuk Thread maupun Comment)
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Kolom ini yang bikin dia bisa nempel ke Thread ATAU Comment
            $table->unsignedBigInteger('votable_id');
            $table->string('votable_type'); // Isinya nanti 'App\Models\Thread' atau 'App\Models\Comment'
            
            $table->tinyInteger('value'); // 1 untuk Upvote/Like, -1 untuk Downvote
            $table->timestamps();
            
            // Mencegah user vote 2x di item yang sama
            $table->unique(['user_id', 'votable_id', 'votable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
