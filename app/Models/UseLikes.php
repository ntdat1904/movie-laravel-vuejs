<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UseLikes extends Model
{
    protected $table = 'user_likes';
    protected $fillable = [
        'user_id', 'movie_id', 'point'
    ];
}
