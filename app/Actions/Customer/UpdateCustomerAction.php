<?php

namespace App\Actions\Customer;

use App\Models\Customer;
use App\Repository\Interfaces\CustomerInterface;

class UpdateCustomerAction
{
    public function __construct(
        private readonly CustomerInterface $customers,
    ) {}

    public function execute(Customer $customer, array $data): Customer
    {
        return $this->customers->update($customer, [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'alternate_phone' => $data['alternate_phone'] ?? null,
            'address' => $data['address'] ?? null,
            'notes' => $data['notes'] ?? null,
        ]);
    }
}
