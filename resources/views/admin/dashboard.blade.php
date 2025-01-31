<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - KADA</title>
    <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        .stat-card {
            transition: all 0.5s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .gradient-text {
            background: linear-gradient(45deg, #3B82F6, #10B981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .chart-container {
            transition: all 0.5s ease;
        }
        .chart-container:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Replace sidebar with component -->
        @include('components.sidebar')

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Overview</h1>
                    <p class="text-gray-600">Selamat datang ke panel kawalan KADA</p>
                </div>
            </div>

            <!-- Add this logout button container -->
            <div class="flex justify-end mb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Log Keluar
                    </button>
                </form>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Total Members Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a3 3 0 11-6 0 3 3 0 016 0zM7 10a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="text-green-500 text-sm font-semibold">
                            {{ number_format($memberGrowthPercentage, 1) }}%
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalApprovedMembers) }}</h3>
                    <p class="text-gray-600">Jumlah Ahli</p>
                </div>

                <!-- Pending Members Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($pendingMembers) }}</h3>
                    <p class="text-gray-600">Permohonan Ahli Menunggu</p>
                </div>

                <!-- Total Savings Card -->
                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">RM {{ number_format($totalSavings, 2) }}</h3>
                    <p class="text-gray-600">Jumlah Simpanan</p>
                </div>

                <!-- Active Loans Card -->
                <div class="stat-card bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalLoanApplications) }}</h3>
                    <p class="text-gray-600">Pinjaman Aktif</p>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Savings Trend Chart -->
                <div class="chart-container bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Trend Simpanan</h3>
                    <div id="savingsChart" class="h-80"></div>
                </div>

                <!-- Member Demographics Chart -->
                <div class="chart-container bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Demografik Ahli</h3>
                    <div id="demographicsChart" class="h-80"></div>
                </div>
            </div>

            <!-- Recent Activities Table -->
            <div class="bg-white rounded-2xl shadow-sm">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktiviti Terkini</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ahli</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktiviti</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($recentActivities as $activity)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($activity->date)->format('Y-m-d') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                    {{ substr($activity->name, 0, 2) }}
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $activity->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $activity->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $activity->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                                   ($activity->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($activity->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                @switch($activity->status)
                                                    @case('completed')
                                                        Selesai
                                                        @break
                                                    @case('approved')
                                                        Diluluskan
                                                        @break
                                                    @case('pending')
                                                        Menunggu
                                                        @break
                                                    @default
                                                        Ditolak
                                                @endswitch
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            Tiada aktiviti terkini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Initialize Charts -->
    <script>
        // Prepare data for Savings Trend Chart
        const savingsData = @json($savingsTrend->pluck('total'));
        const savingsLabels = @json($savingsTrend->map(function($item) {
            return \Carbon\Carbon::createFromDate($item->year, $item->month, 1)->format('M Y');
        }));

        // Prepare data for Demographics Chart
        const demographicsData = @json($demographics->pluck('total'));
        const demographicsLabels = @json($demographics->map(function($item) {
            return $item->age_group . ' tahun';
        }));

        // Savings Trend Chart
        var savingsOptions = {
            series: [{
                name: 'Simpanan',
                data: savingsData
            }],
            chart: {
                type: 'area',
                height: 320,
                toolbar: {
                    show: false
                }
            },
            colors: ['#3B82F6'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: savingsLabels
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return 'RM ' + val.toLocaleString()
                    }
                }
            }
        };

        var savingsChart = new ApexCharts(document.querySelector("#savingsChart"), savingsOptions);
        savingsChart.render();

        // Demographics Chart
        var demographicsOptions = {
            series: demographicsData,
            chart: {
                type: 'donut',
                height: 320
            },
            labels: demographicsLabels,
            colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var demographicsChart = new ApexCharts(document.querySelector("#demographicsChart"), demographicsOptions);
        demographicsChart.render();
    </script>
</body>
</html> 