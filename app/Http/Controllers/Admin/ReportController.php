<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Data for charts
        $statusDistribution = DB::table('schools')
            ->select('status', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();

        $stateDistribution = DB::table('schools')
            ->join('states', 'schools.state_id', '=', 'states.id')
            ->select('states.name as state_name', DB::raw('count(schools.id) as total'))
            ->whereNull('schools.deleted_at')
            ->groupBy('states.name')
            ->orderByDesc('total')
            ->get();

        // Let's get registrations by date (last 30 days)
        $registrationsOverTime = DB::table('schools')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.index', compact('statusDistribution', 'stateDistribution', 'registrationsOverTime'));
    }
}
