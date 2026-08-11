<?php

namespace App\Http\Controllers;

use App\Repository\Interfaces\ReportInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        private readonly ReportInterface $reports,
    ) {}

    public function index(Request $request): View
    {
        $from = $request->filled('from')
            ? Carbon::parse($request->input('from'))
            : now()->startOfMonth();

        $to = $request->filled('to')
            ? Carbon::parse($request->input('to'))
            : now()->endOfMonth();

        $revenue = $this->reports->revenueByDateRange($from, $to);
        $statusCounts = $this->reports->orderStatusCounts($from, $to);
        $dressTypeCounts = $this->reports->dressTypeCounts($from, $to);
        $outstandingDues = $this->reports->outstandingDues();
        $topCustomers = $this->reports->topCustomers();

        $totalRevenue = $revenue->sum('total');
        $totalOrders = $statusCounts->sum('total');
        $totalOutstanding = $outstandingDues->sum('balance');

        return view('dashboard.reports.index', compact(
            'revenue', 'statusCounts', 'dressTypeCounts', 'outstandingDues', 'topCustomers',
            'totalRevenue', 'totalOrders', 'totalOutstanding', 'from', 'to',
        ));
    }
}
