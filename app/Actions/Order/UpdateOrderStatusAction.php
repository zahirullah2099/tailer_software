<?php

namespace App\Actions\Order;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repository\Interfaces\OrderInterface;

class UpdateOrderStatusAction
{
    public function __construct(
        private readonly OrderInterface $orders,
    ) {}

    public function execute(Order $order, OrderStatus $status): Order
    {
        return $this->orders->updateStatus($order, $status);
    }
}
