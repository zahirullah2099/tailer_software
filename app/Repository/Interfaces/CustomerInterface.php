<?php

namespace App\Repository\Interfaces;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

interface CustomerInterface
{
    /**
     * Get all customers.
     */
    public function all(): Collection;

    /**
     * Create a new customer.
     */
    public function create(array $data): Customer;

    /**
     * Find a customer by ID, with its measurements loaded.
     */
    public function findWithMeasurements(int $id): Customer;

    /**
     * Find a plain customer by ID (no relations).
     */
    public function find(int $id): Customer;

    /**
     * Update an existing customer.
     */
    public function update(Customer $customer, array $data): Customer;

    /**
     * Soft delete a customer.
     */
    public function delete(Customer $customer): bool;

    /**
     * Check if a phone number is already used by another customer.
     */
    public function phoneExists(string $phone): bool;

    /**
     * Check if a phone number is used by a customer other than the given one.
     */
    public function phoneExistsExcept(string $phone, int $exceptId): bool;

    /**
     * Search customers by name or phone (used by the New Order customer picker).
     */
    public function search(string $term, int $limit = 10): Collection;
}
