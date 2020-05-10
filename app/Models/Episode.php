<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Episode extends Model
{
    //
    CONST EPISODE_FOLDER = '/uploads/movie/episode/';
    CONST EPISODE_480_FOLDER = '/uploads/movie/episode/480/';
    CONST EPISODE_720_FOLDER = '/uploads/movie/episode/720/';
    protected $table = 'episodes';
    protected $fillable = ['episode','video_url'];
    public function movie()
    {
        return $this->hasOne(Movie::class);
    }

    public static function _remove(Episode $episode) {
        if (!filter_var($episode->video_url, FILTER_VALIDATE_URL)) {
            Storage::disk('my_upload')->delete(
                [
                    self::EPISODE_FOLDER . $episode->video_url,
                    self::EPISODE_480_FOLDER . $episode->video_url,
                    self::EPISODE_720_FOLDER . $episode->video_url
                ]);
        }
        $episode->delete();
    }
}
