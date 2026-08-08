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
}
