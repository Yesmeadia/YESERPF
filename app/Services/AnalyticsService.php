<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\School;
use App\Models\State;
use App\Repositories\Contracts\SchoolRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    public function __construct(
        protected SchoolRepositoryInterface $schoolRepository
    ) {}

    public function getDashboardMetrics(): array
    {
        $statusCounts = $this->schoolRepository->getStatusCounts();

        $totalStudents = School::where('status', 'on_going')->sum('total_students');
        $totalTeachers = School::where('status', 'on_going')->sum('total_teachers');

        // State distribution
        $stateDistribution = DB::table('schools')
            ->join('states', 'schools.state_id', '=', 'states.id')
            ->whereNull('schools.deleted_at')
            ->select('states.name as state_name', DB::raw('count(schools.id) as total'))
            ->groupBy('states.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Category distribution
        $categoryDistribution = DB::table('schools')
            ->join('categories', 'schools.category_id', '=', 'categories.id')
            ->whereNull('schools.deleted_at')
            ->select('categories.name as category_name', DB::raw('count(schools.id) as total'))
            ->groupBy('categories.name')
            ->get();

        // Recent activity
        $recentActivities = ActivityLog::with(['user', 'school'])
            ->latest()
            ->limit(10)
            ->get();

        // Recent schools
        $recentSchools = School::with(['state', 'zone', 'category'])
            ->latest()
            ->limit(6)
            ->get();

        return [
            'status_counts' => $statusCounts,
            'total_students' => $totalStudents,
            'total_teachers' => $totalTeachers,
            'state_distribution' => $stateDistribution,
            'category_distribution' => $categoryDistribution,
            'recent_activities' => $recentActivities,
            'recent_schools' => $recentSchools,
        ];
    }
}
