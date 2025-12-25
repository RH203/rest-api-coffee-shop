<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            "product_id" => "required|integer|exists:products,id",
            "name" => "nullable|string",
            "description" => "nullable|string",
            "price" => "nullable|numeric",
            "image" => "nullable|file|image|mimes:jpeg,png,jpg,gif,svg",
            "stock" => "nullable|integer",
            "is_unlimited" => "nullable|integer|in:0,1",
            "status_product" => "nullable|integer|in:0,1",
        ];
    }
}
