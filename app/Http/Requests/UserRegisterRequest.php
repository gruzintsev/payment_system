<?php

namespace App\Http\Requests;

class UserRegisterRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:users',
            'password' => 'required',
            'country' => 'max:50',
            'city' => 'max:50',
            'currency_iso' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'password.required' => 'Password is required',
        ];
    }
}
