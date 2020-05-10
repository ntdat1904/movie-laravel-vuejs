<?php

namespace App\Http\Requests\Episode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EpisodeRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $data = $this->only(['episode', 'movie_id', 'id', 'video_url']);
        $val = [
            'episode' => [
                Rule::unique('episodes')->where(
                    function ($query) use ($data) {
                        return $query->where('movie_id', $data['movie_id'])
                            ->where('episode', $data['episode'])
                            ->where('id', '!=', $data['id']);
                    }
                ),
            ]
        ];
        if (!empty($data['video_url']) && !Storage::disk('my_upload')->exists('uploads/draft/' . $data['video_url'])) {
            $val = array_merge($val, ['video_url' => 'url']);
        }
        return $val;

    }
}
