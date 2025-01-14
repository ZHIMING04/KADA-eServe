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
            <!-- Member Details -->
            <div class="info-card">
                <h3 class="text-5xl font-bold text-gray-900 dark:text-gray-100 mb-4">MUHAMMAD BIN ALI TUN MAHATHIR YAP JUN HAO</h3>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-1/3 mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>IC:</strong> 012345678901</p>
                    </div>
                    <div class="w-full md:w-1/3 mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>No PF:</strong> 1111</p>
                    </div>
                    <div class="w-full md:w-1/3 mb-2">
                        <p class="text-sm text-gray-600 dark:text-gray-400"><strong>No Ahli:</strong> 2222</p>
                    </div>
                </div>
            </div>

            <!-- Saving Details and Chart -->
            <div class="flex flex-wrap -mx-4">
                <div class="w-full md:w-1/2 px-4">
                    <div class="info-card">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">MAKLUMAT SAHAM AHLI</h3>
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
                                            enabled: false
                                        },
                                    },
                                    fill: {
                                        opacity: 1,
                                    },
                                    series: [44,55,66,11,22],
                                    labels: ["Modal Syer", "Modal Yuran", "Simpanan Tetap", "Tabung Anggota", "Simpanan Anggota"],
                                    tooltip: {
                                        theme: 'dark'
                                    },
                                    grid: {
                                        strokeDashArray: 4,
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
                                            vertical: 8
                                        },
                                    },
                                    tooltip: {
                                        fillSeriesColor: false
                                    },
                                })).render();
                            });
                        </script>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 text-center animate-pop-out">RM {{ number_format($member->esaving_amount ?? 198, 2) }} </h3>
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

                    </div>
                </div>

            </div>


            <!-- Loan Details -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-7xl mx-auto">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">MAKLUMAT PINJAMAN</h3>
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
                                    Tarikh Permohonan
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                           
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                       001
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        Kereta
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        RM10000
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        RM100
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        12/12/2024
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        BERJAYA
                                    </td>
                                </tr>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>