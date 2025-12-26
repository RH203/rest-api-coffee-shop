<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            "category_id" => "required|exists:categories,id",
            "name" => "required|string",
            "description" => "nullable|string",
            "image" => "nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:6500",
            "price" => "required|numeric",
            "status_product" => "required|integer|between:0,1",
            "stock" => "nullable|integer",
            "is_unlimited" => "nullable|integer|between:0,1",
            "variants" => "required|array|min:1",
            "variants.*.variant_id" => "required|integer|exists:variants,id",
            "variants.*.add_on_price" => "required|numeric",
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            if (! $this->has('variants')) {
                return;
            }

            $variantIds = collect($this->input('variants'))
                ->pluck('variant_id');

            if ($variantIds->duplicates()->isNotEmpty()) {
                $validator->errors()->add(
                    'variants',
                    'Variant tidak boleh duplikat.'
                );
            }
        });
    }
}
