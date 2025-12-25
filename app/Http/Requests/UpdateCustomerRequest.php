<?php

namespace App\Http\Requests;

use App\Enum\GenderEnum;
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
            'customer_id' => 'required|int|exists:customers,id',
            'name' => 'nullable|string',
            'email' => 'nullable|email',
            'no_phone' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:'.GenderEnum::MALE->value.','.GenderEnum::FEMALE->value,
        ];
    }
}
