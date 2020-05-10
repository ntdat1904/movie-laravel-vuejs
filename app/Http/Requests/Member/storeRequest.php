<?php

namespace App\Http\Requests\Member;

use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
        return [
            'country_id' => 'required|exists:countries,id',
            'weight' => 'required|numeric|between:10,200',
            'height' => 'required|numeric|between:0.1,2.5',
            'introduce' => 'required',
            'name' => 'required|max:255',
            'type' => 'required|in:1,2',
            'avatar_url' => 'required|sometimes|image|mimes:jpeg,jpg,png',
        ];
    }
}
