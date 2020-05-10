<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use DB;

class Tag extends Model
{
    public function movie() {
        return $this->belongsToMany(Movie::class, 'tag_movies', 'tag_id', 'movie_id');
    }
    protected function insertTagMoive($movies, $id)
    {
        foreach ($movies as $movie) {
            DB::table('tag_movies')->insert([
                [
                    'tag_id' => $id,
                    'movie_id' => $movie,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]);
        }
    }
    protected function updateTagMoive($movies,$oldmovie, $id)
    {
        foreach ($oldmovie as $movie) {
            DB::table('tag_movies')
                ->where([
                    ['tag_id', '=', $id],
                    ['movie_id', '=', $movie],
                ])
                ->delete();
        }
        foreach ($movies as $movie) {
            DB::table('tag_movies')->insert([
                [
                    'tag_id' => $id,
                    'movie_id' => $movie,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]);
        }
    }

    protected function _buildTags($params) {
        $tags = Tag::select('*');
        foreach ($params->all() as $key => $item) {
            switch ($key) {
                case 'id':
                    $tags = $tags->where('tags.id', $item);
                    break;
                case 'name':
                    $tags = $tags->where('tags.name', 'like', sprintf("%%%s%%", trim($item)));
                    break;
                case 'to':
                    $tags = $tags->where('tags.created_at', '<=', $item);
                    break;
                case 'from':
                    $tags = $tags->where('tags.created_at', '>=', $item);
                    break;
            }
        }
        if (!empty($params['sort']) && !empty($params['order'])) {
            $tags = $tags->orderBy($params['order'], $params['sort']);
        }
        $tags = $tags->paginate($params['per_page'] ?? 5);
        if ($tags->lastPage() < $tags->currentPage()) {
            $params['page'] = $tags->lastPage();
            $tags = self::_buildTags($params);
        }
        return $tags;
    }

    protected function getAll()
    {
        return self::all();
    }
}
