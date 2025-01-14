<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Loan Application') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6" x-data="{ currentStep: 1 }">
                    <!-- Step Numbers -->
                    <div class="flex justify-between mb-8">
                        <div class="text-center" :class="{ 'text-purple-600': currentStep >= 1, 'text-gray-400': currentStep < 1 }">
                            <span class="text-lg font-medium">1</span>
                            <p class="text-sm">Maklumat Peribadi</p>
                        </div>
                        <div class="text-center" :class="{ 'text-purple-600': currentStep >= 2, 'text-gray-400': currentStep < 2 }">
                            <span class="text-lg font-medium">2</span>
                            <p class="text-sm">Maklumat Pinjaman</p>
                        </div>
                        <div class="text-center" :class="{ 'text-purple-600': currentStep >= 3, 'text-gray-400': currentStep < 3 }">
                            <span class="text-lg font-medium">3</span>
                            <p class="text-sm">Maklumat Penjamin</p>
                        </div>
                        <div class="text-center" :class="{ 'text-purple-600': currentStep >= 4, 'text-gray-400': currentStep < 4 }">
                            <span class="text-lg font-medium">4</span>
                            <p class="text-sm">Pengesahan</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('loan.store') }}">
                        @csrf
                        
                        <!-- Step 1: Personal Information -->
                        <div x-show="currentStep === 1">
                            <h2 class="text-xl font-semibold mb-6">Maklumat Peribadi</h2>
                            
                            <div class="space-y-6">
                                <!-- Name -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                                        {{ $member->name }}
                                    </div>
                                </div>

                                <!-- IC Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                                        {{ $member->ic }}
                                    </div>
                                </div>

                                <!-- Address -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                                        {{ $member->address }}
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                                        {{ $member->phone }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Emel</label>
                                    <div class="mt-1 p-3 bg-gray-50 rounded-md border border-gray-200">
                                        {{ $member->email }}
                                    </div>
                                </div>
                            </div>

                            <!-- Next Step Button -->
                            <div class="mt-8 flex justify-end">
                                <button type="button" 
                                        @click="currentStep = 2"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
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
                            
                            <div class="space-y-6">
                                <!-- Loan Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jenis Pinjaman</label>
                                    <select name="loan_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Jenis Pinjaman</option>
                                        @foreach($loanTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }} - Maksimum RM{{ number_format($type->max_amount, 2) }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Loan Amount -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Jumlah Pinjaman (RM)</label>
                                    <input type="number" name="loan_amount" step="0.01" min="0" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <!-- Loan Period -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tempoh Pinjaman (Bulan)</label>
                                    <input type="number" name="loan_period" min="1" max="60"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <!-- Monthly Income -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gaji Kasar Bulanan (RM)</label>
                                    <input type="number" name="monthly_gross_salary" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Gaji Bersih Bulanan (RM)</label>
                                    <input type="number" name="monthly_net_salary" step="0.01" min="0"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>

                                <!-- Purpose -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tujuan Pinjaman</label>
                                    <textarea name="purpose" rows="3" 
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between">
                                <button type="button" 
                                        @click="currentStep = 1"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <button type="button" 
                                        @click="currentStep = 3"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
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
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="guarantor1_ic" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="guarantor1_phone" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea name="guarantor1_address" rows="3" 
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hubungan dengan Pemohon</label>
                                        <select name="guarantor1_relationship" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="guarantor2_ic" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="guarantor2_phone" 
                                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <textarea name="guarantor2_address" rows="3" 
                                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hubungan dengan Pemohon</label>
                                        <select name="guarantor2_relationship" 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between">
                                <button type="button" 
                                        @click="currentStep = 2"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <button type="button" 
                                        @click="currentStep = 4"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
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
                                        <input type="checkbox" name="terms_agreed" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <span class="ml-2">Saya mengesahkan bahawa semua maklumat yang diberikan adalah benar dan tepat</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between">
                                <button type="button" 
                                        @click="currentStep = 3"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                    Sebelumnya
                                </button>
                                <button type="submit"
                                        class="inline-flex items-center px-6 py-2 bg-gray-100 text-black font-medium rounded-lg hover:bg-gray-200 border border-gray-300">
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







