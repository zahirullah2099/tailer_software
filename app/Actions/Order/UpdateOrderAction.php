<?php

namespace App\Actions\Order;

use App\Models\Order;
use App\Repository\Interfaces\OrderInterface;

class UpdateOrderAction
{
    public function __construct(
        private readonly OrderInterface $orders,
    ) {}

    public function execute(Order $order, array $data): Order
    {
        return $this->orders->update($order, [
            'dress_type' => $data['dress_type'],
            'quantity' => $data['quantity'],
            'total_amount' => $data['total_amount'],
            'order_date' => $data['order_date'],
            'delivery_date' => $data['delivery_date'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);
    }
}
