<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberMovie extends Model
{
    protected $table = "member_movies";

    public function member()
    {
        return $this->belongsTo(Member::Class, 'member_id');
    }
}
