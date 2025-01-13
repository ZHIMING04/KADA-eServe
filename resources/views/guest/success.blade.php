<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen relative">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/paddy.jpg') }}" alt="KADA Background" 
                    class="w-full h-full object-cover opacity-45">
            </div>

            <!-- Content -->
            <div class="relative z-10">
                <div class="py-12">
                    <div class="max-w-3xl mx-auto">
                        <div class="bg-white/50 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <!-- Success Message Card -->
                                <div class="bg-white rounded-lg shadow-md p-6">
                                    <div class="flex items-center justify-center mb-6">
                                        <div class="rounded-full bg-green-100 p-3">
                                            <svg class="h-12 w-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">
                                        Pendaftaran Berjaya!
                                    </h2>
                                    
                                    <div class="text-center text-gray-600 mb-6">
                                        <p class="mb-3">Terima kasih kerana mendaftar sebagai ahli KADA.</p>
                                        <p>Permohonan anda akan diproses dalam tempoh 3-5 hari bekerja.</p>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <p class="text-sm text-gray-600">
                                            Sila ambil perhatian:
                                        </p>
                                        <ul class="list-disc list-inside text-sm text-gray-600 mt-2 space-y-1">
                                            <li>Email pengesahan akan dihantar ke alamat email yang didaftarkan</li>
                                            <li>Sila semak email anda termasuk folder SPAM</li>
                                            <li>Untuk sebarang pertanyaan, sila hubungi pihak KADA</li>
                                        </ul>
                                    </div>

                                    <div class="flex justify-center space-x-4">
                                        <a href="{{ url('/guest/dashboard') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            Kembali ke Halaman Utama
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>