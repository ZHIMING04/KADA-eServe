<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ showMessage: true }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Success Message (Green) -->
            @if (session('success'))
                <div x-show="showMessage" 
                     x-init="setTimeout(() => showMessage = false, 3000)"
                     class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl transition-opacity duration-500"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Warning Message (Yellow) -->
            @if ($errors->has('warning'))
                <div x-show="showMessage" 
                     x-init="setTimeout(() => showMessage = false, 3000)"
                     class="mb-4 p-4 bg-yellow-100 border border-yellow-400 text-yellow-700 rounded-xl transition-opacity duration-500"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    {{ $errors->first('warning') }}
                </div>
            @endif

            <!-- Unsuccessful Message (Red) -->
            @if (session('error'))
                <div x-show="showMessage" 
                     x-init="setTimeout(() => showMessage = false, 3000)"
                     class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl transition-opacity duration-500"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    {{ session('error') }}
                </div>
            @endif

             <!-- Status Display Section -->
             <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="mb-4">
                    <!-- Status Display - Simple Pill Style -->
                    <div class="mb-4">
                        @php
                            $statusClass = match(strtolower($member->status)) {
                                'approved' => 'bg-green-100 text-green-700',
                                'deceased' => 'bg-gray-100 text-gray-700',
                                'resigned' => 'bg-orange-100 text-orange-700',
                                'rejected' => 'bg-red-100 text-red-700',
                                default => 'bg-yellow-100 text-yellow-700'
                            };

                            $statusText = match(strtolower($member->status)) {
                                'approved' => 'Ahli',
                                'pending' => 'Sedang Diproses',
                                'resigned' => 'Berhenti',
                                'deceased' => 'Wafat',
                                'rejected' => 'Ditolak',
                                default => 'Sedang Diproses'
                            };
                        @endphp
                        <span class="inline-flex px-4 py-1.5 rounded-full text-sm font-medium {{ $statusClass }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div>
                    @include('profile.partials.display-user-info')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

             <!-- Resignation Button - Only show if not resigned -->
             @if(strtolower($member->status) !== 'resigned')
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <section>
                            <header>
                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ __('Permohonan Berhenti') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    {{ __('Setelah permohonan berhenti diluluskan, semua data dan rekod anda akan diarkibkan.') }}
                                </p>
                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                    {{ __('Permohonan pinjaman tidak lagi dibenarkan & sebarang penambahan simpanan akan dihentikan.') }}
                                </p>
                            </header>

                            <div class="mt-6">
                                <a href="{{ route('resignation.form', ['id' => $member->id]) }}" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 text-md font-semibold">
                                    {{ __('Mohon Berhenti') }}
                                </a>
                            </div>
                        </section>
                    </div>
                </div>
            @else
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('Permohonan berhenti anda telah diluluskan. Terima kasih atas sumbangan anda.') }}
                        </p>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
