<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateOrderAction;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function create(Request $request): View
    {
        $customer = null;

        if ($request->filled('customer')) {
            $customer = $this->customers->findWithMeasurements((int) $request->input('customer'));
        }

        return view('dashboard.orders.create', compact('customer'));
    }

    /**
     * Lightweight customer search for the New Order customer picker.
     */
    public function searchCustomers(Request $request): JsonResponse
    {
        $term = $request->string('q')->toString();

        if (mb_strlen($term) < 2) {
            return response()->json(['customers' => []]);
        }

        $customers = $this->customers->search($term)->map(fn ($customer) => [
            'id' => $customer->id,
            'name' => $customer->name,
            'phone' => $customer->phone,
            'customer_code' => $customer->customer_code,
            'has_measurement' => $customer->measurements->isNotEmpty(),
            'measurement_id' => optional($customer->measurements->first())->id,
        ]);

        return response()->json(['customers' => $customers]);
    }

    public function store(StoreOrderRequest $request, CreateOrderAction $action): JsonResponse
    {
        $order = $action->execute($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'redirect_url' => route('customers.show', $order->customer_id),
        ]);
    }
}
