<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $fillable = ['user_id', 'votable_id', 'votable_type', 'value'];

    // Relasi Polymorphic
    public function votable()
    {
        return $this->morphTo();
    }
}