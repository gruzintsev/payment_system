<?php

namespace App\Http\Requests;

class TransactionRequest extends JsonRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from' => 'exists:users,id|different:to',
            'to' => 'required|exists:users,id|different:from',
            'amount' => 'required',
            'currency' => 'required|max:3|exists:currencies,iso',
        ];
    }
}
