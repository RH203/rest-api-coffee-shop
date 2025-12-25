<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomerException;
use App\Http\Requests\GetCustomerRequest;
use App\Http\Requests\NewCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Service\CustomerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    use ApiResponseTrait;

    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function getAllCustomer(GetCustomerRequest $request)
    {
        try {
            $results = $this->customerService->getCustomer($request['name'], $request['email'], $request['phone']);

            return $this->successResponse($results);
        } catch (CustomerException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Gagal mendapatkan data customers.' . $e->getMessage());

            return $this->errorResponse('Oops! Something went wrong.');
        }
    }

    public function createNewCustomer(NewCustomerRequest $request)
    {
        try {
            $result = $this->customerService->createNewCustomer($request);

            return $this->successResponse($result);
        } catch (CustomerException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Error ketika membuat member baru: ' . $e->getMessage());

            return $this->errorResponse('Oops something wrong.');
        }
    }

    public function deleteCustomer(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'customer_id' => 'required|integer|exists:customers,id',
            ]);

            $result = $this->customerService->deleteCustomer($validatedData['customer_id']);

            return $this->successResponse($result);
        } catch (CustomerException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Error ketika membuat menghapus member: ' . $e->getMessage());

            return $this->errorResponse('Oops something wrong.');
        }
    }

    public function updateCustomer(UpdateCustomerRequest $request)
    {
        try {
            $result = $this->customerService->updateCustomer(
                $request['customer_id'],
                $request['name'],
                $request['email'],
                $request['phone'],
                $request['gender'],
                $request['birth_date']
            );

            return $this->successResponse($result);
        } catch (CustomerException $e) {
            return $this->errorResponse($e->getMessage());
        } catch (\Throwable $e) {
            Log::error('Error ketika membuat mengubah member: ' . $e->getMessage());
            return $this->errorResponse('Oops something wrong.');
        }
    }
}
