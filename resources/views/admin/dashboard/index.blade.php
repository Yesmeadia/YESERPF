@extends('layouts.app')

@section('title', 'Executive Dashboard — YES INDIA SCHOOLS ERP')

@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9ff !important;
            font-family: 'Figtree', sans-serif;
            font-weight: 400;
            color: #111c2d;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        /* Premium Cards */
        .premium-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .premium-card:hover {
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }

        /* Table Styles */
        .dash-table th {
            padding: 10px 12px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #505f76;
            border-bottom: 1px solid #e7eeff;
        }
        .dash-table td {
            padding: 14px 12px;
            font-size: 14px;
            vertical-align: middle;
            border-bottom: 1px solid #e7eeff;
        }
        .dash-table tbody tr:last-child td { border-bottom: none; }
        .dash-table tbody tr:hover { background: #f0f3ff; transition: background 0.15s; }

        /* Status Badges */
        .badge-on_going        { background: rgba(79,70,229,0.08); color: #4f46e5; }
        .badge-registered      { background: rgba(217,119,6,0.08); color: #d97706; }
        .badge-trial_running   { background: rgba(16,185,129,0.08); color: #10b981; }
        .badge-under_construction { background: rgba(186,26,26,0.08); color: #ba1a1a; }

        /* Donut SVG Chart */
        .donut-ring {
            transition: stroke-dashoffset 0.8s cubic-bezier(0.4,0,0.2,1);
        }

        /* Slim Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #dee8ff; border-radius: 10px; }
    </style>
@endsection

@section('content')

    <x-admin-sidebar active="dashboard" />

    <div class="lg:pl-64 min-h-screen" style="background-color: #f9f9ff;">

        <div class="p-5 md:p-8 max-w-[1440px] mx-auto w-full">

            {{-- ══════════════════════════════════════════ --}}
            {{-- HERO HEADER                               --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-[32px] font-semibold tracking-tight text-[#00030d] leading-10">Executive Overview</h2>
                    <p class="text-base text-[#505f76] mt-1">Operational real-time data for the YES Schools network.</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-4 py-2 bg-white border border-[#c5c6ce] rounded-lg text-sm text-[#505f76] shadow-sm">
                        <span class="material-symbols-outlined text-sm" style="font-size:18px;">calendar_today</span>
                        <span id="liveDateTime" class="text-xs font-medium">Loading…</span>
                    </div>
                    <a href="{{ route('register') }}"
                       class="flex items-center gap-2 px-4 py-2 bg-[#00030d] text-white rounded-lg text-sm font-semibold hover:opacity-90 active:scale-95 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-sm" style="font-size:18px;">add</span>
                        New School
                    </a>
                </div>
            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- KPI METRIC CARDS                          --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

                {{-- Total Schools --}}
                <div class="premium-card p-6 rounded-xl border border-[#f1f5f9] shadow-sm flex flex-col items-center text-center gap-4 min-h-[140px] justify-center">
                    <div class="w-12 h-12 flex items-center justify-center bg-[#dee8ff] rounded-full">
                        <span class="material-symbols-outlined text-[#00030d]">corporate_fare</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.06em] uppercase text-[#505f76] mb-1">Total Schools</p>
                        <p class="text-2xl font-bold text-[#111c2d]">{{ number_format($status_counts['total']) }}</p>
                    </div>
                </div>

                {{-- On Going --}}
                <div class="premium-card p-6 rounded-xl border border-[#f1f5f9] shadow-sm flex flex-col items-center text-center gap-4 min-h-[140px] justify-center">
                    <div class="w-12 h-12 flex items-center justify-center bg-[#d4e3ff] rounded-full">
                        <span class="material-symbols-outlined text-[#505f76]">sync</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.06em] uppercase text-[#505f76] mb-1">On Going</p>
                        <p class="text-2xl font-bold text-[#111c2d]">{{ number_format($status_counts['approved']) }}</p>
                    </div>
                </div>

                {{-- Registered --}}
                <div class="premium-card p-6 rounded-xl border border-[#f1f5f9] shadow-sm flex flex-col items-center text-center gap-4 min-h-[140px] justify-center">
                    <div class="w-12 h-12 flex items-center justify-center bg-[#e7eeff] rounded-full">
                        <span class="material-symbols-outlined text-[#45474d]">how_to_reg</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.06em] uppercase text-[#505f76] mb-1">Registered</p>
                        <p class="text-2xl font-bold text-[#111c2d]">{{ number_format($status_counts['pending']) }}</p>
                    </div>
                </div>

                {{-- Trial Phase --}}
                <div class="premium-card p-6 rounded-xl border border-[#f1f5f9] shadow-sm flex flex-col items-center text-center gap-4 min-h-[140px] justify-center">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full" style="background:rgba(217,119,6,0.1);">
                        <span class="material-symbols-outlined" style="color:#d97706;">experiment</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.06em] uppercase text-[#505f76] mb-1">Trial Phase</p>
                        <p class="text-2xl font-bold text-[#111c2d]">{{ number_format($status_counts['under_review']) }}</p>
                    </div>
                </div>

                {{-- Maintenance --}}
                <div class="premium-card p-6 rounded-xl border border-[#f1f5f9] shadow-sm flex flex-col items-center text-center gap-4 min-h-[140px] justify-center">
                    <div class="w-12 h-12 flex items-center justify-center bg-[#ffdad6] rounded-full">
                        <span class="material-symbols-outlined text-[#ba1a1a]">build</span>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold tracking-[0.06em] uppercase text-[#505f76] mb-1">Maintenance</p>
                        <p class="text-2xl font-bold text-[#111c2d]">{{ number_format($status_counts['rejected']) }}</p>
                    </div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- CHARTS ROW                                --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                {{-- Status Distribution Donut --}}
                <div class="premium-card p-6 rounded-xl flex flex-col bg-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-[#111c2d]">Status Distribution</h3>
                        <a href="{{ route('admin.schools.index') }}" class="text-xs font-bold uppercase tracking-widest text-[#00030d] hover:underline">View All</a>
                    </div>
                    <div class="relative flex-1 flex items-center justify-center min-h-[280px]">
                        @php
                            $total = max($status_counts['total'], 1);
                            $approved = $status_counts['approved'];
                            $pending  = $status_counts['pending'];
                            $review   = $status_counts['under_review'];
                            $rejected = $status_counts['rejected'];
                            $circ = 2 * M_PI * 80; // circumference ~502.65

                            // Compute offsets (segments stack as stroke-dashoffset)
                            $seg1 = ($approved / $total) * $circ;
                            $seg2 = ($pending  / $total) * $circ;
                            $seg3 = ($review   / $total) * $circ;

                            $off1 = $circ - $seg1;
                            $off2 = $circ - $seg2 + $off1;
                            $off3 = $circ - $seg3 + $off2 - ($circ - $seg2);
                        @endphp
                        <svg class="w-48 h-48 transform -rotate-90" viewBox="0 0 192 192">
                            {{-- Track --}}
                            <circle cx="96" cy="96" r="80" fill="transparent" stroke="#f0f3ff" stroke-width="20"/>
                            {{-- On Going (indigo) --}}
                            <circle cx="96" cy="96" r="80" fill="transparent"
                                stroke="#4f46e5"
                                stroke-width="20"
                                stroke-dasharray="{{ number_format($circ, 2) }}"
                                stroke-dashoffset="{{ number_format($circ - $seg1, 2) }}"
                                class="donut-ring"/>
                            {{-- Registered (amber) --}}
                            <circle cx="96" cy="96" r="80" fill="transparent"
                                stroke="#d97706"
                                stroke-width="20"
                                stroke-dasharray="{{ number_format($seg2, 2) }} {{ number_format($circ - $seg2, 2) }}"
                                stroke-dashoffset="{{ number_format($circ - $seg1, 2) }}"
                                class="donut-ring"/>
                            {{-- Trial (emerald) --}}
                            <circle cx="96" cy="96" r="80" fill="transparent"
                                stroke="#10b981"
                                stroke-width="20"
                                stroke-dasharray="{{ number_format($status_counts['under_review'] / $total * $circ, 2) }} {{ number_format($circ, 2) }}"
                                stroke-dashoffset="{{ number_format($circ - $seg1 - $seg2, 2) }}"
                                class="donut-ring"/>
                            {{-- Maintenance (red) --}}
                            <circle cx="96" cy="96" r="80" fill="transparent"
                                stroke="#ba1a1a"
                                stroke-width="20"
                                stroke-dasharray="{{ number_format($status_counts['rejected'] / $total * $circ, 2) }} {{ number_format($circ, 2) }}"
                                stroke-dashoffset="{{ number_format($circ - $seg1 - $seg2 - ($review / $total * $circ), 2) }}"
                                class="donut-ring"/>
                        </svg>
                        <div class="absolute inset-0 flex flex-col items-center justify-center">
                            <span class="text-3xl font-bold text-[#111c2d]">{{ number_format($status_counts['total']) }}</span>
                            <span class="text-xs text-[#505f76] uppercase tracking-widest mt-0.5">Units</span>
                        </div>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#4f46e5]"></div>
                            <span class="text-sm text-[#505f76]">On Going</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#d97706]"></div>
                            <span class="text-sm text-[#505f76]">Registered</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#10b981]"></div>
                            <span class="text-sm text-[#505f76]">Trial Phase</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-[#ba1a1a]"></div>
                            <span class="text-sm text-[#505f76]">Maintenance</span>
                        </div>
                    </div>
                </div>

                {{-- State & Zone Distribution --}}
                <div class="premium-card p-6 rounded-xl flex flex-col bg-white">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-[#111c2d]">State Distribution</h3>
                        <div class="flex bg-[#f0f3ff] p-1 rounded-lg">
                            <button class="px-3 py-1 bg-white shadow-sm rounded-md text-xs font-semibold text-[#00030d]">State</button>
                            <button class="px-3 py-1 text-xs font-semibold text-[#505f76] hover:text-[#111c2d] transition-colors">Zone</button>
                        </div>
                    </div>
                    <div class="flex-1 space-y-4 py-2">
                        @php
                            $topStates = collect($state_distribution)->sortByDesc('total')->take(6);
                            $maxState  = $topStates->max('total') ?: 1;
                            $barColors = ['#4f46e5','#10b981','#d97706','#ba1a1a','#505f76','#00030d'];
                        @endphp
                        @foreach($topStates as $idx => $st)
                        @php $pct = round(($st->total / $maxState) * 100); @endphp
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm">
                                <span class="text-[#111c2d] font-medium">{{ $st->state_name }}</span>
                                <span class="font-bold text-[#111c2d]">{{ $st->total }}</span>
                            </div>
                            <div class="w-full bg-[#f0f3ff] h-2 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700"
                                     style="width: {{ $pct }}%; background: {{ $barColors[$idx % count($barColors)] }};"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- RECENTLY REGISTERED SCHOOLS TABLE         --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="premium-card rounded-xl bg-white mb-8">
                <div class="flex justify-between items-center px-6 py-5 border-b border-[#e7eeff]">
                    <h3 class="text-lg font-bold text-[#111c2d]">Recently Registered Schools</h3>
                    <a href="{{ route('admin.schools.index') }}"
                       class="text-xs font-bold uppercase tracking-widest text-[#00030d] hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left dash-table">
                        <thead>
                            <tr class="border-b border-[#e7eeff]">
                                <th>SUIC Code</th>
                                <th>School & Principal</th>
                                <th>State</th>
                                <th>Status</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e7eeff]">
                            @forelse($recent_schools as $s)
                            <tr class="hover:bg-[#f0f3ff] transition-colors">
                                <td class="font-bold text-[#00030d] text-sm">{{ $s->suic_code ?? $s->code }}</td>
                                <td>
                                    <p class="text-sm font-bold text-[#111c2d]">
                                        <a href="{{ route('admin.schools.show', $s->id) }}" class="hover:text-[#4f46e5] transition-colors">{{ $s->name }}</a>
                                    </p>
                                    <p class="text-xs text-[#505f76]">{{ $s->principal_name ?? 'N/A' }}</p>
                                </td>
                                <td class="text-sm text-[#45474d]">{{ $s->state->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full badge-{{ $s->status }}">
                                        {{ ucwords(str_replace('_', ' ', $s->status)) }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    <div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
                                        <button @click="open = !open" type="button"
                                                class="w-8 h-8 rounded-lg text-[#505f76] bg-[#f0f3ff] hover:bg-[#dee8ff] flex items-center justify-center transition-all ml-auto">
                                            <span class="material-symbols-outlined" style="font-size:18px;">more_vert</span>
                                        </button>
                                        <div x-show="open" x-cloak
                                             x-transition:enter="transition ease-out duration-100"
                                             x-transition:enter-start="opacity-0 scale-95"
                                             x-transition:enter-end="opacity-100 scale-100"
                                             x-transition:leave="transition ease-in duration-75"
                                             x-transition:leave-start="opacity-100 scale-100"
                                             x-transition:leave-end="opacity-0 scale-95"
                                             class="absolute right-0 mt-1.5 w-44 rounded-xl bg-white shadow-xl border border-[#e7eeff] py-1 z-50 text-xs divide-y divide-[#f0f3ff]">
                                            <div class="py-1">
                                                <a href="{{ route('admin.schools.show', $s->id) }}"
                                                   class="flex items-center gap-2 px-4 py-2.5 hover:bg-[#f0f3ff] text-[#45474d] hover:text-[#4f46e5]">
                                                    <span class="material-symbols-outlined" style="font-size:16px;">visibility</span> View Record
                                                </a>
                                                <a href="{{ route('admin.schools.edit', $s->id) }}"
                                                   class="flex items-center gap-2 px-4 py-2.5 hover:bg-[#f0f3ff] text-[#45474d] hover:text-[#d97706]">
                                                    <span class="material-symbols-outlined" style="font-size:16px;">edit</span> Edit Profile
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-[#505f76] text-sm font-normal">No recent school records found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- RECENT ACTIVITY TABLE                     --}}
            {{-- ══════════════════════════════════════════ --}}
            <div class="premium-card rounded-xl bg-white mb-8">
                <div class="flex justify-between items-center px-6 py-5 border-b border-[#e7eeff]">
                    <h3 class="text-lg font-bold text-[#111c2d]">Recent Activity</h3>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#505f76]">Audit Logs</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left dash-table">
                        <thead>
                            <tr class="border-b border-[#e7eeff]">
                                <th>Activity</th>
                                <th>Source</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#e7eeff]">
                            @forelse($recent_activities as $act)
                            <tr class="hover:bg-[#f0f3ff] transition-colors">
                                <td class="text-sm font-bold text-[#111c2d]">{{ $act->description }}</td>
                                <td class="text-sm text-[#45474d]">{{ $act->ip_address ?? 'Internal' }}</td>
                                <td class="text-sm text-[#505f76]">{{ $act->created_at->diffForHumans() }}</td>
                                <td>
                                    <span class="px-3 py-1 text-xs font-bold rounded-full" style="background:rgba(16,185,129,0.08);color:#10b981;">
                                        Logged
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center text-[#505f76] text-sm font-normal">No audit activity logged.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <x-admin-footer />

    </div>

@endsection

@section('scripts')
    <script>
        // Live Date/Time
        function updateClock() {
            const now = new Date();
            document.getElementById('liveDateTime').textContent = now.toLocaleString('en-IN', {
                weekday: 'short', day: '2-digit', month: 'short', year: 'numeric',
                hour: '2-digit', minute: '2-digit', hour12: true
            });
        }
        updateClock();
        setInterval(updateClock, 60000);

        // Card hover interaction
        document.querySelectorAll('.premium-card').forEach(card => {
            card.addEventListener('mousedown', () => card.style.transform = 'scale(0.99)');
            card.addEventListener('mouseup',   () => card.style.transform = 'translateY(-2px)');
            card.addEventListener('mouseleave',() => card.style.transform = 'translateY(0)');
        });
    </script>
@endsection