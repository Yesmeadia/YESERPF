<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterSchoolRequest;
use App\Http\Requests\UpdateSchoolStatusRequest;
use App\Services\AnalyticsService;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolApiController extends Controller
{
    public function __construct(
        protected SchoolService $schoolService,
        protected AnalyticsService $analyticsService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'state_id', 'zone_id', 'category_id', 'search', 'sort_by', 'sort_order']);
        $perPage = (int) $request->query('per_page', 15);

        $schools = $this->schoolService->getSchools($filters, min($perPage, 100));

        return response()->json([
            'success' => true,
            'data' => $schools->items(),
            'pagination' => [
                'total' => $schools->total(),
                'per_page' => $schools->perPage(),
                'current_page' => $schools->currentPage(),
                'last_page' => $schools->lastPage(),
            ],
        ]);
    }

    public function store(RegisterSchoolRequest $request): JsonResponse
    {
        $school = $this->schoolService->registerSchool(
            $request->validated(),
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => 'School created successfully.',
            'data' => $school,
        ], 201);
    }

    public function show(int $id): JsonResponse
    {
        $school = $this->schoolService->findSchool($id);

        if (!$school) {
            return response()->json([
                'success' => false,
                'message' => 'School record not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $school,
        ]);
    }

    public function updateStatus(UpdateSchoolStatusRequest $request, int $id): JsonResponse
    {
        $school = $this->schoolService->changeStatus(
            $id,
            $request->validated('status'),
            $request->validated('rejection_reason') ?? $request->validated('notes'),
            $request->user()?->id,
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => 'School status updated successfully.',
            'data' => $school,
        ]);
    }

    public function analytics(): JsonResponse
    {
        $metrics = $this->analyticsService->getDashboardMetrics();

        return response()->json([
            'success' => true,
            'data' => $metrics,
        ]);
    }
}
