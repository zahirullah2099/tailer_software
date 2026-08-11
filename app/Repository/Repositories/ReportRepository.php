<?php

namespace App\Repository\Repositories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use App\Repository\Interfaces\ReportInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\DB;

class ReportRepository implements ReportInterface
{
    public function revenueByDateRange(Carbon $from, Carbon $to): BaseCollection
    {
        return Payment::whereBetween('paid_at', [$from->startOfDay(), $to->endOfDay()])
            ->select(DB::raw('DATE(paid_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(fn ($row) => [
                'date' => $row->date,
                'total' => (float) $row->total,
            ]);
    }

    public function orderStatusCounts(Carbon $from, Carbon $to): Collection
    {
        return Order::whereBetween('order_date', [$from->startOfDay(), $to->endOfDay()])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
    }

    public function dressTypeCounts(Carbon $from, Carbon $to): Collection
    {
        return Order::whereBetween('order_date', [$from->startOfDay(), $to->endOfDay()])
            ->select('dress_type', DB::raw('count(*) as total'))
            ->groupBy('dress_type')
            ->get();
    }

    public function outstandingDues(): Collection
    {
        return Order::with('customer')
            ->withSum('payments', 'amount')
            ->get()
            ->map(function ($order) {
                $order->balance = $order->total_amount - ($order->payments_sum_amount ?? 0);

                return $order;
            })
            ->filter(fn ($order) => $order->balance > 0)
            ->sortByDesc('balance')
            ->values();
    }

    public function topCustomers(int $limit = 10): Collection
    {
        return Customer::withSum('orders', 'total_amount')
            ->withCount('orders')
            ->having('orders_count', '>', 0)
            ->orderByDesc('orders_sum_total_amount')
            ->limit($limit)
            ->get();
    }
}
