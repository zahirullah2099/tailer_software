<?php

namespace App\Repository\Interfaces;

use App\Models\Measurement;

interface MeasurementInterface
{
    /**
     * Create a new measurement record for a customer.
     */
    public function create(array $data): Measurement;

    /**
     * Find the measurement record belonging to a customer, if any.
     */
    public function findByCustomer(int $customerId): ?Measurement;

    /**
     * Update an existing measurement record.
     */
    public function update(Measurement $measurement, array $data): Measurement;
}
