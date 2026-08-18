<?php

namespace App\Actions\Customer;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Validation\ValidationException;

class DeleteCustomerAction
{
    private const CLOSED_STATUSES = [
        OrderStatus::DELIVERED,
        OrderStatus::CANCELLED,
    ];

    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function execute(Customer $customer): bool
    {
        $hasActiveOrders = $customer->orders()
            ->whereNotIn('status', self::CLOSED_STATUSES)
            ->exists();

        if ($hasActiveOrders) {
            throw ValidationException::withMessages([
                'customer' => 'This customer has an order still in progress and cannot be deleted until it is delivered or cancelled.',
            ]);
        }

        if ($this->hasOutstandingDues($customer)) {
            throw ValidationException::withMessages([
                'customer' => 'This customer has an unpaid balance on a delivered order and cannot be deleted until it is fully paid.',
            ]);
        }

        // All orders are closed and fully paid — safe to remove.
        // Soft-deleted so payment history stays intact for accounting records.
        $customer->orders()->get()->each->delete();

        return $this->customers->delete($customer);
    }

    private function hasOutstandingDues(Customer $customer): bool
    {
        $due = $customer->orders()
            ->where('status', OrderStatus::DELIVERED)
            ->with('payments')
            ->get()
            ->sum(fn ($order) => (float) $order->total_amount - $order->payments->sum('amount'));

        return $due > 0;
    }
}
