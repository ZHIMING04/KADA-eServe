<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Koperasi KADA</title>
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
        .chart-container .apexcharts-toolbar {
            top: -50px !important; /* Adjust this value as needed */
            right: 0 !important;
            position: absolute !important;
        }
        
        .chart-container {
            position: relative;
        }
        
        .chart-toolbar {
            min-height: 30px; /* Adjust based on toolbar height */
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
                    <h1 class="text-3xl font-bold text-gray-800">Selamat Datang ke Panel Kawalan Koperasi!</h1>
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
            </div>

        
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-8">
                <!-- Total Members Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-blue-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalApprovedMembers }}</h3>
                    <p class="text-gray-600">Jumlah Ahli</p>
                    <div class="mt-2 flex items-center">
                        @if($memberGrowthPercentage > 0)
                            <span class="text-green-500 text-sm">+{{ $memberGrowthPercentage }}%</span>
                        @elseif($memberGrowthPercentage < 0)
                            <span class="text-red-500 text-sm">{{ $memberGrowthPercentage }}%</span>
                        @else
                            <span class="text-gray-500 text-sm">0%</span>
                        @endif
                        <span class="text-gray-500 text-sm ml-1">dari bulan lepas</span>
                    </div>
                </div>

                <!-- Pending Members Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-yellow-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pendingMembers }}</h3>
                    <p class="text-gray-600">Ahli Dalam Proses</p>
                </div>

                <!-- Total Savings Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-green-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">RM {{ $totalSavings }}</h3>
                    <p class="text-gray-600">Jumlah Simpanan</p>
                </div>

                <!-- Loan Applications Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div class="bg-purple-100 rounded-lg p-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $LoanApplications->sum('total') }}</h3>
                    <p class="text-gray-600">Permohonan Pinjaman</p>
                    <div class="mt-2 text-sm text-gray-500">
                        {{ $LoanApprovals->sum('total') }} diluluskan
                    </div>
                </div>
            </div>

              <!-- Add after Header section -->
              <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
                <form id="timeFilterForm" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Tempoh
                        </label>
                        <select id="periodType" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="annually">Tahunan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun
                        </label>
                        <select id="yearSelect" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @for($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div id="monthSelectContainer" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Bulan
                        </label>
                        <select id="monthSelect" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @php
                                $malayMonths = [
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Mac',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Jun',
                                    7 => 'Julai',
                                    8 => 'Ogos',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Disember'
                                ];
                            @endphp
                            @foreach($malayMonths as $monthNum => $monthName)
                                <option value="{{ $monthNum }}">{{ $monthName }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

           
                      <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Member Demographics Chart -->
                <div class="chart-container bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Demografik Ahli</h3>
                    <div id="demographicsChart" class="h-80"></div>
                </div>

                <!-- Savings Trend Chart -->
                <div class="chart-container bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Simpanan</h3>
                    <div id="savingsChart" class="h-80"></div>
                    <div id="savingsSummary"></div>
                </div>

                <!-- Member Registration Chart -->
                <div class="chart-container bg-white rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Statistik Pendaftaran Ahli</h3>
                        <!-- This empty div will be filled by the chart toolbar -->
                        <div class="chart-toolbar"></div>
                    </div>
                    <div id="memberChart" class="h-80"></div>
                </div>

                <!-- Loan Statistics Chart -->
                <div class="chart-container bg-white rounded-2xl p-6 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Pinjaman</h3>
                    <div id="loanChart" class="h-80"></div>
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
        const demographicsData = @json($demographics->pluck('total'));
        const demographicsLabels = @json($demographics->map(function($item) {
            return $item->age_group . ' tahun';
        }));

       // If $totalSavings is a single numeric value
        const savingsData = @json($savingsChartData);
        const savingsLabels = @json($savingsChartLabels);

        // Demographics Chart
        var demographicsOptions = {
            series: demographicsData,
            chart: {
                type: 'donut',
                height: 320,
                toolbar: {
                show: true,
                tools: {
                    download: true,
                    selection: false,
                    zoom: false,
                    zoomin: false,
                    zoomout: false,
                    pan: false,
                    reset: false
                }
            },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            labels: demographicsLabels,
            colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444'],
            legend: {
                position: 'bottom',
                formatter: function(seriesName, opts) {
                    return [seriesName, ' - ', opts.w.globals.series[opts.seriesIndex]]
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val, opts) {
                    return Math.round(val) + '%'
                }
            },

            
            plotOptions: {
                pie: {
                    donut: {
                        size: '50%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Jumlah Ahli',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                }
                            }
                        }
                    }
                }
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

        // Make sure the element exists before rendering
        if (document.querySelector("#demographicsChart")) {
            var demographicsChart = new ApexCharts(document.querySelector("#demographicsChart"), demographicsOptions);
            demographicsChart.render();
        }

//********* STATISTIK SIMPANAN CHART ************

                var savingsOptions = {
                    series: [{
                        name: 'Total Simpanan',
                        data: {!! json_encode($savingsChartData) !!}
                    }],
                    chart: {
                        height: 350,
                        type: 'bar',
                        toolbar: {
                            show: true,
                            tools: {
                                download: true,
                                selection: false,
                                zoom: false,
                                zoomin: false,
                                zoomout: false,
                                pan: false,
                                reset: false
                            }
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    colors: ['#3B82F6'],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded',
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                            // Check if we're in annual view (more than 1 data point)
                            const isAnnualView = w.globals.series[0].length > 1;
                            if (isAnnualView) {
                                // In annual view, show 0 values as empty string
                                return val > 0 ? formatCurrency(val) : '';
                            } else {
                                // In monthly view, show all values
                                return formatCurrency(val);
                            }
                        },
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ["#304758"]
                        }
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: savingsLabels,
                        labels: {
                            rotate: -45,
                            rotateAlways: false,
                            style: {
                                fontSize: '12px',
                                fontWeight: 500
                            }
                        },
                        title: {
                            text: 'Bulan',
                            style: {
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#2E3A47'
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Simpanan (RM)',
                            style: {
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#2E3A47'
                            }
                        },
                        labels: {
                            formatter: formatCurrency
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: '14px',
                        markers: {
                            width: 12,
                            height: 12,
                            radius: 12
                        },
                        itemMargin: {
                            horizontal: 25
                        }
                    },
                    tooltip: {
                        y: {
                            formatter: formatCurrency
                        }
                    }
                };

                // Helper function to format currency
                function formatCurrency(value) {
                    if (value >= 1000000) {
                        return 'RM ' + (value / 1000000).toFixed(2) + 'M';
                    } else if (value >= 1000) {
                        return 'RM ' + (value / 1000).toFixed(1) + 'K';
                    }
                    return 'RM ' + value.toFixed(2);
                }

                // Initialize chart
                var savingsChart = new ApexCharts(document.querySelector("#savingsChart"), savingsOptions);
                savingsChart.render();

                // Add event listeners for period changes
                document.addEventListener('DOMContentLoaded', function() {
                    const periodType = document.getElementById('periodType');
                    const yearSelect = document.getElementById('yearSelect');
                    const monthSelect = document.getElementById('monthSelect');
                    const monthSelectContainer = document.getElementById('monthSelectContainer');

                    function updateSavingsChart() {
                        const period = periodType.value;
                        const year = yearSelect.value;
                        const month = monthSelect.value;

                        fetch(`/admin/savings-data?period=${period}&year=${year}&month=${month}`)
                            .then(response => response.json())
                            .then(data => {
                                let chartData = [];
                                let labels = [];

                                if (period === 'annually') {
                                    // For annual view, show all months
                                    chartData = data.savings.map(item => item.amount);
                                    labels = data.savings.map(item => {
                                        const monthNames = {
                                            1: 'Januari', 2: 'Februari', 3: 'Mac', 4: 'April',
                                            5: 'Mei', 6: 'Jun', 7: 'Julai', 8: 'Ogos',
                                            9: 'September', 10: 'Oktober', 11: 'November', 12: 'Disember'
                                        };
                                        return monthNames[item.month];
                                    });
                                } else {
                                    // For monthly view, show only the selected month
                                    const monthNames = {
                                        1: 'Januari', 2: 'Februari', 3: 'Mac', 4: 'April',
                                        5: 'Mei', 6: 'Jun', 7: 'Julai', 8: 'Ogos',
                                        9: 'September', 10: 'Oktober', 11: 'November', 12: 'Disember'
                                    };
                                    
                                    chartData = [data.total];
                                    labels = [`${monthNames[parseInt(month)]} ${year}`];
                                }

                                // Update chart with new data
                                savingsChart.updateOptions({
                                    series: [{
                                        name: 'Jumlah Simpanan',
                                        data: chartData
                                    }],
                                    xaxis: {
                                        categories: labels
                                    }
                                });

                                // Update summary statistics
                                const totalSavings = chartData.reduce((a, b) => a + b, 0);
                                const avgSavings = totalSavings / chartData.length;
                                
                                if (document.querySelector('#savingsSummary')) {
                                    document.querySelector('#savingsSummary').innerHTML = `
                                        <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                            <div class="bg-blue-50 p-3 rounded-lg">
                                                <div class="font-semibold text-blue-800">Jumlah Keseluruhan</div>
                                                <div class="text-blue-600">${formatCurrency(totalSavings)}</div>
                                            </div>
                                            <div class="bg-green-50 p-3 rounded-lg">
                                                <div class="font-semibold text-green-800">Purata Simpanan</div>
                                                <div class="text-green-600">${formatCurrency(avgSavings)}</div>
                                            </div>
                                        </div>
                                    `;
                                }
                            })
                            .catch(error => console.error('Error fetching savings data:', error));
                    }

                    // Toggle month selector visibility and update chart
                    periodType.addEventListener('change', function() {
                        monthSelectContainer.classList.toggle('hidden', this.value === 'annually');
                        updateSavingsChart();
                    });

                    // Add event listeners for year and month changes
                    yearSelect.addEventListener('change', updateSavingsChart);
                    monthSelect.addEventListener('change', updateSavingsChart);

                    // Initial chart update
                    updateSavingsChart();
                });

        </script>


      

        <script>
       document.addEventListener('DOMContentLoaded', function () {
        const periodType = document.getElementById('periodType');
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');

        function updateMemberChart() {
            const period = periodType.value;
            const year = yearSelect.value;
            const month = monthSelect.value;
            
            const params = new URLSearchParams({
                period: period,
                year: year,
                month: month
            });

            fetch(`/admin/dashboard-data?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    // Update the chart with new data
                    if (data.memberChartData && data.memberChartLabels) {
                        window.memberChart.updateOptions({
                            series: [{
                                name: 'Jumlah Ahli',
                                data: data.memberChartData
                            }],
                            xaxis: {
                                categories: data.memberChartLabels
                            }
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        // Initialize chart with enhanced options
        window.memberChart = new ApexCharts(document.querySelector("#memberChart"), {
            series: [{ 
                name: 'Jumlah Ahli', 
                data: @json($memberChartData)
            }],
            chart: { 
                type: 'bar', 
                height: 320, 
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            colors: ['#F59E0B'],
            dataLabels: { 
                enabled: true,
                formatter: function(val) {
                    return val.toFixed(0);
                }
            },
            xaxis: { 
                categories: @json($memberChartLabels),
                labels: {
                    rotate: -45,
                    rotateAlways: false,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: { 
                title: { 
                    text: 'Jumlah Ahli',
                    style: {
                        fontSize: '14px',
                        fontWeight: 600
                    }
                },
                labels: {
                    formatter: function(val) {
                        return val.toFixed(0);
                    }
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            }
        });

        window.memberChart.render();

        // Listen for changes in selectors
        periodType.addEventListener('change', updateMemberChart);
        yearSelect.addEventListener('change', updateMemberChart);
        monthSelect.addEventListener('change', updateMemberChart);

        // Initial chart load
        updateMemberChart();
    });
</script>


        <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debug the data
        console.log('Loan Chart Data:', @json($loanChartData));
        
        // Initialize loan chart with proper configuration
        var loanOptions = {
            series: [{
                name: 'Diluluskan',
                data: @json(collect($loanChartData)->pluck('approved'))
            }, {
                name: 'Ditolak',
                data: @json(collect($loanChartData)->pluck('rejected'))
            }],
            chart: {
                type: 'bar',
                height: 350,
                stacked: true,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        zoomin: false,
                        zoomout: false,
                        pan: false,
                        reset: false
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded',
                    borderRadius: 4
                },
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val || '0';
                }
            },
            xaxis: {
                categories: @json($memberChartLabels),
                labels: {
                    rotate: -45,
                    rotateAlways: false
                }
            },
            yaxis: {
                title: {
                    text: 'Jumlah Pinjaman'
                }
            },
            colors: ['#34D399', '#EF4444'],
            legend: {
                position: 'bottom'
            },
            // Add this to prevent chart from disappearing
            noData: {
                text: 'Tiada Data',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    fontSize: '16px'
                }
            }
        };

        // Create chart instance and store it
        if (document.querySelector("#loanChart")) {
            window.loanChart = new ApexCharts(document.querySelector("#loanChart"), loanOptions);
            window.loanChart.render();
        }

        // Add event listeners for period changes
        const periodType = document.getElementById('periodType');
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');

        function updateLoanChart() {
            const period = periodType.value;
            const year = yearSelect.value;
            const month = monthSelect.value;

            fetch(`/admin/dashboard-data?period=${period}&year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    if (data.loanChartData) {
                        window.loanChart.updateSeries([
                            {
                                name: 'Diluluskan',
                                data: data.loanChartData.map(item => item.approved)
                            },
                            {
                                name: 'Ditolak',
                                data: data.loanChartData.map(item => item.rejected)
                            }
                        ]);
                    }
                })
                .catch(error => console.error('Error updating loan chart:', error));
        }

        // Add event listeners
        if (periodType && yearSelect && monthSelect) {
            periodType.addEventListener('change', updateLoanChart);
            yearSelect.addEventListener('change', updateLoanChart);
            monthSelect.addEventListener('change', updateLoanChart);
        }
    });
</script>






<script>
            // Initial chart load
            updateCharts();
        });

        // Initial chart configurations
        let loanChart, userChart;

        // Chart options
        const chartOptions = {
            chart: {
                type: 'line',
                height: 350,
                zoom: { enabled: false }
            },
            stroke: { curve: 'smooth', width: 3 },
            markers: { size: 4 },
            xaxis: { type: 'category' },
            tooltip: { theme: 'dark' }
        };

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize charts
            loanChart = new ApexCharts(document.querySelector("#loanChart"), {
                ...chartOptions,
                series: [{ name: 'Loans', data: [] }],
                colors: ['#3B82F6']
            });
            
            userChart = new ApexCharts(document.querySelector("#userChart"), {
                ...chartOptions,
                series: [{ name: 'Users', data: [] }],
                colors: ['#10B981']
            });

            loanChart.render();
            userChart.render();

            // Load initial data
            fetchChartData();
        });

        function fetchChartData() {
            const year = new Date().getFullYear();
            
            fetch(`/admin/dashboard-data?period=annually&year=${year}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Received data:', data);
                    
                    // Update loan chart
                    if (data.loanData) {
                        const loanSeries = [{
                            name: 'Permohonan',
                            data: data.loanData.map(item => ({
                                x: malayMonths[item.month-1],
                                y: item.count
                            }))
                        }];
                        loanChart.updateSeries(loanSeries);
                    }

                    // Update member chart
                    if (data.memberData) {
                        const memberSeries = [{
                            name: 'Jumlah Ahli',
                            data: data.memberData.map(item => ({
                                x: malayMonths[item.month-1],
                                y: item.count
                            }))
                        }];
                        memberChart.updateOptions({
                            xaxis: {
                                categories: memberSeries[0].data.map(item => item.x)
                            }
                        });
                        memberChart.updateSeries([{
                            name: 'Jumlah Ahli',
                            data: memberSeries[0].data.map(item => item.y)
                        }]);
                    }
                })
                .catch(error => console.error('Error fetching chart data:', error));
        }

        // Add Malay month names
        const malayMonths = [
            'Januari', 'Februari', 'Mac', 'April', 
            'Mei', 'Jun', 'Julai', 'Ogos',
            'September', 'Oktober', 'November', 'Disember'
        ];

        var loanOptions = {
            series: [{
                name: 'Pinjaman',
                data: [] // Start with empty data
            }],
            chart: {
                type: 'line',
                height: 350,
                toolbar: {
                    show: false
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                type: 'category'
            },
            yaxis: {
                title: {
                    text: 'Jumlah Pinjaman'
                }
            }
        };

        var loanChart = new ApexCharts(document.querySelector("#loanChart"), loanOptions);
        loanChart.render();

        // Update chart when data is received
        function updateCharts(period, year, month) {
            fetch(`/admin/dashboard-data?period=${period}&year=${year}&month=${month}`)
                .then(response => response.json())
                .then(data => {
                    if (data.loanData) {
                        loanChart.updateSeries([{
                            name: 'Pinjaman',
                            data: data.loanData.map(item => ({
                                x: new Date(year, item.month-1).toLocaleString('default', { month: 'short' }),
                                y: item.count
                            }))
                        }]);
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Initial load
        updateCharts('annually', new Date().getFullYear(), new Date().getMonth() + 1);
    </script>



    <script>
document.addEventListener('DOMContentLoaded', function() {
    const periodType = document.getElementById('periodType');
    const monthContainer = document.getElementById('monthSelectContainer');
    const yearSelect = document.getElementById('yearSelect');
    const monthSelect = document.getElementById('monthSelect');

    // Toggle month selector visibility
    periodType.addEventListener('change', function() {
        monthContainer.classList.toggle('hidden', this.value === 'annually');
        updateCharts();
    });

    yearSelect.addEventListener('change', updateCharts);
    monthSelect.addEventListener('change', updateCharts);

    function updateCharts() {
        const period = periodType.value;
        const year = yearSelect.value;
        const month = monthSelect.value;

        // Update charts with new data
        fetch(`/admin/dashboard-data?period=${period}&year=${year}&month=${month}`)
            .then(response => response.json())
            .then(data => {
                if (data.loanData) {
                    loanChart.updateSeries([{
                        name: 'Pinjaman',
                        data: data.loanData
                    }]);
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Initial load
    updateCharts();
});
</script>
</body>
</html>