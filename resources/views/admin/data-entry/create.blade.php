<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-900">
            {{ __('Entri Data Ahli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.registrations.pending') }}" class="inline-block px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 transition duration-300 ease-in-out transform hover:scale-105">
                    Kembali
                </a>
            </div>

            <!-- Error Messages -->
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.data-entry.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Maklumat Akaun --}}
                <div class="p-6 bg-white rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:shadow-xl">
                    <h3 class="text-lg font-medium text-gray-800">Maklumat Akaun</h3>
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Emel</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                {{-- Maklumat Ahli --}}
                <div class="p-6 bg-white rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:shadow-xl">
                    <h3 class="text-lg font-medium text-gray-800">Maklumat Ahli</h3>
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="no_anggota" class="block text-sm font-medium text-gray-700">No Anggota</label>
                            <input id="no_anggota" type="text" name="no_anggota" value="{{ old('no_anggota') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="ic" class="block text-sm font-medium text-gray-700">No IC</label>
                            <input id="ic" type="text" name="ic" value="{{ old('ic') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">No Telefon</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                            <input id="address" type="text" name="address" value="{{ old('address') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Bandar</label>
                            <input id="city" type="text" name="city" value="{{ old('city') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="postcode" class="block text-sm font-medium text-gray-700">Poskod</label>
                            <input id="postcode" type="text" name="postcode" value="{{ old('postcode') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">Negeri</label>
                            <input id="state" type="text" name="state" value="{{ old('state') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Jantina</label>
                            <select id="gender" name="gender" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Pilih Jantina</option>
                                <option value="Lelaki">Lelaki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div>
                            <label for="DOB" class="block text-sm font-medium text-gray-700">Tarikh Lahir</label>
                            <input id="DOB" type="date" name="DOB" value="{{ old('DOB') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="agama" class="block text-sm font-medium text-gray-700">Agama</label>
                            <input id="agama" type="text" name="agama" value="{{ old('agama') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="bangsa" class="block text-sm font-medium text-gray-700">Bangsa</label>
                            <input id="bangsa" type="text" name="bangsa" value="{{ old('bangsa') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                {{-- Maklumat Pekerjaan --}}
                <div class="p-6 bg-white rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:shadow-xl">
                    <h3 class="text-lg font-medium text-gray-800">Maklumat Pekerjaan</h3>
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="no_pf" class="block text-sm font-medium text-gray-700">No PF</label>
                            <input id="no_pf" type="text" name="no_pf" value="{{ old('no_pf') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="salary" class="block text-sm font-medium text-gray-700">Gaji</label>
                            <input id="salary" type="number" step="0.01" name="salary" value="{{ old('salary') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="office_address" class="block text-sm font-medium text-gray-700">Alamat Pejabat</label>
                            <input id="office_address" type="text" name="office_address" value="{{ old('office_address') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="office_city" class="block text-sm font-medium text-gray-700">Bandar Pejabat</label>
                            <input id="office_city" type="text" name="office_city" value="{{ old('office_city') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="office_postcode" class="block text-sm font-medium text-gray-700">Poskod Pejabat</label>
                            <input id="office_postcode" type="text" name="office_postcode" value="{{ old('office_postcode') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="office_state" class="block text-sm font-medium text-gray-700">Negeri Pejabat</label>
                            <input id="office_state" type="text" name="office_state" value="{{ old('office_state') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="jawatan" class="block text-sm font-medium text-gray-700">Jawatan</label>
                            <input id="jawatan" type="text" name="jawatan" value="{{ old('jawatan') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="gred" class="block text-sm font-medium text-gray-700">Gred</label>
                            <input id="gred" type="text" name="gred" value="{{ old('gred') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                {{-- Maklumat Simpanan --}}
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h3 class="text-lg font-medium text-gray-800">Yuran dan Simpanan</h3>
                    <div class="grid grid-cols-2 gap-6 mt-4">
                        <div>
                            <label for="fees_entrance" class="block text-sm font-medium text-gray-700">Yuran Masuk</label>
                            <input id="fees_entrance" type="number" name="fees[entrance]" value="{{ old('fees.entrance') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="fees_share_capital" class="block text-sm font-medium text-gray-700">Modal Syer</label>
                            <input id="fees_share_capital" type="number" name="fees[share_capital]" value="{{ old('fees.share_capital') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="fees_subscription_capital" class="block text-sm font-medium text-gray-700">Modal Yuran</label>
                            <input id="fees_subscription_capital" type="number" name="fees[subscription_capital]" value="{{ old('fees.subscription_capital') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="fees_member_deposit" class="block text-sm font-medium text-gray-700">Simpanan Ahli</label>
                            <input id="fees_member_deposit" type="number" name="fees[member_deposit]" value="{{ old('fees.member_deposit') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="fees_welfare_fund" class="block text-sm font-medium text-gray-700">Tabung Kebajikan</label>
                            <input id="fees_welfare_fund" type="number" name="fees[welfare_fund]" value="{{ old('fees.welfare_fund') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                        <div>
                            <label for="fees_fixed_savings" class="block text-sm font-medium text-gray-700">Simpanan Tetap</label>
                            <input id="fees_fixed_savings" type="number" name="fees[fixed_savings]" value="{{ old('fees.fixed_savings') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                        </div>
                    </div>
                </div>

                {{-- Maklumat Keluarga --}}
                <div class="p-6 bg-white rounded-lg shadow-lg transition duration-300 ease-in-out transform hover:shadow-xl">
                    <h3 class="text-lg font-medium text-gray-800">
                        Maklumat Keluarga 
                    </h3>
                    <div class="mt-4">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Bil.</th>
                                    <th class="px-4 py-2 text-left">Nama</th>
                                    <th class="px-4 py-2 text-left">No. KP</th>
                                    <th class="px-4 py-2 text-left">Hubungan</th>
                                    <th class="px-4 py-2">
                                        <button type="button" onclick="addFamilyRow()" 
                                                class="inline-flex items-center px-3 py-1 bg-primary text-white rounded-md hover:bg-primary-dark transition duration-300 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            Tambah
                                        </button>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="familyTableBody">
                                <!-- Family members will be added here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Maklumat Pinjaman --}}
                <div x-data="{ 
                    hasLoan: false,
                    loanAmount: 0,
                    loanPeriod: 0,
                    toggleLoan(value) {
                        this.hasLoan = value;
                        if (!value) {
                            // Clear loan fields when switching to no loan
                            document.querySelectorAll('[data-loan-field]').forEach(field => {
                                field.removeAttribute('required');
                                field.value = '';
                                field.disabled = true;
                            });
                        } else {
                            // Add required attribute back when loan is selected
                            document.querySelectorAll('[data-loan-field]').forEach(field => {
                                field.setAttribute('required', 'required');
                                field.disabled = false;
                            });
                        }
                    }
                }" class="p-6 bg-white rounded-lg shadow-lg" x-init="toggleLoan(false)">
                    <h3 class="text-lg font-medium text-gray-800">
                        Maklumat Pinjaman
                        <span class="text-sm text-gray-500">(Pilihan)</span>
                    </h3>
                    
                    <div class="mt-4 space-x-6">
                        <input type="hidden" name="has_loan" :value="hasLoan">
                        
                        <div class="space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" 
                                       name="loan_choice"
                                       value="0"
                                       @click="toggleLoan(false)"
                                       checked
                                       class="form-radio text-primary">
                                <span class="ml-2">Tiada Pinjaman</span>
                            </label>
                            
                            <label class="inline-flex items-center">
                                <input type="radio" 
                                       name="loan_choice"
                                       value="1"
                                       @click="toggleLoan(true)"
                                       class="form-radio text-primary">
                                <span class="ml-2">Ada Pinjaman</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="hasLoan" x-transition class="mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="loan_type_id" class="block text-sm font-medium text-gray-700">Jenis Pembiayaan</label>
                                <select id="loan_type_id" 
                                        name="loan_type_id" 
                                        data-loan-field
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    <option value="">Pilih Jenis Pembiayaan</option>
                                    <option value="1">Al-Bai</option>
                                    <option value="2">Al-Inah</option>
                                    <option value="3">Skim Khas</option>
                                    <option value="4">Karnival Muslim Istimewa</option>
                                    <option value="5">Baik Pulih Kenderaan</option>
                                    <option value="6">Cukai Jalan</option>
                                </select>
                            </div>
                            <div>
                                <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank</label>
                                <select id="bank_name" name="bank_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="">Pilih Bank</option>
                                    <option value="Affin Bank Berhad">Affin Bank Berhad</option>
                                    <option value="Affin Islamic Bank Berhad">Affin Islamic Bank Berhad</option>
                                    <option value="Alliance Bank Malaysia Berhad">Alliance Bank Malaysia Berhad</option>
                                    <option value="Alliance Islamic Bank Malaysia Berhad">Alliance Islamic Bank Malaysia Berhad</option>
                                    <option value="Al Rajhi Banking & Investment Corporation (Malaysia) Berhad">Al Rajhi Banking & Investment Corporation (Malaysia) Berhad</option>
                                    <option value="AmBank (M) Berhad">AmBank (M) Berhad</option>
                                    <option value="Bank Islam Malaysia Berhad">Bank Islam Malaysia Berhad</option>
                                    <option value="Bank Kerjasama Rakyat Malaysia Berhad">Bank Kerjasama Rakyat Malaysia Berhad</option>
                                    <option value="Bank Muamalat Malaysia Berhad">Bank Muamalat Malaysia Berhad</option>
                                    <option value="Bank of China (Malaysia) Berhad">Bank of China (Malaysia) Berhad</option>
                                    <option value="Bank Pertanian Malaysia Berhad (Agrobank)">Bank Pertanian Malaysia Berhad (Agrobank)</option>
                                    <option value="Bank Simpanan Nasional">Bank Simpanan Nasional</option>
                                    <option value="CIMB Bank Berhad">CIMB Bank Berhad</option>
                                    <option value="CIMB Islamic Bank Berhad">CIMB Islamic Bank Berhad</option>
                                    <option value="Citibank Berhad">Citibank Berhad</option>
                                    <option value="Hong Leong Bank Berhad">Hong Leong Bank Berhad</option>
                                    <option value="Hong Leong Islamic Bank Berhad">Hong Leong Islamic Bank Berhad</option>
                                    <option value="HSBC Amanah Malaysia Berhad">HSBC Amanah Malaysia Berhad</option>
                                    <option value="HSBC Bank Malaysia Berhad">HSBC Bank Malaysia Berhad</option>
                                    <option value="Industrial and Commercial Bank of China (Malaysia) Berhad">Industrial and Commercial Bank of China (Malaysia) Berhad</option>
                                    <option value="Kuwait Finance House">Kuwait Finance House</option>
                                    <option value="Malayan Banking Berhad">Malayan Banking Berhad</option>
                                    <option value="MBSB Bank Berhad">MBSB Bank Berhad</option>
                                    <option value="OCBC Bank (Malaysia) Berhad">OCBC Bank (Malaysia) Berhad</option>
                                    <option value="Public Bank Berhad">Public Bank Berhad</option>
                                    <option value="RHB Bank Berhad">RHB Bank Berhad</option>
                                    <option value="RHB Islamic Bank Berhad">RHB Islamic Bank Berhad</option>
                                    <option value="Standard Chartered Bank Malaysia Berhad">Standard Chartered Bank Malaysia Berhad</option>
                                    <option value="Standard Chartered Saadiq Berhad">Standard Chartered Saadiq Berhad</option>
                                    <option value="United Overseas Bank (Malaysia) Berhad">United Overseas Bank (Malaysia) Berhad</option>
                                </select>
                            </div>
                            <div>
                                <label for="date_apply" class="block text-sm font-medium text-gray-700">Tarikh Mohon</label>
                                <input id="date_apply" 
                                       type="date" 
                                       name="date_apply" 
                                       data-loan-field
                                       disabled
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label for="bank_account" class="block text-sm font-medium text-gray-700">No. Akaun Bank</label>
                                <input id="bank_account" type="text" name="bank_account" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label for="loan_amount" class="block text-sm font-medium text-gray-700">Jumlah Pinjaman (RM)</label>
                                <input type="number" 
                                       id="loan_amount" 
                                       name="loan_amount" 
                                       x-model="loanAmount"
                                       data-loan-field
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="loan_period" class="block text-sm font-medium text-gray-700">Tempoh Pinjaman (Bulan)</label>
                                <input type="number" 
                                       id="loan_period" 
                                       name="loan_period" 
                                       x-model="loanPeriod"
                                       data-loan-field
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            </div>
                            <div>
                                <label for="monthly_gross_salary" class="block text-sm font-medium text-gray-700">Gaji Kasar Bulanan (RM)</label>
                                <input id="monthly_gross_salary" type="number" name="monthly_gross_salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label for="monthly_net_salary" class="block text-sm font-medium text-gray-700">Gaji Bersih Bulanan (RM)</label>
                                <input id="monthly_net_salary" type="number" name="monthly_net_salary" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                            <div>
                                <label for="interest_rate" class="block text-sm font-medium text-gray-700">Kadar Faedah (%)</label>
                                <input id="interest_rate" type="text" name="interest_rate" value="{{ $interestRate }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm bg-gray-100" />
                            </div>
                            <div>
                                <label for="loan_balance" class="block text-sm font-medium text-gray-700">Baki Pinjaman</label>
                                <input id="loan_balance" 
                                       type="number" 
                                       name="loan_balance" 
                                       data-loan-field
                                       disabled
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                            </div>
                        </div>

                        {{-- Guarantor sections --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <!-- First Guarantor Card -->
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-800">Penjamin Pertama</h4>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div>
                                        <label for="guarantor1_name" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" 
                                               id="guarantor1_name" 
                                               name="guarantor1_name" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor1_pf" class="block text-sm font-medium text-gray-700">No. PF</label>
                                        <input type="text" 
                                               id="guarantor1_pf" 
                                               name="guarantor1_pf" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor1_ic" class="block text-sm font-medium text-gray-700">No. KP</label>
                                        <input type="text" 
                                               id="guarantor1_ic" 
                                               name="guarantor1_ic" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor1_phone" class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" 
                                               id="guarantor1_phone" 
                                               name="guarantor1_phone" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor1_no_anggota" class="block text-sm font-medium text-gray-700">No. Anggota</label>
                                        <input type="text" 
                                               id="guarantor1_no_anggota" 
                                               name="guarantor1_no_anggota" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>

                            <!-- Second Guarantor Card -->
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
                                <div class="p-4">
                                    <h4 class="text-lg font-semibold text-gray-800">Penjamin Kedua</h4>
                                </div>
                                <div class="p-6 space-y-4">
                                    <div>
                                        <label for="guarantor2_name" class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" 
                                               id="guarantor2_name" 
                                               name="guarantor2_name" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor2_pf" class="block text-sm font-medium text-gray-700">No. PF</label>
                                        <input type="text" 
                                               id="guarantor2_pf" 
                                               name="guarantor2_pf" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor2_ic" class="block text-sm font-medium text-gray-700">No. KP</label>
                                        <input type="text" 
                                               id="guarantor2_ic" 
                                               name="guarantor2_ic" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor2_phone" class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" 
                                               id="guarantor2_phone" 
                                               name="guarantor2_phone" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                    <div>
                                        <label for="guarantor2_no_anggota" class="block text-sm font-medium text-gray-700">No. Anggota</label>
                                        <input type="text" 
                                               id="guarantor2_no_anggota" 
                                               name="guarantor2_no_anggota" 
                                               data-loan-field
                                               :required="hasLoan"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300 ease-in-out transform hover:scale-105">
                        Simpan Data Ahli
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let rowCount = 0;

        function addFamilyRow() {
            rowCount++;
            const tbody = document.getElementById('familyTableBody');
            const newRow = document.createElement('tr');
            
            newRow.innerHTML = `
                <td class="px-4 py-3">${rowCount}</td>
                <td class="px-4 py-3">
                    <input type="text" name="family[${rowCount}][name]" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </td>
                <td class="px-4 py-3">
                    <input type="text" name="family[${rowCount}][ic]" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                </td>
                <td class="px-4 py-3">
                    <select name="family[${rowCount}][relationship]" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                        <option value="">Pilih Hubungan</option>
                        <option value="Isteri">Isteri</option>
                        <option value="Suami">Suami</option>
                        <option value="Anak">Anak</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Bapa">Bapa</option>
                        <option value="Adik-beradik">Adik-beradik</option>
                    </select>
                </td>
                <td class="px-4 py-3 text-center">
                    <button type="button" onclick="this.closest('tr').remove(); updateRowNumbers()" 
                            class="text-red-600 hover:text-red-800 transition duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </td>
            `;
            
            tbody.appendChild(newRow);
        }

        function updateRowNumbers() {
            const rows = document.getElementById('familyTableBody').getElementsByTagName('tr');
            for (let i = 0; i < rows.length; i++) {
                rows[i].cells[0].textContent = i + 1;
            }
            rowCount = rows.length;
        }
    </script>
    @endpush
</x-app-layout> 