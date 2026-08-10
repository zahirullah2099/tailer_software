<?php

namespace App\Http\Controllers;

use App\Actions\Order\CreateOrderAction;
use App\Actions\Order\DeleteOrderAction;
use App\Actions\Order\UpdateOrderAction;
use App\Actions\Order\UpdateOrderStatusAction;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Requests\Order\UpdateOrderStatusRequest;
use App\Models\Order;
use App\Repository\Interfaces\CustomerInterface;
use App\Repository\Interfaces\OrderInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private readonly CustomerInterface $customers,
        private readonly OrderInterface $orders,
    ) {}

    public function index(): View
    {
        $orders = $this->orders->all();

        return view('dashboard.orders.index', compact('orders'));
    }

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

    public function edit(Order $order): JsonResponse
    {
        return response()->json([
            'order' => $order,
        ]);
    }

    public function update(UpdateOrderRequest $request, Order $order, UpdateOrderAction $action): JsonResponse
    {
        $order = $action->execute($order, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully.',
            'order' => $order,
        ]);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, Order $order, UpdateOrderStatusAction $action): JsonResponse
    {
        $order = $action->execute($order, $request->enum('status', \App\Enums\OrderStatus::class));

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully.',
            'status' => $order->status->value,
        ]);
    }

    public function destroy(Order $order, DeleteOrderAction $action): JsonResponse
    {
        $action->execute($order);

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully.',
        ]);
    }
}
