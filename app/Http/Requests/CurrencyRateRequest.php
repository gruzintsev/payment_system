<?php

namespace App\Http\Requests;

class CurrencyRateRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency_iso' => 'required|max:3|exists:currencies,iso',
            'rate' => 'required',
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
//            'name.required' => 'Name is required',
//            'password.required' => 'Password is required',
        ];
    }
}
