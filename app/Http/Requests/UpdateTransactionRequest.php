<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'transaction_name' => 'required|string|max:255',
            'transaction_code' => 'required|string|max:255|unique:transactions,transaction_code,' . $id,
            'client_name' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'installment_1' => 'nullable|numeric|min:0',
            'installment_2' => 'nullable|numeric|min:0',
            'installment_3' => 'nullable|numeric|min:0',
        ];
    }
}
