<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permohonan Pinjaman') }}
        </h2>
    </x-slot>



    <div class="py-6">
    <div class="flex gap-4 mx-4">
        <!-- Butir-butir Pembiayaan Card -->
        <div class="w-1/3 bg-white shadow-sm rounded-lg">
            <!--change back to flex-1 if u want equal size-->
            <div class="border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 p-4">
                    <form method="POST" action="{{ route('loan.store') }}" class="space-y-6">
                    @csrf
                    Butir-butir Pembiayaan
                </h3>
            </div>
            <div class="p-4">
                <!-- Jenis Pembiayaan Dropdown -->
                <div class="mb-4">
                    <label for="jenis_pembiayaan" class="block text-sm font-medium text-gray-700">
                        Jenis Pembiayaan <span class="text-red-500">*</span>
                    </label>
                    <select id="jenis_pembiayaan" 
                        name="jenis_pembiayaan" 
                        class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                        required>
                        <option value="">Pilih Jenis Pembiayaan</option>
                        <option value="albai">Al-Bai</option>
                        <option value="alinah">Al-Inah</option>
                        <option value="skimkhas">Skim Khas</option>
                        <option value="karnivaL">Karnival Muslim Istimewa</option>
                        <option value="baikpulih">Baik Pulih Kenderaan</option>
                        <option value="cukaijalan">Cukai Jalan</option>
                    </select>
                    <x-input-error :messages="$errors->get('jenis_pembiayaan')" class="mt-2" />
                </div>

                <!-- Amaun Dipohon Input -->
                <div class="mb-4">
                    <label for="amaun_dipohon" class="block text-sm font-medium text-gray-700">
                        Amaun Dipohon <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input type="number" 
                            name="amaun_dipohon" 
                            id="amaun_dipohon" 
                            class="block w-full rounded-md border border-green-500 pl-12 pr-12 focus:border-green-600 focus:ring-green-600 sm:text-sm" 
                            placeholder="0.00" 
                            required 
                            step="0.01" 
                            min="0">
                    </div>
                    <x-input-error :messages="$errors->get('amaun_dipohon')" class="mt-2" />
                </div>

                <!-- Tempoh Pembiayaan Input -->
                 <div class="mb-4">
                    <label for="tempoh_pembiayaan" class="block text-sm font-medium text-gray-700">
                        Tempoh Pembiayaan (Bulan) <span class="text-red-500">*</span>
                    </label>
                        <div class="relative mt-2 rounded-md shadow-sm">
                            <input type="number" 
                            name="tempoh_pembiayaan" 
                            id="tempoh_pembiayaan" 
                            class="block w-full h-12 rounded-md border border-green-500 pl-4 pr-12 focus:border-green-600 focus:ring-green-600 sm:text-sm" 
                            placeholder="Masukkan tempoh" 
                            required 
                            min="1"
                            max="120">
                         </div>
                    <x-input-error :messages="$errors->get('tempoh_pembiayaan')" class="mt-2" />
                </div>

                <!--ansuran bulanan -->
                <div class="mb-4">
                    <label for="ansuran_bulanan" class="block text-sm font-medium text-gray-700">
                        Ansuran Bulanan
                    </label>
                    <div class="relative mt-2 rounded-md shadow-sm">
                        <input type="text" 
                            name="ansuran_bulanan" 
                            id="ansuran_bulanan" 
                            class="block w-full h-12 rounded-md border border-gray-300 pl-16 pr-12 text-base bg-gray-50" 
                            readonly>
                    </div>
                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const amaunInput = document.getElementById('amaun_dipohon');
                        const tempohInput = document.getElementById('tempoh_pembiayaan');
                        const ansuranInput = document.getElementById('ansuran_bulanan');

                        function calculateAnsuran() {
                            const amaun = parseFloat(amaunInput.value) || 0;
                            const tempoh = parseInt(tempohInput.value) || 1;
                            const ansuran = (amaun / tempoh).toFixed(2);
                            ansuranInput.value = ansuran;
                        }

                        amaunInput.addEventListener('input', calculateAnsuran);
                        tempohInput.addEventListener('input', calculateAnsuran);
                    });
                </script>
            </div>
        </div>

        <!-- Butir-butir Peribadi Card -->
        <div class="flex-1 bg-white shadow-sm rounded-lg">
            <div class="border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 p-4">
                    Butir-butir Peribadi Pemohon
                </h3>
            </div>
            <div class="p-4">
                <!-- ...existing code for peribadi form... -->
                 <!-- Nama Input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Nama <span class="text-red-500">*</span>
                     </label>
                         <input type="text" 
                     name="name" 
                     id="name" 
                     class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                     required 
                     autofocus>
                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                 <!-- IC and DOB in same row -->
                 <div class="grid grid-cols-2 gap-4 mb-4">
                        <!-- IC Number Input -->
                        <div>
                            <label for="ic" class="block text-sm font-medium text-gray-700">
                                No. K/P <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="ic" 
                                id="ic" 
                                class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                required 
                                placeholder="000000-00-0000">
                            <x-input-error :messages="$errors->get('ic')" class="mt-2" />
                        </div>

                        <!-- Date of Birth Input -->
                        <div>
                            <label for="dob" class="block text-sm font-medium text-gray-700">
                                Tarikh Lahir <span class="text-red-500">*</span>
                            </label>
                            <input type="date" 
                                name="dob" 
                                id="dob" 
                                class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                required>
                            <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Gender, Religion, Race in same row -->
                    <table class="w-full mb-4">
                        <tr>
                            <!-- Gender Dropdown -->
                            <td class="pr-4">
                                <label for="gender" class="block text-sm font-medium text-gray-700">
                                    Jantina <span class="text-red-500">*</span>
                                </label>
                                <select id="gender" name="gender" class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" required>
                                    <option value="">Pilih Jantina</option>
                                    <option value="Lelaki">Lelaki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </td>

                            <!-- Religion Dropdown -->
                            <td class="pr-4">
                                <label for="agama" class="block text-sm font-medium text-gray-700">
                                    Agama <span class="text-red-500">*</span>
                                </label>
                                <select id="agama" name="agama" class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" required>
                                    <option value="">Pilih Agama</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Kristian">Kristian</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                            </td>

                            <!-- Race Dropdown -->
                            <td>
                                <label for="bangsa" class="block text-sm font-medium text-gray-700">
                                    Bangsa <span class="text-red-500">*</span>
                                </label>
                                <select id="bangsa" name="bangsa" class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" required>
                                    <option value="">Pilih Bangsa</option>
                                    <option value="Melayu">Melayu</option>
                                    <option value="Cina">Cina</option>
                                    <option value="India">India</option>
                                    <option value="Lain-lain">Lain-lain</option>
                                </select>
                            </td>
                        </tr>
                    </table>

                <!-- Address Section -->
<div class="mb-4">
    <!-- Full Address Input -->
    <div class="mb-4">
        <label for="address" class="block text-sm font-medium text-gray-700">
            Alamat <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="address" 
               id="address" 
               class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
               required>
        <x-input-error :messages="$errors->get('address')" class="mt-2" />
    </div>

    <!-- City, Postcode and State in one row -->
    <table class="w-full">
        <tr>
            <!-- City -->
            <td class="pr-4">
                <label for="city" class="block text-sm font-medium text-gray-700">
                    Bandar <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="city" 
                       id="city" 
                       class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                       required>
            </td>

            <!-- Postcode -->
            <td class="pr-4">
                <label for="postcode" class="block text-sm font-medium text-gray-700">
                    Poskod <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="postcode" 
                       id="postcode" 
                       class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                       required>
            </td>

            <!-- State -->
            <td>
                <label for="state" class="block text-sm font-medium text-gray-700">
                    Negeri <span class="text-red-500">*</span>
                </label>
                <select name="state" 
                        id="state" 
                        class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                        required>
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
</div>

                <!-- Member Details Section -->
                 <table class="w-full mb-4">
                    <tr>
                        <!-- Member Number -->
                        <td class="pr-2">
                            <label for="member_no" class="block text-sm font-medium text-gray-700">
                                No. Anggota <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="member_no" 
                                id="member_no" 
                                class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                required>
                            <x-input-error :messages="$errors->get('member_no')" class="mt-2" />
                        </td>

                        <!-- PF Number -->
                        <td class= "pl-2"> 
                            <label for="pf_no" class="block text-sm font-medium text-gray-700">
                                No. PF <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="pf_no" 
                                id="pf_no" 
                                class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                required>
                            <x-input-error :messages="$errors->get('pf_no')" class="mt-2" />
                        </td>
                    </tr>
                </table>

                <!-- Office Address Section -->
                <div class="mb-4">
                    <label for="office_address" class="block text-sm font-medium text-gray-700">
                        Alamat Pejabat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                        name="office_address" 
                        id="office_address" 
                        class="mt-1 block w-full rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                        required>
                    <x-input-error :messages="$errors->get('office_address')" class="mt-2" />
                </div>

                <!-- Office City and Postcode -->
                <table class="w-full mb-4">
                    <tr>
                        <!-- Office City -->
                        <td class="pr-2">
                            <label for="office_city" class="block text-sm font-medium text-gray-700">
                                Bandar <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="office_city" 
                                id="office_city" 
                                class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                required>
                            <x-input-error :messages="$errors->get('office_city')" class="mt-2" />
                        </td>

                        <!-- Office Postcode -->
                        <td class="pl-2">
                            <label for="office_postcode" class="block text-sm font-medium text-gray-700">
                                Poskod <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                name="office_postcode" 
                                id="office_postcode" 
                                class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                required>
                            <x-input-error :messages="$errors->get('office_postcode')" class="mt-2" />
                        </td>
                    </tr>
                </table>

                <!-- Bank Details Section -->
                    <table class="w-full mb-4">
                        <tr>
                            <!-- Bank Name -->
                            <td class="pr-2">
                                <label for="bank" class="block text-sm font-medium text-gray-700">
                                    Nama Bank <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    name="bank" 
                                    id="bank" 
                                    class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                    required>
                                <x-input-error :messages="$errors->get('bank')" class="mt-2" />
                            </td>

                            <!-- Bank Account Number -->
                            <td class="pl-2">
                                <label for="bank_no" class="block text-sm font-medium text-gray-700">
                                    No. Akaun Bank <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    name="bank_no" 
                                    id="bank_no" 
                                    class="mt-1 block w-3/4 rounded-md border border-green-500 focus:border-green-600 focus:ring-green-600" 
                                    required>
                                <x-input-error :messages="$errors->get('bank_no')" class="mt-2" />
                            </td>
                        </tr>
                    </table>















            </div> 
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
</div>

</x-app-layout>







