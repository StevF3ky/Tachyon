<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
        public function thread()
    {
        // Comment dimiliki oleh satu Thread
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        // Comment dimiliki oleh satu User
        return $this->belongsTo(User::class);
    }
}
