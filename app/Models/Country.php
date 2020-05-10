<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Country extends Model
{
    protected $table = 'countries';
    public function member()
    {
        return $this->hasMany(Member::Class, 'country_id');
    }
    public function movie()
    {
        return $this->belongsToMany(Movie::class, 'country_movies', 'country_id', 'movie_id');
    }

    protected function getListCountry()
    {
        return self::select('countries.name', DB::raw('COUNT(country_movies.movie_id) as total'))
            ->join('country_movies', 'country_movies.country_id', 'countries.id')
            ->join('movies', 'movies.id', 'country_movies.movie_id')
            ->limit(10)
            ->groupBy('country_movies.country_id')
            ->get();
    }


    protected function listCountries($limit)
    {
        return self::select('countries.name', DB::raw('COUNT(country_movies.movie_id) as total'))
            ->join('country_movies', 'country_movies.country_id', 'countries.id')
            ->join('movies', 'movies.id', 'country_movies.movie_id')
            ->limit($limit)
            ->groupBy('countries.name')
            ->orderBy('total','DESC')
            ->get();
    }
}
