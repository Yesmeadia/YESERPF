<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterSchoolRequest;
use App\Models\Category;
use App\Models\School;
use App\Models\SchoolStatusHistory;
use App\Models\Setting;
use App\Models\State;
use App\Models\Zone;
use App\Services\SchoolService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        $rawZones = Zone::where('is_active', true)
            ->with(['schools' => function ($q) use ($filters) {
                if (!empty($filters['search'])) {
                    $q->where('name', 'like', '%' . $filters['search'] . '%');
                }
                if (!empty($filters['status'])) {
                    $q->where('status', $filters['status']);
                }
                $q->with('statusHistories');
            }])
            ->get();

        $zoneGroups = $rawZones->groupBy(function ($zone) {
            return trim($zone->name);
        })->map(function ($zones, $name) {
            $schools = $zones->pluck('schools')->flatten()->unique('id');
            return (object) [
                'name' => $name,
                'schools' => $schools,
            ];
        })->filter(function ($zoneGroup) {
            return $zoneGroup->schools->isNotEmpty();
        })->values();

        $totalSchools = School::count();
        $onGoingCount = School::onGoing()->count();
        $trialCount = School::trialRunning()->count();
        $constructionCount = School::underConstruction()->count();
        $registeredCount = School::registered()->count();

        $operationalPct = $totalSchools > 0 ? round(($onGoingCount / $totalSchools) * 100, 1) : 100.0;

        $overallStatus = 'operational';
        $statusText = 'All Systems Operational';

        if ($registeredCount > 0 && $constructionCount === 0 && $trialCount === 0) {
            $overallStatus = 'operational';
            $statusText = 'Systems Operational & Onboarding Active';
        } elseif ($constructionCount > 0 && $trialCount === 0 && $registeredCount === 0) {
            $overallStatus = 'maintenance';
            $statusText = 'Scheduled Maintenance & Upgrades Active';
        } elseif ($trialCount > 0 && $constructionCount === 0 && $registeredCount === 0) {
            $overallStatus = 'trial';
            $statusText = 'Trial Phase Running Smoothly';
        } elseif ($registeredCount > 0 || $trialCount > 0 || $constructionCount > 0) {
            $overallStatus = 'operational';
            $statusText = 'Active Registration & Operational Phase';
        }

        $stats = [
            'total'               => $totalSchools,
            'on_going'            => $onGoingCount,
            'trial_running'       => $trialCount,
            'under_construction'  => $constructionCount,
            'registered'          => $registeredCount,
            'total_students'      => School::onGoing()->sum('total_students'),
            'operational_pct'     => $operationalPct,
            'overall_status'      => $overallStatus,
            'status_text'         => $statusText,
            'last_updated'        => now()->setTimezone('Asia/Kolkata')->format('M d, Y - H:i:s') . ' IST',
        ];

        // Fetch recent status history updates grouped by zone
        $recentUpdatesByZone = SchoolStatusHistory::with(['school.zone', 'user'])
            ->latest()
            ->take(50)
            ->get()
            ->groupBy(function ($item) {
                return $item->school && $item->school->zone ? $item->school->zone->name : 'General';
            });

        return view('public.home', compact('schools', 'states', 'categories', 'stats', 'filters', 'zoneGroups', 'recentUpdatesByZone'));
    }

    public function showRegistrationForm()
    {
        $registration_enabled = Setting::get('registration_enabled', '1');
        $registration_disabled_notice = Setting::get('registration_disabled_notice', 'Campus registrations are currently paused for institutional census audit.');

        $states = State::where('is_active', true)->orderBy('name')->get();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('public.register', compact('states', 'categories', 'registration_enabled', 'registration_disabled_notice'));
    }

    public function register(RegisterSchoolRequest $request): JsonResponse
    {
        $registration_enabled = Setting::get('registration_enabled', '1');
        if ($registration_enabled === '0') {
            $notice = Setting::get('registration_disabled_notice', 'Campus registrations are currently paused.');
            return response()->json([
                'success' => false,
                'message' => $notice,
            ], 403);
        }
        try {
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
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('School registration DB error: ' . $e->getMessage());

            // Duplicate SUIC code (unique constraint violation)
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'This SUIC code is already registered. Please use a unique code.',
                    'errors' => ['suic_code' => ['This SUIC code is already taken by another school.']],
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'A database error occurred. Please check your input and try again.',
            ], 500);
        } catch (\Throwable $e) {
            Log::error('School registration error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred. Please try again.',
            ], 500);
        }
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

    /**
     * Check if a given domain/URL is currently live (accessible).
     * GET /api/check-domain-live?url=https://example.com
     */
    public function checkDomainLive(Request $request): JsonResponse
    {
        $url = trim($request->query('url', ''));

        if (empty($url)) {
            return response()->json(['live' => false, 'message' => 'No URL provided.']);
        }

        // Ensure scheme prefix for curl
        if (!preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://' . $url;
        }

        // Basic URL format check
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return response()->json(['live' => false, 'message' => 'Invalid URL format.']);
        }

        try {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_NOBODY         => true,   // HEAD request
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 5,
                CURLOPT_TIMEOUT        => 8,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; YesDomainChecker/1.0)',
            ]);

            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error    = curl_error($ch);
            curl_close($ch);

            if ($error) {
                return response()->json([
                    'live'        => false,
                    'status_code' => 0,
                    'message'     => 'Domain is not reachable. (' . $error . ')',
                ]);
            }

            $live = ($httpCode >= 200 && $httpCode < 400);

            return response()->json([
                'live'        => $live,
                'status_code' => $httpCode,
                'message'     => $live
                    ? "Domain is live and running! (HTTP {$httpCode})"
                    : "Domain returned HTTP {$httpCode}. It may not be running correctly.",
            ]);
        } catch (\Throwable $e) {
            Log::error('Domain live check error: ' . $e->getMessage());
            return response()->json(['live' => false, 'status_code' => 0, 'message' => 'Unable to reach the domain. Please verify the URL.']);
        }
    }

    /**
     * Check if a desired new domain is available (not yet registered).
     * GET /api/check-domain-availability?domain=example.com
     */
    public function checkDomainAvailability(Request $request): JsonResponse
    {
        $domain = strtolower(trim($request->query('domain', '')));

        if (empty($domain)) {
            return response()->json(['available' => false, 'message' => 'No domain provided.']);
        }

        // Strip scheme if accidentally included
        $domain = preg_replace('/^https?:\/\//i', '', $domain);
        $domain = rtrim($domain, '/');
        // Remove www. prefix for the check
        $domain = preg_replace('/^www\./i', '', $domain);

        // Basic domain format validation
        if (!preg_match('/^([a-z0-9\-]+\.)+[a-z]{2,}$/', $domain)) {
            return response()->json(['available' => false, 'message' => 'Invalid domain format. Use e.g. example.com']);
        }

        // Check if domain is already registered by looking for DNS A/AAAA/NS records
        $hasA    = checkdnsrr($domain, 'A');
        $hasAAAA = checkdnsrr($domain, 'AAAA');
        $hasNS   = checkdnsrr($domain, 'NS');
        $hasMX   = checkdnsrr($domain, 'MX');

        $registered = $hasA || $hasAAAA || $hasNS || $hasMX;

        // Also check if desired domain already exists in our DB
        $takenInDb = School::where('desired_domain', $domain)->exists();

        if ($takenInDb) {
            return response()->json([
                'available' => false,
                'message'   => 'This domain has already been requested by another school in our system.',
            ]);
        }

        if ($registered) {
            return response()->json([
                'available' => false,
                'message'   => "Domain '{$domain}' is already registered and not available.",
            ]);
        }

        return response()->json([
            'available' => true,
            'message'   => "Domain '{$domain}' appears to be available!",
        ]);
    }
}
