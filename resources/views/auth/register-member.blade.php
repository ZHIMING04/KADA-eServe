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
                            
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <form method="POST" action="{{ route('register-member.store') }}" class="space-y-6">
                                        @csrf
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- Name -->
                                            <div>
                                                <x-input-label for="name" value="Nama Pendaftar" />
                                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>

                                            <!-- Email -->
                                            <div>
                                                <x-input-label for="email" value="Email" />
                                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            </div>

                                            <!-- Password -->
                                            <div>
                                                <x-input-label for="password" value="Kata Laluan" />
                                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- No K.P -->
                                            <div>
                                                <x-input-label for="ic" value="No. K/P" />
                                                <x-text-input id="ic" name="ic" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('ic')" class="mt-2" />
                                            </div>

                                            <!-- Phone -->
                                            <div>
                                                <x-input-label for="phone" value="Phone" />
                                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                            </div>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-span-2">
                                            <x-input-label for="address" value="Address" />
                                            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" required />
                                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                        </div>

                                        <!-- City, Postcode, and State in the same row using table -->
                                        <table class="w-full">
                                            <tr>
                                                <!-- City -->
                                                <td class="pr-4">
                                                    <label for="city" class="block text-sm font-medium text-gray-700">Bandar <span class="text-red-500">*</span></label>
                                                    <input id="city" name="city" type="text" class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" required>
                                                </td>

                                                <!-- Postcode -->
                                                <td class="pr-4">
                                                    <label for="poskod" class="block text-sm font-medium text-gray-700">Poskod <span class="text-red-500">*</span></label>
                                                    <input id="poskod" name="poskod" type="text" class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" required>
                                                </td>

                                                <!-- State -->
                                                <td>
                                                    <label for="state" class="block text-sm font-medium text-gray-700">Negeri <span class="text-red-500">*</span></label>
                                                    <select id="state" name="state" class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" required>
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
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Gender / Jantina -->
                                        <div>
                                            <x-input-label for="gender" value="Jantina" />
                                            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                <option value="">Pilih Jantina</option>
                                                <option value="Lelaki">Lelaki</option>
                                                <option value="Perempuan">Perempuan </option>
                                            </select>
                                            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-input-label for="DOB" value="Tarikh Lahir" />
                                            <input 
                                                id="DOB" 
                                                name="DOB"
                                                type="date" 
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                                required 
                                            />
                                            <x-input-error :messages="$errors->get('DOB')" class="mt-2" />
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="gred" value="Jawatan dan Gred" />
                                                <x-text-input id="gred" name="gred" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('gred')" class="mt-2" />
                                            </div>

                                            <div>
                                                <x-input-label for="salary" value="Gaji Bulanan" />
                                                <x-text-input id="salary" name="salary" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                                            </div>
                                        </div>
                                        
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
    </body>
</html>
