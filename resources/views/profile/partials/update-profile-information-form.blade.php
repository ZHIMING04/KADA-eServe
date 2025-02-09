<section>
    <header>
        <div class="bg-gradient-to-r from-green-600 to-blue-400 p-2 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-semibold text-white flex items-center" style="margin-top: 10px;">
                <i class="fas fa-coins mr-2"></i> Kemas Kini Maklumat
            </h3>
        </div>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Sila kemas kini maklumat terkini anda. Selepas menekan butang kemaskini, anda dapat mengubah maklumat anda. Jangan lupa menekan butang Simpan.") }}
        </p>
    </header>

    <form id="profile-form" method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Address Section -->
        <div>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="address" :value="__('Alamat Rumah')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $member->address)" readonly required />
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="city" :value="__('Bandar')" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $member->city)" readonly required />
                    @error('city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="postcode" :value="__('Poskod')" />
                    <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode', $member->postcode)" readonly required />
                    @error('postcode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <br>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="state" :value="__('Negeri')" />
                    <select id="state" name="state" class="mt-1 block w-full  rounded-lg border-gray-300" disabled required>
                        <option value="">{{ __('Pilih Negeri') }}</option>
                        <option value="Johor" {{ old('state', $member->state) == 'Johor' ? 'selected' : '' }}>Johor</option>
                        <option value="Kedah" {{ old('state', $member->state) == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                        <option value="Kelantan" {{ old('state', $member->state) == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                        <option value="Melaka" {{ old('state', $member->state) == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                        <option value="Negeri Sembilan" {{ old('state', $member->state) == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                        <option value="Pahang" {{ old('state', $member->state) == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                        <option value="Perak" {{ old('state', $member->state) == 'Perak' ? 'selected' : '' }}>Perak</option>
                        <option value="Perlis" {{ old('state', $member->state) == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                        <option value="Pulau Pinang" {{ old('state', $member->state) == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                        <option value="Sabah" {{ old('state', $member->state) == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                        <option value="Sarawak" {{ old('state', $member->state) == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                        <option value="Selangor" {{ old('state', $member->state) == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                        <option value="Terengganu" {{ old('state', $member->state) == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                        <option value="Kuala Lumpur" {{ old('state', $member->state) == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="Labuan" {{ old('state', $member->state) == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                        <option value="Putrajaya" {{ old('state', $member->state) == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                    </select>
                    @error('state')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Office Address Section -->
        <div>
            <hr class="my-6 border-gray-300 dark:border-gray-700">
            
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="office_address" :value="__('Alamat Pejabat')" />
                    <x-text-input id="office_address" name="office_address" type="text" class="mt-1 block w-full" :value="old('office_address', $member->office_address)" readonly required />
                    @error('office_address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="office_city" :value="__('Bandar Pejabat')" />
                    <x-text-input id="office_city" name="office_city" type="text" class="mt-1 block w-full" :value="old('office_city', $member->office_city)" readonly required />
                    @error('office_city')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <x-input-label for="office_postcode" :value="__('Poskod Pejabat')" />
                    <x-text-input id="office_postcode" name="office_postcode" type="text" class="mt-1 block w-full" :value="old('office_postcode', $member->office_postcode)" readonly required />
                    @error('office_postcode')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <br>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="office_state" :value="__('Negeri Pejabat')" />
                    <select id="office_state" name="office_state" class="mt-1 block w-full rounded-lg border-gray-300" disabled required>
                        <option value="">{{ __('Pilih Negeri') }}</option>
                        <option value="Johor" {{ old('office_state', $member->office_state) == 'Johor' ? 'selected' : '' }}>Johor</option>
                        <option value="Kedah" {{ old('office_state', $member->office_state) == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                        <option value="Kelantan" {{ old('office_state', $member->office_state) == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                        <option value="Melaka" {{ old('office_state', $member->office_state) == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                        <option value="Negeri Sembilan" {{ old('office_state', $member->office_state) == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                        <option value="Pahang" {{ old('office_state', $member->office_state) == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                        <option value="Perak" {{ old('office_state', $member->office_state) == 'Perak' ? 'selected' : '' }}>Perak</option>
                        <option value="Perlis" {{ old('office_state', $member->office_state) == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                        <option value="Pulau Pinang" {{ old('office_state', $member->office_state) == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                        <option value="Sabah" {{ old('office_state', $member->office_state) == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                        <option value="Sarawak" {{ old('office_state', $member->office_state) == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                        <option value="Selangor" {{ old('office_state', $member->office_state) == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                        <option value="Terengganu" {{ old('office_state', $member->office_state) == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                        <option value="Kuala Lumpur" {{ old('office_state', $member->office_state) == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="Labuan" {{ old('office_state', $member->office_state) == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                        <option value="Putrajaya" {{ old('office_state', $member->office_state) == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                    </select>
                    @error('office_state')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <br>

        <div class="flex items-center gap-4 justify-center">
            <x-primary-button id="edit-button" type="button">{{ __('Kemas Kini') }}</x-primary-button>
            <x-primary-button id="save-button" type="submit" class="hidden bg-green-500 hover:bg-green-700">{{ __('Simpan') }}</x-primary-button>
        </div>
    </form>

    @if (session('status') == 'profile-updated')
    <p
        x-data="{ show: true }"
        x-show="show"
        x-transition
        x-init="setTimeout(() => show = false, 20000)"
        class="text-sm text-gray-600 dark:text-gray-400"
    >{{ __('Saved.') }}</p>
    @endif

    <script>
    document.getElementById('edit-button').addEventListener('click', function() {
        const inputs = document.querySelectorAll('#address, #city, #postcode, #state, #office_address, #office_city, #office_postcode, #office_state');
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.classList.add('border-green-500');
        });
        document.getElementById('state').removeAttribute('disabled');
        document.getElementById('office_state').removeAttribute('disabled');
        document.getElementById('edit-button').classList.add('hidden');
        document.getElementById('save-button').classList.remove('hidden');
        alert('Anda boleh mula mengedit maklumat anda.');
    });

    document.getElementById('profile-form').addEventListener('submit', function(event) {
        const inputs = document.querySelectorAll('#address, #city, #postcode, #state, #office_address, #office_city, #office_postcode, #office_state');
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('border-red-500');
                valid = false;
            }
        });
        if (!valid) {
            event.preventDefault();
            alert('Sila isi semua maklumat dengan betul.');
        }
    });

    document.querySelectorAll('input, select').forEach(input => {
        input.addEventListener('invalid', function() {
            this.classList.add('border-red-500');
        });
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('border-red-500');
            }
        });
    });

    // Postcode validation
    const postcodeInputs = document.querySelectorAll('#postcode, #office_postcode');
    postcodeInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value.length === 5 && /^\d+$/.test(this.value)) {
                this.classList.remove('border-red-500');
                this.classList.add('border-green-500');
            } else {
                this.classList.remove('border-green-500');
                this.classList.add('border-red-500');
            }
        });
    });
</script>

</section>
