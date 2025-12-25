<?php

namespace App\Repository;

use App\Models\Customers;

class CustomerRepository
{
    public function getCustomer($name, $email, $noPhone, $perPage = 10)
    {
        $query = Customers::query();

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        if ($email) {
            $query->where('email', 'like', "%$email%");
        }

        if ($noPhone) {
            $query->where('noPhone', 'like', "%$noPhone%");
        }

        return $query->paginate($perPage);
    }

    public function createNewUCustomer($name, $email, $noPhone, $gender, $birthDate)
    {
        return Customers::create([
            'name' => $name,
            'email' => $email,
            'no_phone' => $noPhone,
            'gender' => $gender ?? null,
            'birth_date' => $birthDate ?? null,
        ]);
    }

    public function findCustomerById($id)
    {
        return Customers::find($id);
    }

    public function deleteCustomer(Customers $customer)
    {
        return $customer->delete();
    }

    public function updateCustomer(Customers $customer, $data)
    {
        $customer->update($data);

        return $customer->update();
    }
}
