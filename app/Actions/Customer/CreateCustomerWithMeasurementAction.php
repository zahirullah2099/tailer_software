<?php

namespace App\Actions\Customer;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use App\Repository\Interfaces\MeasurementInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateCustomerWithMeasurementAction
{
    /**
     * Measurement fields that, when any is present, trigger measurement creation.
     */
    private const MEASUREMENT_FIELDS = [
        'chest', 'shoulder', 'sleeve', 'neck', 'shirt_length',
        'waist', 'hip', 'shalwar_length', 'bottom_width',
        'collar', 'cuff', 'pocket_type', 'fitting_notes',
    ];

    public function __construct(
        private readonly CustomerInterface $customers,
        private readonly MeasurementInterface $measurements,
    ) {}

    public function execute(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            $customer = $this->customers->create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'alternate_phone' => $data['alternate_phone'] ?? null,
                'address' => $data['address'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            if ($this->hasMeasurementData($data)) {
                $this->measurements->create([
                    'customer_id' => $customer->id,
                    'taken_by' => Auth::id(),
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
                    'is_default' => true,
                ]);
            }

            return $customer;
        });
    }

    private function hasMeasurementData(array $data): bool
    {
        foreach (self::MEASUREMENT_FIELDS as $field) {
            if (! empty($data[$field])) {
                return true;
            }
        }

        return false;
    }
}
