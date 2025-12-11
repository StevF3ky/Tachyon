<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    // Tambahkan bagian ini:
    protected $fillable = [
        'user_id',
        'thread_id',
        'content',
        'parent_id',
    ];

    // Relasi untuk Reply (Balasan)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    // Relasi Votes (Polymorphic)
    public function votes()
    {
        return $this->morphMany(Vote::class, 'votable');
    }

    // Helper untuk hitung skor
    public function getScoreAttribute()
    {
        return $this->votes->sum('value');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}