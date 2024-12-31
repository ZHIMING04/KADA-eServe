<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Register New Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
       
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <!-- Card Title -->
                            <div class="bg-white shadow-md rounded-lg mb-4">
                                <div class="border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900 p-4">
                                        Profil Pemohon
                                    </h3>
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
                                    </td>
                                </tr>
                            </table>

                                
                            <!-- Gender / Jantina -->
                            <div>
                                <x-input-label for="gender" value="Jantina" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jantina</option>
                                    <option value="Lelaki">Lelaki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="gender" value="Tarikh Lahir" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Pilih Jantina</option>
                                    <option value="Lelaki">Lelaki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
        
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                        
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="gred" value="Jawatan dan Gred" />
                                    <x-text-input id="gred" name="gred" type="text" class="mt-1 block w-full" required />
                                    <x-input-error :messages="$errors->get('gred')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="salary" class="block text-sm font-medium text-gray-700">Gaji Bulanan</x-input-label>
                                    <x-text-input 
                                        type="number" 
                                        name="salary" 
                                        id="salary" 
                                        class="block w-full rounded-md border border-green-500 pl-12 pr-12 focus:border-green-600 focus:ring-green-600 sm:text-sm" 
                                        placeholder="0.00" 
                                        required 
                                        step="0.01" 
                                        min="0">
                                    @error('salary')
                                        <span class="text-sm text-red-500 mt-2">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                    
                        <div class="flex items-center justify-end mt-6">
                            <x-secondary-button type="reset" class="mr-3">
                                {{ __('Reset') }}
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
</x-app-layout>