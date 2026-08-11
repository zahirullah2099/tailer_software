<?php

namespace App\Repository\Repositories;

use App\Models\Payment;
use App\Repository\Interfaces\PaymentInterface;
use Illuminate\Database\Eloquent\Collection;

class PaymentRepository implements PaymentInterface
{
    public function all(): Collection
    {
        return Payment::with('order.customer')->latest('paid_at')->get();
    }

    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function delete(Payment $payment): bool
    {
        return $payment->delete();
    }

    public function totalPaidForOrder(int $orderId): float
    {
        return (float) Payment::where('order_id', $orderId)->sum('amount');
    }
}
