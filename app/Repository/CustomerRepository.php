<?php

namespace App\Repository;

use App\Models\Customers;
use Illuminate\Support\Facades\DB;

class CustomerRepository
{
    public function getCustomer($name, $email, $noPhone, $perPage = 10)
    {
        return Customers::when($name, function ($query) use ($name) {
            return $query->where('name', 'like', '%'.$name.'%');
        })->when($email, function ($query) use ($email) {
            return $query->where('email', 'like', '%'.$email.'%');
        })->when($noPhone, function ($query) use ($noPhone) {
            return $query->where('noPhone', 'like', '%'.$noPhone.'%');
        })->paginate($perPage);
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
        DB::transaction(function () use ($customer, $data) {
            $customer->update($data);

            return $customer->fresh();
        });

        return null;
    }
}
