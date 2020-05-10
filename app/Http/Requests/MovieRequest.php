<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function all($input = [])
    {
        $input = parent::all();
        $route = parent::route()->getName();
        $episodes = [];
        switch ($route) {
            case 'admin.movie.create':
                $episodes = explode(',', $input['episodes']);
                break;
            case 'admin.movie.edit':
                foreach (json_decode($input['episodes']) as $item) {
                    $episodes[] = [
                        'video_url' => $item->value,
                        'episode' => $item->name
                    ];
                }
                break;
        }
        $trailers = explode(',', $input['trailers']);

        $input['episodes'] = $episodes;
        $input['trailers'] = $trailers;
        return $input;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->all();
        $route = $this->route()->getName();
        switch ($route) {
            case 'admin.movie.create':
                $val = [
                    'native_name' => 'required|unique:movies,native_name,',
                    'vietnamese_name' => 'required|unique:movies,vietnamese_name,',
                    'IMDb_scores' => 'required|numeric',
                    'avatar_url' => 'required|sometimes|image|mimes:jpeg,jpg,png',
                    'episode_number_current' => 'required|numeric',
                    'episode_number' => 'required',
                    'realease_year' => 'required',
                    'time' => 'required|numeric',
                    'introduce' => 'required',
                    'production_company' => 'required',
                    'form' => 'required',
                    'type_language' => 'required',
                    'resolution' => 'required',
                    'quality' => 'required',
                    'countries' => 'required',
                    'tags' => 'required',
                    'categories' => 'required',
                    'has_movie' => 'required',
                ];
                foreach ($data['episodes'] as $episode) {
                    if (!empty($episode) && !Storage::disk('my_upload')->exists('uploads/draft/' . $episode)) {
                        $val = array_merge($val, ['episodes.*' => 'url']);
                    }
                }

                foreach ($data['trailers'] as $trailer) {
                    if (!empty($trailer) && !Storage::disk('my_upload')->exists('uploads/draft/' . $trailer)) {
                        $val = array_merge($val, ['trailers.*' => 'url']);
                    }
                }
                return $val;
                break;
            case 'admin.movie.edit':
                $val = [
                    'native_name' => 'required|unique:movies,native_name,' . $this->id,
                    'vietnamese_name' => 'required|unique:movies,vietnamese_name,' . $this->id,
                    'IMDb_scores' => 'required|numeric',
//                    'avatar_url' => 'required|mimes:jpeg,svg,png',
                    'episode_number_current' => 'required|numeric',
                    'episode_number' => 'required|numeric',
                    'realease_year' => 'required|numeric',
                    'time' => 'required|numeric',
                    'introduce' => 'required',
                    'production_company' => 'required',
                    'form' => 'required',
                    'type_language' => 'required',
                    'resolution' => 'required',
                    'quality' => 'required',
                    'countries' => 'required',
                    'tags' => 'required',
                    'categories' => 'required',
                    'has_movie' => 'required',
                    'trailers' => 'array',
                    'episodes' => 'array',
                    'episodes.*.episode' => [
                        Rule::unique('episodes')->where(function ($query) use ($data) {
                            foreach ($data['episodes'] as $episode) {
                                if(!empty($episode)) {
                                    return $query->where('movie_id', $data['id'])->where('episode', $episode['episode']);
                                }
                            }
                        }),
                    ],
                ];
                $indexEpisode = 0;
                foreach ($data['episodes'] as $episode) {
                    if (!empty($episode) && !Storage::disk('my_upload')->exists('uploads/draft/' . $episode['video_url'])) {
                        $val = array_merge($val, ['episodes.' . $indexEpisode . '.video_url' => 'url']);
                    }
                    $indexEpisode++;
                }

                $indexTrailer = 0;
                foreach ($data['trailers'] as $trailer) {
                    if (!empty($trailer) && !Storage::disk('my_upload')->exists('uploads/draft/' . $trailer)) {
                        $val = array_merge($val, ['trailers.*' => 'url']);
                    }
                    $indexTrailer++;
                }
                return $val;
                break;
            default:
                break;
        };
        return [];

    }

    public function messages()
    {
        return [
        ];
    }

}
