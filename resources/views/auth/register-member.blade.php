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
                                            <!-- Jawatan -->
                                            <div>
                                                <x-input-label for="jawatan" value="Jawatan" />
                                                <x-text-input id="jawatan" name="jawatan" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('jawatan')" class="mt-2" />
                                            </div>

                                            <!-- Gred -->
                                            <div>
                                                <x-input-label for="gred" value="Gred" />
                                                <x-text-input id="gred" name="gred" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('gred')" class="mt-2" />
                                            </div>

                                            <!-- Salary (keeping it in the same grid) -->
                                            <div>
                                                <x-input-label for="salary" value="Gaji Bulanan" />
                                                <x-text-input id="salary" name="salary" type="text" class="mt-1 block w-full" required />
                                                <x-input-error :messages="$errors->get('salary')" class="mt-2" />
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
    </body>
</html>
