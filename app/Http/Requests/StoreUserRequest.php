<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'      =>      'required|string|max:127|min:3',
            'email'     =>      'required|email|unique:users,email',
            'type_user' =>      'required|boolean',
            'password'  =>      'required|string|min:8|max:24',
            
        ];
    }
}
