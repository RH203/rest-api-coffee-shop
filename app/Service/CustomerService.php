<?php

namespace App\Service;

use App\Enum\RoleEnum;
use App\Exceptions\CustomerException;
use App\Repository\CustomerRepository;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function getCustomer($name, $email, $noPhone)
    {
        $customers = $this->customerRepository->getCustomer($name, $email, $noPhone);

        if (empty($customers)) {
            throw new CustomerException('Gagal mendapatkan data customers.');
        }

        return $customers;
    }

    public function createNewCustomer($request)
    {
        $newCustomer = $this->customerRepository->createNewUCustomer($request['name'], $request['email'], $request['no_phone'], $request['gender'], $request['birth_date']);

        if (empty($newCustomer)) {
            throw new CustomerException('Gagal membuat member baru!.');
        }

        $newCustomer->assignRole(RoleEnum::CUSTOMER->value);

        return $newCustomer;
    }

    public function deleteCustomer($customerId)
    {
        $customer = $this->customerRepository->findCustomerById($customerId);

        if (empty($customer)) {
            throw new CustomerException('Customer tidak ditemukan!.');
        }

        $this->customerRepository->deleteCustomer($customer);

        return 'Berhasil menghapus member!';
    }

    public function updateCustomer($customerId, $name, $email, $noPhone, $gender, $birthDate)
    {
        $customer = $this->customerRepository->findCustomerById($customerId);

        if (empty($customer)) {
            throw new CustomerException('Customer tidak ditemukan!.');
        }

        $data = array_filter([
            'name' => $name,
            'email' => $email,
            'no_phone' => $noPhone,
            'gender' => $gender,
            'birth_date' => $birthDate,
        ], fn($v) => !is_null($v));

        return $this->customerRepository->updateCustomer($customer, $data);
    }
}
