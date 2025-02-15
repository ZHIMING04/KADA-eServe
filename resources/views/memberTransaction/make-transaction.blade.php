<x-app-layout>
    @if(session('success'))
    <div id="successNotification" class="fixed top-4 right-4 z-50 rounded-lg bg-green-100 px-6 py-4 text-green-700 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="flex items-center space-x-2">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Transaksi Baru') }}
        </h2>
    </x-slot>

    <div class="py-6" style="background-color: #f0f7ff;">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-gray-800 dark:to-gray-700 p-4 border-b border-blue-100">
                    <h3 class="text-lg font-medium text-blue-900 dark:text-gray-200">
                        Maklumat Transaksi
                    </h3>
                    <p class="mt-1 text-sm text-blue-600 dark:text-gray-400">
                        Sila lengkapkan butiran transaksi anda
                    </p>
                </div>

                <div class="p-4 bg-white dark:bg-gray-800">
                    <!-- Transaction Form -->
                    <form id="transactionForm" method="POST" action="{{ route('member.transactions.store') }}" 
                          enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        
                        <!-- Add this for debugging -->
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Add this for debugging -->
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <!-- Transaction Type -->
                        <div class="bg-blue-50 dark:bg-gray-700 p-3 rounded-t-lg">
                            <x-input-label for="transactionType" :value="__('Jenis Transaksi')" class="text-blue-800 dark:text-gray-200" />
                            <select id="transactionType" name="type" 
                                    class="mt-1 block w-full border-blue-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-400 dark:focus:border-blue-500 focus:ring-blue-400 dark:focus:ring-blue-500 rounded-md shadow-sm" 
                                    required>
                                <option value="savings">Simpanan</option>
                                <option value="loan">Bayaran Pinjaman</option>
                            </select>
                        </div>

                        <!-- Savings Type -->
                        <div id="savingsTypeDiv" class="bg-blue-50 dark:bg-gray-700 p-3">
                            <x-input-label for="savings_type" :value="__('Jenis Simpanan')" class="text-blue-800 dark:text-gray-200" />
                            <select name="savings_type" 
                                    class="mt-1 block w-full border-blue-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-400 dark:focus:border-blue-500 focus:ring-blue-400 dark:focus:ring-blue-500 rounded-md shadow-sm">
                                <option value="share_capital">Modal Syer</option>
                                <option value="subscription_capital">Modal Yuran</option>
                                <option value="member_deposit">Deposit Ahli</option>
                                <option value="welfare_fund">Tabung Kebajikan</option>
                                <option value="fixed_savings">Simpanan Tetap</option>
                            </select>
                        </div>

                        <!-- Loan Selection -->
                        <div id="loanDiv" class="hidden bg-blue-50 dark:bg-gray-700 p-3">
                            <x-input-label for="loan_id" :value="__('Pilih Pinjaman')" class="text-blue-800 dark:text-gray-200" />
                            <select name="loan_id" 
                                    class="mt-1 block w-full border-blue-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-400 dark:focus:border-blue-500 focus:ring-blue-400 dark:focus:ring-blue-500 rounded-md shadow-sm">
                                <!-- Will be populated via AJAX -->
                            </select>
                        </div>

                        <!-- Amount -->
                        <div class="bg-blue-50 dark:bg-gray-700 p-3">
                            <x-input-label for="amount" :value="__('Jumlah (RM)')" class="text-blue-800 dark:text-gray-200" />
                            <x-text-input id="amount" 
                                         type="number" 
                                         name="amount" 
                                         step="0.01"
                                         class="mt-1 block w-full border-blue-200 focus:border-blue-400 focus:ring-blue-400" 
                                         required />
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-blue-50 dark:bg-gray-700 p-3">
                            <x-input-label :value="__('Kaedah Pembayaran')" class="text-blue-800 dark:text-gray-200 mb-2" />
                            <div class="space-y-1">
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="online" 
                                           class="rounded dark:bg-gray-900 border-blue-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-400 dark:focus:ring-blue-500 dark:focus:ring-offset-gray-800"
                                           checked>
                                    <span class="ml-2 text-sm text-blue-800 dark:text-gray-300">Online Banking</span>
                                </label>
                                <br>
                                <label class="inline-flex items-center">
                                    <input type="radio" 
                                           name="payment_method" 
                                           value="cash" 
                                           class="rounded dark:bg-gray-900 border-blue-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-400 dark:focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                                    <span class="ml-2 text-sm text-blue-800 dark:text-gray-300">Tunai</span>
                                </label>
                            </div>
                        </div>

                        <!-- Payment Proof Upload -->
                        <div id="proofUploadDiv" class="bg-blue-50 dark:bg-gray-700 p-3 rounded-lg">
                            <x-input-label for="payment_proof" :value="__('Bukti Pembayaran')" class="text-blue-800 dark:text-gray-200 mb-2" />
                            <div class="flex justify-center rounded-md border-2 border-dashed border-blue-200 dark:border-gray-600 px-6 pt-4 pb-4">
                                <div class="space-y-3 text-center">
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="hidden mx-auto">
                                        <img id="preview" src="" alt="Preview" class="mx-auto max-h-40 rounded-lg shadow-sm mb-2">
                                        <p id="fileName" class="text-sm text-blue-600 dark:text-blue-400 mb-2"></p>
                                        <div class="flex justify-center space-x-3">
                                            <button type="button" 
                                                    onclick="document.getElementById('payment_proof').click()" 
                                                    class="text-sm text-blue-600 hover:text-blue-500 dark:text-blue-400">
                                                Tukar Gambar
                                            </button>
                                            <button type="button" 
                                                    onclick="removeImage()" 
                                                    class="text-sm text-red-600 hover:text-red-500 dark:text-red-400">
                                                Buang Gambar
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Upload Icon and Button -->
                                    <div id="uploadPrompt">
                                        <svg class="mx-auto h-10 w-10 text-blue-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                                                  stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex justify-center text-sm text-blue-700 dark:text-gray-400">
                                            <label class="relative cursor-pointer rounded-md font-medium text-blue-600 dark:text-blue-400 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>Muat Naik Bukti</span>
                                                <input id="payment_proof" 
                                                       name="payment_proof" 
                                                       type="file" 
                                                       accept="image/*"
                                                       class="sr-only"
                                                       required>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-2">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md shadow-sm transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                {{ __('Hantar Transaksi') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Essential functions only
        $(document).ready(function() {
            // Initialize transaction type handling
            $('#transactionType').change(function() {
                const type = $(this).val();
                if (type === 'savings') {
                    $('#savingsTypeDiv').removeClass('hidden').addClass('block');
                    $('#loanDiv').removeClass('block').addClass('hidden');
                } else {
                    $('#savingsTypeDiv').removeClass('block').addClass('hidden');
                    $('#loanDiv').removeClass('hidden').addClass('block');
                    fetchMemberLoans();
                }
            });

            // Payment method handling
            $('input[name="payment_method"]').change(function() {
                const proofUploadDiv = $('#proofUploadDiv');
                const proofInput = $('input[name="payment_proof"]');
                
                if (this.value === 'online') {
                    proofUploadDiv.removeClass('hidden');
                    proofInput.prop('required', true);
                } else {
                    proofUploadDiv.addClass('hidden');
                    proofInput.prop('required', false);
                }
            });

            // Fetch loans function with better error handling
            function fetchMemberLoans() {
                const loanSelect = $('select[name="loan_id"]');
                loanSelect.prop('disabled', true);
                loanSelect.html('<option value="">Memuat...</option>');

                $.ajax({
                    url: '/member/loans/active',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        loanSelect.empty();
                        
                        if (data.length > 0) {
                            loanSelect.append('<option value="">-- Pilih Pinjaman --</option>');
                            data.forEach(loan => {
                                loanSelect.append(`
                                    <option value="${loan.loan_id}">
                                        Pinjaman #${loan.loan_id} - Baki: RM${loan.loan_balance.toFixed(2)}
                                    </option>
                                `);
                            });
                        } else {
                            loanSelect.append('<option value="">Tiada rekod pinjaman aktif</option>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching loans:', error);
                        loanSelect.html('<option value="">Ralat memuat pinjaman. Sila cuba lagi.</option>');
                    },
                    complete: function() {
                        loanSelect.prop('disabled', false);
                    }
                });
            }

            // File upload preview
            $('#payment_proof').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                        $('#fileName').text(file.name);
                        $('#imagePreview').removeClass('hidden');
                        $('#uploadPrompt').addClass('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove image function
            window.removeImage = function() {
                $('#payment_proof').val('');
                $('#imagePreview').addClass('hidden');
                $('#uploadPrompt').removeClass('hidden');
                $('#preview').attr('src', '');
                $('#fileName').text('');
            }

            // Form submission handling
            $('#transactionForm').submit(function() {
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html(`
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Menghantar...
                `);
            });

            // Initialize if loan type is selected
            if ($('#transactionType').val() === 'loan') {
                fetchMemberLoans();
            }
        });
    </script>
    @endpush

</x-app-layout>
