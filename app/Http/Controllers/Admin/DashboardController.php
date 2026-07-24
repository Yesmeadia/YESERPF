<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected AnalyticsService $analyticsService
    ) {}

    public function index()
    {
        $data = $this->analyticsService->getDashboardMetrics();
        return view('admin.dashboard.index', $data);
    }
}
