<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $rule = [
            'name' => 'required|min:4|unique:users,name,'.$this->id,
        ];

        switch ($route) {
            case 'admin.users.create':
                $rule = array_merge($rule, [
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:3',
                    'password_confirmation' => 'same:password',
                    'avatar_url' => 'nullable|sometimes|image|mimes:jpeg,jpg,png'
                ]);
                return $rule;
                break;
            case 'admin.register':
                $rule = array_merge($rule, [
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|min:3',
                    'password_confirmation' => 'same:password',
                ]);
                return $rule;
                break;
            case 'admin.users.edit':
                if (!empty($this->file('avatar_url'))) {
                    $rule = array_merge($rule, ['avatar_url' => 'nullable|sometimes|image|mimes:jpeg,jpg,png']);
                }
                $rule = array_merge($rule, [
                    'email' => 'required|email|unique:users,email,' . $this->id,
                ]);
                return $rule;
                break;
            default:
                break;
        };
        return [];

    }
}
