<?php

namespace App\Http\Requests\Tag;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
        $route = $route = $this->route()->getName();
        switch ($route) {
            case 'admin.tag.create':
                return ['name' => 'required|unique:tags,name'];
                break;
            case 'admin.tag.edit':
                return ['name' => 'required|unique:tags,name,'.  $this->id];
                break;
            default:
                break;
        };
        return [];
    }
}
