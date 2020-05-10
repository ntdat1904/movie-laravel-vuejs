<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Movie extends Model
{
    //
    public $timestamps = true;
    const optionYear = [
        '2019' => 2019,
        '2018' => 2018,
        '2017' => 2017,
        '2016' => 2016,
    ];
    protected $fillable =
        [
            'native_name',
            'id',
            'vietnamese_name',
            'avatar_url',
            'introduce',
            'has_movie',
            'IMDb_scores',
            'episode_number_current',
            'episode_number',
            'realease_year',
            'time',
            'quality',
            'resolution',
            'type_language',
            'form',
            'production_company',
            'country_id',
        ];
    const optionLanguage = [
        'EN' => 'English',
        'Sub' => 'Viet-Sub',
    ];
    const optionSort = [
        'number_view' => 'Lượt xem nhiều',
        'created_at' => 'Ngày thêm phim',
    ];
    const optionForm = [
        'Set' => 'Phim Bộ',
        'Odd' => 'Phim Lẻ',
    ];
    protected $table = 'movies';

    public function episode()
    {
        return $this->hasOne(Episode::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_movies', 'movie_id', 'category_id')->withTimestamps();
    }

    public function person()
    {
        return $this->belongsToMany(Person::class, 'movie_person', 'movie_id', 'person_id');
    }

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'country_movies', 'movie_id', 'country_id')->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_movies', 'movie_id', 'tag_id')->withTimestamps();
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'member_movies', 'movie_id', 'member_id')->withTimestamps();
    }

    public function trailer()
    {
        return $this->hasMany(Trailer::class);
    }


    public function memberMovie()
    {
        return $this->hasMany(MemberMovie::class, 'movie_id');
    }

    public function delete()
    {
        $this->tags()->detach();
        $this->countries()->detach();
        $this->categories()->detach();
        $this->trailer()->delete();
        $this->episode()->delete();

        // delete the user
        return parent::delete();
    }

    protected function index()
    {
        $index = self::join('member_movies', 'member_movies.member_id', 'members.id')
            ->join('movies', 'movies.id', 'member_movies.movie_id')
            ->leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', 'members.type', 'members.name', 'members.avatar_url', 'movies.id as movie_id', 'movies.avatar_url as movie_avatar_url',
                'members.country_id', 'countries.name as country_name', 'movies.native_name as movie_name', 'member_movies.name_in_movie as name_in_movie', 'members.introduce', 'members.height', 'members.weight')
            ->get();
        return $index;
    }

    protected function getListMemberByMovie($id)
    {
        $detail = self::join('member_movies', 'member_movies.movie_id', 'movies.id')
            ->join('members', 'members.id', 'member_movies.member_id')
            ->leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', 'members.type', 'members.name', 'members.avatar_url', 'movies.id as movie_id', 'movies.avatar_url as movie_avatar_url',
                'members.country_id', 'countries.name as country_name', 'movies.native_name as movie_name', 'member_movies.name_in_movie as name_in_movie', 'members.introduce', 'members.height', 'members.weight')
            ->where('member_movies.movie_id', $id)
            ->get();
        return $detail;
    }

    public static function builderMovie($params = array())
    {
        $query = self::select(['movies.native_name', 'movies.vietnamese_name', 'movies.id', 'movies.id'
            , 'movies.realease_year', 'movies.avatar_url', 'movies.production_company', 'movies.quality', 'movies.resolution', 'movies.type_language',
            'movies.created_at'])
            ->leftJoin('tag_movies', 'movies.id', 'tag_movies.movie_id')
            ->leftJoin('tags', 'tags.id', 'tag_movies.tag_id')
            ->leftJoin('member_movies', 'movies.id', 'member_movies.movie_id')
            ->leftJoin('members', 'members.id', 'member_movies.member_id')
            ->leftJoin('category_movies', 'movies.id', 'category_movies.movie_id')
            ->leftJoin('categories', 'categories.id', 'category_movies.category_id')
            ->leftJoin('country_movies', 'movies.id', 'country_movies.movie_id')
            ->leftJoin('countries', 'countries.id', 'country_movies.country_id');
        foreach ($params as $key => $item) {
            if (!empty($item)) {
                switch ($key) {
                    case 'form':
                        $query = $query->where('movies.form', $item);
                        break;
                    case 'language':
                        $query = $query->where('movies.type_language', $item);
                        break;
                    case 'category':
                        $query = $query->where('categories.name', $item);
                        break;
                    case 'country':
                        $query = $query->where('countries.name', $item);
                        break;
                    case 'q':
                        $query = $query->where('movies.native_name', 'like', sprintf("%%%s%%", trim($item)))
                            ->orWhere('movies.vietnamese_name', 'like', sprintf("%%%s%%", trim($item)))
                            ->orWhere('members.name', 'like', sprintf("%%%s%%", trim($item)))
                            ->orWhere('movies.production_company', 'like', sprintf("%%%s%%", trim($item)));
                        break;
                    case 'year':
                        $query = $query->where('movies.realease_year', $item);
                        break;
                    case 'tag':
                        $query = $query->where('tags.name', 'like', $item);
                        break;
                }
            }
        }
        if (!empty($params['sort'])) {
            $query->OrderBy($params['sort']);
        }
        $query->groupBy(['movies.native_name', 'movies.vietnamese_name', 'movies.id', 'movies.id',
            'movies.realease_year', 'movies.created_at', 'movies.production_company', 'movies.quality', 'movies.resolution',
            'movies.type_language', 'movies.avatar_url']);
        return $query;
    }


    protected function _buildMoviesAdmin($params)
    {
        $movies = self::select(
            ['movies.native_name', 'movies.vietnamese_name', 'movies.id', 'movies.id', 'movies.realease_year', 'movies.avatar_url',
                'movies.production_company', 'movies.quality', 'movies.resolution', 'movies.type_language', 'movies.created_at',
                DB::raw("(select GROUP_CONCAT(c.name) from countries c join country_movies cm on c.id = cm.country_id where cm.movie_id = movies.id group by cm.movie_id) as countries_name")])
            ->leftJoin('tag_movies', 'movies.id', 'tag_movies.movie_id')
            ->leftJoin('tags', 'tags.id', 'tag_movies.tag_id')
            ->leftJoin('member_movies', 'movies.id', 'member_movies.movie_id')
            ->leftJoin('members', 'members.id', 'member_movies.member_id')
            ->leftJoin('category_movies', 'movies.id', 'category_movies.movie_id')
            ->leftJoin('categories', 'categories.id', 'category_movies.category_id')
            ->leftJoin('country_movies', 'movies.id', 'country_movies.movie_id')
            ->leftJoin('countries', 'countries.id', 'country_movies.country_id');
        foreach ($params->all() as $key => $item) {
            switch ($key) {
                case 'id':
                    $movies = $movies->where('movies.id', $item);
                    break;
                case 'IMDb_scores':
                    $movies = $movies->where('movies.IMDb_scores', '>=', $item);
                    break;
                case 'resolution':
                    $movies = $movies->where('movies.resolution', $item);
                    break;
                case 'quality':
                    $movies = $movies->where('movies.quality', $item);
                    break;
                case 'free_word':
                    $movies = $movies->where('movies.native_name', 'like', sprintf("%%%s%%", trim($item)))
                        ->orWhere('movies.vietnamese_name', 'like', sprintf("%%%s%%", trim($item)))
                        ->orWhere('movies.production_company', 'like', sprintf("%%%s%%", trim($item)))
                        ->orWhere('countries.name', 'like', sprintf("%%%s%%", trim($item)))
                        ->orWhere('movies.realease_year', $item);
                    break;
                case 'to':
                    $movies = $movies->where('movies.created_at', '<=', $item);
                    break;
                case 'from':
                    $movies = $movies->where('movies.created_at', '>=', $item);
                    break;
            }
        }
        if (!empty($params['sort']) && !empty($params['order'])) {
            $movies = $movies->orderBy($params['order'], $params['sort']);
        } else {
            $movies = $movies->orderBy('id', 'DESC');
        }
        $movies->groupBy(['movies.native_name', 'movies.vietnamese_name', 'movies.id', 'movies.id',
            'movies.realease_year', 'movies.created_at', 'movies.production_company', 'movies.quality', 'movies.resolution',
            'movies.type_language', 'movies.avatar_url']);
        $movies = $movies->paginate($params['per_page'] ?? 5);
        if ($movies->lastPage() < $movies->currentPage()) {
            $params['page'] = $movies->lastPage();
            $movies = self::_buildMoviesAdmin($params);
        }
        return $movies;
    }
}
