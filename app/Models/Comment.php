<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $table = "comments";

    protected $fillable = [
        'user_id',
        'movie_id',
        'content',
        'comment_id',
        'status',
    ];
    CONST status = [
        0 => 'active',
        1 => 'Tin nhắn đã bị gỡ!',
        2 => 'Tin nhắn đã bị ẩn do không phù hợp!',
    ];

    public function children()
    {
        return $this->belongsTo(self::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function listComments($movie_id,$record) {
        $comments =  self::select(['comments.*','users.name as author', 'users.avatar_url as avatar_url'])
        ->leftjoin('users','comments.user_id','users.id')
            ->where('comments.movie_id',$movie_id)
            ->where('comments.comment_id',0)
            ->where('comments.status',0)
            ->orderby('comments.created_at')
            ->paginate($record);
        foreach ( $comments as $comment) {
            $comment['child'] = self::select(['comments.*','users.name as author', 'users.avatar_url as avatar_url'])
                ->leftjoin('users','comments.user_id','users.id')
                ->where('comments.comment_id',$comment->id)
                ->where('comments.status',0)
                ->orderby('comments.created_at')
                ->paginate(5);
        }

        return $comments;
    }


    public static function listChildComments($comment_id,$record = 5) {
        $comments =  self::select(['comments.*','users.name as author', 'users.avatar_url as avatar_url'])
            ->leftjoin('users','comments.user_id','users.id')
            ->where('comments.comment_id',$comment_id)
            ->where('comments.status',0)
            ->orderby('comments.created_at')
            ->paginate($record);

        return $comments;
    }
//    public function getAuthorAttribute()
//    {
//        $user_id = $this->attributes['user_id'];
//        $user = User::select('name')->find($user_id);
//        return $user->name;
//    }

}
