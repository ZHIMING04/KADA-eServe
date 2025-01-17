<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Individu') }}
        </h2>
    </x-slot>

    <style>
        @import url('https://rsms.me/inter/inter.css');
        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
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
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Members Details -->
            <div class="info-card">
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
            </div>

            <!-- Saving Details and Chart -->
            <div class="flex flex-wrap -mx-2">
                <div class="w-full md:w-1/2 px-2">
                    <div class="info-card">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">MAKLUMAT SAHAM AHLI</h3>
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
                                        {{$saving->fixed_savings}},
                                        {{$saving->welfare_fund}},
                                    ],
                                    labels: ["Modal Syer", "Modal Yuran", "Deposit Ahli","Tabung Kebajikan", "Simpanan Tetap"],
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
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Deposit Ahli</td>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">{{ number_format($saving->member_deposit, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm text-gray-500">Tabung Kebajikan</td>
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

            </div>


            <!-- Loan Details -->
            <div class="p-2 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">MAKLUMAT PINJAMAN</h3>
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Pinjaman ID
                                </th>
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
                                    Tarikh Permahonan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                           @forelse($loans as $loan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                       {{$loan->loan_id}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{$loan->loan_type->loan_type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        RM {{number_format($loan->loan_amount, 2)}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        RM {{number_format($loan->monthly_repayment, 2)}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        {{$loan->created_at}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($loan->status == 'pending')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">
                                                DIPROSES
                                            </span>
                                        @elseif($loan->status == 'rejected')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                DITOLAK
                                            </span>
                                        @elseif($loan->status == 'approved')
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                DILULUSKAN
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                           @empty
                                <tr>
                                    <td class="px-6 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100" colspan="6">
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
</x-app-layout>