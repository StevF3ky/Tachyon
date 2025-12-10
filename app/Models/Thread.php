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
        return $this->hasMany(Comment::class);
    }
}