<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSchoolStoreRequest;
use App\Http\Requests\AdminSchoolUpdateRequest;
use App\Http\Requests\UpdateSchoolStatusRequest;
use App\Models\Category;
use App\Models\School;
use App\Models\State;
use App\Models\Zone;
use App\Services\ExportService;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SchoolManagementController extends Controller
{
    public function __construct(
        protected SchoolService $schoolService,
        protected ExportService $exportService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'state_id', 'category_id', 'search', 'sort_by', 'sort_order']);
        $schools = $this->schoolService->getSchools($filters, 15);

        $states = State::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('admin.schools.index', compact('schools', 'states', 'categories', 'filters'));
    }

    public function show(int $id)
    {
        $school = $this->schoolService->findSchool($id);
        if (!$school) {
            abort(404, 'School not found');
        }

        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'school'           => $school,
                'status_histories' => $school->statusHistories,
                'activity_logs'    => $school->activityLogs,
            ]);
        }

        return view('admin.schools.show', compact('school'));
    }

    public function edit(int $id)
    {
        $school = $this->schoolService->findSchool($id);
        if (!$school) {
            abort(404, 'School not found');
        }

        $states     = State::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $zones      = Zone::where('state_id', $school->state_id)
                         ->where('is_active', true)
                         ->orderBy('name')
                         ->get();

        return view('admin.schools.edit', compact('school', 'states', 'categories', 'zones'));
    }

    public function update(AdminSchoolUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $data = $request->validated();

            // Recompute legacy totals
            $data['total_students'] = ($data['male_students'] ?? 0) + ($data['female_students'] ?? 0);
            $data['total_teachers'] = ($data['teaching_male_staff'] ?? 0)
                                    + ($data['teaching_female_staff'] ?? 0)
                                    + ($data['non_teaching_male_staff'] ?? 0)
                                    + ($data['non_teaching_female_staff'] ?? 0);

            $school = $this->schoolService->updateSchool($id, $data, auth()->id(), $request->ip());

            return response()->json([
                'success' => true,
                'message' => 'School details updated successfully.',
                'school'  => $school,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('School update error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    public function updateStatus(UpdateSchoolStatusRequest $request, int $id): JsonResponse
    {
        $school = $this->schoolService->changeStatus(
            $id,
            $request->validated('status'),
            $request->validated('rejection_reason') ?? $request->validated('notes'),
            auth()->id(),
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => "School status updated to " . strtoupper($school->status),
            'school' => $school,
        ]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->schoolService->deleteSchool($id, $request->ip());

        return response()->json([
            'success' => true,
            'message' => 'School deleted successfully.',
        ]);
    }

    public function exportCsv(Request $request)
    {
        $filters = $request->only(['status', 'state_id']);
        return $this->exportService->exportSchoolsCsv($filters);
    }
}
