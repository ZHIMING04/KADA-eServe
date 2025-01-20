<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('PINJAMAN') }}</h2>
        </div>
    </x-slot>

    <style>
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
            margin-bottom: 1.5rem; /* Add margin to create gap between cards */
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($loans as $loan)
                <div class="info-card">

                <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                        Pinjaman {{$loan->loan_type->loan_type}}
                    </h3>
                    <p class="text-l font-semibold text-white flex items-center">Id: {{$loan->loan_id}}  </p>
                </div>

                    <div class="rounded-lg justify-center items-center bg-gray-100 dark:bg-gray-800 p-4">
                        <div class="flex items-center mt-4">
                            <!-- Step 1 -->
                            <div class="flex flex-col items-right" style="margin-left: 15%;">
                                <div class="bg-teal-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 15l2 2l4 -4" /></svg>
                                </div>
                              
                            </div>

                            <!-- Line Connector -->
                            <div class="h-1 bg-teal-500 w-full"></div>

                            <!-- Step 2 -->
                            <div class="flex flex-col items-center">
                                <div class="bg-yellow-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                </div>
                                
                            </div>

                            <!-- Line Connector -->
                            @if($loan->status == 'approved')
                                <div class="h-1 bg-green-300 w-full"></div> 
                            @elseif($loan->status == 'rejected')
                                <div class="h-1 bg-red-300 w-full"></div>
                            @else
                                <div class="h-1 bg-gray-300 w-full"></div>
                            @endif

                            <!-- Step 3 -->
                            <div class="flex flex-col items-center" style="margin-right: 15%;">
                                @if($loan->status == 'approved')
                                    <div class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                @elseif($loan->status == 'rejected')
                                    <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                 
                                @else
                                    <div class="bg-gray-300 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clock-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.993 11.646a9 9 0 1 0 -9.318 9.348" /><path d="M12 7v5l1 1" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                                    </div>
                                    
                                @endif
                            </div>
                        </div>
                    <!-- status words section -->

                    <!-- step 1 -->
                        <div class="flex items-center mt-4">
                            <span class="flex-1 text-teal-700 text-sm text-center">Permohonan Dihantar</span>
                    <!-- step 2 -->
                            @if($loan->status == 'pending')
                            <span class="flex-1 text-yellow-500 text-sm text-center">Sedang Diproses</span>
                            @else
                            <span class="flex-1 text-yellow-500 text-sm text-center">Telah Diproses</span>
                            @endif
                    <!-- step 3 -->
                            @if($loan->status == 'approved')
                                <span class="flex-1 text-green-500 text-sm text-center">Diluluskan</span>
                            @elseif($loan->status == 'rejected')
                                <span class="flex-1 text-red-500 text-sm text-center">Ditolak</span>
                            @else
                                <span class="flex-1 text-gray-500 text-sm text-center">Belum Disahkan</span>
                            @endif
                        </div>
                    </div>

                    <br>
                    <br>

                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-center">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Amaun Pinjaman
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Bayaran Bulanan
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Kadar
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tarikh Pinjaman
                                </th>
                                <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tindakan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                        RM {{$loan->loan_amount,2 }}
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
                                        <div class="flex justify-center">
                                            <a href="{{ route('loan.show', $loan->loan_id) }}">
                                            <x-primary-button type="submit" class="bg-blue-500 hover:bg-blue-700">{{ __('BUTIRAN') }}</x-primary-button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            @empty
                <div class="info-card">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">TIADA REKOD PINJAMAN</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>