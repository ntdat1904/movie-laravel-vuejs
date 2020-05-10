<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            case 'admin.category.create':
                return [
                    'name' => 'required|unique:categories,name',
                    'number_order' => 'required|numeric|unique:categories,number_order',
                ];
                break;
            case 'admin.category.edit':
                return [
                    'name' => 'required|unique:categories,name,'.  $this->id,
                    'number_order' => 'required|numeric|unique:categories,number_order,'.  $this->id,
                ];
                break;
            default:
                break;
        };
        return [];
    }
}
