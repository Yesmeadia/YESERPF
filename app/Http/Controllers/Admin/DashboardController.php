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

    public function index(Request $request)
    {
        $stateId = $request->input('state_id');
        $zoneId = $request->input('zone_id');

        $data = $this->analyticsService->getDashboardMetrics($stateId, $zoneId);
        
        $data['states'] = \App\Models\State::orderBy('name')->get();
        $data['zones'] = \App\Models\Zone::orderBy('name')->get();
        $data['selectedState'] = $stateId;
        $data['selectedZone'] = $zoneId;

        return view('admin.dashboard.index', $data);
    }
}
