<?php

namespace App\Actions\Customer;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;
use Illuminate\Validation\ValidationException;

class DeleteCustomerAction
{
    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function execute(Customer $customer): bool
    {
        if ($customer->orders()->exists()) {
            throw ValidationException::withMessages([
                'customer' => 'This customer has existing orders and cannot be deleted. Cancel or remove their orders first.',
            ]);
        }

        return $this->customers->delete($customer);
    }
}
