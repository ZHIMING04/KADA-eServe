<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Kemas kini Maklumat') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Sila kemas kini maklumat terkini anda. Selepas menekan butang kemaskini, anda dapat mengubah maklumat anda. Jangan lupa menekan butang Simpan.") }}
        </p>
     
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Contact Section -->
         <br>
        <div>
            <div class="grid grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="phone" :value="__('Telefon')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $member->phone)" readonly />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $member->email)" readonly />
                    </div>
            </div>
        </div>

        <!-- Address Section -->
        <br><br>
        <hr class="my-6 border-gray-300 dark:border-gray-700">
        <br>
        <div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ __('Alamat') }}</h3>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="address" :value="__('Alamat')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $member->address)" readonly />
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="city" :value="__('Bandar')" />
                    <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $member->city)" readonly />
                </div>
                <div>
                    <x-input-label for="postcode" :value="__('Poskod')" />
                    <x-text-input id="postcode" name="postcode" type="text" class="mt-1 block w-full" :value="old('postcode', $member->postcode)" readonly />
                </div>
            </div>
            <br>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="state" :value="__('Negeri')" />
                    <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $member->state)" readonly />
                </div>
            </div>
        </div>
        <br><br>
        <!-- Office Address Section -->
        <div>
        <hr class="my-6 border-gray-300 dark:border-gray-700">
        <br>

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="office_address" :value="__('Alamat Pejabat')" />
                    <x-text-input id="office_address" name="office_address" type="text" class="mt-1 block w-full" :value="old('office_address', $member->office_address)" readonly />
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="office_city" :value="__('Bandar Pejabat')" />
                    <x-text-input id="office_city" name="office_city" type="text" class="mt-1 block w-full" :value="old('office_city', $member->office_city)" readonly />
                </div>
                <div>
                    <x-input-label for="office_postcode" :value="__('Poskod Pejabat')" />
                    <x-text-input id="office_postcode" name="office_postcode" type="text" class="mt-1 block w-full" :value="old('office_postcode', $member->office_postcode)" readonly />
                </div>
            </div>
            <br>
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="office_state" :value="__('Negeri Pejabat')" />
                    <x-text-input id="office_state" name="office_state" type="text" class="mt-1 block w-full" :value="old('office_state', $member->office_state)" readonly />
                </div>
            </div>
        </div>
        <br>

        <div class="flex items-center gap-4 justify-center">
            <x-primary-button id="edit-button" type="button">{{ __('Kemas Kini') }}</x-primary-button>
            <x-primary-button id="save-button" type="submit" class="hidden" @click="modalOpen=true">{{ __('Simpan') }}</x-primary-button>

            @if (session('status') == 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 20000)"
                class="text-sm text-gray-600 dark:text-gray-400"
            >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
    



    <script>
        document.getElementById('edit-button').addEventListener('click', function() {
            document.getElementById('address').removeAttribute('readonly');
            document.getElementById('city').removeAttribute('readonly');
            document.getElementById('postcode').removeAttribute('readonly');
            document.getElementById('state').removeAttribute('readonly');
            document.getElementById('office_address').removeAttribute('readonly');
            document.getElementById('office_city').removeAttribute('readonly');
            document.getElementById('office_postcode').removeAttribute('readonly');
            document.getElementById('office_state').removeAttribute('readonly');
            document.getElementById('edit-button').classList.add('hidden');
            document.getElementById('save-button').classList.remove('hidden');
        });


    </script>
</section>
