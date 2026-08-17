<?php

namespace App\Actions\Dashboard;

use App\Repository\Interfaces\ReportInterface;

class GetDashboardStatsAction
{
    public function __construct(
        private readonly ReportInterface $reports,
    ) {}

    /**
     * @return array{total_customers: int, total_orders: int, pending_orders: int, completed_orders: int, revenue: float, todays_orders: int}
     */
    public function execute(): array
    {
        return $this->reports->dashboardSummary();
    }
}
