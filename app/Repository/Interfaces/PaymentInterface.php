<?php

namespace App\Repository\Interfaces;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Collection;

interface PaymentInterface
{
    /**
     * Get all payments, with order and customer loaded, most recent first.
     */
    public function all(): Collection;

    /**
     * Record a new payment.
     */
    public function create(array $data): Payment;

    /**
     * Delete a payment.
     */
    public function delete(Payment $payment): bool;

    /**
     * Total amount already paid against a given order.
     */
    public function totalPaidForOrder(int $orderId): float;
}
