<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        
        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        
        <!-- Add any custom styles -->
        <style>
            [x-cloak] { display: none !important; }
            
            .bg-primary {
                background-color: #4f46e5;
            }
            .text-primary {
                color: #4f46e5;
            }
            .hover\:bg-primary-hover:hover {
                background-color: #3730a3;
            }

            /* Form Container */
            .max-w-3xl {
                max-width: 48rem;
            }

            /* Currency Input Styling */
            .currency-input {
                position: relative;
            }

            .currency-input::before {
                content: 'RM';
                position: absolute;
                left: 0.75rem;
                top: 50%;
                transform: translateY(-50%);
                color: #6B7280;
                z-index: 10;
            }

            .currency-input input {
                padding-left: 3rem !important; /* Make space for the RM prefix */
            }

            /* Input Fields - Updated with thicker padding */
            .form-input,
            .form-select,
            .form-textarea {
                width: 100%;
                padding: 0.75rem 1rem;
                border-radius: 0.375rem;
                border: 1px solid #d1d5db;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
                font-size: 0.95rem;
                line-height: 1.5;
                min-height: 2.75rem;
                background-color: #fff;
            }

            .form-input:focus,
            .form-select:focus,
            .form-textarea:focus {
                outline: none;
                border-color: #4f46e5;
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            }

            /* Specific input type adjustments */
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="date"],
            select,
            textarea {
                padding: 0.75rem 1rem;
                height: 3rem;
                width: 100%;
                border-radius: 0.375rem;
                border: 1px solid #d1d5db;
                background-color: #fff;
                color: #1f2937;
            }

            /* Step Indicator */
            .step-indicator {
                width: 2.5rem;
                height: 2.5rem;
                transition: all 0.3s ease;
            }

            /* Progress Bar */
            .progress-bar {
                height: 0.25rem;
                transition: width 0.5s ease-in-out;
            }

            /* File Upload */
            .file-upload-container {
                border: 2px dashed #d1d5db;
                border-radius: 0.5rem;
                padding: 2rem;
                text-align: center;
                transition: all 0.3s ease;
            }

            .file-upload-container:hover {
                border-color: #4f46e5;
                background-color: rgba(79, 70, 229, 0.05);
            }

            /* Payment Method Cards */
            .payment-method-card {
                border: 2px solid transparent;
                transition: all 0.3s ease;
            }

            .payment-method-card.selected {
                border-color: #4f46e5;
                background-color: rgba(79, 70, 229, 0.05);
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            ::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #555;
            }

            /* Responsive Adjustments */
            @media (max-width: 640px) {
                .max-w-3xl {
                    margin: 1rem;
                }
            }

            /* Input Number Styles */
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }

            /* Grid Columns Adjustment */
            .grid-cols-2 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1.5rem;
            }

            .grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 1.5rem;
            }

            /* Button Styles */
            .btn-primary {
                background-color: #4f46e5;
                color: white;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                font-weight: 500;
                transition: background-color 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #3730a3;
            }

            /* Error Messages */
            .error-message {
                color: #dc2626;
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen relative" x-data="{ currentStep: 1, totalSteps: 4, paymentMethod: 'cash' }">
            <!-- Return Button - Minimalist dark arrow -->
            <div class="fixed top-6 left-6 z-50">
                <a href="{{ route('guest.dashboard') }}" 
                   class="group inline-flex items-center p-2 text-gray-800 hover:text-gray-900 transition-all duration-300">
                    <svg class="w-7 h-7 transform group-hover:-translate-x-1 transition-transform duration-200" 
                         fill="none" 
                         stroke="currentColor" 
                         viewBox="0 0 24 24"
                         stroke-width="2.5">
                        <path stroke-linecap="round" 
                              stroke-linejoin="round" 
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
            </div>

            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/paddy.jpg') }}" alt="Background" 
                    class="w-full h-full object-cover">
            </div>

            <form method="POST" action="{{ route('guest.register.store') }}" 
                  class="relative z-10" 
                  enctype="multipart/form-data">
                @csrf
                <!-- Content -->
                <div class="relative z-10">
                    <div class="py-12">
                        <div class="max-w-3xl mx-auto">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 text-gray-900">
                                    <div class="p-8" x-data="{
                                    currentStep: 1,
                                    errors: {},
                                    hasSubmitted: false,
                                    async checkDuplicate(field, value) {
                                        if (!value) return true;
                                        
                                        try {
                                            const response = await fetch(`/guest/check-duplicate/${field}/${value}`);
                                            const data = await response.json();
                                            
                                            if (!data.valid) {
                                                this.errors[field] = data.message;
                                            } else {
                                                delete this.errors[field];
                                            }
                                            return data.valid;
                                        } catch (error) {
                                            console.error(`Error validating ${field}:`, error);
                                            return false;
                                        }
                                    },

                                    clearError(field) {
                                        delete this.errors[field];
                                    },
                                    validateStep1() {
                                        this.errors = {};
                                        let isValid = true;

                                        // Validate name
                                        if (!document.getElementById('name').value) {
                                            this.errors.name = 'Sila masukkan nama';
                                            isValid = false;
                                        }

                                        // Validate no_anggota
                                        if (!document.getElementById('no_anggota').value) {
                                            this.errors.no_anggota = 'Sila masukkan no anggota';
                                            isValid = false;
                                        }

                                        // Validate IC
                                        if (!document.getElementById('ic').value) {
                                            this.errors.ic = 'Sila masukkan no kad pengenalan';
                                            isValid = false;
                                        } else if (!/^\d{12}$/.test(document.getElementById('ic').value)) {
                                            this.errors.ic = 'No kad pengenalan mestilah 12 nombor';
                                            isValid = false;
                                        }

                                        // Validate phone
                                        if (!document.getElementById('phone').value) {
                                            this.errors.phone = 'Sila masukkan no telefon';
                                            isValid = false;
                                        }

                                        // Validate email
                                        if (!document.getElementById('email').value) {
                                            this.errors.email = 'Sila masukkan alamat emel';
                                            isValid = false;
                                        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('email').value)) {
                                            this.errors.email = 'Sila masukkan alamat emel yang sah';
                                            isValid = false;
                                        }

                                        // Validate address fields
                                        if (!document.getElementById('address').value) {
                                            this.errors.address = 'Sila masukkan alamat';
                                            isValid = false;
                                        }

                                        // Validate city fields
                                        if (!document.getElementById('city').value) {
                                            this.errors.city = 'Sila masukkan bandar';
                                            isValid = false;
                                        }

                                        // Validate postcode fields
                                        if (!document.getElementById('postcode').value) {
                                            this.errors.postcode = 'Sila masukkan poskod';
                                            isValid = false;
                                        }

                                        // Validate state fields
                                        if (!document.getElementById('state').value) {
                                            this.errors.state = 'Sila masukkan negeri';
                                            isValid = false;
                                        }

                                        return isValid;
                                    },
                                    
                                    validateStep2() {
                                        this.errors = {};
                                        let isValid = true;

                                        // Validate gender
                                        if (!document.getElementById('gender').value) {
                                            this.errors.gender = 'Sila pilih jantina';
                                            isValid = false;
                                        }

                                        // Validate DOB
                                        if (!document.getElementById('DOB').value) {
                                            this.errors.DOB = 'Sila masukkan tarikh lahir';
                                            isValid = false;
                                        }

                                        // Validate religion
                                        if (!document.getElementById('agama').value) {
                                            this.errors.agama = 'Sila pilih agama';
                                            isValid = false;
                                        }

                                        // Validate race
                                        if (!document.getElementById('bangsa').value) {
                                            this.errors.bangsa = 'Sila pilih bangsa';
                                            isValid = false;
                                        }

                                        // Validate position and grade
                                        if (!document.getElementById('jawatan').value) {
                                            this.errors.jawatan = 'Sila masukkan jawatan';
                                            isValid = false;
                                        }

                                        if (!document.getElementById('gred').value) {
                                            this.errors.gred = 'Sila masukkan gred';
                                            isValid = false;
                                        }

                                        // Validate no_pf
                                        if (!document.getElementById('no_pf').value) {
                                            this.errors.no_pf = 'Sila masukkan no fail peribadi';
                                            isValid = false;
                                        }
                                        
                                        // Validate salary
                                        if (!document.getElementById('salary').value) {
                                            this.errors.salary = 'Sila masukkan gaji';
                                            isValid = false;
                                        }
                                        
                                        // Validate office address fields
                                        if (!document.getElementById('office_address').value) {
                                            this.errors.office_address = 'Sila masukkan alamat pejabat';
                                            isValid = false;
                                        }

                                        // Validate office city fields
                                        if (!document.getElementById('office_city').value) {
                                            this.errors.office_city = 'Sila masukkan bandar pejabat';
                                            isValid = false;
                                        }

                                        // Validate office postcode fields
                                        if (!document.getElementById('office_postcode').value) {
                                            this.errors.office_postcode = 'Sila masukkan poskod pejabat';
                                            isValid = false;
                                        }
                                        
                                        // Validate office state fields
                                        if (!document.getElementById('office_state').value) {
                                            this.errors.office_state = 'Sila masukkan negeri pejabat';
                                            isValid = false;
                                        } 
                                        return isValid;
                                    },

                                    validateStep3() {
                                        this.errors = {};
                                        let isValid = true;

                                        // Validate family members
                                        const familyRows = document.getElementById('familyTableBody').children;
                                        if (familyRows.length === 0) {
                                            alert('Sila tambah ahli keluarga');
                                            isValid = false;
                                        }

                                        return isValid;
                                    },

                                    async handleSubmit(e) {
                                        e.preventDefault();
                                        this.hasSubmitted = true;
                                        
                                        // Check all fields that need duplicate validation
                                        const duplicateChecks = await Promise.all([
                                            this.checkDuplicate('no_anggota', document.getElementById('no_anggota').value),
                                            this.checkDuplicate('ic', document.getElementById('ic').value),
                                            this.checkDuplicate('email', document.getElementById('email').value),
                                            this.checkDuplicate('no_pf', document.getElementById('no_pf').value)
                                        ]);

                                        // If any duplicate check failed
                                        if (duplicateChecks.includes(false)) {
                                            return; // Stop form submission
                                        }

                                        // If there are other validation errors
                                        if (Object.keys(this.errors).length > 0) {
                                            alert('Sila betulkan kesalahan sebelum menghantar borang.');
                                            return;
                                        }

                                        // If all validations pass, submit the form
                                        e.target.submit();
                                    },

                                
                                    }">


                                        <!-- Step Indicator -->
                                        <div class="flex justify-between mb-12 relative px-6">
                                            <!-- Progress Bar -->
                                            <div class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-gray-200 w-full -z-1"></div>
                                            <div class="absolute top-1/2 transform -translate-y-1/2 h-1 bg-primary transition-all duration-500"
                                                :style="'width: ' + ((currentStep - 1) * 25) + '%'"></div>
                                            
                                            <!-- Step Numbers -->
                                            <div class="relative z-10 text-center flex-1">
                                                <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center mx-auto"
                                                    :class="currentStep >= 1 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                                    <span class="text-lg font-medium">1</span>
                                                </div>
                                                <p class="mt-2 text-sm font-medium" 
                                                :class="currentStep >= 1 ? 'text-primary' : 'text-gray-400'">
                                                    Maklumat Peribadi
                                                </p>
                                            </div>

                                            <div class="relative z-10 text-center flex-1">
                                                <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center mx-auto"
                                                    :class="currentStep >= 2 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                                    <span class="text-lg font-medium">2</span>
                                                </div>
                                                <p class="mt-2 text-sm font-medium" 
                                                :class="currentStep >= 2 ? 'text-primary' : 'text-gray-400'">
                                                    Maklumat Pekerjaan
                                                </p>
                                            </div>

                                            <div class="relative z-10 text-center flex-1">
                                                <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center mx-auto"
                                                    :class="currentStep >= 3 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                                    <span class="text-lg font-medium">3</span>
                                                </div>
                                                <p class="mt-2 text-sm font-medium" 
                                                :class="currentStep >= 3 ? 'text-primary' : 'text-gray-400'">
                                                    Maklumat Keluarga
                                                </p>
                                            </div>

                                            <div class="relative z-10 text-center flex-1">
                                                <div class="w-10 h-10 rounded-full transition-all duration-500 flex items-center justify-center mx-auto"
                                                    :class="currentStep >= 4 ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600'">
                                                    <span class="text-lg font-medium">4</span>
                                                </div>
                                                <p class="mt-2 text-sm font-medium" 
                                                :class="currentStep >= 4 ? 'text-primary' : 'text-gray-400'">
                                                    Yuran dan Sumbangan
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Step 1: Personal Information -->
                                        <div x-show="currentStep === 1">
                                            <div class="bg-white shadow-md rounded-lg mb-4">
                                                <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-4 rounded-t-lg">
                                                    <h3 class="text-xl font-semibold text-white">
                                                        Maklumat Peribadi
                                                    </h3>
                                                </div>

                                                <div class="p-6 space-y-6">
                                                    <!-- Name and Member Number -->
                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <x-input-label for="name" value="Nama Pendaftar" class="font-semibold text-gray-700" />
                                                            <x-text-input id="name" name="name" type="text" 
                                                                class="mt-1 block w-full" required autofocus 
                                                                placeholder="Masukkan nama penuh" />
                                                                <p x-show="errors.name" 
                                                                    x-text="errors.name" 
                                                                    class="mt-1 text-sm text-red-600"></p>               
                                                        </div>

                                                        <div>
                                                            <x-input-label for="no_anggota" value="No. Anggota" class="font-semibold text-gray-700" />
                                                            <x-text-input id="no_anggota" name="no_anggota" type="text" 
                                                                class="mt-1 block w-full" required 
                                                                placeholder="Masukkan nombor anggota" 
                                                                @input="hasSubmitted ? await checkDuplicate('no_anggota', $event.target.value) : clearError('no_anggota')"  
                                                                @blur="checkDuplicate('no_anggota', $event.target.value)" />
                                                                <p x-show="errors.no_anggota" 
                                                                    x-text="errors.no_anggota" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>

                                                    <!-- IC and Phone -->
                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <x-input-label for="ic" value="No. K/P" class="font-semibold text-gray-700" />
                                                            <x-text-input id="ic" name="ic" type="text" 
                                                                class="mt-1 block w-full" required 
                                                                placeholder="Masukkan nombor kad pengenalan"
                                                                @input="hasSubmitted ? await checkDuplicate('ic', $event.target.value) : clearError('ic')" 
                                                                @blur="checkDuplicate('ic', $event.target.value)" />
                                                                <p x-show="errors.ic" 
                                                                    x-text="errors.ic" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="phone" value="No. Telefon" class="font-semibold text-gray-700" />
                                                            <x-text-input id="phone" name="phone" type="text" 
                                                                class="mt-1 block w-full" required 
                                                                placeholder="Masukkan nombor telefon" />
                                                                <p x-show="errors.phone" 
                                                                    x-text="errors.phone" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>

                                                    <!-- Email -->
                                                    <div>
                                                        <x-input-label for="email" value="Email" class="font-semibold text-gray-700" />
                                                        <x-text-input id="email" name="email" type="email" 
                                                            class="mt-1 block w-full" required 
                                                            placeholder="Masukkan alamat email"
                                                            @input="hasSubmitted ? await checkDuplicate('email', $event.target.value) : clearError('email')"  
                                                            @blur="checkDuplicate('email', $event.target.value)"/>
                                                            <p x-show="errors.email" 
                                                                    x-text="errors.email" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <!-- Address -->
                                                    <div>
                                                        <x-input-label for="address" value="Alamat" class="font-semibold text-gray-700" />
                                                        <textarea id="address" name="address" 
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" 
                                                            rows="3" required placeholder="Masukkan alamat penuh"></textarea>
                                                            <p x-show="errors.address" 
                                                                    x-text="errors.address" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <!-- City, Postcode, State -->
                                                    <div class="grid grid-cols-3 gap-6">
                                                        <div>
                                                            <x-input-label for="city" value="Bandar" class="font-semibold text-gray-700" />
                                                            <x-text-input id="city" name="city" type="text" 
                                                                class="mt-1 block w-full" required 
                                                                placeholder="Masukkan nama bandar" />
                                                                <p x-show="errors.city" 
                                                                    x-text="errors.city" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="postcode" value="Poskod" class="font-semibold text-gray-700" />
                                                            <x-text-input id="postcode" name="postcode" type="text" 
                                                                class="mt-1 block w-full" required maxlength="5"
                                                                placeholder="Masukkan poskod" />
                                                                <p x-show="errors.postcode" 
                                                                    x-text="errors.postcode" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="state" value="Negeri" class="font-semibold text-gray-700" />
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
                                                            <p x-show="errors.state" 
                                                                    x-text="errors.state" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Navigation -->
                                            <div class="mt-6 flex justify-end">
                                                <button type="button"  
                                                    @click="async () => {
                                                        const duplicateChecks = await Promise.all([
                                                            checkDuplicate('no_anggota', document.getElementById('no_anggota').value),
                                                            checkDuplicate('ic', document.getElementById('ic').value),
                                                            checkDuplicate('email', document.getElementById('email').value)
                                                        ]);
                                                        
                                                        // Only proceed if no duplicates and validation passes
                                                        if (!duplicateChecks.includes(false) && validateStep1()) {
                                                            currentStep = 2;
                                                        }
                                                    }"
                                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                                    Seterusnya
                                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <!-- Step 2: Family Information -->
                                        <div x-show="currentStep === 2" x-cloak>
                                            <div class="bg-white shadow-md rounded-lg mb-4">
                                                <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-4 rounded-t-lg">
                                                    <h3 class="text-xl font-semibold text-white">
                                                        Maklumat Pekerjaan & Peribadi
                                                    </h3>
                                                </div>

                                                <div class="p-6 space-y-6">
                                                    <!-- Personal Details -->
                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <x-input-label for="gender" value="Jantina" class="font-semibold text-gray-700" />
                                                            <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                                <option value="">Pilih Jantina</option>
                                                                <option value="Lelaki">Lelaki</option>
                                                                <option value="Perempuan">Perempuan</option>
                                                            </select>
                                                            <p x-show="errors.gender" 
                                                                    x-text="errors.gender" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="DOB" value="Tarikh Lahir" class="font-semibold text-gray-700" />
                                                            <x-text-input type="date" id="DOB" name="DOB" 
                                                            class="mt-1 block w-full" required 
                                                            placeholder="Masukkan tarikh lahir " />
                                                            <p x-show="errors.DOB" 
                                                                    x-text="errors.DOB" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <x-input-label for="agama" value="Agama" class="font-semibold text-gray-700" />
                                                            <select id="agama" name="agama" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                                <option value="">Pilih Agama</option>
                                                                <option value="Islam">Islam</option>
                                                                <option value="Kristian">Kristian</option>
                                                                <option value="Buddha">Buddha</option>
                                                                <option value="Hindu">Hindu</option>
                                                                <option value="Lain-lain">Lain-lain</option>
                                                            </select>
                                                            <p x-show="errors.agama" 
                                                                x-text="errors.agama" 
                                                                class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="bangsa" value="Bangsa" class="font-semibold text-gray-700" />
                                                            <select id="bangsa" name="bangsa" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                                <option value="">Pilih Bangsa</option>
                                                                <option value="Melayu">Melayu</option>
                                                                <option value="Cina">Cina</option>
                                                                <option value="India">India</option>
                                                                <option value="Lain-lain">Lain-lain</option>
                                                            </select>
                                                            <p x-show="errors.bangsa" 
                                                                x-text="errors.bangsa" 
                                                                class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>

                                                    <!-- Work Information -->
                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <x-input-label for="jawatan" value="Jawatan" class="font-semibold text-gray-700" />
                                                            <x-text-input id="jawatan" name="jawatan" type="text" 
                                                            class="mt-1 block w-full" required 
                                                            placeholder="Masukkan jawatan anda " />
                                                            <p x-show="errors.jawatan" 
                                                                    x-text="errors.jawatan" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="gred" value="Gred" class="font-semibold text-gray-700" />
                                                            <x-text-input id="gred" name="gred" type="text" 
                                                            class="mt-1 block w-full" required 
                                                            placeholder="Masukkan gred anda " />
                                                            <p x-show="errors.gred" 
                                                                    x-text="errors.gred" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>

                                                    <div class="grid grid-cols-2 gap-6">
                                                        <div>
                                                            <x-input-label for="no_pf" value="No. Fail Peribadi" class="font-semibold text-gray-700" />
                                                            <x-text-input id="no_pf" name="no_pf" type="text" 
                                                            class="mt-1 block w-full" required
                                                            placeholder="Masukkan nombor fail peribadi" 
                                                                @input="hasSubmitted ? await checkDuplicate('no_pf', $event.target.value) : clearError('pf')"  
                                                                @blur="checkDuplicate('no_pf', $event.target.value)" />
                                                            <p x-show="errors.no_pf" 
                                                                    x-text="errors.no_pf" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="salary" value="Gaji (RM)" class="font-semibold text-gray-700" />
                                                            <x-text-input id="salary" name="salary" type="number" step="0.01" 
                                                            class="mt-1 block w-full" required 
                                                            placeholder="Masukkan gaji(RM) anda " />
                                                            <p x-show="errors.salary" 
                                                                    x-text="errors.salary" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>

                                                    <!-- Office Address -->
                                                    <div>
                                                        <x-input-label for="office_address" value="Alamat Pejabat" class="font-semibold text-gray-700" />
                                                        <textarea id="office_address" name="office_address" 
                                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" 
                                                            rows="3" required
                                                            placeholder="Masukkan alamat pejabat"></textarea>
                                                            <p x-show="errors.office_address" 
                                                                    x-text="errors.office_address" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div class="grid grid-cols-3 gap-6">
                                                        <div>
                                                            <x-input-label for="office_city" value="Bandar" class="font-semibold text-gray-700" />
                                                            <x-text-input id="office_city" name="office_city" type="text" 
                                                            class="mt-1 block w-full" required 
                                                            placeholder="Masukkan nama bandar " />
                                                            <p x-show="errors.office_city" 
                                                                    x-text="errors.office_city" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="office_postcode" value="Poskod" class="font-semibold text-gray-700" />
                                                            <x-text-input id="office_postcode" name="office_postcode" type="text" 
                                                                class="mt-1 block w-full" required maxlength="5" 
                                                                placeholder="Masukkan poskod " />
                                                                <p x-show="errors.office_postcode" 
                                                                    x-text="errors.office_postcode" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>

                                                        <div>
                                                            <x-input-label for="office_state" value="Negeri" class="font-semibold text-gray-700" />
                                                            <select id="office_state" name="office_state" 
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                                                <option value="">Pilih Negeri</option>
                                                                <!-- Same state options as before -->
                                                                @foreach(['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Pulau Pinang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'W.P. Kuala Lumpur', 'W.P. Labuan', 'W.P. Putrajaya'] as $state)
                                                                    <option value="{{ $state }}">{{ $state }}</option>
                                                                @endforeach
                                                            </select>
                                                            <p x-show="errors.office_state" 
                                                                    x-text="errors.office_state" 
                                                                    class="mt-1 text-sm text-red-600"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Navigation -->
                                            <div class="mt-6 flex justify-between">
                                                <button type="button" @click="currentStep = 1"
                                                        class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                    </svg>
                                                    Sebelumnya
                                                </button>
                                                <button type="button" 
                                                    @click="async () => {
                                                            const duplicateChecks = await Promise.all([
                                                                checkDuplicate('no_pf', document.getElementById('no_pf').value),

                                                            ]);
                                                            
                                                            // Only proceed if no duplicates and validation passes
                                                            if (!duplicateChecks.includes(false) && validateStep2()) {
                                                                currentStep = 3;
                                                            }
                                                        }"
                                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                                    Seterusnya
                                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Step 3: Family Members -->
                                        <div x-show="currentStep === 3" x-cloak>
                                            <div class="bg-white shadow-md rounded-lg mb-4">
                                                <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-4 rounded-t-lg">
                                                    <h3 class="text-xl font-semibold text-white">
                                                        Maklumat Keluarga
                                                    </h3>
                                                </div>

                                                <div class="p-6">
                                                    <!-- Family Members Table -->
                                                    <div class="overflow-x-auto">
                                                        <table class="min-w-full divide-y divide-gray-200">
                                                            <thead>
                                                                <tr>
                                                                    <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Bil</th>
                                                                    <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                                                    <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">No. K/P</th>
                                                                    <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Hubungan</th>
                                                                    <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase w-20">Tindakan</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="familyTableBody" class="bg-white divide-y divide-gray-200">
                                                                <!-- Family members will be added here dynamically -->
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- Add Family Member Button -->
                                                    <div class="mt-4">
                                                        <button type="button" onclick="addFamilyMember()"
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                            </svg>
                                                            Tambah Ahli Keluarga
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Navigation -->
                                            <div class="mt-6 flex justify-between">
                                                <button type="button" @click="currentStep = 2"
                                                        class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                    </svg>
                                                    Sebelumnya
                                                </button>
                                                <button type="button" @click="currentStep = 4"
                                                        class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                                    Seterusnya
                                                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Step 4: Fees and Contributions -->
                                        <div x-show="currentStep === 4" x-cloak>
                                            <div class="bg-white shadow-md rounded-lg mb-4">
                                                <div class="bg-gradient-to-r from-blue-600 to-blue-400 p-4 rounded-t-lg">
                                                    <h3 class="text-xl font-semibold text-white">
                                                        Yuran dan Sumbangan
                                                    </h3>
                                                </div>

                                                <div class="p-6">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead>
                                                            <tr>
                                                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase w-16">Bil</th>
                                                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Perkara</th>
                                                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase w-48">RM</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <!-- Fee rows -->
                                                            @foreach([
                                                                'entrance' => ['label' => 'Yuran Masuk', 'value' => 50, 'fixed' => true],
                                                                'share_capital' => ['label' => 'Modal Syer', 'value' => 300, 'min' => true],
                                                                'subscription_capital' => ['label' => 'Modal Yuran', 'value' => 35, 'min' => true],
                                                                'member_deposit' => ['label' => 'Wang Deposit Anggota', 'value' => 20, 'min' => true],
                                                                'welfare_fund' => ['label' => 'Sumbangan Tabung Kebajikan (Al-Abrar)', 'value' => 5, 'fixed' => true],
                                                                'fixed_savings' => ['label' => 'Simpanan Tetap', 'value' => 5, 'fixed' => true]
                                                            ] as $key => $fee)
                                                            <tr>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                                    {{ $fee['label'] }}
                                                                    @if(isset($fee['min']))
                                                                        <span class="text-sm text-gray-500">(Minimum: RM{{ number_format($fee['value'], 2) }})</span>
                                                                    @endif
                                                                </td>
                                                                <td class="px-6 py-4 whitespace-nowrap">
                                                                    <div class="relative">
                                                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-600">
                                                                            RM
                                                                        </span>
                                                                        <input type="number" 
                                                                            step="0.01" 
                                                                            name="fees[{{ $key }}]" 
                                                                            class="pl-12 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                                                                            required
                                                                            value="{{ $fee['value'] }}"
                                                                            {{ ($fee['fixed'] ?? false) ? 'readonly' : '' }}
                                                                            {{ (!($fee['fixed'] ?? false)) ? 'min='.$fee['value'] : '' }}
                                                                            data-min="{{ $fee['value'] }}"
                                                                            data-fixed="{{ $fee['fixed'] ?? false }}"
                                                                        />
                                                                        <div class="hidden text-red-500 text-sm mt-1 error-message"></div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            @endforeach

                                                            <!-- Total row -->
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
                                                            </div>
                                                            <!-- Selected indicator -->
                                                            <div class="absolute top-2 right-2" x-show="paymentMethod === 'online'">
                                                                <i class="fas fa-check-circle text-blue-500 text-xl"></i>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>

                                                <!-- Cash Payment Message -->
                                                <div x-show="paymentMethod === 'cash'"
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 transform scale-95"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg"
                                                    x-cloak>
                                                    <div class="flex items-center">
                                                        <i class="fas fa-info-circle text-green-500 text-xl mr-3"></i>
                                                        <p class="text-green-700">
                                                            Sila pergi ke kaunter hadapan untuk membuat pembayaran secara tunai.
                                                        </p>
                                                    </div>
                                                </div>

                                                <!-- Payment Proof Upload -->
                                                <div x-show="paymentMethod === 'online'" 
                                                    x-transition:enter="transition ease-out duration-300"
                                                    x-transition:enter-start="opacity-0 transform scale-95"
                                                    x-transition:enter-end="opacity-100 transform scale-100"
                                                    x-cloak>
                                                    <div class="mt-4">
                                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                                            Bukti Pembayaran <span class="text-red-500">*</span>
                                                        </label>
                                                        
                                                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6"
                                                            x-data="{ fileName: null }"
                                                            @dragover.prevent="$el.classList.add('border-blue-500', 'bg-blue-50')"
                                                            @dragleave.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50')"
                                                            @drop.prevent="$el.classList.remove('border-blue-500', 'bg-blue-50')">
                                                            
                                                            <!-- Hidden file input with dynamic required attribute -->
                                                            <input type="file" 
                                                                id="payment_proof" 
                                                                name="payment_proof" 
                                                                class="hidden"
                                                                accept="image/*"
                                                                :required="paymentMethod === 'online'"
                                                                @change="fileName = $event.target.files[0].name">
                                                            
                                                            <!-- Upload Interface -->
                                                            <div class="text-center" x-show="!fileName">
                                                                <div class="mx-auto h-24 w-24 text-gray-400 mb-4">
                                                                    <i class="fas fa-cloud-upload-alt text-5xl"></i>
                                                                </div>
                                                                <div class="flex flex-col items-center">
                                                                    <label for="payment_proof" 
                                                                        class="mb-2 px-6 py-2.5 bg-blue-500 text-white rounded-md cursor-pointer 
                                                                        hover:bg-blue-600 transition-colors duration-200 font-medium">
                                                                        Pilih Fail
                                                                    </label>
                                                                    <p class="text-xs text-gray-400 mt-2">PNG, JPG, GIF sehingga 5MB</p>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- File Selected State -->
                                                            <div class="text-center" x-show="fileName">
                                                                <div class="flex items-center justify-center space-x-2">
                                                                    <i class="fas fa-file-image text-blue-500 text-xl"></i>
                                                                    <span class="text-sm text-gray-600" x-text="fileName"></span>
                                                                </div>
                                                                <button type="button" 
                                                                        class="mt-4 px-4 py-2 text-sm text-red-600 hover:text-red-800 
                                                                    hover:bg-red-50 rounded-md transition-colors duration-200"
                                                                        @click="fileName = null; document.getElementById('payment_proof').value = ''">
                                                                    <i class="fas fa-trash-alt mr-1"></i> Buang Fail
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <!-- Error message -->
                                                        <div class="mt-1 text-sm text-red-600" x-show="paymentMethod === 'online' && !fileName">
                                                            Sila muat naik bukti pembayaran
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Navigation -->
                                            <div class="mt-6 flex justify-between">
                                                <button type="button" @click="currentStep = 3"
                                                        class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                                    <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                    </svg>
                                                    Sebelumnya
                                                </button>
                                                
                                                <div class="flex items-center space-x-3">
                                                    <x-secondary-button type="reset">
                                                        {{ __('Set Semula') }}
                                                    </x-secondary-button>
                                                    <x-primary-button type="submit">
                                                        {{ __('Hantar') }}
                                                    </x-primary-button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- JavaScript for Family Members Table -->
        <script>
            let rowCount = 0;
            
            function addFamilyMember() {
                const tbody = document.getElementById('familyTableBody');
                rowCount++;
                
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="px-4 py-3 text-sm text-gray-900">${rowCount}</td>
                    <td class="px-4 py-3">
                        <input type="text" name="family[${rowCount}][name]" class="w-full rounded-md border-gray-300" required>
                    </td>
                    <td class="px-4 py-3">
                        <input type="text" name="family[${rowCount}][ic]" class="w-full rounded-md border-gray-300" required>
                    </td>
                    <td class="px-4 py-3">
                        <select name="family[${rowCount}][relationship]" class="w-full rounded-md border-gray-300" required>
                            <option value="">Pilih Hubungan</option>
                            <option value="Isteri">Isteri</option>
                            <option value="Suami">Suami</option>
                            <option value="Anak">Anak</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Bapa">Bapa</option>
                            <option value="Adik-beradik">Adik-beradik</option>
                        </select>
                    </td>
                    <td class="px-4 py-3">
                        <button type="button" onclick="this.closest('tr').remove(); updateRowNumbers()"
                                class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
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

            // Auto-calculate total amount
            document.addEventListener('DOMContentLoaded', function() {
                const feeInputs = document.querySelectorAll('input[name^="fees["]');
                const totalInput = document.getElementById('total_amount');
                
                function calculateTotal() {
                    let total = 0;
                    feeInputs.forEach(input => {
                        // Remove 'RM' and any whitespace before parsing
                        const value = input.value.replace(/[^0-9.-]+/g, '');
                        total += parseFloat(value || 0);
                    });
                    // Format total with 2 decimal places
                    totalInput.value = total.toFixed(2);
                }
                
                feeInputs.forEach(input => {
                    const errorDiv = input.parentElement.querySelector('.error-message');
                    if (errorDiv) {
                        errorDiv.style.visibility = 'hidden';
                        errorDiv.style.height = '20px';
                        errorDiv.style.margin = '4px 0';
                    }
                    
                    // Set initial values for fixed amounts
                    const isFixed = input.dataset.fixed === 'true';
                    if (isFixed) {
                        input.value = parseFloat(input.dataset.min).toFixed(2);
                    }
                    
                    input.addEventListener('input', function() {
                        calculateTotal();
                        
                        const minValue = parseFloat(this.dataset.min);
                        const isFixed = this.dataset.fixed === 'true';
                        const value = parseFloat(this.value || 0);
                        
                        if (errorDiv) {
                            if (isFixed && value !== minValue) {
                                errorDiv.textContent = `Jumlah tetap RM${minValue.toFixed(2)}`;
                                errorDiv.style.visibility = 'visible';
                                this.value = minValue.toFixed(2);
                            } else if (!isFixed && value < minValue) {
                                errorDiv.textContent = `Jumlah minimum RM${minValue.toFixed(2)}`;
                                errorDiv.style.visibility = 'visible';
                            } else {
                                errorDiv.style.visibility = 'hidden';
                            }
                        }
                    });
                });

                // Calculate initial total
                calculateTotal();
            });

            // Form submission validation
            document.querySelector('form').addEventListener('submit', function(e) {
                const feeInputs = document.querySelectorAll('input[name^="fees["]');
                let hasError = false;

                feeInputs.forEach(input => {
                    const minValue = parseFloat(input.dataset.min);
                    const value = parseFloat(input.value || 0);
                    const errorDiv = input.parentElement.querySelector('.error-message');

                    if (value < minValue) {
                        hasError = true;
                        errorDiv.textContent = `Minimum amount required is RM${minValue.toFixed(2)}`;
                        errorDiv.style.visibility = 'visible';
                    }
                });

                if (hasError) {
                    e.preventDefault();
                    alert('Please correct the errors in the fee amounts before proceeding.');
                }
            });
        </script>
    </body>
</html>