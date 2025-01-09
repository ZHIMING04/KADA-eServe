<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="py-12">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <!-- Enhanced Card Title -->
                            <div class="bg-white shadow-md rounded-lg mb-4">
                                <div class="bg-gradient-to-r from-green-600 to-green-400 border-b border-gray-200">
                                    <div class="flex items-center space-x-3 p-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <h3 class="text-xl font-semibold text-black">
                                            Pendaftaran Ahli Baru
                                        </h3>
                                    </div>
                                    <div class="text-sm text-white/80 px-4 pb-3">
                                        Sila isi maklumat peribadi anda dengan lengkap
                                    </div>
                                </div>

                               <!-- Maklumat Peribadi Section -->
                            <div class="mt-8">
                                <div class="bg-white shadow-md rounded-lg mb-4">
                                    <div class="border-b border-gray-200">
                                        <h3 class="text-lg font-medium text-gray-900 p-4">
                                            Maklumat Peribadi
                                        </h3>
                                    </div>

                                    <div class="p-4">
                                        <!-- Personal Details Grid -->
                                        <div class="mt-6 bg-gray-50 rounded-lg p-4">
                                            <!-- Name -->
                                            <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                                                <div class="flex items-center mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <x-input-label for="name" value="Nama Pendaftar" class="font-semibold text-gray-700" />
                                                </div>
                                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-50" required autofocus placeholder="Masukkan nama penuh" />
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>

                                            <!-- Email -->
                                            <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                                                <div class="flex items-center mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                    </svg>
                                                    <x-input-label for="email" value="Email" class="font-semibold text-gray-700" />
                                                </div>
                                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan alamat email" />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <div class="grid grid-cols-2 gap-6">
                                                <!-- IC Number -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                                        </svg>
                                                        <x-input-label for="ic" value="No. K/P" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <x-text-input id="ic" name="ic" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan nombor kad pengenalan" />
                                                    <x-input-error :messages="$errors->get('ic')" class="mt-2" />
                                                </div>

                                                <!-- Phone -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                        </svg>
                                                        <x-input-label for="phone" value="No. Telefon" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan nombor telefon" />
                                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                                </div>
                                            </div>

                                            <!-- Address -->
                                            <div class="bg-white p-4 rounded-lg shadow-sm mt-4">
                                                <div class="flex items-center mb-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <x-input-label for="address" value="Alamat" class="font-semibold text-gray-700" />
                                                </div>
                                                <x-text-input id="address" name="address" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan alamat penuh" />
                                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                            </div>

                                            <!-- City, Postcode, State Grid -->
                                            <div class="grid grid-cols-3 gap-4 mt-4">
                                                <!-- City -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                        <x-input-label for="city" value="Bandar" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan nama bandar" />
                                                    <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                                </div>

                                                <!-- Postcode -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        </svg>
                                                        <x-input-label for="poskod" value="Poskod" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <x-text-input id="poskod" name="poskod" type="text" class="mt-1 block w-full bg-gray-50" required maxlength="5" placeholder="Masukkan poskod" />
                                                    <x-input-error :messages="$errors->get('poskod')" class="mt-2" />
                                                </div>

                                                <!-- State -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <x-input-label for="state" value="Negeri" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <select id="state" name="state" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50" required>
                                                        <option value="">Pilih Negeri</option>
                                                        <option value="Johor">Johor</option>
                                                        <option value="Kedah">Kedah</option>
                                                        <option value="Kelantan">Kelantan</option>
                                                        <option value="Melaka">Melaka</option>
                                                        <option value="Negeri Sembilan">Negeri Sembilan</option>
                                                        <option value="Pahang">Pahang</option>
                                                        <option value="Perak">Perak</option>
                                                        <option value="Perlis">Perlis</option>
                                                        <option value="Pulau Pinang">Pulau Pinang</option>
                                                        <option value="Sabah">Sabah</option>
                                                        <option value="Sarawak">Sarawak</option>
                                                        <option value="Selangor">Selangor</option>
                                                        <option value="Terengganu">Terengganu</option>
                                                        <option value="W.P. Kuala Lumpur">W.P. Kuala Lumpur</option>
                                                        <option value="W.P. Labuan">W.P. Labuan</option>
                                                        <option value="W.P. Putrajaya">W.P. Putrajaya</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                                </div>
                </div>
                                            <!-- Gender, DOB Grid -->
                                            <div class="grid grid-cols-2 gap-6 mt-4">
                                                <!-- Gender -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                        <x-input-label for="gender" value="Jantina" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50" required>
                                                        <option value="">Pilih Jantina</option>
                                                        <option value="Lelaki">Lelaki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                                </div>

                                                <!-- DOB -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <x-input-label for="DOB" value="Tarikh Lahir" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <input 
                                                        id="DOB" 
                                                        name="DOB" 
                                                        type="date" 
                                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50" 
                                                        required 
                                                    />
                                                    <x-input-error :messages="$errors->get('DOB')" class="mt-2" />
                                                </div>
                                            </div>

                                            <!-- Agama, Bangsa Grid -->
                                            <div class="grid grid-cols-2 gap-6 mt-4">
                                                <!-- Agama -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <x-input-label for="agama" value="Agama" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <select id="agama" name="agama" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50" required>
                                                        <option value="">Pilih Agama</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Buddha">Buddha</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Kristian">Kristian</option>
                                                        <option value="Sikh">Sikh</option>
                                                        <option value="Lain-lain">Lain-lain</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('agama')" class="mt-2" />
                                                </div>

                                                <!-- Bangsa -->
                                                <div class="bg-white p-4 rounded-lg shadow-sm">
                                                    <div class="flex items-center mb-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                        </svg>
                                                        <x-input-label for="bangsa" value="Bangsa" class="font-semibold text-gray-700" />
                                                    </div>
                                                    <select id="bangsa" name="bangsa" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm bg-gray-50" required>
                                                        <option value="">Pilih Bangsa</option>
                                                        <option value="Melayu">Melayu</option>
                                                        <option value="Cina">Cina</option>
                                                        <option value="India">India</option>
                                                        <option value="Bumiputera Sabah">Bumiputera Sabah</option>
                                                        <option value="Bumiputera Sarawak">Bumiputera Sarawak</option>
                                                        <option value="Orang Asli">Orang Asli</option>
                                                        <option value="Lain-lain">Lain-lain</option>
                                                    </select>
                                                    <x-input-error :messages="$errors->get('bangsa')" class="mt-2" />
                                                </div>
                                            </div>

                                            <!-- No. PF and Gaji Bulanan in the last row -->
                                            <div class="grid grid-cols-2 gap-4 mt-4">
                                                <!-- No. PF -->
                                                <div>
                                                    <x-input-label for="pf_number" value="No. PF" />
                                                    <x-text-input id="pf_number" name="pf_number" type="text" class="mt-1 block w-full" required />
                                                    <x-input-error :messages="$errors->get('pf_number')" class="mt-2" />
                                                </div>
                                                <!-- Salary -->
                                                <div>
                                                    <x-input-label for="salary" value="Gaji Bulanan" />
                                                    <x-text-input id="salary" name="salary" type="text" class="mt-1 block w-full" required />
                                                    <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                                                </div>
                                            </div>

                                            <!-- Maklumat Pekerjaan Section -->
                                            <div class="mt-8">
                                                <div class="bg-white shadow-md rounded-lg mb-4">
                                                    <div class="border-b border-gray-200">
                                                        <h3 class="text-lg font-medium text-gray-900 p-4">
                                                            Maklumat Pekerjaan
                                                        </h3>
                                                    </div>

                                                    <div class="p-4">
                                                        <!-- Office Address -->
                                                        <div class="mt-4">
                                                            <x-input-label for="office_address" value="Alamat Pejabat" />
                                                            <x-text-input id="office_address" name="office_address" type="text" class="mt-1 block w-full" required />
                                                            <x-input-error :messages="$errors->get('office_address')" class="mt-2" />
                                                        </div>

                                                        <!-- Employment Details Grid -->
                                                        <div class="mt-6 bg-gray-50 rounded-lg p-4">
                                                            <div class="grid grid-cols-2 gap-6">
                                                                <!-- Left Column -->
                                                                <div class="space-y-4">
                                                                    <!-- Jawatan -->
                                                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                                                        <div class="flex items-center mb-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                                            </svg>
                                                                            <x-input-label for="jawatan" value="Jawatan" class="font-semibold text-gray-700" />
                                                                        </div>
                                                                        <x-text-input id="jawatan" name="jawatan" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan jawatan anda" />
                                                                        <x-input-error :messages="$errors->get('jawatan')" class="mt-2" />
                                                                    </div>

                                                                    <!-- Gred -->
                                                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                                                        <div class="flex items-center mb-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                                            </svg>
                                                                            <x-input-label for="gred" value="Gred" class="font-semibold text-gray-700" />
                                                                        </div>
                                                                        <x-text-input id="gred" name="gred" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan gred anda" />
                                                                        <x-input-error :messages="$errors->get('gred')" class="mt-2" />
                                                                    </div>
                                                                </div>

                                                                <!-- Right Column -->
                                                                <div class="space-y-4">
                                                                    <!-- No. PF -->
                                                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                                                        <div class="flex items-center mb-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                                            </svg>
                                                                            <x-input-label for="pf_number" value="No. PF" class="font-semibold text-gray-700" />
                                                                        </div>
                                                                        <x-text-input id="pf_number" name="pf_number" type="text" class="mt-1 block w-full bg-gray-50" required placeholder="Masukkan nombor PF" />
                                                                        <x-input-error :messages="$errors->get('pf_number')" class="mt-2" />
                                                                    </div>

                                                                    <!-- Gaji Bulanan -->
                                                                    <div class="bg-white p-4 rounded-lg shadow-sm">
                                                                        <div class="flex items-center mb-2">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                            </svg>
                                                                            <x-input-label for="salary" value="Gaji Bulanan" class="font-semibold text-gray-700" />
                                                                        </div>
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input 
                                                                                id="salary" 
                                                                                name="salary" 
                                                                                type="text" 
                                                                                class="mt-1 block w-full pl-10 bg-gray-50" 
                                                                                required 
                                                                                placeholder="Masukkan gaji bulanan"
                                                                            />
                                                                        </div>
                                                                        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Maklumat Keluarga dan Pewaris -->
                                                <div class="mt-8">
                                                    <div class="bg-white shadow-md rounded-lg mb-4">
                                                        <div class="border-b border-gray-200">
                                                            <h3 class="text-lg font-medium text-gray-900 p-4">
                                                                Maklumat Keluarga dan Pewaris
                                                            </h3>
                                                        </div>

                                                        <div class="p-4">
                                                            <div class="mb-4">
                                                                <table class="min-w-full divide-y divide-gray-200">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bil</th>
                                                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hubungan</th>
                                                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No K/P</th>
                                                                            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody class="bg-white divide-y divide-gray-200" id="familyTableBody">
                                                                        <!-- Table rows will be dynamically added here -->
                                                                    </tbody>
                                                                </table>

                                                                <div class="mt-4">
                                                                    <x-secondary-button type="button" onclick="addFamilyMember()" class="bg-green-500 text-white hover:bg-green-600">
                                                                        + Tambah Ahli Keluarga
                                                                    </x-secondary-button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            <!-- Add this JavaScript before the closing body tag -->
                                            <script>
                                                let rowCount = 0;
                                                function addFamilyMember() {
                                                    rowCount++;
                                                    const tbody = document.getElementById('familyTableBody');
                                                    const newRow = document.createElement('tr');
                                                    
                                                    newRow.innerHTML = `
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${rowCount}</td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <select name="family[${rowCount}][relationship]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                                <option value="">Pilih Hubungan</option>
                                                                <option value="Isteri">Isteri</option>
                                                                <option value="Suami">Suami</option>
                                                                <option value="Anak">Anak</option>
                                                                <option value="Ibu">Ibu</option>
                                                                <option value="Bapa">Bapa</option>
                                                                <option value="Adik-beradik">Adik-beradik</option>
                                                            </select>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="text" name="family[${rowCount}][name]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <input type="text" name="family[${rowCount}][ic]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <button type="button" onclick="this.closest('tr').remove(); updateRowNumbers();" class="text-red-600 hover:text-red-900">
                                                                Buang
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

                                            <!-- Yuran dan Sumbangan -->
                                            <div class="mt-8">
                                                <div class="bg-white shadow-md rounded-lg mb-4">
                                                    <div class="border-b border-gray-200">
                                                        <h3 class="text-lg font-medium text-gray-900 p-4">
                                                            Yuran dan Sumbangan
                                                        </h3>
                                                    </div>

                                                    <div class="p-4">
                                                        <table class="min-w-full divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">Bil</th>
                                                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perkara</th>
                                                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-48">RM</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="bg-white divide-y divide-gray-200">
                                                                <!-- Yuran Masuk -->
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">1</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Yuran Masuk</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" name="fees[entrance]" 
                                                                                class="pl-12 block w-full" required />
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <!-- Modal Syer -->
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">2</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Modal Syer</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" name="fees[share_capital]" 
                                                                                class="pl-12 block w-full" required />
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <!-- Modal Yuran -->
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">3</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Modal Yuran</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" name="fees[subscription_capital]" 
                                                                                class="pl-12 block w-full" required />
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <!-- Wang Deposit Anggota -->
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">4</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Wang Deposit Anggota</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" name="fees[member_deposit]" 
                                                                                class="pl-12 block w-full" required />
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <!-- Sumbangan Tabung Kebajikan -->
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">5</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Sumbangan Tabung Kebajikan (Al-Abrar)</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" name="fees[welfare_fund]" 
                                                                                class="pl-12 block w-full" required />
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <!-- Simpanan Tetap -->
                                                                <tr>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">6</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Simpanan Tetap</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" name="fees[fixed_savings]" 
                                                                                class="pl-12 block w-full" required />
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <!-- Jumlah -->
                                                                <tr class="bg-gray-50 font-bold">
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">7</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">JUMLAH</td>
                                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                                        <div class="relative">
                                                                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                                RM
                                                                            </span>
                                                                            <x-text-input type="number" step="0.01" id="total_amount" 
                                                                                class="pl-12 block w-full bg-gray-100" readonly />
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Add this JavaScript for auto-calculation -->
                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const feeInputs = document.querySelectorAll('input[name^="fees["]');
                                                    const totalInput = document.getElementById('total_amount');
                                                    function calculateTotal() {
                                                        let total = 0;
                                                        feeInputs.forEach(input => {
                                                            total += parseFloat(input.value || 0);
                                                        });
                                                        totalInput.value = total.toFixed(2);
                                                    }
                                                    feeInputs.forEach(input => {
                                                        input.addEventListener('input', calculateTotal);
                                                    });
                                                });
                                            </script>


                                            <div class="flex items-center justify-end mt-6">
                                                <x-secondary-button type="reset" class="mr-3">
                                                    {{ __('Set Semula') }}
                                                </x-secondary-button>
                                                <x-primary-button>
                                                    {{ __('Hantar') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
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