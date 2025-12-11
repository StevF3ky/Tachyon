<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type', // <-- Tambahkan ini
        'title',
        'category_id',
        'content',
        'image',
        'tags',
    ];

    // Relasi: Setiap thread dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        // Setiap Thread memiliki banyak Comment/Reply
        return $this->hasMany(Comment::class)->latest();
    }
    // Relasi ke User yang me-like thread ini
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'thread_id', 'user_id');
    }

    // Cek apakah user yang sedang login sudah like
    public function isLikedBy($user)
    {
        if (!$user) return false;
        return $this->likes->contains('id', $user->id);
    }

    // Relasi Votes (Polymorphic) menggantikan likes() yang lama
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // Helper hitung skor (Upvote - Downvote)
    public function getScoreAttribute()
    {
        return $this->votes->sum('value'); // Menjumlahkan semua +1 dan -1
    }
}