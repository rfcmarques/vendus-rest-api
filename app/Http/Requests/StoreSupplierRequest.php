<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
                'unique:suppliers,vat'
            ],
            'email' => [
                'required',
                'email',
                'unique:suppliers,email',
                'max:255'
            ],
            'address' => [
                'required',
                'max:255'
            ],
            'max_due_days' => [
                'required',
                'numeric'
            ],
            'contract_file' => [
                'required',
                'string',
                'max:255'
            ]
        ];
    }
}
