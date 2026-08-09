<?php

namespace App\Actions\Customer;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;

class DeleteCustomerAction
{
    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function execute(Customer $customer): bool
    {
        return $this->customers->delete($customer);
    }
}
