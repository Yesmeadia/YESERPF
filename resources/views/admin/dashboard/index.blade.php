@extends('layouts.app')

@section('title', 'Dashboard - YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #f8fafc !important;
            color: #1e293b !important;
            font-family: 'Inter', sans-serif;
        }

        /* Clean Card Utility */
        .clean-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            padding: 1.25rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .clean-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
        }

        .kpi-num {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.02em;
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        /* Status Badges */
        .badge-on_going {
            background: #d1fae5;
            color: #047857;
        }

        .badge-registered {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-trial_running {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .badge-under_construction {
            background: #fef9c3;
            color: #a16207;
        }
    </style>
@endsection

@section('content')

    <!-- Sidebar Component -->
    <x-admin-sidebar active="dashboard" />

    <!-- Main Content Area -->
    <div class="lg:pl-64 min-h-screen flex flex-col justify-between">

        <!-- Page Content Container -->
        <div class="p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">

            <!-- Top Header Banner -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
                <div>
                    <h1 class="text-2xl font-extrabold text-[#271e6d] tracking-tight flex items-center gap-2.5">
                        <span>Executive Dashboard</span>
                    </h1>
                    <p class="text-xs text-slate-500 mt-1">Overview of school registrations, status metrics, and regional
                        data.</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" target="_blank"
                        class="px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 hover:border-slate-300 transition-all inline-flex items-center gap-2 shadow-sm">
                        <i class="fa-solid fa-compass text-indigo-500"></i>
                        <span>Public Site</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                    </a>
                    <a href="{{ route('register') }}" target="_blank"
                        class="btn-purple-action text-xs px-4 py-2 inline-flex items-center gap-2 shadow-md">
                        <i class="fa-solid fa-circle-plus text-xs"></i>
                        <span>New Campus</span>
                    </a>
                </div>
            </div>

            <!-- 5 KPI Metric Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <!-- Total Schools Card -->
                <div class="clean-card border-t-2 border-t-indigo-600">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider">Total Schools</span>
                        <div
                            class="w-10 h-10 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-[#271e6d] shadow-sm">
                            <i class="fa-solid fa-building-columns text-sm"></i>
                        </div>
                    </div>
                    <div class="kpi-num text-[#271e6d] mb-1">{{ number_format($status_counts['total']) }}</div>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="fa-solid fa-database text-[10px] text-indigo-400"></i> Total database records
                    </div>
                </div>

                <!-- On Going Card -->
                <div class="clean-card border-t-2 border-t-emerald-500">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-emerald-700 font-bold uppercase tracking-wider">On Going</span>
                        <div
                            class="w-10 h-10 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center justify-center text-emerald-600 shadow-sm">
                            <i class="fa-solid fa-circle-check text-sm"></i>
                        </div>
                    </div>
                    <div class="kpi-num text-emerald-600 mb-1">{{ number_format($status_counts['approved']) }}</div>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="fa-solid fa-circle-dot text-[10px] text-emerald-500 animate-pulse"></i> Active operational
                    </div>
                </div>

                <!-- Registered Card -->
                <div class="clean-card border-t-2 border-t-rose-500">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-rose-700 font-bold uppercase tracking-wider">Registered</span>
                        <div
                            class="w-10 h-10 rounded-2xl bg-rose-50 border border-rose-100 flex items-center justify-center text-rose-600 shadow-sm">
                            <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                        </div>
                    </div>
                    <div class="kpi-num text-rose-600 mb-1">{{ number_format($status_counts['pending']) }}</div>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="fa-solid fa-user-plus text-[10px] text-rose-400"></i> Newly registered
                    </div>
                </div>

                <!-- Trial Running Card -->
                <div class="clean-card border-t-2 border-t-purple-500">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-purple-700 font-bold uppercase tracking-wider">Trial Running</span>
                        <div
                            class="w-10 h-10 rounded-2xl bg-purple-50 border border-purple-100 flex items-center justify-center text-purple-600 shadow-sm">
                            <i class="fa-solid fa-flask-vial text-sm"></i>
                        </div>
                    </div>
                    <div class="kpi-num text-purple-600 mb-1">{{ number_format($status_counts['under_review']) }}</div>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="fa-solid fa-vial-circle-check text-[10px] text-purple-400"></i> In evaluation trial
                    </div>
                </div>

                <!-- Under Construction Card -->
                <div class="clean-card border-t-2 border-t-amber-500">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-amber-700 font-bold uppercase tracking-wider">Construction</span>
                        <div
                            class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-100 flex items-center justify-center text-amber-600 shadow-sm">
                            <i class="fa-solid fa-screwdriver-wrench text-sm"></i>
                        </div>
                    </div>
                    <div class="kpi-num text-amber-600 mb-1">{{ number_format($status_counts['rejected']) }}</div>
                    <div class="text-[11px] text-slate-400 flex items-center gap-1">
                        <i class="fa-solid fa-compass-drafting text-[10px] text-amber-400"></i> Work in progress
                    </div>
                </div>

            </div>

            <!-- Analytics Charts Row -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Donut Chart -->
                <div class="lg:col-span-5 clean-card flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-100">
                        <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-indigo-600 text-sm"></i>
                            <span>Status Breakdown</span>
                        </h3>
                        <span
                            class="text-[10px] font-semibold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">
                            Live Data
                        </span>
                    </div>
                    <div id="statusChart" class="h-60 flex items-center justify-center"></div>
                </div>

                <!-- Bar Chart -->
                <div class="lg:col-span-7 clean-card flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3 pb-2.5 border-b border-slate-100">
                        <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-indigo-600 text-sm"></i>
                            <span>Top States Volume</span>
                        </h3>
                        <span class="text-[10px] font-semibold text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-chart-simple"></i> Regional Statistics
                        </span>
                    </div>
                    <div id="stateChart" class="h-60"></div>
                </div>

            </div>

            <!-- Recent Table & Logs -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- Recent Table -->
                <div class="lg:col-span-8 clean-card">
                    <div class="flex items-center justify-between mb-4 pb-2.5 border-b border-slate-100">
                        <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-rectangle-list text-indigo-600 text-sm"></i>
                            <span>Recently Registered</span>
                        </h3>
                        <a href="{{ route('admin.schools.index') }}"
                            class="text-xs font-bold text-[#271e6d] hover:text-indigo-600 transition-colors inline-flex items-center gap-1">
                            <span>View Datatable</span>
                            <i class="fa-solid fa-arrow-right text-[11px]"></i>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs">
                            <thead>
                                <tr
                                    class="text-slate-500 border-b border-slate-200 text-[11px] font-bold uppercase tracking-wider bg-slate-50/50">
                                    <th class="py-2.5 px-3">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-barcode text-slate-400"></i> SUIC Code
                                        </div>
                                    </th>
                                    <th class="py-2.5 px-3">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-school text-slate-400"></i> School Name
                                        </div>
                                    </th>
                                    <th class="py-2.5 px-3">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-location-dot text-slate-400"></i> State
                                        </div>
                                    </th>
                                    <th class="py-2.5 px-3">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-shield-halved text-slate-400"></i> Status
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700">
                                @forelse($recent_schools as $s)
                                    <tr class="hover:bg-slate-50/80 transition-colors">
                                        <td class="py-3 px-3 font-mono font-bold text-[#271e6d]">
                                            {{ $s->suic_code ?? $s->code }}
                                        </td>
                                        <td class="py-3 px-3 font-semibold text-slate-900">
                                            {{ $s->name }}
                                        </td>
                                        <td class="py-3 px-3 text-slate-500">
                                            {{ $s->state->name ?? 'N/A' }}
                                        </td>
                                        <td class="py-3 px-3">
                                            <span
                                                class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-wide badge-{{ $s->status }}">
                                                {{ str_replace('_', ' ', $s->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-8 text-center text-slate-400">
                                            <div class="space-y-1">
                                                <i class="fa-solid fa-folder-open text-2xl text-slate-300"></i>
                                                <p>No school records found.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Activity Logs -->
                <div class="lg:col-span-4 clean-card flex flex-col">
                    <div class="flex items-center justify-between mb-4 pb-2.5 border-b border-slate-100">
                        <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-timeline text-indigo-600 text-sm"></i>
                            <span>Audit Log Activity</span>
                        </h3>
                        <span class="text-[10px] font-semibold text-slate-400 flex items-center gap-1">
                            <i class="fa-solid fa-bolt text-amber-500"></i> Latest
                        </span>
                    </div>

                    <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1 custom-scroll flex-grow">
                        @forelse($recent_activities as $act)
                            <div
                                class="p-3 rounded-2xl bg-slate-50/80 border border-slate-200/70 text-xs space-y-1 hover:bg-slate-100/80 transition-colors">
                                <div class="text-slate-800 font-medium leading-snug flex items-start gap-2">
                                    <i class="fa-solid fa-circle-dot text-indigo-500 text-[8px] shrink-0 mt-1"></i>
                                    <span>{{ $act->description }}</span>
                                </div>
                                <div
                                    class="flex items-center justify-between text-[10px] text-slate-400 pt-1 border-t border-slate-200/50">
                                    <span class="flex items-center gap-1">
                                        <i class="fa-solid fa-clock text-[9px]"></i> {{ $act->created_at->diffForHumans() }}
                                    </span>
                                    <span class="font-mono text-slate-500 flex items-center gap-1">
                                        <i class="fa-solid fa-network-wired text-[9px]"></i>
                                        {{ $act->ip_address ?? '127.0.0.1' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 text-slate-400 text-xs space-y-1.5">
                                <i class="fa-solid fa-clock-rotate-left text-2xl text-slate-300"></i>
                                <p>No activity logs recorded.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>

        <!-- Admin Footer -->
        <x-admin-footer />

    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const opts = { theme: { mode: 'light' }, chart: { background: 'transparent', fontFamily: 'Inter, sans-serif' } };

            new ApexCharts(document.querySelector('#statusChart'), {
                ...opts,
                series: [
                {{ $status_counts['approved'] }},
                {{ $status_counts['pending'] }},
                {{ $status_counts['under_review'] }},
                    {{ $status_counts['rejected'] }}
                ],
                labels: ['On Going', 'Registered', 'Trial Running', 'Under Construction'],
                colors: ['#10b981', '#ef4444', '#a855f7', '#eab308'],
                chart: { ...opts.chart, type: 'donut', height: 230 },
                stroke: { width: 2, colors: ['#ffffff'] },
                legend: { position: 'bottom', labels: { colors: '#475569' }, fontSize: '11px' },
                dataLabels: { enabled: true }
            }).render();

            const sd = @json($state_distribution);
            new ApexCharts(document.querySelector('#stateChart'), {
                ...opts,
                series: [{ name: 'Schools', data: sd.map(i => i.total) }],
                chart: { ...opts.chart, type: 'bar', height: 230, toolbar: { show: false } },
                colors: ['#271e6d'],
                plotOptions: { bar: { borderRadius: 6, columnWidth: '40%' } },
                xaxis: {
                    categories: sd.map(i => i.state_name),
                    labels: { style: { colors: '#475569', fontSize: '11px' } }
                },
                yaxis: { labels: { style: { colors: '#64748b' } } },
                grid: { borderColor: '#f1f5f9' }
            }).render();
        });
    </script>
@endsection