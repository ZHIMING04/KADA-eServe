<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('STATUS PERMOHONAN AHLI') }}</h2>
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
            @if($member)
                <div class="info-card">
                    <div class="rounded-lg justify-center items-center bg-gray-100 dark:bg-gray-800 p-4">
                        <div class="flex items-center mt-4">
                            <!-- Step 1 -->
                            <div class="flex flex-col items-right" style="margin-left: 15%;">
                                <div class="bg-teal-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 15l2 2l4 -4" /></svg>
                                </div>
                            </div>

                            <!-- Line Connector -->
                            <div class="h-1 bg-teal-500 w-full"></div>

                            <!-- Step 2 -->
                            <div class="flex flex-col items-center">
                                <div class="bg-yellow-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 7v5l3 3" /></svg>
                                </div>
                            </div>

                            <!-- Line Connector -->
                            @if($member->status == 'approved')
                                <div class="h-1 bg-green-300 w-full"></div> 
                            @elseif($member->status == 'rejected')
                                <div class="h-1 bg-red-300 w-full"></div>
                            @else
                                <div class="h-1 bg-gray-300 w-full"></div>
                            @endif

                            <!-- Step 3 -->
                            <div class="flex flex-col items-center" style="margin-right: 15%;">
                                @if($member->status == 'approved')
                                    <div class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                @elseif($member->status == 'rejected')
                                    <div class="bg-red-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </div>
                                @else
                                    <div class="bg-gray-300 text-white w-10 h-10 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-clock-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20.993 11.646a9 9 0 1 0 -9.318 9.348" /><path d="M12 7v5l1 1" /><path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" /><path d="M20.2 20.2l1.8 1.8" /></svg>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- status words section -->

                        <!-- step 1 -->
                        <div class="flex items-center mt-4">
                            <span class="flex-1 text-teal-700 text-sm text-center">Permohonan Dihantar</span>
                            <!-- step 2 -->
                            @if($member->status == 'pending')
                                <span class="flex-1 text-yellow-500 text-sm text-center">Sedang Diproses</span>
                            @else
                                <span class="flex-1 text-yellow-500 text-sm text-center">Telah Diproses</span>
                            @endif
                            <!-- step 3 -->
                            @if($member->status == 'approved')
                                <span class="flex-1 text-green-500 text-sm text-center">Diluluskan</span>
                            @elseif($member->status == 'rejected')
                                <span class="flex-1 text-red-500 text-sm text-center">Ditolak</span>
                            @else
                                <span class="flex-1 text-gray-500 text-sm text-center">Belum Disahkan</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle"><path stroke="none" d="M0 0h24h24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /> </svg>
                            Maklumat Peribadi
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div class="col-span-3">
                            <label class="block text-gray-700"><strong>Nama:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->name }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>No. K/P:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->ic }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Tarikh Lahir:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->DOB }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Jantina:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->gender }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Agama:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->agama }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Bangsa:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->bangsa }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>No. Telefon:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->phone }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Email:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->email }}</p>
                        </div>
                        <div class="col-span-4">
                            <label class="block text-gray-700"><strong>Alamat:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->address }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Bandar:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->city }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Negeri:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->state }}</p>
                        </div>
                        <div>
                            <label class="block text-gray-700"><strong>Poskod:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->postcode }}</p>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase mr-2"><path stroke="none" d="M0 0h24h24H0z" fill="none"/><path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" /><path d="M12 12l0 .01" /><path d="M3 13a20 20 0 0 0 18 0" /> </svg>
                            Maklumat Pekerjaan
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 mt-4">
                        <div class="col-span-3">
                            <label class="block text-gray-700"><strong>No Anggota:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->no_anggota }}</p>
                        </div>
                        <div class="col-span-3">
                            <label class="block text-gray-700"><strong>No PF:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->workingInfo->no_pf }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Jawatan:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->workingInfo->jawatan }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Gred:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->workingInfo->gred }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Gaji:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">RM {{ number_format($member->workingInfo->salary, 2) }}</p>
                        </div>
                        <div class="col-span-6">
                            <label class="block text-gray-700"><strong>Alamat Pejabat:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->office_address }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Bandar:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->office_city }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Negeri:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->office_state }}</p>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-700"><strong>Poskod:</strong></label>
                            <p class="bg-gray-100 p-2 rounded">{{ $member->office_postcode }}</p>
                        </div>
                    </div>
                </div>

                <div class="info-card">
                    <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users-group mr-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" /><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M17 10h2a2 2 0 0 1 2 2v1" /><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M3 13v-1a2 2 0 0 1 2 -2h2" /> </svg>
                            Maklumat Keluarga
                        </h3>
                    </div>

                    @if($member->familymembers->isEmpty())
                        <div class="text-center text-gray-500 p-4 bg-gray-100 rounded">
                            <p><strong>Tiada Rekod</strong></p>
                        </div>
                    @else
                        @foreach($member->familymembers as $family)
                            <div class="p-4 bg-gray-100 rounded mb-4">
                                <p><strong>Hubungan:</strong> {{ $family->relationship }}</p>
                                <p><strong>Nama:</strong> {{ $family->name }}</p>
                                <p><strong>No. K/P:</strong> {{ $family->ic }}</p>
                            </div>
                        @endforeach
                    @endif
                </div>

                
                <div class="info-card">
                    <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg">
                        <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-moneybag"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.5 3h5a1.5 1.5 0 0 1 1.5 1.5a3.5 3.5 0 0 1 -3.5 3.5h-1a3.5 3.5 0 0 1 -3.5 -3.5a1.5 1.5 0 0 1 1.5 -1.5z" /><path d="M4 17v-1a8 8 0 1 1 16 0v1a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z" /> </svg>
                            Yuran dan Sumbangan
                        </h3>
                    </div>
            <table class="table-auto w-full text-left mt-4">
                <tr class="border-b border-gray-300">
                    <td class="px-6 py-4"><strong>Yuran Masuk</strong></td>
                    <td class="px-6 py-4">RM {{ number_format($member->savings->entrance, 2) }}</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-6 py-4"><strong>Modal Syer</strong></td>
                    <td class="px-6 py-4">RM {{ number_format($member->savings->share_capital, 2) }}</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-6 py-4"><strong>Modal Yuran</strong></td>
                    <td class="px-6 py-4">RM {{ number_format($member->savings->subscription_capital, 2) }}</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-6 py-4"><strong>Wang Deposit Anggota</strong></td>
                    <td class="px-6 py-4">RM {{ number_format($member->savings->member_deposit, 2) }}</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-6 py-4"><strong>Sumbangan Tabung Kebajikan (Al-Abrar)</strong></td>
                    <td class="px-6 py-4">RM {{ number_format($member->savings->welfare_fund, 2) }}</td>
                </tr>
                <tr class="border-b border-gray-300">
                    <td class="px-6 py-4"><strong>Simpanan Tetap</strong></td>
                    <td class="px-6 py-4">RM {{ number_format($member->savings->fixed_savings, 2) }}</td>
                </tr>
                <tr>
                    <td class="px-6 py-4"><strong>Total Amount</strong></td>
                    <td class="px-6 py-4"><strong>RM {{ number_format($member->savings->total_amount, 2) }}</strong></td>
                </tr>
            </table>
                </div>

            @else
                <div class="info-card">
                    <p class="text-center text-gray-500">Tiada Rekod</p>
                </div>
            @endif
        </div>
    </div>
            
</x-app-layout>