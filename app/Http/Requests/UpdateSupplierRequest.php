<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
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
                'digits:9',
                'unique:suppliers,vat'
            ],
            'email' => [
                'email',
                'unique:suppliers,email',
                'max:255'
            ],
            'address' => [
                'max:255'
            ],
            'max_due_days' => [
                'numeric'
            ],
            'contract_file' => [
                'string',
                'max:255'
            ]
        ];
    }
}
