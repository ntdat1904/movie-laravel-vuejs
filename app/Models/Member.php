<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Member extends Model
{
    CONST ROOT_FOLDER = '/files/';

    protected $table = "members";

    protected $fillable = [
        'country_id',
        'weight',
        'height',
        'avatar_url',
        'introduce',
        'name',
        'type'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function memberMovie()
    {
        return $this->hasMany(MemberMovie::Class, 'member_id');
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'member_movies', 'member_id', 'movie_id')->withTimestamps();
    }

    CONST TYPE = [
        1 => 'Actor',
        2 => 'Director',
    ];

    CONST FIELD_SORT = [
        'id' => 'members.id',
        'type' => 'members.type',
        'name' => 'members.name',
        'country' => 'countries.name',
        'height' => 'members.height',
        'weight' => 'members.weight',
    ];

    CONST SORT_TYPE = [
        'asc' => 'ASC',
        'desc' => 'DESC'
    ];

    protected function getListMember($filter = array())
    {
        $members = self::leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', DB::raw($this->getRawType()), 'members.name', 'members.avatar_url',
                'countries.name as country', 'members.height', 'members.weight');

        if (isset(self::FIELD_SORT[$filter['field_sort']])) {
            $members = $members->orderBy(self::FIELD_SORT[$filter['field_sort']], self::SORT_TYPE[$filter['sort_type']] ?? 'ASC');
        } else {
            $members = $members->orderBy(self::FIELD_SORT['id'], 'ASC');
        }

        $members = $members->paginate($filter['per_page'] ?? 5);
        return $members;
    }

    private function getRawType()
    {
        $query = "CASE ";
        foreach (self::TYPE as $key => $value) {
            $query .= "WHEN members.type = " . $key . " THEN '" . $value . "' ";
        }
        $query .= "ELSE 'Undefined' ";
        $query .= "END as type ";
        return $query;
    }

    protected function getListMovieByMember($id)
    {
        $detail = self::join('member_movies', 'member_movies.member_id', 'members.id')
            ->join('movies', 'movies.id', 'member_movies.movie_id')
            ->leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', 'members.type', 'members.name', 'members.avatar_url', 'movies.id as movie_id', 'movies.avatar_url as movie_avatar_url',
                'members.country_id', 'countries.name as country_name', 'movies.native_name as movie_name', 'member_movies.name_in_movie as name_in_movie', 'members.introduce', 'members.height', 'members.weight')
            ->where('member_movies.member_id', $id)
            ->paginate(4);
        return $detail;
    }

    protected function getListMovieByMember_v2()
    {
        $detail = self::join('member_movies', 'member_movies.member_id', 'members.id')
            ->join('movies', 'movies.id', 'member_movies.movie_id')
            ->leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', 'members.type', 'members.name', 'members.avatar_url', 'movies.id as movie_id', 'movies.avatar_url as movie_avatar_url',
                'members.country_id', 'countries.name as country_name', 'movies.native_name as movie_name', 'member_movies.name_in_movie as name_in_movie', 'members.introduce', 'members.height', 'members.weight')
            ->get();
        return $detail;
    }


    protected function getList()
    {
        $detail = self::leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', 'members.type', 'members.name', 'members.avatar_url',
                'members.country_id', 'countries.name as country_name', 'members.introduce', 'members.height', 'members.weight')->get();
        return $detail;
    }


    protected function buildMembers($params)
    {
        $members = Member::leftJoin('countries', 'members.country_id', '=', 'countries.id')
            ->select('members.id', 'members.type', 'members.name', 'members.avatar_url',
                'members.country_id', 'countries.name as country_name', 'members.introduce', 'members.height', 'members.weight');
        foreach ($params->all() as $key => $item) {
            switch ($key) {
                case 'id':
                    $members = $members->where('members.id', $item);
                    break;
                case 'name':
                    $members = $members->where('members.name', 'like', sprintf("%%%s%%", trim($item)));
                    break;
                case 'country':
                    $members = $members->where('countries.name', 'like', sprintf("%%%s%%", trim($item)));
                    break;
                case 'type':
                    $members = $members->where('members.type', $item);
                    break;
                case 'height':
                    $members = $members->where('members.height', '>=', $item);
                    break;
                case 'weight':
                    $members = $members->where('members.weight', '>=', $item);
                    break;
                case 'to':
                    $members = $members->where('members.created_at', '<=', $item);
                    break;
                case 'from':
                    $members = $members->where('members.created_at', '>=', $item);
                    break;
            }
        }
        if (!empty($params['sort']) && !empty($params['order'])) {
            $members = $members->orderBy($params['order'], $params['sort']);
        }
        $members = $members->paginate($params['per_page'] ?? 5);
        if ($members->lastPage() < $members->currentPage()) {
            $params['page'] = $members->lastPage();
            $members = self::buildMembers($params);
        }
        foreach ($members as $member) {
            $member->img = false;
            if (!empty($member->avatar_url) && Storage::disk('my_upload')->exists(str_replace(self::ROOT_FOLDER, '', $member->avatar_url))) {
                $member->img = true;
            }
        }
        return $members;
    }
}
