<?php

namespace App\Http\Controllers;

use App\Actions\Measurement\SaveMeasurementAction;
use App\Http\Requests\Measurement\SaveMeasurementRequest;
use App\Models\Customer;
use App\Repository\Interfaces\MeasurementInterface;
use Illuminate\Http\JsonResponse;

class MeasurementController extends Controller
{
    public function __construct(
        private readonly MeasurementInterface $measurements,
    ) {}

    public function edit(Customer $customer): JsonResponse
    {
        return response()->json([
            'measurement' => $this->measurements->findByCustomer($customer->id),
        ]);
    }

    public function store(SaveMeasurementRequest $request, Customer $customer, SaveMeasurementAction $action): JsonResponse
    {
        $measurement = $action->execute($customer, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Measurement saved successfully.',
            'card' => view('dashboard.customers._measurement-card', compact('measurement'))->render(),
        ]);
    }
}
