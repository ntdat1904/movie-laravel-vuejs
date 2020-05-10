<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use DB;

class Category extends Model
{
    protected $fillable = ['name', 'number_order'];

    //
    public function movie()
    {
        return $this->belongsToMany(Movie::class, 'category_movies', 'category_id', 'movie_id');
    }

    protected function insertCategoryMoive($movies, $id)
    {
        foreach ($movies as $movie) {
            DB::table('category_movies')->insert([
                [
                    'category_id' => $id,
                    'movie_id' => $movie,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]);
        }
    }

    protected function updateCategoryMovie($movies, $oldmovie, $id)
    {
        foreach ($oldmovie as $movie) {
            DB::table('category_movies')
                ->where([
                    ['category_id', '=', $id],
                    ['movie_id', '=', $movie],
                ])
                ->delete();
        }
        foreach ($movies as $movie) {
            DB::table('category_movies')->insert([
                [
                    'category_id' => $id,
                    'movie_id' => $movie,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
            ]);
        }
    }

    protected function listCategory($limit)
    {
        return self::select('categories.name', DB::raw('COUNT(category_movies.movie_id) as total'))
            ->join('category_movies', 'category_movies.category_id', 'categories.id')
            ->join('movies', 'movies.id', 'category_movies.movie_id')
            ->limit($limit)
            ->groupBy('categories.name')
            ->orderBy('total', 'DESC')
            ->get();
    }

    protected function buildCategories($params)
    {
        $categories = Category::select('*');
        foreach ($params->all() as $key => $item) {
            switch ($key) {
                case 'id':
                    $categories = $categories->where('categories.id', $item);
                    break;
                case 'name':
                    $categories = $categories->where('categories.name', 'like', sprintf("%%%s%%", trim($item)));
                    break;
                case 'number_order':
                    $categories = $categories->where('categories.number_order', $item);
                    break;
                case 'to':
                    $categories = $categories->where('categories.created_at', '<=', $item);
                    break;
                case 'from':
                    $categories = $categories->where('categories.created_at', '>=', $item);
                    break;
            }
        }
        if (!empty($params['sort']) && !empty($params['order'])) {
            $categories = $categories->orderBy($params['order'], $params['sort']);
        }
        $categories = $categories->paginate($params['per_page'] ?? 5);
        if ($categories->lastPage() < $categories->currentPage()) {
            $params['page'] = $categories->lastPage();
            $categories = self::buildCategories($params);
        }
        return $categories;
    }

    protected function getAll()
    {
        return self::all();
    }
}
