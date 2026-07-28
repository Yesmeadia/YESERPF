@extends('layouts.app')

@section('title', 'YES INDIA SCHOOLS SYSTEM STATUS')

@section('content')

    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto space-y-8 font-sans font-normal text-slate-800">

        <!-- ==================== HEADER BAR ==================== -->
        <div class="flex items-center justify-between pt-2 pb-1">
            <h1 class="text-base sm:text-lg font-bold text-[#1f1659] tracking-wider uppercase font-sans">
                YES INDIA SCHOOLS SYSTEM STATUS
            </h1>
            <div
                class="flex items-center gap-2 text-[11px] sm:text-xs font-semibold text-slate-500 uppercase tracking-widest font-sans">
                <span class="w-2 h-2 rounded-full bg-emerald-500 dot-blink"></span>
                <span>LIVE MONITORING</span>
            </div>
        </div>

        <!-- ==================== HERO TOPIC BANNER (DYNAMIC) ==================== -->
        @php
            $overallStatus = $stats['overall_status'] ?? 'operational';
            $statusText = $stats['status_text'] ?? 'All Systems Operational';
            $bannerBg = 'bg-[#3af0a4]';
            $heroIcon = 'fa-check';
            $statusDesc = 'Systems across all zones are performing within normal parameters.';
            
            if (isset($zoneGroups) && $zoneGroups->isEmpty()) {
                $overallStatus = 'awaiting_registration';
                $statusText = 'Awaiting registration';
                $bannerBg = 'bg-yellow-300';
                $heroIcon = 'fa-clock-rotate-left';
                $statusDesc = 'No zones have been registered yet.';
            } elseif ($overallStatus === 'maintenance') {
                $bannerBg = 'bg-amber-200';
                $heroIcon = 'fa-screwdriver-wrench';
            } elseif ($overallStatus === 'degraded') {
                $bannerBg = 'bg-rose-200';
                $heroIcon = 'fa-triangle-exclamation';
            } elseif ($overallStatus === 'trial') {
                $bannerBg = 'bg-purple-200';
                $heroIcon = 'fa-flask';
            }
        @endphp

        <div
            class="{{ $bannerBg }} rounded-2xl p-6 sm:p-7 text-[#044e37] flex flex-col sm:flex-row sm:items-center justify-between gap-5 shadow-sm">
            <div class="flex items-center gap-4">
                <div
                    class="w-10 h-10 rounded-full bg-[#044e37] text-white flex items-center justify-center text-lg font-bold shrink-0">
                    <i class="fa-solid {{ $heroIcon }}"></i>
                </div>
                <div>
                    <h2 class="text-xl sm:text-2xl font-normal tracking-tight leading-tight">
                        {{ $statusText }}
                    </h2>
                    <p class="text-xs sm:text-sm font-normal text-[#065f46] mt-0.5">
                        {{ $statusDesc }}
                    </p>
                </div>
            </div>
            <div class="text-left sm:text-right shrink-0">
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#065f46]">
                    UPTIME LAST 45 DAYS
                </div>
                <div class="text-2xl sm:text-3xl font-bold font-mono text-[#044e37] mt-0.5">
                    {{ $stats['operational_pct'] ?? '99.98' }}%
                </div>
            </div>
        </div>

        <!-- ==================== ZONE GROUPS — STATUS ROWS + RECENT UPDATES PER ZONE ==================== -->
        <div class="space-y-10 pt-2">
            @if($zoneGroups->isEmpty())
                <div class="bg-white rounded-xl p-8 text-center text-slate-500 border border-slate-200 font-normal">
                    No zone status records available.
                </div>
            @else
                @foreach($zoneGroups as $zoneIndex => $zoneGroup)
                    @if($zoneGroup->schools->isEmpty())
                        @continue
                    @endif
                    @php
                        $operationalCount = $zoneGroup->schools->where('status', 'on_going')->count();
                        $impactedCount = $zoneGroup->schools->count() - $operationalCount;
                        $zoneUpdates = $recentUpdatesByZone->get($zoneGroup->name, collect());
                    @endphp

                    <div class="space-y-3" x-data="{ showUpdates: false }">

                        <!-- Zone Section Header -->
                        <div class="flex items-center justify-between border-b border-slate-200/90 pb-2">
                            <h3 class="text-base font-semibold text-[#1f1659]">
                                {{ Str::endsWith(strtolower($zoneGroup->name), 'zone') ? $zoneGroup->name : $zoneGroup->name . ' Zone' }}
                            </h3>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-normal text-slate-500">
                                    @if($impactedCount > 0)
                                        <span class="text-amber-800 font-semibold">{{ $impactedCount }}
                                            {{ Str::plural('School', $impactedCount) }} Impacted</span>
                                    @else
                                        <span>{{ $operationalCount }} {{ Str::plural('School', $operationalCount) }} Operational</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <!-- Schools Rows -->
                        <div class="space-y-2.5">
                            @foreach($zoneGroup->schools as $schoolIndex => $school)
                                @php
                                    // ─── CONFIG ──────────────────────────────────────────────────────
                                    $totalBars = 48; // each bar = 1 calendar day
                                    $now = now()->setTimezone('Asia/Kolkata');
                                    $today = $now->copy()->startOfDay();

                                    $schoolCreatedAt = $school->created_at
                                        ? $school->created_at->setTimezone('Asia/Kolkata')
                                        : $now->copy();

                                    // ─── BUILD INTERVALS with REAL timestamps ─────────────────────────
                                    $sortedHistories = $school->statusHistories
                                        ? $school->statusHistories->sortBy('created_at')
                                        : collect();

                                    $windowStart = $today->copy()->subDays($totalBars - 1);
                                    $ivList = [];

                                    // Add the creation interval
                                    $ivList[] = ['from' => $schoolCreatedAt->copy(), 'status' => 'registered'];

                                    foreach ($sortedHistories as $h) {
                                        $ivList[] = [
                                            'from' => $h->created_at->setTimezone('Asia/Kolkata'),
                                            'status' => $h->status,
                                        ];
                                    }

                                    // Sort oldest → newest
                                    usort($ivList, fn($a, $b) => $a['from']->timestamp <=> $b['from']->timestamp);

                                    // ─── MAP EACH DATE BAR TO ITS ACTIVE STATUS ───────────────────────
                                    $statusColors = [
                                        'on_going' => 'bg-[#15803d]',
                                        'trial_running' => 'bg-[#7e22ce]',
                                        'under_construction' => 'bg-[#d97706]',
                                        'registered' => 'bg-[#e11d48]',
                                    ];
                                    $statusLabels = [
                                        'on_going' => 'Operational',
                                        'trial_running' => 'Trial Running',
                                        'under_construction' => 'Under Maintenance',
                                        'registered' => 'Registered / Pending',
                                    ];

                                    $bars = [];
                                    for ($d = $totalBars - 1; $d >= 0; $d--) {
                                        $barDayStart = $today->copy()->subDays($d);
                                        $barDayEnd = $barDayStart->copy()->endOfDay();

                                        $formattedDate = $barDayStart->format('M d, Y');

                                        if ($barDayEnd->lt($schoolCreatedAt)) {
                                            $bars[] = [
                                                'color' => 'bg-slate-300',
                                                'tip' => "{$formattedDate}: Not Registered Yet",
                                            ];
                                        } else {
                                            $activeStatus = 'registered';
                                            foreach ($ivList as $iv) {
                                                if ($iv['from']->lte($barDayEnd)) {
                                                    $activeStatus = $iv['status'];
                                                }
                                                if ($iv['from']->gt($barDayEnd))
                                                    break;
                                            }

                                            $bars[] = [
                                                'color' => $statusColors[$activeStatus] ?? 'bg-[#15803d]',
                                                'tip' => "{$formattedDate}: " . ($statusLabels[$activeStatus] ?? ucfirst($activeStatus)),
                                            ];
                                        }
                                    }
                                @endphp

                                <div
                                    class="bg-white rounded-xl border border-slate-200/90 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:border-slate-300 transition-all font-normal">

                                    <!-- School Name -->
                                    <div class="sm:w-2/5 shrink-0">
                                        <h4 class="text-sm font-semibold text-slate-800">{{ $school->name }}</h4>
                                    </div>

                                    <!-- Enlarged Date-Based Historical Status Bar -->
                                    <div
                                        class="flex items-center justify-end gap-[3px] flex-1 max-w-full sm:max-w-xl overflow-hidden py-1">
                                        @foreach($bars as $bar)
                                            <span title="{{ $bar['tip'] }}"
                                                class="h-9 w-[3.5px] rounded-[1px] {{ $bar['color'] }} opacity-90 hover:opacity-100 hover:scale-y-110 transition-all shrink-0 cursor-pointer">
                                            </span>
                                        @endforeach
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- ==================== RECENT UPDATES PER ZONE (Collapsible) ==================== -->
                        @if($zoneUpdates->isNotEmpty())
                            <div class="mt-1">
                                <!-- Show / Hide Toggle Button -->
                                <button @click="showUpdates = !showUpdates"
                                    class="flex items-center gap-2 text-xs font-semibold text-[#1f1659] hover:text-indigo-900 transition-colors py-1.5">
                                    <i class="fa-solid" :class="showUpdates ? 'fa-chevron-up' : 'fa-chevron-down'"
                                        style="font-size: 10px;"></i>
                                    <span
                                        x-text="showUpdates ? 'Hide Updates for {{ $zoneGroup->name }} Zone' : 'Show Updates for {{ $zoneGroup->name }} Zone (' + {{ $zoneUpdates->count() }} + ')'"></span>
                                </button>

                                <!-- Updates Panel -->
                                <div x-show="showUpdates" x-cloak x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="mt-2 bg-[#f2f0f9] rounded-2xl p-5 sm:p-6 border border-slate-200/70 space-y-4">
                                    <h4 class="text-sm font-bold text-slate-900">
                                        Recent Updates — {{ $zoneGroup->name }} Zone
                                    </h4>
                                    <div
                                        class="relative pl-5 space-y-5 before:absolute before:left-1.5 before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-300">
                                        @foreach($zoneUpdates->take(5) as $update)
                                            @php
                                                $upSchoolName = $update->school ? $update->school->name : 'System Portal';
                                                $upStatus = match ($update->status) {
                                                    'on_going' => 'On Going',
                                                    'trial_running' => 'Trial Running',
                                                    'under_construction' => 'Under Maintenance',
                                                    'registered' => 'Registered',
                                                    default => ucfirst(str_replace('_', ' ', $update->status))
                                                };
                                                $dotColor = match ($update->status) {
                                                    'on_going' => 'bg-[#15803d]',
                                                    'trial_running' => 'bg-[#7e22ce]',
                                                    'under_construction' => 'bg-[#d97706]',
                                                    'registered' => 'bg-[#e11d48]',
                                                    default => 'bg-[#1f1659]'
                                                };
                                            @endphp
                                            <div class="relative space-y-0.5 font-normal">
                                                <span
                                                    class="absolute -left-[20px] top-1.5 w-3 h-3 rounded-full {{ $dotColor }} border-2 border-[#f2f0f9]"></span>
                                                <div class="text-xs font-semibold text-[#1f1659]">
                                                    {{ $update->created_at ? $update->created_at->setTimezone('Asia/Kolkata')->format('M d, H:i') . ' IST' : now()->setTimezone('Asia/Kolkata')->format('M d, H:i') . ' IST' }}
                                                </div>
                                                <div class="text-xs font-bold text-slate-900">
                                                    {{ $upSchoolName }}: Status changed to <span
                                                        class="font-extrabold">{{ $upStatus }}</span>
                                                </div>
                                                @if($update->notes)
                                                    <p class="text-xs text-slate-600 font-normal leading-relaxed max-w-3xl pt-0.5">
                                                        {{ $update->notes }}
                                                    </p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                @endforeach
            @endif
        </div>

        <!-- ==================== STATUS COLOR LEGEND & REGISTER LINK ==================== -->
        <div
            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs font-semibold text-slate-600 border-t border-slate-200 pt-4">
            <div class="flex flex-wrap items-center gap-4">
                <span class="text-slate-400 uppercase tracking-wider text-[10px]">Status Key:</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#15803d] inline-block"></span>
                    On Going</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#7e22ce] inline-block"></span>
                    Trial Running</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#d97706] inline-block"></span>
                    Under Maintenance</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-[#e11d48] inline-block"></span>
                    Registered / Pending</span>
                <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-slate-300 inline-block"></span>
                    Not Yet Registered</span>
            </div>
            <a href="{{ route('register') }}"
                class="inline-flex items-center gap-1 text-xs font-semibold text-[#1f1659] hover:text-indigo-700 hover:underline transition-colors shrink-0">
                <span>Register Campus</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

    </div>

@endsection