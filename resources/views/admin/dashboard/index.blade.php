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
        border-radius: 16px;
        padding: 1.25rem;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .clean-card:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .kpi-num {
        font-size: 2rem;
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
    .badge-on_going { background: #d1fae5; color: #047857; }
    .badge-registered { background: #fee2e2; color: #b91c1c; }
    .badge-trial_running { background: #f3e8ff; color: #7e22ce; }
    .badge-under_construction { background: #fef9c3; color: #a16207; }
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
                <h1 class="text-2xl font-extrabold text-[#271e6d] tracking-tight">Executive Dashboard</h1>
                <p class="text-xs text-slate-500 mt-1">Overview of school registrations, status metrics, and regional data.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank"
                   class="px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 text-xs font-semibold hover:bg-slate-200 transition-colors inline-flex items-center gap-2">
                    <i class="fa-solid fa-globe text-slate-500"></i> Public Site
                </a>
                <a href="{{ route('register') }}" target="_blank"
                   class="btn-purple-action text-xs px-4 py-2 inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> New Campus
                </a>
            </div>
        </div>

        <!-- 5 KPI Metric Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

            <!-- Total Schools Card -->
            <div class="clean-card">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-slate-500 font-medium uppercase tracking-wider">Total Schools</span>
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-[#271e6d]">
                        <i class="fa-solid fa-school text-xs"></i>
                    </div>
                </div>
                <div class="kpi-num text-[#271e6d] mb-1">{{ number_format($status_counts['total']) }}</div>
                <div class="text-[11px] text-slate-400">Total database records</div>
            </div>

            <!-- On Going Card -->
            <div class="clean-card border-t-2 border-t-emerald-500">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-emerald-700 font-medium uppercase tracking-wider">On Going</span>
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-circle-check text-xs"></i>
                    </div>
                </div>
                <div class="kpi-num text-emerald-600 mb-1">{{ number_format($status_counts['approved']) }}</div>
                <div class="text-[11px] text-slate-400">Active operational</div>
            </div>

            <!-- Registered Card -->
            <div class="clean-card border-t-2 border-t-red-500">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-red-700 font-medium uppercase tracking-wider">Registered</span>
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-600">
                        <i class="fa-solid fa-clock text-xs"></i>
                    </div>
                </div>
                <div class="kpi-num text-red-600 mb-1">{{ number_format($status_counts['pending']) }}</div>
                <div class="text-[11px] text-slate-400">Newly registered</div>
            </div>

            <!-- Trial Running Card -->
            <div class="clean-card border-t-2 border-t-purple-500">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-purple-700 font-medium uppercase tracking-wider">Trial Running</span>
                    <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                        <i class="fa-solid fa-flask text-xs"></i>
                    </div>
                </div>
                <div class="kpi-num text-purple-600 mb-1">{{ number_format($status_counts['under_review']) }}</div>
                <div class="text-[11px] text-slate-400">In evaluation trial</div>
            </div>

            <!-- Under Construction Card -->
            <div class="clean-card border-t-2 border-t-amber-500">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs text-amber-700 font-medium uppercase tracking-wider">Construction</span>
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                        <i class="fa-solid fa-person-digging text-xs"></i>
                    </div>
                </div>
                <div class="kpi-num text-amber-600 mb-1">{{ number_format($status_counts['rejected']) }}</div>
                <div class="text-[11px] text-slate-400">Work in progress</div>
            </div>

        </div>

        <!-- Analytics Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Donut Chart -->
            <div class="lg:col-span-5 clean-card flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-chart-pie text-indigo-500"></i> Status Breakdown
                    </h3>
                    <span class="text-[10px] text-slate-400">Live Data</span>
                </div>
                <div id="statusChart" class="h-60 flex items-center justify-center"></div>
            </div>

            <!-- Bar Chart -->
            <div class="lg:col-span-7 clean-card flex flex-col justify-between">
                <div class="flex items-center justify-between mb-3 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-indigo-500"></i> Top States Volume
                    </h3>
                    <span class="text-[10px] text-slate-400">Regional Statistics</span>
                </div>
                <div id="stateChart" class="h-60"></div>
            </div>

        </div>

        <!-- Recent Table & Logs -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Recent Table -->
            <div class="lg:col-span-8 clean-card">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Recently Registered</h3>
                    <a href="{{ route('admin.schools.index') }}" class="text-xs font-semibold text-[#271e6d] hover:underline">
                        View Datatable &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="text-slate-500 border-b border-slate-200 text-[11px] font-semibold uppercase">
                                <th class="pb-2.5 px-3">SUIC Code</th>
                                <th class="pb-2.5 px-3">School Name</th>
                                <th class="pb-2.5 px-3">State</th>
                                <th class="pb-2.5 px-3">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($recent_schools as $s)
                                <tr class="hover:bg-slate-50 transition-colors">
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
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase badge-{{ $s->status }}">
                                            {{ str_replace('_', ' ', $s->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-slate-400">
                                        No school records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Activity Logs -->
            <div class="lg:col-span-4 clean-card flex flex-col">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                    <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Audit Log Activity</h3>
                    <span class="text-[10px] text-slate-400">Latest Updates</span>
                </div>

                <div class="space-y-2.5 max-h-72 overflow-y-auto pr-1 custom-scroll flex-grow">
                    @forelse($recent_activities as $act)
                        <div class="p-2.5 rounded-xl bg-slate-50 border border-slate-200/70 text-xs space-y-1">
                            <div class="text-slate-800 font-medium leading-snug">{{ $act->description }}</div>
                            <div class="flex items-center justify-between text-[10px] text-slate-400 pt-1">
                                <span>{{ $act->created_at->diffForHumans() }}</span>
                                <span class="font-mono">{{ $act->ip_address ?? '127.0.0.1' }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-slate-400 text-xs">
                            No logs recorded.
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