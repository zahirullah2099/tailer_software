<?php

namespace App\Repository\Interfaces;

use App\Models\Measurement;

interface MeasurementInterface
{
    /**
     * Create a new measurement record for a customer.
     */
    public function create(array $data): Measurement;
}
