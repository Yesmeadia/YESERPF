@extends('layouts.app')

@section('title', 'System Reports — YES INDIA SCHOOLS ERP Admin')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f9f9ff !important;
            font-family: 'Figtree', sans-serif;
            color: #111c2d;
        }

        .premium-card {
            background: #ffffff;
            border: 1px solid #f1f5f9;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .premium-card:hover {
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05);
            transform: translateY(-2px);
        }
    </style>
@endsection

@section('content')

    <x-admin-sidebar active="reports" />

    <div class="lg:pl-64 min-h-screen">
        <div class="p-6 lg:p-8 max-w-7xl w-full mx-auto space-y-6">

            <div class="flex items-center justify-between mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-[#111c2d]">System Reports</h1>
                    <p class="text-sm text-[#505f76] mt-1">Analytics and data visualizations for the system.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Registrations Over Time -->
                <div class="premium-card p-6 rounded-2xl lg:col-span-2">
                    <h2 class="text-lg font-bold text-[#111c2d] mb-4">Registrations Over Time (Last 30 Days)</h2>
                    <div class="h-72 w-full">
                        <canvas id="registrationsChart"></canvas>
                    </div>
                </div>

                <!-- Status Distribution -->
                <div class="premium-card p-6 rounded-2xl">
                    <h2 class="text-lg font-bold text-[#111c2d] mb-4">Schools by Status</h2>
                    <div class="h-64 w-full flex justify-center">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- State Distribution -->
                <div class="premium-card p-6 rounded-2xl">
                    <h2 class="text-lg font-bold text-[#111c2d] mb-4">Top States by Registration</h2>
                    <div class="h-64 w-full">
                        <canvas id="stateChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data from backend
            const regData = @json($registrationsOverTime);
            const statusData = @json($statusDistribution);
            const stateData = @json($stateDistribution);

            // 1. Registrations Line Chart
            const ctxReg = document.getElementById('registrationsChart').getContext('2d');
            new Chart(ctxReg, {
                type: 'line',
                data: {
                    labels: regData.map(d => d.date),
                    datasets: [{
                        label: 'New Registrations',
                        data: regData.map(d => d.total),
                        borderColor: '#00030d',
                        backgroundColor: 'rgba(0, 3, 13, 0.05)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });

            // 2. Status Doughnut Chart
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            const formatStatus = str => str.split('_').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
            
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: statusData.map(d => formatStatus(d.status)),
                    datasets: [{
                        data: statusData.map(d => d.total),
                        backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#64748b'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });

            // 3. State Bar Chart (Top 10)
            const ctxState = document.getElementById('stateChart').getContext('2d');
            const topStates = stateData.slice(0, 10);
            new Chart(ctxState, {
                type: 'bar',
                data: {
                    labels: topStates.map(d => d.state_name),
                    datasets: [{
                        label: 'Schools',
                        data: topStates.map(d => d.total),
                        backgroundColor: '#4f46e5',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        });
    </script>
@endsection
