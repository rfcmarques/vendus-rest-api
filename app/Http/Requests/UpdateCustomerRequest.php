<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
                'string',
                'max:255'
            ],
            'vat' => [
                'between:100000000,999999',
                'unique:customers,vat,' . $this->partner->id
            ],
            'email' => [
                'email',
                'unique:customers,email,' . $this->partner->id
            ],
            'address' => 'max:255',
            'discount' => [
                'between:0,100',
                'decimal:0,2'
            ]
        ];
    }
}
