<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Trailer extends Model
{
    protected $table = 'trailers';
    CONST TRAILER_FOLDER = '/uploads/movie/trailer/';
    CONST TRAILER_480_FOLDER = '/uploads/movie/trailer/480/';
    CONST TRAILER_720_FOLDER = '/uploads/movie/trailer/720/';
    public function movie()
    {
        return $this->belongsTo(Movie::class)->withTimestamps();
    }

    public static function _remove(Trailer $trailer) {
        if (!filter_var($trailer->video_url, FILTER_VALIDATE_URL)) {
            Storage::disk('my_upload')->delete(
                [
                    self::TRAILER_FOLDER . $trailer->video_url,
                    self::TRAILER_480_FOLDER . $trailer->video_url,
                    self::TRAILER_720_FOLDER . $trailer->video_url
                ]);
        }
        $trailer->delete();
    }
}
