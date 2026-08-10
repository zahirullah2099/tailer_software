<?php

namespace App\Actions\Order;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repository\Interfaces\OrderInterface;
use Illuminate\Support\Facades\Auth;

class CreateOrderAction
{
    public function __construct(
        private readonly OrderInterface $orders,
    ) {}

    public function execute(array $data): Order
    {
        return $this->orders->create([
            'customer_id' => $data['customer_id'],
            'measurement_id' => $data['measurement_id'],
            'created_by' => Auth::id(),
            'dress_type' => $data['dress_type'],
            'quantity' => $data['quantity'],
            'total_amount' => $data['total_amount'],
            'order_date' => $data['order_date'],
            'delivery_date' => $data['delivery_date'] ?? null,
            'status' => OrderStatus::PENDING,
            'notes' => $data['notes'] ?? null,
        ]);
    }
}
