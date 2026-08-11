<?php

namespace App\Repository\Interfaces;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as BaseCollection;

interface ReportInterface
{
    /**
     * Total revenue collected per day, within the given date range.
     */
    public function revenueByDateRange(Carbon $from, Carbon $to): BaseCollection;

    /**
     * Order counts grouped by status, within the given date range.
     */
    public function orderStatusCounts(Carbon $from, Carbon $to): Collection;

    /**
     * Order counts grouped by dress type, within the given date range.
     */
    public function dressTypeCounts(Carbon $from, Carbon $to): Collection;

    /**
     * All orders that still have a balance due, largest balance first.
     */
    public function outstandingDues(): Collection;

    /**
     * Customers ranked by total order value.
     */
    public function topCustomers(int $limit = 10): Collection;
}
