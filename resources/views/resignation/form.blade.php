<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <a href="{{ route('profile.edit') }}" class="mr-4">
                <svg class="w-6 h-6 text-gray-600 hover:text-gray-800 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Permohonan Berhenti Menjadi Anggota') }}
            </h2>
        </div>
    </x-slot>

    <div class="min-h-screen relative" x-data="{ currentStep: 1 }">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/paddy.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-50">
        </div>

        <div class="py-12 relative z-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
                    <div class="p-8">
                        <form method="POST" action="{{ route('resignation.submit') }}">
                            @csrf

                            <!-- Step Indicator -->
                            <div class="flex justify-between mb-12 relative">
                                <div class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 w-full -z-1"></div>
                                <div class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-primary transition-all duration-500" :style="'width: ' + ((currentStep - 1) * 50) + '%'"></div>

                                <div class="relative z-10 text-center flex-1">
                                    <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center mx-auto" :class="currentStep >= 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                        <span class="text-lg font-medium">1</span>
                                    </div>
                                    <p class="mt-2 text-sm font-medium" :class="currentStep >= 1 ? 'text-primary' : 'text-gray-400'">Maklumat Ahli</p>
                                </div>

                                <div class="relative z-10 text-center flex-1">
                                    <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center mx-auto" :class="currentStep >= 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                        <span class="text-lg font-medium">2</span>
                                    </div>
                                    <p class="mt-2 text-sm font-medium" :class="currentStep >= 2 ? 'text-primary' : 'text-gray-400'">Sebab Berhenti</p>
                                </div>
                            </div>

                            <!-- Step 1: Member Information -->
                            <div x-show="currentStep === 1">
                                <h3 class="text-lg font-semibold mb-4">Maklumat Ahli</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                                        <input type="text" name="name" value="{{ $member->name }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">No. Kad Pengenalan</label>
                                        <input type="text" name="ic" value="{{ $member->ic }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Tarikh Lahir</label>
                                        <input type="date" name="dob" value="{{ $member->DOB }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">No. Telefon</label>
                                        <input type="text" name="phone" value="{{ $member->phone }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Jantina</label>
                                        <input type="text" name="gender" value="{{ $member->gender }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Agama</label>
                                        <input type="text" name="agama" value="{{ $member->agama }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Bangsa</label>
                                        <input type="text" name="bangsa" value="{{ $member->bangsa }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                        <input type="text" name="address" value="{{ $member->address }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Poskod</label>
                                        <input type="text" name="postcode" value="{{ $member->postcode }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Bandar</label>
                                        <input type="text" name="city" value="{{ $member->city }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Negeri</label>
                                        <input type="text" name="state" value="{{ $member->state }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">No. Ahli</label>
                                        <input type="text" name="no_anggota" value="{{ $member->no_anggota }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">No. PF</label>
                                        <input type="text" name="no_pf" value="{{ $member->no_pf }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Jawatan</label>
                                        <input type="text" name="jawatan" value="{{ $member->workingInfo->jawatan }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0 shadow-sm" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Alamat Pejabat</label>
                                        <input type="text" name="office_address" value="{{ $member->office_address }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Poskod Pejabat</label>
                                        <input type="text" name="office_postcode" value="{{ $member->office_postcode }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0" readonly>
                                    </div>
                                    <div class="bg-blue-100 p-4 rounded-md">
                                        <label class="block text-sm font-medium text-gray-700">Bandar Pejabat</label>
                                        <input type="text" name="office_city" value="{{ $member->office_city }}" class="mt-1 block w-full p-2.5 bg-white rounded-md border-0" readonly>
                                    </div>
                                </div>

                                <!-- Navigation -->
                                <div class="mt-6 flex justify-end">
                                    <button type="button" @click="currentStep = 2"
                                            class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                        Seterusnya
                                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 2: Reasons for Resignation -->
                            <div x-show="currentStep === 2" x-cloak>
                                <h3 class="text-lg font-semibold mb-4">Sebab Berhenti Menjadi Anggota</h3>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Sila nyatakan sekurang-kurangnya 2 sebab mengapa anda ingin berhenti:</label><br>
                                    <div class="grid grid-cols-1 gap-6 mb-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Sebab 1</label>
                                            <input type="text" name="reason1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Sebab 2</label>
                                            <input type="text" name="reason2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Sebab 3</label>
                                            <input type="text" name="reason3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Sebab 4</label>
                                            <input type="text" name="reason4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Sebab 5</label>
                                            <input type="text" name="reason5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                        </div>
                                    </div>
                                </div>

                                <!-- Navigation -->
                                <div class="mt-6 flex justify-between">
                                    <button type="button" @click="currentStep = 1"
                                            class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                        <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                        Sebelumnya
                                    </button>
                                    <div class="flex space-x-4">
                                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                            Hantar Permohonan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Alpine.js if not already included in your layout -->
    @push('scripts')
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @endpush
</x-app-layout>
