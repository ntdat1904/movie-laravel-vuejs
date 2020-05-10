<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    //
    protected $fillable = [
        'use_id', 'url'
    ];
    public $timestamps = true;

}
