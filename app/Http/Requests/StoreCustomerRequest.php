<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'vat' => [
                'required',
                'digits:9',
                'unique:customers,vat'
            ],
            'email' => [
                'required',
                'email',
                'unique:customers,email'
            ],
            'address' => [
                'required',
                'max:255'
            ],
            'partner_id' => [
                'required',
                'exists:partners,id'
            ],
            'discount' => [
                'required',
                'between:0,100',
                'decimal:0,2'
            ]
        ];
    }
}
