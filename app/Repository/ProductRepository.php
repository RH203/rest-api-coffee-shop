<?php

namespace App\Repository;

use App\Models\Products;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function findProductById($productId)
    {
        return Products::find($productId);
    }

    public function getProduct($name, $categoryId, $perPage = 10)
    {
        return Products::with(['category', 'varianProducts'])
            ->when(
                $name,
                fn ($q) => $q->where('name', 'like', "%{$name}%")
            )
            ->when(
                $categoryId,
                fn ($q) => $q->where('category_id', $categoryId)
            )
            ->paginate($perPage);
    }

    public function createProduct($categoryId, $name, $description, $image, $price, $statusProduct, $stock, $isUnlimited)
    {
        return Products::create([
            'category_id' => $categoryId,
            'name' => $name,
            'description' => $description ?? null,
            'image' => $image ?? null,
            'price' => $price,
            'status_products' => $statusProduct,
            'stock' => $stock ?? null,
            'is_unlimited' => $isUnlimited ?? null,
        ]);
    }

    public function updateProduct(Products $product, $data)
    {
        DB::transaction(function () use ($product, $data) {
            $product->update($data);

            return $product->fresh();
        });

        return null;
    }

    public function deleteProduct(Products $product)
    {
        return $product->delete();
    }

    public function syncVariantProduct(Products $product, $variant)
    {
        return $product->varianProducts()->sync($variant);
    }
}
