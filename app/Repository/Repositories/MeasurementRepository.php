<?php

namespace App\Repository\Repositories;

use App\Models\Measurement;
use App\Repository\Interfaces\MeasurementInterface;

class MeasurementRepository implements MeasurementInterface
{
    public function create(array $data): Measurement
    {
        return Measurement::create($data);
    }

    public function findByCustomer(int $customerId): ?Measurement
    {
        return Measurement::where('customer_id', $customerId)->first();
    }

    public function update(Measurement $measurement, array $data): Measurement
    {
        $measurement->update($data);

        return $measurement->fresh();
    }
}
