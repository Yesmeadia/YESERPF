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

    public function getDashboardMetrics(?int $stateId = null, ?int $zoneId = null): array
    {
        // For status counts, we might want to filter as well? 
        // The user asked for "sate/zone seletor on the State Distribution section", but filtering the whole dashboard makes sense.
        // Let's filter the state distribution query explicitly.
        
        $statusCounts = $this->schoolRepository->getStatusCounts();
        
        $totalStudentsQuery = School::where('status', 'on_going');
        $totalTeachersQuery = School::where('status', 'on_going');
        
        if ($stateId) {
            $totalStudentsQuery->where('state_id', $stateId);
            $totalTeachersQuery->where('state_id', $stateId);
        }
        if ($zoneId) {
            $totalStudentsQuery->where('zone_id', $zoneId);
            $totalTeachersQuery->where('zone_id', $zoneId);
        }

        $totalStudents = $totalStudentsQuery->sum('total_students');
        $totalTeachers = $totalTeachersQuery->sum('total_teachers');

        // State distribution
        $stateDistributionQuery = DB::table('schools')
            ->join('states', 'schools.state_id', '=', 'states.id')
            ->whereNull('schools.deleted_at')
            ->select('states.name as state_name', DB::raw('count(schools.id) as total'));
            
        if ($stateId) {
            $stateDistributionQuery->where('schools.state_id', $stateId);
        }
        if ($zoneId) {
            $stateDistributionQuery->where('schools.zone_id', $zoneId);
        }

        $stateDistribution = $stateDistributionQuery
            ->groupBy('states.name')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Category distribution
        $categoryDistributionQuery = DB::table('schools')
            ->join('categories', 'schools.category_id', '=', 'categories.id')
            ->whereNull('schools.deleted_at')
            ->select('categories.name as category_name', DB::raw('count(schools.id) as total'));
            
        if ($stateId) {
            $categoryDistributionQuery->where('schools.state_id', $stateId);
        }
        if ($zoneId) {
            $categoryDistributionQuery->where('schools.zone_id', $zoneId);
        }

        $categoryDistribution = $categoryDistributionQuery
            ->groupBy('categories.name')
            ->get();

        // Recent activity
        $recentActivities = ActivityLog::with(['user', 'school'])
            ->latest()
            ->limit(10)
            ->get();

        // Recent schools
        $recentSchoolsQuery = School::with(['state', 'zone', 'category'])
            ->latest()
            ->limit(6);
            
        if ($stateId) {
            $recentSchoolsQuery->where('state_id', $stateId);
        }
        if ($zoneId) {
            $recentSchoolsQuery->where('zone_id', $zoneId);
        }
        
        $recentSchools = $recentSchoolsQuery->get();

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
