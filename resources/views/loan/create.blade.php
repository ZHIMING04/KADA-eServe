<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Loan Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
                <div class="p-8" x-data="{ currentStep: 1 }">
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

                        <!-- Step 2: Loan Details - Updated Design -->
                        <div x-show="currentStep === 2" x-cloak class="transition-all duration-500">
                            <h2 class="text-2xl font-bold mb-8 text-gray-800 dark:text-white">Maklumat Pinjaman</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Loan Type -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Jenis Pinjaman</label>
                                    <select name="loan_type_id" 
                                            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                        <option value="">Pilih Jenis Pinjaman</option>
                                        @foreach($loanTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }} - Maksimum RM{{ number_format($type->max_amount, 2) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Loan Amount -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Jumlah Pinjaman (RM)</label>
                                    <input type="number" name="loan_amount" step="0.01" min="0" 
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <!-- Loan Period -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Tempoh Pinjaman (Bulan)</label>
                                    <input type="number" name="loan_period" min="1" max="60"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <!-- Monthly Income -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Gaji Kasar Bulanan (RM)</label>
                                    <input type="number" name="monthly_gross_salary" step="0.01" min="0"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <div class="space-y-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Gaji Bersih Bulanan (RM)</label>
                                    <input type="number" name="monthly_net_salary" step="0.01" min="0"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500">
                                </div>

                                <!-- Purpose -->
                                <div class="space-y-4">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Tujuan Pinjaman</label>
                                    <textarea name="purpose" rows="3" 
                                              class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-purple-500 focus:ring-purple-500"></textarea>
                                </div>
                            </div>

                            <!-- Step 2 Navigation Buttons -->
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
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="guarantor1_ic" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="guarantor1_phone" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea name="guarantor1_address" rows="3" 
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hubungan dengan Pemohon</label>
                                        <select name="guarantor1_relationship" 
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
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="guarantor2_ic" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="guarantor2_phone" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea name="guarantor2_address" rows="3" 
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hubungan dengan Pemohon</label>
                                        <select name="guarantor2_relationship" 
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
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <dl class="grid grid-cols-1 gap-4">
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Jumlah Pinjaman</dt>
                                                <dd class="text-sm text-gray-900" x-text="'RM ' + document.getElementsByName('loan_amount')[0]?.value"></dd>
                                            </div>
                                            <div>
                                                <dt class="text-sm font-medium text-gray-500">Tempoh Pinjaman</dt>
                                                <dd class="text-sm text-gray-900" x-text="document.getElementsByName('loan_period')[0]?.value + ' bulan'"></dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>

                                <!-- Guarantor Information Summary -->
                                <div>
                                    <h3 class="text-lg font-medium mb-4">Maklumat Penjamin</h3>
                                    <div class="space-y-4">
                                        <!-- First Guarantor -->
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <h4 class="font-medium mb-2">Penjamin Pertama</h4>
                                            <dl class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                                    <dd class="text-sm text-gray-900" x-text="document.getElementsByName('guarantor1_name')[0]?.value"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Kad Pengenalan</dt>
                                                    <dd class="text-sm text-gray-900" x-text="document.getElementsByName('guarantor1_ic')[0]?.value"></dd>
                                                </div>
                                            </dl>
                                        </div>

                                        <!-- Second Guarantor -->
                                        <div class="bg-gray-50 p-4 rounded-lg">
                                            <h4 class="font-medium mb-2">Penjamin Kedua</h4>
                                            <dl class="grid grid-cols-1 gap-4">
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">Nama</dt>
                                                    <dd class="text-sm text-gray-900" x-text="document.getElementsByName('guarantor2_name')[0]?.value"></dd>
                                                </div>
                                                <div>
                                                    <dt class="text-sm font-medium text-gray-500">No. Kad Pengenalan</dt>
                                                    <dd class="text-sm text-gray-900" x-text="document.getElementsByName('guarantor2_ic')[0]?.value"></dd>
                                                </div>
                                            </dl>
                                        </div>
                                    </div>
                                </div>

                                <!-- Terms and Agreement -->
                                <div class="mt-8">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="terms_agreed" class="rounded border-gray-300 text-purple-600 shadow-sm focus:border-purple-300 focus:ring focus:ring-purple-200 focus:ring-opacity-50">
                                        <span class="ml-2">Saya mengesahkan bahawa semua maklumat yang diberikan adalah benar dan tepat</span>
                                    </label>
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
                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
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







