@extends('layouts.app')

@section('title', 'Activity Logs — YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Figtree', sans-serif;
        }
    </style>
@endsection

@section('content')

    <x-admin-sidebar active="activity-logs" />

    <div class="lg:pl-64 min-h-screen bg-[#f8fafc]">
        <div class="p-4 sm:p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight">System Activity Logs</h1>
                    <p class="text-sm text-slate-500 mt-1">A complete timeline of administrative and system actions.</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-bold text-slate-500">
                            <tr>
                                <th class="px-6 py-4">Timestamp</th>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Action Description</th>
                                <th class="px-6 py-4">IP Address</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($logs as $log)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs whitespace-nowrap">
                                        {{ $log->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($log->user)
                                            <span class="font-semibold text-slate-900">{{ $log->user->name }}</span>
                                        @else
                                            <span class="text-slate-400 italic">System</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-400">
                                        {{ $log->ip_address ?? 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500 font-normal">
                                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-slate-100 mb-3">
                                            <i class="fa-solid fa-list-ul text-slate-400"></i>
                                        </div>
                                        <p>No activity logs found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-slate-200">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
