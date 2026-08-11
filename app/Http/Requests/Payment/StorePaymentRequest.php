<?php

namespace App\Http\Requests\Payment;

use App\Enums\PaymentMethod;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'integer', 'exists:orders,id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'paid_at' => ['required', 'date'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Prevent recording a payment that exceeds the order's remaining balance.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->has('order_id') || $validator->errors()->has('amount')) {
                return;
            }

            $order = Order::find($this->input('order_id'));

            if (! $order) {
                return;
            }

            $alreadyPaid = $order->payments()->sum('amount');
            $balance = $order->total_amount - $alreadyPaid;

            if ((float) $this->input('amount') > (float) $balance) {
                $validator->errors()->add('amount', 'This exceeds the remaining balance of Rs. ' . number_format($balance, 2) . '.');
            }
        });
    }
}
