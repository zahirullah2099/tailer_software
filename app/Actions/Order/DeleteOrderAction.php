<?php

namespace App\Actions\Order;

use App\Models\Order;
use App\Repository\Interfaces\OrderInterface;

class DeleteOrderAction
{
    public function __construct(
        private readonly OrderInterface $orders,
    ) {}

    public function execute(Order $order): bool
    {
        return $this->orders->delete($order);
    }
}
