<?php

namespace App\Actions\Customer;

use App\Enums\OrderStatus;
use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Validation\ValidationException;

class DeleteCustomerAction
{
    private const array CLOSED_STATUSES = [
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

        // All remaining orders are delivered/cancelled — safe to remove.
        // Soft-deleted so payment history stays intact for accounting records.
        $customer->orders()->get()->each->delete();

        return $this->customers->delete($customer);
    }
}
