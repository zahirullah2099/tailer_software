<?php

namespace App\Repository\Interfaces;

use App\Models\Order;

interface OrderInterface
{
    /**
     * Create a new order.
     */
    public function create(array $data): Order;
}
