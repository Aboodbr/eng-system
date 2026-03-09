<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'transaction_name' => 'required|string|max:255',
            'transaction_code' => 'required|string|max:50|unique:transactions',
            'client_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'installment_1' => 'nullable|numeric|min:0',
            'installment_2' => 'nullable|numeric|min:0',
            'installment_3' => 'nullable|numeric|min:0',
        ];
    }
}
