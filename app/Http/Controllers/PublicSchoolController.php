<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSchoolRequest;
use App\Models\Category;
use App\Models\School;
use App\Models\State;
use App\Models\Zone;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicSchoolController extends Controller
{
    public function __construct(
        protected SchoolService $schoolService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'state_id', 'zone_id', 'category_id', 'search']);
        $schools = $this->schoolService->getSchools($filters, 12);

        $states = State::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        $zoneGroups = Zone::where('is_active', true)
            ->whereHas('schools')
            ->with(['schools' => function ($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get()
            // Merge zones that share the same name into a single group
            ->groupBy('name')
            ->map(function ($zones) {
                $merged = $zones->first();
                $merged->setRelation('schools', $zones->pluck('schools')->flatten()->sortBy('name')->values());
                return $merged;
            })
            ->values();

        $stats = [
            'total'              => School::count(),
            'on_going'           => School::onGoing()->count(),
            'registered'         => School::registered()->count(),
            'trial_running'      => School::trialRunning()->count(),
            'total_students'     => School::onGoing()->sum('total_students'),
        ];

        return view('public.home', compact('schools', 'states', 'categories', 'stats', 'filters', 'zoneGroups'));
    }

    public function showRegistrationForm()
    {
        $states = State::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('public.register', compact('states', 'categories'));
    }

    public function register(RegisterSchoolRequest $request): JsonResponse
    {
        $school = $this->schoolService->registerSchool(
            $request->validated(),
            $request->ip()
        );

        return response()->json([
            'success' => true,
            'message' => 'School registration submitted successfully! Your application is under review.',
            'code' => $school->code,
            'school' => [
                'id' => $school->id,
                'name' => $school->name,
                'code' => $school->code,
                'status' => strtoupper($school->status),
            ],
        ], 201);
    }

    public function getZones(Request $request): JsonResponse
    {
        try {
            $stateId = $request->query('state_id');
            if (!$stateId) {
                return response()->json([]);
            }

            $zones = Zone::where('state_id', $stateId)
                ->where('is_active', true)
                ->orderBy('name')
                ->get(['id', 'name', 'code']);

            return response()->json($zones);
        } catch (\Throwable $e) {
            return response()->json(['error' => 'Could not load zones: ' . $e->getMessage()], 500);
        }
    }

    public function checkSuic(Request $request): JsonResponse
    {
        $code = strtoupper(trim($request->query('code', '')));
        if (strlen($code) !== 6 || !preg_match('/^[A-Z]{6}$/', $code)) {
            return response()->json(['valid' => false, 'available' => false, 'message' => 'SUIC must be 6 uppercase letters.']);
        }

        $exists = School::where('suic_code', $code)->orWhere('code', $code)->exists();
        if ($exists) {
            return response()->json(['valid' => true, 'available' => false, 'message' => 'This SUIC code is already taken. Please enter a unique code.']);
        }

        return response()->json(['valid' => true, 'available' => true, 'message' => 'SUIC code is available!']);
    }
}
