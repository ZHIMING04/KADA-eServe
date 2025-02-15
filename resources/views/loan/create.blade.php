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
                    errors: {},
                    loanData: {
                        loan_type_id: '',
                        bank_id: '',
                        bank_account: '',
                        loan_amount: '',
                        loan_period: '',
                        monthly_gross_salary: '',
                        monthly_net_salary: ''
                    },
                    guarantorData: {
                        guarantor1_name: '',
                        guarantor1_pf: '',
                        guarantor1_ic: '',  
                        guarantor1_phone: '',
                        guarantor1_no_anggota: '',
                        guarantor2_name: '',
                        guarantor2_pf: '',
                        guarantor2_ic: '',
                        guarantor2_phone: '',
                        guarantor2_no_anggota: ''
                    },
                    validateStep2() {
                        this.errors = {};
                        let isValid = true;

                        // Validate loan type
                        if (!this.loanData.loan_type_id) {
                            this.errors.loan_type_id = 'Sila pilih jenis pembiayaan';
                            isValid = false;
                        }

                        // Validate bank
                        if (!this.loanData.bank_id) {
                            this.errors.bank_id = 'Sila pilih bank';
                            isValid = false;
                        }

                        // Validate bank account (must be numbers and dashes only)
                        if (!this.loanData.bank_account) {
                            this.errors.bank_account = 'Sila masukkan nombor akaun bank';
                            isValid = false;
                        } else if (!/^[0-9-]+$/.test(this.loanData.bank_account)) {
                            this.errors.bank_account = 'Nombor akaun bank tidak sah';
                            isValid = false;
                        }

                        // Validate loan amount
                        if (!this.loanData.loan_amount) {
                            this.errors.loan_amount = 'Sila masukkan jumlah pinjaman';
                            isValid = false;
                        } else if (this.loanData.loan_amount < 1000 || this.loanData.loan_amount > 100000) {
                            this.errors.loan_amount = 'Jumlah pinjaman mestilah antara RM1,000 hingga RM100,000';
                            isValid = false;
                        }

                        // Validate loan period
                        if (!this.loanData.loan_period) {
                            this.errors.loan_period = 'Sila masukkan tempoh pinjaman';
                            isValid = false;
                        } else if (this.loanData.loan_period < 1 || this.loanData.loan_period > 60) {
                            this.errors.loan_period = 'Tempoh pinjaman mestilah antara 1 hingga 60 bulan';
                            isValid = false;
                        }

                        // Validate salaries
                        if (!this.loanData.monthly_gross_salary) {
                            this.errors.monthly_gross_salary = 'Sila masukkan gaji kasar bulanan';
                            isValid = false;
                        }
                        if (!this.loanData.monthly_net_salary) {
                            this.errors.monthly_net_salary = 'Sila masukkan gaji bersih bulanan';
                            isValid = false;
                        }
                        if (parseFloat(this.loanData.monthly_net_salary) >= parseFloat(this.loanData.monthly_gross_salary)) {
                            this.errors.monthly_net_salary = 'Gaji bersih mestilah kurang daripada gaji kasar';
                            isValid = false;
                        }

                        return isValid;
                    },
                    validateStep3() {
                        this.errors = {};
                        let isValid = true;

                        // Validate first guarantor
                        if (!this.guarantorData.guarantor1_name) {
                            this.errors.guarantor1_name = 'Sila masukkan nama penjamin pertama';
                            isValid = false;
                        } else if (this.guarantorData.guarantor1_name.length > 255) {
                            this.errors.guarantor1_name = 'Nama penjamin pertama tidak boleh melebihi 255 aksara';
                            isValid = false;
                        }

                        if (!this.guarantorData.guarantor1_pf) {
                            this.errors.guarantor1_pf = 'Sila masukkan No. PF penjamin pertama';
                            isValid = false;
                        } else if (this.guarantorData.guarantor1_pf === this.guarantorData.guarantor2_pf) {
                            this.errors.guarantor1_pf = 'No. PF penjamin 1 tidak boleh sama dengan penjamin 2';
                            isValid = false;
                        }

                        if (!this.guarantorData.guarantor1_ic) {
                            this.errors.guarantor1_ic = 'Sila masukkan No. KP penjamin pertama';
                            isValid = false;
                        } else if (this.guarantorData.guarantor1_ic.length !== 12) {
                            this.errors.guarantor1_ic = 'No. KP penjamin pertama mestilah 12 nombor';
                            isValid = false;
                        } else if (!/^\d+$/.test(this.guarantorData.guarantor1_ic)) {
                            this.errors.guarantor1_ic = 'No. KP penjamin pertama mestilah nombor sahaja';
                            isValid = false;
                        }

                        // Phone validation
                        if (!this.guarantorData.guarantor1_phone) {
                            this.errors.guarantor1_phone = 'No. Telefon penjamin pertama diperlukan';
                            isValid = false;
                        } else if (!/^\d+$/.test(this.guarantorData.guarantor1_phone)) {
                            this.errors.guarantor1_phone = 'No. Telefon penjamin pertama mestilah nombor sahaja';
                            isValid = false;
                        }

                        // No Anggota validation
                        if (!this.guarantorData.guarantor1_no_anggota) {
                            this.errors.guarantor1_no_anggota = 'No. Anggota penjamin pertama diperlukan';
                            isValid = false;
                        }

                        // Validate second guarantor
                        if (!this.guarantorData.guarantor2_name) {
                            this.errors.guarantor2_name = 'Sila masukkan nama penjamin kedua';
                            isValid = false;
                        } else if (this.guarantorData.guarantor2_name.length > 255) {
                            this.errors.guarantor2_name = 'Nama penjamin kedua tidak boleh melebihi 255 aksara';
                            isValid = false;
                        } else if (this.guarantorData.guarantor2_name === this.guarantorData.guarantor1_name) {
                            this.errors.guarantor2_name = 'Nama penjamin 2 tidak boleh sama dengan penjamin 1';
                            isValid = false;
                        }

                        if (!this.guarantorData.guarantor2_pf) {
                            this.errors.guarantor2_pf = 'Sila masukkan No. PF penjamin kedua';
                            isValid = false;
                        } else if (this.guarantorData.guarantor2_pf === this.guarantorData.guarantor1_pf) {
                            this.errors.guarantor2_pf = 'No. PF penjamin 2 tidak boleh sama dengan penjamin 1';
                            isValid = false;
                        }

                        if (!this.guarantorData.guarantor2_ic) {
                            this.errors.guarantor2_ic = 'Sila masukkan No. KP penjamin kedua';
                            isValid = false;
                        } else if (this.guarantorData.guarantor2_ic.length !== 12) {
                            this.errors.guarantor2_ic = 'No. KP penjamin kedua mestilah 12 nombor';
                            isValid = false;
                        } else if (!/^\d+$/.test(this.guarantorData.guarantor2_ic)) {
                            this.errors.guarantor2_ic = 'No. KP penjamin kedua mestilah nombor sahaja';
                            isValid = false;
                        }

                        if (!this.guarantorData.guarantor2_phone) {
                            this.errors.guarantor2_phone = 'No. Telefon penjamin kedua diperlukan';
                            isValid = false;
                        } else if (!/^\d+$/.test(this.guarantorData.guarantor2_phone)) {
                            this.errors.guarantor2_phone = 'No. Telefon penjamin kedua mestilah nombor sahaja';
                            isValid = false;
                        }

                        if (!this.guarantorData.guarantor2_no_anggota) {
                            this.errors.guarantor2_no_anggota = 'No. Anggota penjamin kedua diperlukan';
                            isValid = false;
                        }

                        // Check if guarantors are different
                        if (this.guarantorData.guarantor1_pf === this.guarantorData.guarantor2_pf) {
                            this.errors.guarantor2_pf = 'Penjamin kedua tidak boleh sama dengan penjamin pertama';
                            isValid = false;
                        }

                        if (this.guarantorData.guarantor1_ic === this.guarantorData.guarantor2_ic) {
                            this.errors.guarantor2_ic = 'No. KP penjamin kedua tidak boleh sama dengan penjamin pertama';
                            isValid = false;
                        }

                        return isValid;
                    },
                    async validateGuarantorPF(pfNumber, fieldName) {
                        try {
                            const response = await fetch(`/loan/validate-guarantor-pf/${pfNumber}`);
                            const data = await response.json();
                            
                            if (!data.valid) {
                                this.errors[fieldName] = data.message;
                                return false;
                            }
                            return true;
                        } catch (error) {
                            console.error('Error validating PF:', error);
                            return false;
                        }
                    },
                    clearError(field) {
                        delete this.errors[field];
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

                    <form method="POST" action="{{ route('loan.store') }}" class="space-y-8" 
                          @submit.prevent="
                            if (validateStep2() && validateStep3()) {
                                console.log('Form data:', {
                                    loanData: loanData,
                                    guarantorData: guarantorData,
                                    terms: document.querySelector('input[name=terms_agreed]').checked
                                });
                                $event.target.submit();
                            }
                          ">
                        @csrf
                        <input type="hidden" name="date_apply" value="{{ date('Y-m-d') }}">
                        
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
                                        @input="clearError('loan_type_id')"
                                        :class="{'border-red-500': errors.loan_type_id}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                        required>
                                    <option value="">Pilih Jenis Pembiayaan</option>
                                    <option value="1">Al-Bai</option>
                                    <option value="2">Al-Inah</option>
                                    <option value="3">Skim Khas</option>
                                    <option value="4">Karnival Muslim Istimewa</option>
                                    <option value="5">Baik Pulih Kenderaan</option>
                                    <option value="6">Cukai Jalan</option>
                                </select>
                                <p x-show="errors.loan_type_id" 
                                   x-text="errors.loan_type_id" 
                                   class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Bank -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Bank</label>
                                <select id="bank_id" 
                                        name="bank_id" 
                                        x-model="loanData.bank_id"
                                        @input="clearError('bank_id')"
                                        :class="{'border-red-500': errors.bank_id}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
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
                                <p x-show="errors.bank_id" 
                                   x-text="errors.bank_id" 
                                   class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Bank Account Number -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">No. Akaun Bank</label>
                                <input type="text" 
                                       name="bank_account" 
                                       x-model="loanData.bank_account"
                                       @input="clearError('bank_account')"
                                       :class="{'border-red-500': errors.bank_account}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                       placeholder="Contoh: 1234567890"
                                       required>
                                <p x-show="errors.bank_account" 
                                   x-text="errors.bank_account" 
                                   class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Loan Amount -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Jumlah Pinjaman (RM)</label>
                                <div class="currency-input">
                                    <input type="number" 
                                           name="loan_amount" 
                                           x-model="loanData.loan_amount"
                                           @input="clearError('loan_amount')"
                                           :class="{'border-red-500': errors.loan_amount}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                           required>
                                </div>
                                <p x-show="errors.loan_amount" 
                                   x-text="errors.loan_amount" 
                                   class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Loan Period -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Tempoh Pinjaman (Bulan)</label>
                                <input type="number" 
                                       name="loan_period" 
                                       x-model="loanData.loan_period"
                                       min="1" 
                                       max="60"
                                       @input="clearError('loan_period')"
                                       :class="{'border-red-500': errors.loan_period}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                       required>
                                <p x-show="errors.loan_period" 
                                   x-text="errors.loan_period" 
                                   class="mt-1 text-sm text-red-600"></p>
                            </div>

                            <!-- Monthly Salaries -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gaji Kasar Bulanan (RM)</label>
                                    <div class="currency-input">
                                        <input type="number" 
                                               name="monthly_gross_salary" 
                                               x-model="loanData.monthly_gross_salary"
                                               @input="clearError('monthly_gross_salary')"
                                               :class="{'border-red-500': errors.monthly_gross_salary}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                               required>
                                    </div>
                                    <p x-show="errors.monthly_gross_salary" 
                                       x-text="errors.monthly_gross_salary" 
                                       class="mt-1 text-sm text-red-600"></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gaji Bersih Bulanan (RM)</label>
                                    <div class="currency-input">
                                        <input type="number" 
                                               name="monthly_net_salary" 
                                               x-model="loanData.monthly_net_salary"
                                               @input="clearError('monthly_net_salary')"
                                               :class="{'border-red-500': errors.monthly_net_salary}"
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary sm:text-sm"
                                               required>
                                    </div>
                                    <p x-show="errors.monthly_net_salary" 
                                       x-text="errors.monthly_net_salary" 
                                       class="mt-1 text-sm text-red-600"></p>
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
                                        @click="if(validateStep2()) currentStep = 3"
                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                    Seterusnya
                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Guarantor Information -->
                        <div x-show="currentStep === 3" class="space-y-8">
                            <h2 class="text-2xl font-bold mb-8 text-gray-800 dark:text-gray-200">Maklumat Penjamin</h2>

                            <!-- First Guarantor -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-sm">
                                <h3 class="text-xl font-semibold mb-6">Penjamin Pertama</h3>
                                
                                <div class="space-y-6">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                        <input type="text" 
                                               name="guarantor1_name" 
                                               x-model="guarantorData.guarantor1_name"
                                               @input="clearError('guarantor1_name')"
                                               :class="{'border-red-500': errors.guarantor1_name}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor1_name" 
                                           x-text="errors.guarantor1_name" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- PF Number -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. PF</label>
                                        <input type="text" 
                                               name="guarantor1_pf" 
                                               x-model="guarantorData.guarantor1_pf"
                                               @input="clearError('guarantor1_pf')"
                                               @blur="validateGuarantorPF($event.target.value, 'guarantor1_pf')"
                                               :class="{'border-red-500': errors.guarantor1_pf}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor1_pf" 
                                           x-text="errors.guarantor1_pf" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- IC Number -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. Kad Pengenalan</label>
                                        <input type="text" 
                                               name="guarantor1_ic" 
                                               x-model="guarantorData.guarantor1_ic"
                                               @input="clearError('guarantor1_ic')"
                                               :class="{'border-red-500': errors.guarantor1_ic}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               maxlength="12"
                                               required>
                                        <p x-show="errors.guarantor1_ic" 
                                           x-text="errors.guarantor1_ic" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. Telefon</label>
                                        <input type="text" 
                                               name="guarantor1_phone" 
                                               x-model="guarantorData.guarantor1_phone"
                                               @input="clearError('guarantor1_phone')"
                                               :class="{'border-red-500': errors.guarantor1_phone}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor1_phone" 
                                           x-text="errors.guarantor1_phone" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- No. Anggota -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. Anggota</label>
                                        <input type="text" 
                                               name="guarantor1_no_anggota" 
                                               x-model="guarantorData.guarantor1_no_anggota"
                                               @input="clearError('guarantor1_no_anggota')"
                                               :class="{'border-red-500': errors.guarantor1_no_anggota}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor1_no_anggota" 
                                           x-text="errors.guarantor1_no_anggota" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Second Guarantor -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-sm mt-8">
                                <h3 class="text-xl font-semibold mb-6">Penjamin Kedua</h3>
                                
                                <div class="space-y-6">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                                        <input type="text" 
                                               name="guarantor2_name" 
                                               x-model="guarantorData.guarantor2_name"
                                               @input="clearError('guarantor2_name')"
                                               :class="{'border-red-500': errors.guarantor2_name}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor2_name" 
                                           x-text="errors.guarantor2_name" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- PF Number -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. PF</label>
                                        <input type="text" 
                                               name="guarantor2_pf" 
                                               x-model="guarantorData.guarantor2_pf"
                                               @input="clearError('guarantor2_pf')"
                                               @blur="validateGuarantorPF($event.target.value, 'guarantor2_pf')"
                                               :class="{'border-red-500': errors.guarantor2_pf}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor2_pf" 
                                           x-text="errors.guarantor2_pf" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- IC Number -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. Kad Pengenalan</label>
                                        <input type="text" 
                                               name="guarantor2_ic" 
                                               x-model="guarantorData.guarantor2_ic"
                                               @input="clearError('guarantor2_ic')"
                                               :class="{'border-red-500': errors.guarantor2_ic}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               maxlength="12"
                                               required>
                                        <p x-show="errors.guarantor2_ic" 
                                           x-text="errors.guarantor2_ic" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- Phone Number -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. Telefon</label>
                                        <input type="text" 
                                               name="guarantor2_phone" 
                                               x-model="guarantorData.guarantor2_phone"
                                               @input="clearError('guarantor2_phone')"
                                               :class="{'border-red-500': errors.guarantor2_phone}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor2_phone" 
                                           x-text="errors.guarantor2_phone" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>

                                    <!-- No. Anggota -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-300 mb-2">No. Anggota</label>
                                        <input type="text" 
                                               name="guarantor2_no_anggota" 
                                               x-model="guarantorData.guarantor2_no_anggota"
                                               @input="clearError('guarantor2_no_anggota')"
                                               :class="{'border-red-500': errors.guarantor2_no_anggota}"
                                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-primary"
                                               required>
                                        <p x-show="errors.guarantor2_no_anggota" 
                                           x-text="errors.guarantor2_no_anggota" 
                                           class="mt-1 text-sm text-red-600"></p>
                                    </div>
                                </div>
                            </div>  
                            


                            <!-- Navigation Buttons -->
                            <div class="flex justify-between mt-8">
                                <button type="button" 
                                        @click="currentStep = 2"
                                        class="inline-flex items-center px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-300 transition-colors duration-200">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Kembali
                                </button>
                                
                                <button type="button" 
                                        @click="if(validateStep3()) currentStep = 4"
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
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">No. Telefon</dt>
                                                <dd class="text-sm text-gray-900">{{ $member->phone }}</dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                                <dd class="text-sm text-gray-900">{{ $member->email }}</dd>
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
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Gaji Kasar Bulanan</dt>
                                                <dd class="mt-1 text-sm text-gray-900">RM <span x-text="loanData.monthly_gross_salary"></span></dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Gaji Bersih Bulanan</dt>
                                                <dd class="mt-1 text-sm text-gray-900">RM <span x-text="loanData.monthly_net_salary"></span></dd>
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
                                                    <dt class="text-sm font-medium text-gray-500">No. PF</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor1_pf"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Kad Pengenalan</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor1_ic"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Telefon</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor1_phone"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Anggota</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor1_no_anggota"></dd>
                                                </div>
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
                                                    <dt class="text-sm font-medium text-gray-500">No. PF</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor2_pf"></dd>
                                                    </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Kad Pengenalan</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor2_ic"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Telefon</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor2_phone"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Anggota</dt>
                                                    <dd class="mt-1 text-sm text-gray-900" x-text="guarantorData.guarantor2_no_anggota"></dd>
                                                </div>
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

<style>
    :root {
        --primary-blue: #0066cc;
        --secondary-blue: #4d94ff;
        --light-blue: #e6f2ff;
        --accent-blue: #00a3ff;
        --deep-blue: #004d99;
        --text-gray: #666;
    }

    .py-12 {
        background: linear-gradient(135deg, var(--light-blue) 0%, #f8f9fa 100%);
    }

    .bg-white {
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0, 102, 204, 0.1);
    }

    .btn {
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        background: linear-gradient(45deg, var(--primary-blue), var(--accent-blue));
        border: none;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
        background: linear-gradient(45deg, var(--accent-blue), var(--primary-blue));
    }

    /* Step indicators styling */
    .rounded-full {
        background: var(--light-blue);
        border: 2px solid var(--primary-blue);
    }

    .bg-primary {
        background: var(--primary-blue) !important;
    }

    .text-primary {
        color: var(--primary-blue) !important;
    }

    /* Form inputs styling */
    input, select, textarea {
        border-color: var(--secondary-blue) !important;
    }

    input:focus, select:focus, textarea:focus {
        border-color: var(--primary-blue) !important;
        box-shadow: 0 0 0 2px rgba(0, 102, 204, 0.1) !important;
    }

    /* Feature box styling */
    .bg-gray-50 {
        background: white;
        border: 1px solid rgba(0, 102, 204, 0.1);
        transition: all 0.3s ease;
    }

    .bg-gray-50:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 102, 204, 0.1);
    }

    /* Enhanced input field styles */
    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="tel"],
    select,
    textarea {
        width: 100%;
        padding: 12px 16px;          /* Increased padding */
        height: 45px;                /* Increased height */
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 14px;
        color: #4a5568;
        background-color: #fff;
        transition: all 0.2s ease;
    }

    /* Focus state */
    input:focus,
    select:focus,
    textarea:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    /* Select specific styles */
    select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234a5568'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 20px;
        padding-right: 40px;
    }

    /* Label styles */
    label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        color: #4a5568;
        margin-bottom: 6px;
    }

    /* Form group spacing */
    .mb-4 {
        margin-bottom: 20px;
    }

    /* Error state */
    input.border-red-500,
    select.border-red-500 {
        border-color: #ef4444;
    }

    /* Error message */
    .text-red-600 {
        font-size: 12px;
        margin-top: 4px;
    }

    /* Currency input specific style */
    input[name="loan_amount"],
    input[name="monthly_gross_salary"],
    input[name="monthly_net_salary"] {
        padding-left: 40px;  /* Make room for the RM prefix */
    }

    /* Add RM prefix to currency inputs */
    .currency-input {
        position: relative;
    }

    .currency-input::before {
        content: 'RM';
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 14px;
        pointer-events: none;
    }
</style>