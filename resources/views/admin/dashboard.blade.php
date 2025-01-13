@extends('layouts.admin')

@section('title', 'Dashboard')

@push('styles')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .stat-card {
            transition: all 0.5s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .chart-container {
            transition: all 0.5s ease;
        }
        .chart-container:hover {
            transform: scale(1.02);
        }
    </style>
@endpush

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
            <p class="text-gray-600">Selamat datang ke panel kawalan KADA</p>
        </div>
    </div>

    <!-- Rest of your dashboard content -->
    <!-- ... -->
@endsection

@push('scripts')
    <script>
        // Your charts initialization code
        // ...
    </script>
@endpush 