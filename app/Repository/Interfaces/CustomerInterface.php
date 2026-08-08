<?php

namespace App\Repository\Interfaces;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CustomerInterface
{
    /**
     * Get paginated customers, optionally filtered by name or phone search.
     */
    public function paginateWithSearch(?string $search, int $perPage = 15): LengthAwarePaginator;

    /**
     * Create a new customer.
     */
    public function create(array $data): Customer;

    /**
     * Find a customer by ID, with its measurements loaded.
     */
    public function findWithMeasurements(int $id): Customer;

    /**
     * Check if a phone number is already used by another customer.
     */
    public function phoneExists(string $phone): bool;
}
