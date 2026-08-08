<?php

namespace App\Repository\Repositories;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerInterface
{
    public function paginateWithSearch(?string $search, int $perPage = 15): LengthAwarePaginator
    {
        return Customer::query()
            ->when($search, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate($perPage);
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
