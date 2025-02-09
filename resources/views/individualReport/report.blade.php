<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('LAPORAN INDIVIDU') }}</h2>
            <form method="get" action="{{ route('report.export') }}">
            @csrf
            <x-primary-button type="submit">{{ __('Muat Turun Laporan Anda') }}</x-primary-button>
            </form>
        </div>
    </x-slot>

    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --primary-blue: #0066cc;
            --secondary-blue: #4d94ff;
            --light-blue: #e6f2ff;
            --accent-blue: #00a3ff;
            --deep-blue: #004d99;
            --text-gray: #666;
        }
        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
        .info-card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 102, 204, 0.1);
        }
        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 102, 204, 0.1);
        }
        .info-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        .info-card p {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .py-12 {
            background: linear-gradient(135deg, var(--light-blue) 0%, #f8f9fa 100%);
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Members Details -->
            <!-- <div class="info-card">
                <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg">
                    <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /> </svg>
                        Maklumat Peribadi
                    </h3>
                </div>

                <br>
                <h3 class="text-9xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{$member->name}}</h3>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/3 mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>IC:</strong> {{$member->ic}}</p>
                    </div>
                    <div class="w-full md:w-1/3 mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>No PF:</strong> {{$member->no_pf}}</p>
                    </div>
                    <div class="w-full md:w-1/3 mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>No Ahli:</strong> {{$member->no_anggota}}</p>
                    </div>
    
                </div>
            </div> -->

            <!-- First row with savings information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Existing Savings Card -->
                <div class="bg-white rounded-2xl shadow-sm">
                    <div class="p-6">
                        <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                                <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                                    <i class="fas fa-coins mr-2"></i> Maklumat Saham Ahli
                                </h3>
                        </div>
                        <div id="chart-demo-pie"></div>
                        <script>
                            document.addEventListener("DOMContentLoaded", function () {
                                window.ApexCharts && (new ApexCharts(document.getElementById('chart-demo-pie'), {
                                    chart: {
                                        type: "donut",
                                        fontFamily: 'inherit',
                                        height: 240,
                                        sparkline: {
                                            enabled: true
                                        },
                                        animations: {
                                            enabled: true
                                        },
                                    },
                                    fill: {
                                        opacity: 2,
                                    },
                                    series: [
                                        {{$saving->share_capital}},
                                        {{$saving->subscription_capital}},
                                        {{$saving->member_deposit}},
                                        {{$saving->welfare_fund}},
                                        {{$saving->fixed_savings}},
                                    ],
                                    labels: ["Modal Syer", "Modal Yuran", "Simpanan Anggota","Tabung Anggota", "Simpanan Tetap"],
                                    tooltip: {
                                        theme: 'dark'
                                    },
                                    grid: {
                                        strokeDashArray: 2,
                                    },
                                    colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
                                    legend: {
                                        show: true,
                                        position: 'bottom',
                                        offsetY: 12,
                                        markers: {
                                            width: 10,
                                            height: 10,
                                            radius: 100,
                                        },
                                        itemMargin: {
                                            horizontal: 8,
                                            vertical: 15
                                        },
                                        fontSize: '11px' // Increase font size for better readability
                                    },
                                    tooltip: {
                                        fillSeriesColor: false
                                    },
                                })).render();
                            });
                        </script>
                     <!-- //<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2 text-center animate-pop-out">RM {{ number_format($totalSavings,2) }} </h3> -->
                        <style>
                            @keyframes pop-out {
                                0% {
                                    transform: scale(0.5);
                                    opacity: 0;
                                }
                                100% {
                                    transform: scale(1);
                                    opacity: 1;
                                }
                            }
                            .animate-pop-out {
                                animation: pop-out 0.5s ease-out;
                            }
                        </style>

                        <table class="min-w-full divide-y divide-gray-200 mt-2">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Amaun (RM)
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Modal Syer</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($saving->share_capital, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Modal Yuran</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($saving->subscription_capital, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Simpanan Anggota</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($saving->member_deposit, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Tabung Anggota</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($saving->welfare_fund, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Simpanan Tetap</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($saving->fixed_savings, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm font-bold text-gray-900">JUMLAH</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm font-bold text-gray-900">{{ number_format($totalSavings,2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- New Transaction History Card with enhanced styling -->
                <div class="bg-white rounded-2xl shadow-sm">
                    <div class="p-6">
                        <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                                <i class="fas fa-coins mr-2"></i>Transaksi
                            </h3>
                            <!-- Sorting Form -->
                            <form method="GET" class="flex items-center space-x-2 ml-auto" id="filterForm">
                                <div>
                                    <select id="month" name="month" class="pr-8 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="document.getElementById('filterForm').submit()">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                                {{ \Carbon\Carbon::create()->month($i)->locale('ms')->translatedFormat('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <select id="year" name="year" class="pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" onchange="document.getElementById('filterForm').submit()">
                                        @for ($i = now()->year; $i >= 2025; $i--)
                                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div>
                                    <x-primary-button>
                                        <a href="{{ route('individualReport.exportTransactions', ['month' => request('month'), 'year' => request('year')]) }}" class="text-white">{{ __('Muat Turun') }}</a>
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            TARIKH
                                        </th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            JENIS
                                        </th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            AMAUN (RM)
                                        </th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            RUJUKAN
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($transactions as $transaction)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/Y') }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $transaction->type == 'savings' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $transaction->type_display }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ number_format($transaction->amount, 2) }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                                @if($transaction->reference && $transaction->reference != '-')
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        {{ $transaction->reference }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                                <div class="flex flex-col items-center justify-center space-y-2">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span class="font-medium">Tiada sejarah transaksi</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Details -->
            <div class="p-2 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                            <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                                <i class="fas fa-coins mr-2"></i> Pinjaman yang Diluluskan
                            </h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Pinjaman Jenis
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Amaun
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Bayaran Bulanan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Kadar
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tarikh Pinjaman
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Baki
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tindakan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @php
                                    $approvedLoans = $loans->filter(function ($loan) {
                                        return $loan->status == 'approved';
                                    })->sortByDesc('created_at')->take(5);
                                @endphp

                                @forelse($approvedLoans as $loan)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-500 dark:text-gray-300">
                                            {{$loan->loan_type->loan_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            RM {{number_format($loan->loan_amount, 2)}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            RM {{number_format($loan->monthly_repayment, 2)}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{$loan->interest_rate}}%
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{$loan->created_at}}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            <div class="bg-yellow-100 dark:bg-gray-700 p-2 rounded-lg text-center font-bold">
                                                RM {{$loan->loan_balance}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            <a href="{{ route('loan.show', $loan->loan_id) }}">
                                                <x-primary-button type="submit" class="bg-blue-500 hover:bg-blue-700">{{ __('BUTIRAN') }}</x-primary-button>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100 text-center" colspan="7">
                                            TIADA REKOD PINJAMAN
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>