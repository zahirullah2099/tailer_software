<?php

namespace App\Repository\Repositories;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Database\Eloquent\Builder;

class CustomerRepository implements CustomerInterface
{
    public function all()
    {
        return Customer::all();
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function findWithMeasurements(int $id): Customer
    {
        return Customer::with('measurements')->findOrFail($id);
    }

    public function phoneExists(string $phone): bool
    {
        return Customer::where('phone', $phone)->exists();
    }
}
