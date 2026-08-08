<?php

namespace App\Repository\Interfaces;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

interface CustomerInterface
{
    /**
     * Get the base query builder for customers (used by DataTables).
     */
    public function all();

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
