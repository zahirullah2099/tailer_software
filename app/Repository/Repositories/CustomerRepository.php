<?php

namespace App\Repository\Repositories;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository implements CustomerInterface
{
    public function all(): Collection
    {
        return Customer::latest()->get();
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function findWithMeasurements(int $id): Customer
    {
        return Customer::with([
            'measurements',
            'orders' => fn ($query) => $query->latest('order_date'),
        ])->findOrFail($id);
    }

    public function find(int $id): Customer
    {
        return Customer::findOrFail($id);
    }

    public function update(Customer $customer, array $data): Customer
    {
        $customer->update($data);

        return $customer->fresh();
    }

    public function delete(Customer $customer): bool
    {
        return $customer->delete();
    }

    public function phoneExists(string $phone): bool
    {
        return Customer::where('phone', $phone)->exists();
    }

    public function phoneExistsExcept(string $phone, int $exceptId): bool
    {
        return Customer::where('phone', $phone)
            ->where('id', '!=', $exceptId)
            ->exists();
    }

    public function search(string $term, int $limit = 10): Collection
    {
        return Customer::with('measurements')
            ->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%");
            })
            ->limit($limit)
            ->get();
    }
}
