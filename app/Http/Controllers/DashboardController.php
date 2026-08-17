<?php

namespace App\Http\Controllers;

use App\Actions\Dashboard\GetDashboardStatsAction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private readonly GetDashboardStatsAction $getDashboardStats,
    ) {}

    public function index(): View
    {
        return view('dashboard.index', [
            'stats' => $this->getDashboardStats->execute(),
        ]);
    }
}
