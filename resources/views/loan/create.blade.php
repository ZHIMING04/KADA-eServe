<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permohonan Pinjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
                <div class="p-8" x-data="{ 
                    currentStep: 1,
                    loanData: {
                        loan_type: '',
                        bank_id: '',
                        bank_account: '',
                        loan_amount: '',
                        loan_period: ''
                    },
                    guarantorData: {
                        guarantor1_name: '',
                        guarantor1_ic: '',
                        guarantor1_phone: '',
                        guarantor1_address: '',
                        guarantor1_relationship: '',
                        guarantor2_name: '',
                        guarantor2_ic: '',
                        guarantor2_phone: '',
                        guarantor2_address: '',
                        guarantor2_relationship: ''
                    }
                }">
                    <!-- Step Numbers - Updated Design -->
                    <div class="flex justify-between mb-12 relative">
                        <!-- Progress Bar -->
                        <div class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 w-full -z-1"></div>
                        <div class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-primary transition-all duration-500"
                             :style="'width: ' + ((currentStep - 1) * 33.33) + '%'"></div>
                        
                        <!-- Step Indicators -->
                        <template x-for="step in 4" :key="step">
                            <div class="relative z-10 text-center">
                                <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center"
                                     :class="currentStep >= step ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                    <span class="text-lg font-medium" x-text="step"></span>
                                </div>
                                <p class="mt-2 text-sm font-medium" 
                                   :class="currentStep >= step ? 'text-primary' : 'text-gray-400'">
                                    <span x-show="step === 1">Maklumat Peribadi</span>
                                    <span x-show="step === 2">Maklumat Pinjaman</span>
                                    <span x-show="step === 3">Maklumat Penjamin</span>
                                    <span x-show="step === 4">Pengesahan</span>
                                </p>
                            </div>
                        </template>
                    </div>

                    <form method="POST" action="{{ route('loan.store') }}" class="space-y-8">
                        @csrf
                        <input type="hidden" name="date_apply" value="{{ date('Y-m-d') }}">
                        
                        @if ($errors->any())
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-8">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">
                                            Terdapat beberapa kesalahan:
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul class="list-disc pl-5 space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Step 1: Personal Information - Updated Design -->
                        <div x-show="currentStep === 1" class="transition-all duration-500">
                            <h2 class="text-2xl font-bold mb-8 text-gray-800 dark:text-white">Maklumat Peribadi</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Name -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                    <div class="text-lg text-gray-900 dark:text-white">{{ $member->name }}</div>
                                </div>

                                <!-- IC Number -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">No. Kad Pengenalan</label>
                                    <div class="text-lg text-gray-900 dark:text-white">{{ $member->ic }}</div>
                                </div>

                                <!-- Address -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Alamat</label>
                                    <div class="text-lg text-gray-900 dark:text-white">{{ $member->address }}</div>
                                </div>

                                <!-- Phone -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">No. Telefon</label>
                                    <div class="text-lg text-gray-900 dark:text-white">{{ $member->phone }}</div>
                                </div>
                                

                                <!-- Email -->
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6 shadow-sm">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Emel</label>
                                    <div class="text-lg text-gray-900 dark:text-white">{{ $member->email }}</div>
                                </div>
                            </div>

                            <!-- Updated Button Design -->
                            <div class="mt-12 flex justify-end">
                                <button type="button" 
                                        @click="currentStep = 2"
                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                    Seterusnya
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Loan Details -->
                        <div x-show="currentStep === 2" x-cloak>
                            <h2 class="text-xl font-semibold mb-6">Maklumat Pinjaman</h2>
                            
                            <!-- Loan Type -->
                            <div class="mb-4">
                                <label for="loan_type_id" class="block text-sm font-medium text-gray-700">Jenis Pembiayaan</label>
                                <select id="loan_type_id" 
                                        name="loan_type_id" 
                                        x-model="loanData.loan_type_id"
                                        class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                        required>
                                    <option value="">Pilih Jenis Pembiayaan</option>
                                    <option value="1">Al-Bai</option>
                                    <option value="2">Al-Inah</option>
                                    <option value="3">Skim Khas</option>
                                    <option value="4">Karnival Muslim Istimewa</option>
                                    <option value="5">Baik Pulih Kenderaan</option>
                                    <option value="6">Cukai Jalan</option>
                                </select>
                            </div>

                            <!-- Bank -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Bank</label>
                                <select id="bank_id" 
                                        name="bank_id" 
                                        x-model="loanData.bank_id"
                                        class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                        required>
                                    <option value="">Pilih Bank</option>
                                    <option value="1">Affin Bank Berhad</option>
                                    <option value="2">Affin Islamic Bank Berhad</option>
                                    <option value="3">Alliance Bank Malaysia Berhad</option>
                                    <option value="4">Alliance Islamic Bank Malaysia Berhad</option>
                                    <option value="5">Al Rajhi Banking & Investment Corporation (Malaysia) Berhad</option>
                                    <option value="6">AmBank (M) Berhad</option>
                                    <option value="7">Bank Islam Malaysia Berhad</option>
                                    <option value="8">Bank Kerjasama Rakyat Malaysia Berhad</option>
                                    <option value="9">Bank Muamalat Malaysia Berhad</option>
                                    <option value="10">Bank of China (Malaysia) Berhad</option>
                                    <option value="11">Bank Pertanian Malaysia Berhad (Agrobank)</option>
                                    <option value="12">Bank Simpanan Nasional</option>
                                    <option value="13">CIMB Bank Berhad</option>
                                    <option value="14">CIMB Islamic Bank Berhad</option>
                                    <option value="15">Citibank Berhad</option>
                                    <option value="16">Hong Leong Bank Berhad</option>
                                    <option value="17">Hong Leong Islamic Bank Berhad</option>
                                    <option value="18">HSBC Amanah Malaysia Berhad</option>
                                    <option value="19">HSBC Bank Malaysia Berhad</option>
                                    <option value="20">Industrial and Commercial Bank of China (Malaysia) Berhad</option>
                                    <option value="21">Kuwait Finance House</option>
                                    <option value="22">Malayan Banking Berhad</option>
                                    <option value="23">MBSB Bank Berhad</option>
                                    <option value="24">OCBC Bank (Malaysia) Berhad</option>
                                    <option value="25">Public Bank Berhad</option>
                                    <option value="26">RHB Bank Berhad</option>
                                    <option value="27">RHB Islamic Bank Berhad</option>
                                    <option value="28">Standard Chartered Bank Malaysia Berhad</option>
                                    <option value="29">Standard Chartered Saadiq Berhad</option>
                                    <option value="30">United Overseas Bank (Malaysia) Berhad</option>
                                </select>
                            </div>

                            <!-- Bank Account Number -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">No. Akaun Bank</label>
                                <input type="text" 
                                       name="bank_account" 
                                       x-model="loanData.bank_account"
                                       class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600"
                                       placeholder="Contoh: 1234567890"
                                       required>
                            </div>

                            <!-- Loan Amount -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Jumlah Pinjaman (RM)</label>
                                <input type="number" 
                                       name="loan_amount" 
                                       x-model="loanData.loan_amount"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                       required>
                            </div>

                            <!-- Loan Period -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Tempoh Pinjaman (Bulan)</label>
                                <input type="number" 
                                       name="loan_period" 
                                       x-model="loanData.loan_period"
                                       min="1" 
                                       max="60"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                       required>
                            </div>

                            <!-- Monthly Salaries -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gaji Kasar Bulanan (RM)</label>
                                    <input type="number" 
                                           name="monthly_gross_salary" 
                                           x-model="loanData.monthly_gross_salary"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                           required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gaji Bersih Bulanan (RM)</label>
                                    <input type="number" 
                                           name="monthly_net_salary" 
                                           x-model="loanData.monthly_net_salary"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                           required>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-12 flex justify-between">
                                <button type="button" @click="currentStep = 1"
                                        class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <button type="button" 
                                        @click="currentStep = 3"
                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                    Seterusnya
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Guarantor Information -->
                        <div x-show="currentStep === 3" x-cloak>
                            <h2 class="text-xl font-semibold mb-6">Maklumat Penjamin</h2>
                            
                            <!-- First Guarantor -->
                            <div class="mb-8">
                                <h3 class="text-lg font-medium mb-4">Penjamin Pertama</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Penjamin</label>
                                        <input type="text" name="guarantor1_name" 
                                               x-model="guarantorData.guarantor1_name"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="guarantor1_ic" 
                                               x-model="guarantorData.guarantor1_ic"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="guarantor1_phone" 
                                               x-model="guarantorData.guarantor1_phone"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea name="guarantor1_address" rows="3" 
                                                  x-model="guarantorData.guarantor1_address"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hubungan dengan Pemohon</label>
                                        <select name="guarantor1_relationship" 
                                                x-model="guarantorData.guarantor1_relationship"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                            <option value="">Pilih Hubungan</option>
                                            <option value="parent">Ibu/Bapa</option>
                                            <option value="spouse">Suami/Isteri</option>
                                            <option value="sibling">Adik-beradik</option>
                                            <option value="relative">Saudara</option>
                                            <option value="friend">Rakan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Guarantor -->
                            <div class="mt-12">
                                <h3 class="text-lg font-medium mb-4">Penjamin Kedua</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nama Penjamin</label>
                                        <input type="text" name="guarantor2_name" 
                                               x-model="guarantorData.guarantor2_name"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="guarantor2_ic" 
                                               x-model="guarantorData.guarantor2_ic"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="guarantor2_phone" 
                                               x-model="guarantorData.guarantor2_phone"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea name="guarantor2_address" rows="3" 
                                                  x-model="guarantorData.guarantor2_address"
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hubungan dengan Pemohon</label>
                                        <select name="guarantor2_relationship" 
                                                x-model="guarantorData.guarantor2_relationship"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                            <option value="">Pilih Hubungan</option>
                                            <option value="parent">Ibu/Bapa</option>
                                            <option value="spouse">Suami/Isteri</option>
                                            <option value="sibling">Adik-beradik</option>
                                            <option value="relative">Saudara</option>
                                            <option value="friend">Rakan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3 Navigation Buttons -->
                            <div class="mt-12 flex justify-between">
                                <button type="button" @click="currentStep = 2"
                                        class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <button type="button" 
                                        @click="currentStep = 4"
                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                    Seterusnya
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 4: Confirmation with Summary -->
                        <div x-show="currentStep === 4" x-cloak>
                            <h2 class="text-xl font-semibold mb-6">Pengesahan</h2>
                            
                            <div class="space-y-8">
                                <!-- Personal Information Summary -->
                                <div>
                                    <h3 class="text-lg font-medium mb-4">Maklumat Peribadi</h3>
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <dl class="grid grid-cols-1 gap-4">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                                <dd class="text-sm text-gray-900">{{ $member->name }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">No. Kad Pengenalan</dt>
                                                <dd class="text-sm text-gray-900">{{ $member->ic }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                                                <dd class="text-sm text-gray-900">{{ $member->address }}</dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <!-- Loan Details Summary -->
                                <div>
                                    <h3 class="text-lg font-medium mb-4">Maklumat Pinjaman</h3>
                                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                        <dl class="grid grid-cols-2 gap-4">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Jenis Pembiayaan</dt>
                                                <dd class="mt-1 text-sm text-gray-900" x-text="getLoanTypeName(loanData.loan_type_id)"></dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Jumlah Pinjaman</dt>
                                                <dd class="mt-1 text-sm text-gray-900">RM <span x-text="loanData.loan_amount"></span></dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tempoh Pinjaman</dt>
                                                <dd class="mt-1 text-sm text-gray-900"><span x-text="loanData.loan_period"></span> bulan</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Bank</dt>
                                                <dd class="mt-1 text-sm text-gray-900" x-text="getBankName(loanData.bank_id)"></dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">No. Akaun Bank</dt>
                                                <dd class="mt-1 text-sm text-gray-900" x-text="loanData.bank_account"></dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <!-- Guarantor Information Summary -->
                                <div>
                                    <h3 class="text-lg font-medium mb-4">Maklumat Penjamin</h3>
                                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                                        <h3 class="text-lg font-medium mb-4">Maklumat Penjamin</h3>
                                        
                                        <!-- First Guarantor Summary -->
                                        <div class="mb-6">
                                            <h4 class="font-medium mb-2">Penjamin Pertama</h4>
                                            <dl class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor1_name"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. KP</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor1_ic"></dd>
                                                </div>
                                                <!-- ... other guarantor1 details ... -->
                                            </dl>
                                        </div>

                                        <!-- Second Guarantor Summary -->
                                        <div>
                                            <h4 class="font-medium mb-2">Penjamin Kedua</h4>
                                            <dl class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor2_name"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. KP</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor2_ic"></dd>
                                                </div>
                                                <!-- ... other guarantor2 details ... -->
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Agreement -->
                                <div class="mt-8">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" 
                                               name="terms_agreed" 
                                               required
                                               class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                        <span class="ml-2">Saya mengesahkan bahawa semua maklumat yang diberikan adalah benar dan tepat</span>
                                    </label>
                                    @error('terms_agreed')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Step 4 Navigation Buttons -->
                            <div class="mt-12 flex justify-between">
                                <button type="button" @click="currentStep = 3"
                                        class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                
                                <button type="submit"
                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200"
                                        onclick="return document.querySelector('input[name=terms_agreed]').checked || (alert('Sila tandakan kotak pengesahan terlebih dahulu.'), false)">
                                    Hantar Permohonan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    function getLoanTypeName(loanTypeId) {
        const loanTypes = {
            '1': 'Al-Bai',
            '2': 'Al-Inah',
            '3': 'Skim Khas',
            '4': 'Karnival Muslim Istimewa',
            '5': 'Baik Pulih Kenderaan',
            '6': 'Cukai Jalan'
        };
        return loanTypes[loanTypeId] || 'Jenis Pembiayaan tidak dipilih';
    }

    function getBankName(bankId) {
        const banks = {
            1: 'Affin Bank Berhad',
            2: 'Affin Islamic Bank Berhad',
            3: 'Alliance Bank Malaysia Berhad',
            4: 'Alliance Islamic Bank Malaysia Berhad',
            5: 'Al Rajhi Banking & Investment Corporation (Malaysia) Berhad',
            6: 'AmBank (M) Berhad',
            7: 'Bank Islam Malaysia Berhad',
            8: 'Bank Kerjasama Rakyat Malaysia Berhad',
            9: 'Bank Muamalat Malaysia Berhad',
            10: 'Bank of China (Malaysia) Berhad',
            11: 'Bank Pertanian Malaysia Berhad (Agrobank)',
            12: 'Bank Simpanan Nasional',
            13: 'CIMB Bank Berhad',
            14: 'CIMB Islamic Bank Berhad',
            15: 'Citibank Berhad',
            16: 'Hong Leong Bank Berhad',
            17: 'Hong Leong Islamic Bank Berhad',
            18: 'HSBC Amanah Malaysia Berhad',
            19: 'HSBC Bank Malaysia Berhad',
            20: 'Industrial and Commercial Bank of China (Malaysia) Berhad',
            21: 'Kuwait Finance House',
            22: 'Malayan Banking Berhad',
            23: 'MBSB Bank Berhad',
            24: 'OCBC Bank (Malaysia) Berhad',
            25: 'Public Bank Berhad',
            26: 'RHB Bank Berhad',
            27: 'RHB Islamic Bank Berhad',
            28: 'Standard Chartered Bank Malaysia Berhad',
            29: 'Standard Chartered Saadiq Berhad',
            30: 'United Overseas Bank (Malaysia) Berhad'
        };
        return banks[bankId] || 'Bank tidak dipilih';
    }
</script>







