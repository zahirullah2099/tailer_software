<?php

namespace App\Http\Controllers;

use App\Actions\Payment\DeletePaymentAction;
use App\Actions\Payment\RecordPaymentAction;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Models\Order;
use App\Models\Payment;
use App\Repository\Interfaces\PaymentInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentInterface $payments,
    ) {}

    public function index(): View
    {
        $payments = $this->payments->all();

        return view('dashboard.payments.index', compact('payments'));
    }

    /**
     * Returns an order's total/paid/balance, for the Add Payment modal.
     */
    public function paymentInfo(Order $order): JsonResponse
    {
        $paid = $order->payments()->sum('amount');

        return response()->json([
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'customer_name' => $order->customer->name,
                'total_amount' => (float) $order->total_amount,
                'paid' => (float) $paid,
                'balance' => (float) $order->total_amount - (float) $paid,
            ],
        ]);
    }

    public function store(StorePaymentRequest $request, RecordPaymentAction $action): JsonResponse
    {
        $payment = $action->execute($request->validated());
        $order = $payment->order;
        $paid = $order->payments()->sum('amount');

        return response()->json([
            'success' => true,
            'message' => 'Payment recorded successfully.',
            'order_id' => $order->id,
            'paid' => (float) $paid,
            'balance' => (float) $order->total_amount - (float) $paid,
        ]);
    }

    public function destroy(Payment $payment, DeletePaymentAction $action): JsonResponse
    {
        $action->execute($payment);

        return response()->json([
            'success' => true,
            'message' => 'Payment deleted successfully.',
        ]);
    }
}
