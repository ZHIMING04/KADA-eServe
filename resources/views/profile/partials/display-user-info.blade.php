<section >
    <header>
        <div class="bg-gradient-to-r from-green-600 to-blue-400 p-4 rounded-t-lg flex justify-between items-center">
            <h3 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-user mr-2"></i> Maklumat Peribadi
            </h3>
                                <div class="ml-4">
                                    <span class="status-badge inline-block px-3 py-1 rounded-full text-sm font-semibold bg-{{ $member->status == 'pending' ? 'yellow' : ($member->status == 'rejected' ? 'red' : ($member->status == 'resigned' ? 'orange' : ($member->status == 'deceased' ? 'gray' : 'green'))) }}-100 text-{{ $member->status == 'pending' ? 'yellow' : ($member->status == 'rejected' ? 'red' : ($member->status == 'resigned' ? 'orange' : ($member->status == 'deceased' ? 'gray' : 'green'))) }}-800">
                                        {{ $member->status == 'pending' ? 'SEDANG DIPROSES' : ($member->status == 'rejected' ? 'DITOLAK' : ($member->status == 'resigned' ? 'BERHENTI' : ($member->status == 'deceased' ? 'WAFAT' : 'AHLI'))) }}
                                    </span>
                                </div>
        </div>
    </header>

    <div class="mt-4">
        <!-- Information Section -->
        <div class="grid grid-cols-1 gap-6 mb-4">
            <div>
                <x-input-label for="name" :value="__('Nama')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $member->name }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-4">
            <div>
                <x-input-label for="ic" :value="__('IC')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $member->ic }}</p>
            </div>
            <div>
                <x-input-label for="DOB" :value="__('Tarikh Lahir')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $member->DOB }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-4">
            <div>
                <x-input-label for="agama" :value="__('Agama')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $member->agama }}</p>
            </div>
            <div>
                <x-input-label for="bangsa" :value="__('Bangsa')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $member->bangsa }}</p>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-6 mb-4">
            <div>
                <x-input-label for="no_pf" :value="__('No PF')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $member->no_pf }}</p>
            </div>
            <div>
                <x-input-label for="jawatan" :value="__('Jawatan')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $workingInfo->jawatan }}</p>
            </div>
            <div>
                <x-input-label for="gred" :value="__('Gred')" />
                <p class="mt-1 block w-full bg-gray-100 p-2 rounded">{{ $workingInfo->gred }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-4">
    <div>
        <x-input-label for="phone" :value="__('Telefon')" />
        <p class="mt-1 block w-full bg-gray-100 p-2 rounded flex justify-between items-center">
            {{ $member->phone }}
        </p>
    </div>
    <div>
        <x-input-label for="email" :value="__('Email')" />
        <p class="mt-1 block w-full bg-gray-100 p-2 rounded flex justify-between items-center">
            {{ $member->email }}
            <button type="button" class="ml-2" onclick="openModal('email')">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /></svg>
            </button>
        </p>
    </div>
</div>
    </div>

    
    <div id="phone-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="relative p-8 border w-2/3 shadow-lg rounded-lg bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-2xl leading-6 font-medium text-gray-900">Tukar Nombor Telefon</h3>
                <div class="mt-4 px-10 py-5">
                    <p class="text-sm text-gray-600 mb-4">Sila tulis nombor telefon baru anda untuk meneruskan proses penukaran nombor telefon melalui pengesahan kod.</p>
                    <form id="phone-form" method="post" action="{{ route('profile.updatePhone') }}" onsubmit="return validatePhone()">
                        @csrf
                        <x-input-label for="new-phone" :value="__('Nombor Telefon Baru')" class="text-left" />
                        <x-text-input id="new-phone" name="new-phone" type="text" class="mt-1 block w-full mx-auto p-2 border border-gray-300 rounded-md" />
                        <p id="phone-error" class="text-red-500 text-sm mt-2"></p>
                        <div class="flex justify-center mt-6 gap-4">
                            <x-primary-button type="submit" class="bg-green-500 hover:bg-green-700 w-3/4 py-2">{{ __('Hantar Kod Pengesahan') }}</x-primary-button>
                            <button id="close-phone-modal" type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">{{ __('Tutup') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="verify-phone-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="relative p-8 border w-2/3 shadow-lg rounded-lg bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-2xl leading-6 font-medium text-gray-900">Sahkan Nombor Telefon</h3>
                <div class="mt-4 px-10 py-5">
                    <p class="text-sm text-gray-600 mb-4">Sila masukkan kod pengesahan yang dihantar ke nombor telefon baru anda.</p>
                    <form id="verify-phone-form" method="post" action="{{ route('profile.verifyPhone') }}">
                        @csrf
                        <x-input-label for="verification_code" :value="__('Kod Pengesahan')" class="text-left" />
                        <x-text-input id="verification_code" name="verification_code" type="text" class="mt-1 block w-full mx-auto p-2 border border-gray-300 rounded-md" />
                        <p id="verification-error" class="text-red-500 text-sm mt-2"></p>
                        <div class="flex justify-center mt-6 gap-4">
                            <x-primary-button type="submit" class="bg-green-500 hover:bg-green-700 w-3/4 py-2">{{ __('Sahkan') }}</x-primary-button>
                            <button id="close-verify-phone-modal" type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">{{ __('Tutup') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="email-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="relative p-8 border w-2/3 shadow-lg rounded-lg bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-2xl leading-6 font-medium text-gray-900">Tukar Email</h3>
                <div class="mt-4 px-10 py-5">
                    <p class="text-sm text-gray-600 mb-4">KADA akan menghantar informasi penting melalui email ini. Email semasa anda ialah: {{ $member->email }}</p>
                    <p class="text-sm text-gray-600 mb-4">Sila tulis email baru anda untuk meneruskan proses penukaran email melalui pengesahan email.</p>
                    <form id="email-form" method="post" action="{{ route('profile.updateEmail') }}" onsubmit="return validateEmail()">
                        @csrf
                        <x-input-label for="new-email" :value="__('Email Baru')" class="text-left" />
                        <x-text-input id="new-email" name="new-email" type="email" class="mt-1 block w-full mx-auto p-2 border border-gray-300 rounded-md" />
                        <p id="email-error" class="text-red-500 text-sm mt-2"></p>
                        <div class="flex justify-center mt-6 gap-4">
                            <x-primary-button type="submit" class="bg-green-500 hover:bg-green-700 w-3/4 py-2">{{ __('Hantar Email Pengesahan') }}</x-primary-button>
                            <button id="close-email-modal" type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">{{ __('Tutup') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Message Modal -->
    <div id="success-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden flex items-center justify-center">
        <div class="relative p-8 border w-96 shadow-lg rounded-lg bg-white">
            <div class="mt-3 text-center">
                <svg class="mx-auto mb-4 w-16 h-16 text-green-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4 -4"></path>
                </svg>
                <h3 class="text-2xl leading-6 font-medium text-gray-900" id="success-message"></h3>
                <div class="mt-4">
                    <button id="close-success-modal" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateEmail() {
            const newEmail = document.getElementById('new-email').value;
            const oldEmail = "{{ $member->email }}";
            const emailError = document.getElementById('email-error');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (newEmail === oldEmail) {
                emailError.innerText = "Sila tulis email baru anda. Ini adalah email semasa anda.";
                return false;
            } else if (!emailPattern.test(newEmail)) {
                emailError.innerText = "Format email salah";
                return false;
            } else {
                emailError.innerText = "";
                return true;
            }
        }

        function validatePhone() {
            const newPhone = document.getElementById('new-phone').value;
            const oldPhone = "{{ $member->phone }}";
            const phoneError = document.getElementById('phone-error');
            const phonePattern = /^[0-9]{10,11}$/;

            if (newPhone === oldPhone) {
                phoneError.innerText = "Sila tulis nombor telefon baru anda. Ini adalah nombor telefon semasa anda.";
                return false;
            } else if (!phonePattern.test(newPhone)) {
                phoneError.innerText = "Format nombor telefon salah";
                return false;
            } else {
                phoneError.innerText = "";
                return true;
            }
        }

        function openModal(type) {
            if (type === 'phone') {
                document.getElementById('phone-modal').classList.remove('hidden');
            } else if (type === 'verify-phone') {
                document.getElementById('verify-phone-modal').classList.remove('hidden');
            } else if (type === 'email') {
                document.getElementById('email-modal').classList.remove('hidden');
            }
        }

        function showSuccessMessage(type) {
            if (type === 'phone') {
                document.getElementById('success-message').innerText = 'Kod Pengesahan Dihantar';
            } else if (type === 'email') {
                document.getElementById('success-message').innerText = 'Email Pengesahan Dihantar';
            }
            document.getElementById('success-modal').classList.remove('hidden');
        }

        document.getElementById('close-phone-modal').addEventListener('click', function() {
            document.getElementById('phone-modal').classList.add('hidden');
        });

        document.getElementById('close-verify-phone-modal').addEventListener('click', function() {
            document.getElementById('verify-phone-modal').classList.add('hidden');
        });

        document.getElementById('close-email-modal').addEventListener('click', function() {
            document.getElementById('email-modal').classList.add('hidden');
        });

        document.getElementById('close-success-modal').addEventListener('click', function() {
            document.getElementById('success-modal').classList.add('hidden');
        });

        document.getElementById('email-form').addEventListener('submit', function(event) {
            event.preventDefault();
            if (validateEmail()) {
                fetch(this.action, {
                    method: this.method,
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        document.getElementById('email-modal').classList.add('hidden');
                        showSuccessMessage('email');
                    }
                });
            }
        });


    

        document.getElementById('verify-phone-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const verificationCode = document.getElementById('verification_code').value;
            const verificationError = document.getElementById('verification-error');
            const codePattern = /^[0-9]{6}$/;

            if (!codePattern.test(verificationCode)) {
                verificationError.innerText = "Kod pengesahan salah";
                return false;
            } else {
                verificationError.innerText = "";
                fetch(this.action, {
                    method: this.method,
                    body: new FormData(this),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(response => {
                    if (response.ok) {
                        document.getElementById('verify-phone-modal').classList.add('hidden');
                        location.reload();
                    } else {
                        verificationError.innerText = "Kod pengesahan salah";
                    }
                });
            }
        });

    
    </script>

</section>
