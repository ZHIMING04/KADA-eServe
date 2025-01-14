<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Permohonan Berjaya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl p-6">
                <div class="text-center">
                    <div class="text-green-500 text-5xl mb-4">
                        ✓
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Permohonan Berjaya Dihantar!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-8">
                        Permohonan pinjaman anda telah berjaya dihantar dan akan diproses dalam masa yang terdekat.
                    </p>
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 