<?php

namespace App\Repository\Repositories;

use App\Models\Order;
use App\Repository\Interfaces\OrderInterface;

class OrderRepository implements OrderInterface
{
    public function create(array $data): Order
    {
        return Order::create($data);
    }
}
