<?php

namespace App\Actions\Payment;

use App\Models\Payment;
use App\Repository\Interfaces\PaymentInterface;
use Illuminate\Support\Facades\Auth;

class RecordPaymentAction
{
    public function __construct(
        private readonly PaymentInterface $payments,
    ) {}

    public function execute(array $data): Payment
    {
        return $this->payments->create([
            'order_id' => $data['order_id'],
            'received_by' => Auth::id(),
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'paid_at' => $data['paid_at'],
            'remarks' => $data['remarks'] ?? null,
        ]);
    }
}
