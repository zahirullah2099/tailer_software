<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use App\Repository\Interfaces\PaymentInterface;

class DeletePaymentAction
{
    public function __construct(
        private readonly PaymentInterface $payments,
    ) {}

    public function execute(Payment $payment): bool
    {
        return $this->payments->delete($payment);
    }
}
