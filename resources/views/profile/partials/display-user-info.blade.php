<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Maklumat Peribadi') }}
        </h2>
    </header>

    <form method="post" action="{{ route('profile.show') }}">
        <!-- Information Section -->
        <div>
    
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input-label for="name" :value="__('Nama')" />
                    <p class="mt-1 block w-full">{{ $member->name }}</p>
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="ic" :value="__('IC')" />
                    <p class="mt-1 block w-full">{{ $member->ic }}</p>
                </div>
                <div>
                    <x-input-label for="DOB" :value="__('Tarikh Lahir')" />
                    <p class="mt-1 block w-full">{{ $member->DOB }}</p>
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <x-input-label for="agama" :value="__('Agama')" />
                    <p class="mt-1 block w-full">{{ $member->agama }}</p>
                </div>
                <div>
                    <x-input-label for="bangsa" :value="__('Bangsa')" />
                    <p class="mt-1 block w-full">{{ $member->bangsa }}</p>
                </div>
            </div>
            <br>
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <x-input-label for="no_pf" :value="__('No PF')" />
                    <p class="mt-1 block w-full">{{ $member->no_pf }}</p>
                </div>
                <div>
                    <x-input-label for="jawatan" :value="__('Jawatan')" />
                    <p class="mt-1 block w-full">{{ $workingInfo->jawatan }}</p>
                </div>
                <div>
                    <x-input-label for="gred" :value="__('Gred')" />
                    <p class="mt-1 block w-full">{{ $workingInfo->gred }}</p>
                </div>
            </div>
        </div>

    </form>
</section>
