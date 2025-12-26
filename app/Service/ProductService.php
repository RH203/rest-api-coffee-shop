<?php

namespace App\Service;

use App\Exceptions\CategoryException;
use App\Exceptions\ProductException;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    protected $productRepository;

    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getProduct($name, $categoryId, $perPage = 10)
    {
        $products = $this->productRepository->getProduct($name, $categoryId, $perPage);
        if (empty($products)) {
            throw new ProductException('Gagal mengambil data.');
        }

        return $products;
    }

    public function createProduct($categoryId, $name, $description, $image, $price, $statusProduct, $stock, $isUnlimited, $variants)
    {
        $category = $this->categoryRepository->findCategoryById($categoryId);

        if (empty($category)) {
            throw new CategoryException('Category tidak ditemukan.');
        }

        $directoryImage = "image";
        $pathImage = Storage::putFile($directoryImage, $image);

        $newProduct = $this->productRepository->createProduct($category->id, $name, $description, $pathImage, $price, $statusProduct, $stock, $isUnlimited);

        if (empty($newProduct)) {
            throw new ProductException('Gagal menyimpan data.');
        }

        $productVariants = [];

        foreach ($variants as $variant) {
            $productVariants[$variant['variant_id']] = [
                'addon_price' => $variant['addon_price']
            ];
        }

        $this->productRepository->syncVariantProduct($newProduct, $productVariants);

        return $newProduct;
    }

    public function updateProduct($productId, $name, $description, $image, $price, $statusProduct, $stock, $isUnlimited)
    {
        $product = $this->productRepository->findProductById($productId);

        if (empty($product)) {
            throw new ProductException('Product tidak ditemukan.');
        }

        $data = array_filter([
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'price' => $price,
            'statusProduct' => $statusProduct,
            'stock' => $stock,
            'isUnlimited' => $isUnlimited,
        ], fn ($value) => ! is_null($value));

        return $this->productRepository->updateProduct($product, $data);
    }

    public function deleteProduct($productId)
    {
        $product = $this->productRepository->findProductById($productId);
        if (empty($product)) {
            throw new ProductException('Product tidak ditemukan.');
        }

        return $this->productRepository->deleteProduct($product);
    }
}
