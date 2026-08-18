<?php

namespace App\Repository\Repositories;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Repository\Interfaces\OrderInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderInterface
{
    public function all(): Collection
    {
        return Order::with(['customer' => fn ($query) => $query->withTrashed(), 'payments'])
            ->latest('order_date')
            ->get();
    }

    public function allByStatuses(array $statuses): Collection
    {
        return Order::with(['customer' => fn ($query) => $query->withTrashed(), 'payments'])
            ->whereIn('status', $statuses)
            ->latest('order_date')
            ->get();
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function find(int $id): Order
    {
        return Order::with(['customer' => fn ($query) => $query->withTrashed()])->findOrFail($id);
    }

    public function update(Order $order, array $data): Order
    {
        $order->update($data);

        return $order->fresh();
    }

    public function updateStatus(Order $order, OrderStatus $status): Order
    {
        $order->update(['status' => $status]);

        return $order->fresh();
    }

    public function delete(Order $order): bool
    {
        return $order->delete();
    }
}
