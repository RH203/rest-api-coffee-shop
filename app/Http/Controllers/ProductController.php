<?php

namespace App\Http\Controllers;

use App\Exceptions\CategoryException;
use App\Exceptions\ProductException;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\GetProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Service\ProductService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    use ApiResponseTrait;

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProduct(GetProductRequest $request)
    {
        try {
            $result = $this->productService->getProduct($request['name'], $request['category_id'], $request['per_page']);

            return $this->successResponse($result);
        } catch (ProductException $e) {
            return $this->errorResponse([$e->getMessage()]);
        } catch (\Throwable $e) {
            Log::error("Error ketika mengambil data product: ".$e->getMessage());

            return $this->errorResponse("Ooops! Something went wrong.");
        }
    }

    public function createProduct(CreateProductRequest $request)
    {
        try {
            $request = $this->productService->createProduct(
                $request['category_id'],
                $request['name'],
                $request['description'],
                $request['image'],
                $request['price'],
                $request['status_product'],
                $request['stock'],
                $request['is_unlimited'],
                $request['variants']
            );

            return $this->successResponse($request);
        } catch (CategoryException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (ProductException $e) {
            return $this->errorResponse([$e->getMessage()]);
        } catch (\Throwable $e) {
            Log::error("Error ketika membuat data product: ".$e->getMessage());

            return $this->errorResponse("Ooops! Something went wrong.");
        }
    }

    public function updateProduct(UpdateProductRequest $request)
    {
        try {
            $result = $this->productService->updateProduct(
                $request['product_id'],
                $request['name'],
                $request['description'],
                $request['image'],
                $request['price'],
                $request['status_product'],
                $request['stock'],
                $request['is_unlimited']
            );

            return $this->successResponse($result);
        } catch (ProductException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error("Error ketika mengubah data product: ".$e->getMessage());

            return $this->errorResponse("Ooops! Something went wrong.");
        }
    }

    public function deleteProduct(Request $request)
    {
        try {
            $validatedData = $request->validate([
                "product_id" => "required|exists:product,id",
            ]);

            $result = $this->productService->deleteProduct($validatedData['product_id']);

            return $this->successResponse($result);
        } catch (ProductException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error("Error ketika menghapus data product: ".$e->getMessage());

            return $this->errorResponse("Ooops! Something went wrong.");
        }
    }
}
