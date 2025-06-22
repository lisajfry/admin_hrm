@extends('layouts.admin')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin</h1>
        <p class="text-sm text-gray-500">Selamat datang di sistem manajemen PayrollMetrics 👋</p>
    </div>

    {{-- Cards Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="text-gray-500 text-sm">Total Karyawan</div>
            <div class="text-3xl font-bold text-blue-600">{{ $totalKaryawan }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="text-gray-500 text-sm">Total Absensi</div>
            <div class="text-3xl font-bold text-green-600">{{ $totalAbsensi }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="text-gray-500 text-sm">Total Task</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $totalTask }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="text-gray-500 text-sm">Jumlah Izin</div>
            <div class="text-3xl font-bold text-yellow-500">{{ $totalIzin }}</div>
        </div>
        <div class="bg-white p-5 rounded-xl shadow hover:shadow-md transition">
            <div class="text-gray-500 text-sm">Lembur Bulan Ini</div>
            <div class="text-3xl font-bold text-purple-600">{{ $totalLembur }}</div>
        </div>
    </div>

    {{-- Grafik Kehadiran --}}
    <div class="bg-white p-6 rounded-xl shadow">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Grafik Kehadiran per Bulan</h2>
        <canvas id="kehadiranChart" height="120"></canvas>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kehadiranChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($bulan) !!},
                datasets: [{
                    label: 'Kehadiran',
                    data: {!! json_encode($kehadiran) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderRadius: 10,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#6B7280', // gray-500
                            font: { size: 12 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5,
                            color: '#6B7280',
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    </script>
@endsection
