<?php

namespace App\Repository\Interfaces;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderInterface
{
    /**
     * Get all orders, with customer loaded, most recent first.
     */
    public function all(): Collection;

    /**
     * Get orders matching any of the given statuses.
     *
     * @param  array<OrderStatus>  $statuses
     */
    public function allByStatuses(array $statuses): Collection;

    /**
     * Create a new order.
     */
    public function create(array $data): Order;

    /**
     * Find an order by ID.
     */
    public function find(int $id): Order;

    /**
     * Update an order's details.
     */
    public function update(Order $order, array $data): Order;

    /**
     * Update just an order's status.
     */
    public function updateStatus(Order $order, OrderStatus $status): Order;

    /**
     * Soft delete an order.
     */
    public function delete(Order $order): bool;
}
