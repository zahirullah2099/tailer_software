<?php

namespace App\Actions\Measurement;

use App\Models\Customer;
use App\Models\Measurement;
use App\Repository\Interfaces\MeasurementInterface;
use Illuminate\Support\Facades\Auth;

class SaveMeasurementAction
{
    public function __construct(
        private readonly MeasurementInterface $measurements,
    ) {}

    /**
     * Update the customer's existing measurement, or create one if none exists yet.
     */
    public function execute(Customer $customer, array $data): Measurement
    {
        $payload = [
            'chest' => $data['chest'] ?? null,
            'shoulder' => $data['shoulder'] ?? null,
            'sleeve' => $data['sleeve'] ?? null,
            'neck' => $data['neck'] ?? null,
            'shirt_length' => $data['shirt_length'] ?? null,
            'waist' => $data['waist'] ?? null,
            'hip' => $data['hip'] ?? null,
            'shalwar_length' => $data['shalwar_length'] ?? null,
            'bottom_width' => $data['bottom_width'] ?? null,
            'collar' => $data['collar'] ?? null,
            'cuff' => $data['cuff'] ?? null,
            'pocket_type' => $data['pocket_type'] ?? null,
            'fitting_notes' => $data['fitting_notes'] ?? null,
        ];

        $existing = $this->measurements->findByCustomer($customer->id);

        if ($existing) {
            return $this->measurements->update($existing, $payload);
        }

        return $this->measurements->create([
            ...$payload,
            'customer_id' => $customer->id,
            'taken_by' => Auth::id(),
            'is_default' => true,
        ]);
    }
}
