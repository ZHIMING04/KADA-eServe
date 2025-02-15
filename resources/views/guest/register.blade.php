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
        <div class="min-h-screen relative" 
             x-data="{ 
                currentStep: 1, 
                totalSteps: 4,
                errors: {},
                memberData: {
                    no_anggota: '',
                    name: '',
                    email: '',
                    ic: '',
                    phone: '',
                    address: '',
                    city: '',
                    postcode: '',
                    state: '',
                    gender: '',
                    DOB: '',
                    agama: '',
                    bangsa: '',
                    jawatan: '',
                    gred: '',
                    no_pf: '',
                    salary: '',
                    office_address: '',
                    office_city: '',
                    office_postcode: '',
                    office_state: ''
                },
                familyMembers: [],
                fees: {
                    entrance: 50,
                    share_capital: 300,
                    subscription_capital: 35,
                    member_deposit: 20,
                    welfare_fund: 5,
                    fixed_savings: 5
                },
                paymentMethod: '',

                validateStep1() {
                    console.log('validateStep1 called');
                    this.errors = {};
                    let isValid = true;

                    // No. Anggota validation
                    if (!this.memberData.no_anggota) {
                        this.errors.no_anggota = 'Sila masukkan nombor anggota';
                        isValid = false;
                    }

                    // Name validation
                    if (!this.memberData.name) {
                        this.errors.name = 'Sila masukkan nama';
                        isValid = false;
                    }

                    // Email validation
                    if (!this.memberData.email) {
                        this.errors.email = 'Sila masukkan alamat emel';
                        isValid = false;
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.memberData.email)) {
                        this.errors.email = 'Alamat emel tidak sah';
                        isValid = false;
                    }

                    // IC validation
                    if (!this.memberData.ic) {
                        this.errors.ic = 'Sila masukkan nombor kad pengenalan';
                        isValid = false;
                    } else if (!/^\d{12}$/.test(this.memberData.ic)) {
                        this.errors.ic = 'Nombor kad pengenalan mestilah 12 nombor';
                        isValid = false;
                    }

                    // Phone validation
                    if (!this.memberData.phone) {
                        this.errors.phone = 'Sila masukkan nombor telefon';
                        isValid = false;
                    } else if (!/^\d{10,11}$/.test(this.memberData.phone)) {
                        this.errors.phone = 'Nombor telefon mestilah 10-11 nombor';
                        isValid = false;
                    }

                    // Address validation
                    if (!this.memberData.address) {
                        this.errors.address = 'Sila masukkan alamat';
                        isValid = false;
                    }

                    // City validation
                    if (!this.memberData.city) {
                        this.errors.city = 'Sila masukkan bandar';
                        isValid = false;
                    }

                    // Postcode validation
                    if (!this.memberData.postcode) {
                        this.errors.postcode = 'Sila masukkan poskod';
                        isValid = false;
                    } else if (!/^\d{5}$/.test(this.memberData.postcode)) {
                        this.errors.postcode = 'Poskod mestilah 5 nombor';
                        isValid = false;
                    }

                    // State validation
                    if (!this.memberData.state) {
                        this.errors.state = 'Sila pilih negeri';
                        isValid = false;
                    }

                    console.log('Validation errors:', this.errors);
                    console.log('Validation result:', isValid);
                    return isValid;
                },

                validateStep2() {
                    console.log('validateStep2 called');
                    this.errors = {};
                    let isValid = true;

                    // Gender validation
                    if (!this.memberData.gender) {
                        this.errors.gender = 'Sila pilih jantina';
                        isValid = false;
                    }

                    // Date of Birth validation
                    if (!this.memberData.DOB) {
                        this.errors.DOB = 'Sila masukkan tarikh lahir';
                        isValid = false;
                    }

                    // Religion validation
                    if (!this.memberData.agama) {
                        this.errors.agama = 'Sila pilih agama';
                        isValid = false;
                    }

                    // Race validation
                    if (!this.memberData.bangsa) {
                        this.errors.bangsa = 'Sila pilih bangsa';
                        isValid = false;
                    }

                    // Position validation
                    if (!this.memberData.jawatan) {
                        this.errors.jawatan = 'Sila masukkan jawatan';
                        isValid = false;
                    }

                    // Grade validation
                    if (!this.memberData.gred) {
                        this.errors.gred = 'Sila masukkan gred';
                        isValid = false;
                    }

                    // Personal File Number validation
                    if (!this.memberData.no_pf) {
                        this.errors.no_pf = 'Sila masukkan no. fail peribadi';
                        isValid = false;
                    }

                    // Salary validation
                    if (!this.memberData.salary) {
                        this.errors.salary = 'Sila masukkan gaji';
                        isValid = false;
                    } else if (isNaN(this.memberData.salary) || this.memberData.salary <= 0) {
                        this.errors.salary = 'Sila masukkan gaji yang sah';
                        isValid = false;
                    }

                    // Office Address validation
                    if (!this.memberData.office_address) {
                        this.errors.office_address = 'Sila masukkan alamat pejabat';
                        isValid = false;
                    }

                    // Office City validation
                    if (!this.memberData.office_city) {
                        this.errors.office_city = 'Sila masukkan bandar';
                        isValid = false;
                    }

                    // Office Postcode validation
                    if (!this.memberData.office_postcode) {
                        this.errors.office_postcode = 'Sila masukkan poskod';
                        isValid = false;
                    } else if (!/^\d{5}$/.test(this.memberData.office_postcode)) {
                        this.errors.office_postcode = 'Poskod mestilah 5 nombor';
                        isValid = false;
                    }

                    // Office State validation
                    if (!this.memberData.office_state) {
                        this.errors.office_state = 'Sila pilih negeri';
                        isValid = false;
                    }

                    return isValid;
                },

                validateStep3() {
                    console.log('validateStep3 called');
                    this.errors = {};
                    let isValid = true;

                    // Only validate if there are family members added
                    if (this.familyMembers.length > 0) {
                        // Validate each family member's details
                        this.familyMembers.forEach((member, index) => {
                            if (!member.name) {
                                this.errors[`family.${index}.name`] = 'Sila masukkan nama';
                                isValid = false;
                            }
                            if (!member.ic) {
                                this.errors[`family.${index}.ic`] = 'Sila masukkan no. kad pengenalan';
                                isValid = false;
                            }
                            if (!member.relationship) {
                                this.errors[`family.${index}.relationship`] = 'Sila pilih hubungan';
                                isValid = false;
                            }
                        });
                    }

                    console.log('Family validation result:', isValid);
                    return isValid;
                },

                validateStep4() {
                    console.log('validateStep4 called');
                    this.errors = {};
                    let isValid = true;

                    // Define fee structure
                    const feeStructure = {
                        'entrance': { value: 50, fixed: true },
                        'share_capital': { value: 300, min: true },
                        'subscription_capital': { value: 35, min: true },
                        'member_deposit': { value: 20, min: true },
                        'welfare_fund': { value: 5, fixed: true },
                        'fixed_savings': { value: 5, fixed: true }
                    };

                    // Validate each fee
                    Object.entries(feeStructure).forEach(([key, config]) => {
                        const feeValue = parseFloat(this.fees[key]);
                        
                        if (isNaN(feeValue)) {
                            this.errors[`fees.${key}`] = 'Sila masukkan jumlah yang sah';
                            isValid = false;
                        } else if (config.fixed && feeValue !== config.value) {
                            this.errors[`fees.${key}`] = `Jumlah tetap RM${config.value}`;
                            isValid = false;
                        } else if (config.min && feeValue < config.value) {
                            this.errors[`fees.${key}`] = `Jumlah minimum RM${config.value}`;
                            isValid = false;
                        }
                    });

                    // Validate payment method
                    if (!this.paymentMethod) {
                        this.errors.paymentMethod = 'Sila pilih kaedah pembayaran';
                        isValid = false;
                    }

                    // Validate payment proof for online payment
                    if (this.paymentMethod === 'online') {
                        const paymentProof = document.getElementById('payment_proof');
                        if (!paymentProof || !paymentProof.files || paymentProof.files.length === 0) {
                            this.errors.payment_proof = 'Sila muat naik bukti pembayaran';
                            isValid = false;
                        }
                    }

                    console.log('Fee validation result:', isValid);
                    return isValid;
                },

                validateCurrentStep() {
                    console.log('validateCurrentStep called for step:', this.currentStep);
                    switch(this.currentStep) {
                        case 1: return this.validateStep1();
                        case 2: return this.validateStep2();
                        case 3: return this.validateStep3();
                        case 4: return this.validateStep4();
                        default: return false;
                    }
                },

                clearError(field) {
                    delete this.errors[field];
                },

                nextStep() {
                    console.log('nextStep called');
                    if (this.validateCurrentStep()) {
                        this.currentStep++;
                        console.log('Moving to step:', this.currentStep);
                    } else {
                        console.log('Validation failed');
                    }
                },

                resetForm() {
                    // Implement the reset logic here
                    console.log('Reset form');
                }
             }">
            <!-- Add debug elements -->
            <div class="bg-yellow-100 p-2 m-2">
                Current Step: <span x-text="currentStep"></span>
                <br>
                Total Steps: <span x-text="totalSteps"></span>
                <br>
                Name: <span x-text="memberData.name"></span>
            </div>

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
                                                        <x-text-input id="name" 
                                                                     name="name" 
                                                                     type="text"
                                                                     x-model="memberData.name"
                                                                     @input="clearError('name')"
                                                                     placeholder="Masukkan nama penuh anda"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.name" 
                                                           x-text="errors.name" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="no_anggota" value="No. Anggota" class="font-semibold text-gray-700" />
                                                        <x-text-input id="no_anggota" 
                                                                     name="no_anggota" 
                                                                     type="text"
                                                                     x-model="memberData.no_anggota"
                                                                     @input="clearError('no_anggota')"
                                                                     placeholder="Contoh: A23CS0189"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.no_anggota" 
                                                           x-text="errors.no_anggota" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>
                                                </div>

                                                <!-- IC and Phone -->
                                                <div class="grid grid-cols-2 gap-6">
                                                    <div>
                                                        <x-input-label for="ic" value="No. K/P" class="font-semibold text-gray-700" />
                                                        <x-text-input id="ic" 
                                                                     name="ic" 
                                                                     type="text"
                                                                     x-model="memberData.ic"
                                                                     @input="clearError('ic')"
                                                                     placeholder="Contoh: 041118011233"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.ic" 
                                                           x-text="errors.ic" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="phone" value="No. Telefon" class="font-semibold text-gray-700" />
                                                        <x-text-input id="phone" 
                                                                     name="phone" 
                                                                     type="text"
                                                                     x-model="memberData.phone"
                                                                     @input="clearError('phone')"
                                                                     placeholder="Contoh: 0195729461"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.phone" 
                                                           x-text="errors.phone" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>
                                                </div>

                                                <!-- Email -->
                                                <div>
                                                    <x-input-label for="email" value="Email" class="font-semibold text-gray-700" />
                                                    <x-text-input id="email" 
                                                                 name="email" 
                                                                 type="email"
                                                                 x-model="memberData.email"
                                                                 @input="clearError('email')"
                                                                 placeholder="Contoh: bryanzhiming@gmail.com"
                                                                 class="mt-1 block w-full" />
                                                    <p x-show="errors.email" 
                                                       x-text="errors.email" 
                                                       class="mt-1 text-sm text-red-600"></p>
                                                </div>

                                                <!-- Address -->
                                                <div>
                                                    <x-input-label for="address" value="Alamat" class="font-semibold text-gray-700" />
                                                    <x-text-input id="address" 
                                                                 name="address" 
                                                                 type="text"
                                                                 x-model="memberData.address"
                                                                 @input="clearError('address')"
                                                                 placeholder="Contoh: UTM JB"
                                                                 class="mt-1 block w-full" />
                                                    <p x-show="errors.address" 
                                                       x-text="errors.address" 
                                                       class="mt-1 text-sm text-red-600"></p>
                                                </div>

                                                <!-- City, Postcode, and State -->
                                                <div class="grid grid-cols-3 gap-6">
                                                    <div>
                                                        <x-input-label for="city" value="Bandar" class="font-semibold text-gray-700" />
                                                        <x-text-input id="city" 
                                                                     name="city" 
                                                                     type="text"
                                                                     x-model="memberData.city"
                                                                     @input="clearError('city')"
                                                                     placeholder="Contoh: JOHOR"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.city" 
                                                           x-text="errors.city" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="postcode" value="Poskod" class="font-semibold text-gray-700" />
                                                        <x-text-input id="postcode" 
                                                                     name="postcode" 
                                                                     type="text"
                                                                     x-model="memberData.postcode"
                                                                     @input="clearError('postcode')"
                                                                     placeholder="Contoh: 84040"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.postcode" 
                                                           x-text="errors.postcode" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="state" value="Negeri" class="font-semibold text-gray-700" />
                                                        <select id="state" 
                                                                name="state" 
                                                                x-model="memberData.state"
                                                                @change="clearError('state')"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                            <option value="">Pilih Negeri</option>
                                                            @foreach(['Johor', 'Kedah', 'Kelantan', 'Melaka', 'Negeri Sembilan', 'Pahang', 'Perak', 'Perlis', 'Pulau Pinang', 'Sabah', 'Sarawak', 'Selangor', 'Terengganu', 'W.P. Kuala Lumpur', 'W.P. Labuan', 'W.P. Putrajaya'] as $state)
                                                                <option value="{{ $state }}">{{ $state }}</option>
                                                            @endforeach
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
                                                    x-show="currentStep < totalSteps"
                                                    @click="nextStep()"
                                                    class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                                Seterusnya
                                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Step 2: Work Information -->
                                    <div x-show="currentStep === 2">
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
                                                        <select id="gender" 
                                                                name="gender" 
                                                                x-model="memberData.gender"
                                                                @change="clearError('gender')"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                                                        <x-text-input type="date" 
                                                                     id="DOB" 
                                                                     name="DOB"
                                                                     x-model="memberData.DOB"
                                                                     @input="clearError('DOB')"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.DOB" 
                                                           x-text="errors.DOB" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div>
                                                        <x-input-label for="agama" value="Agama" class="font-semibold text-gray-700" />
                                                        <select id="agama" 
                                                                name="agama" 
                                                                x-model="memberData.agama"
                                                                @change="clearError('agama')"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                                                        <select id="bangsa" 
                                                                name="bangsa" 
                                                                x-model="memberData.bangsa"
                                                                @change="clearError('bangsa')"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                                                        <x-text-input id="jawatan" 
                                                                     name="jawatan" 
                                                                     type="text"
                                                                     x-model="memberData.jawatan"
                                                                     @input="clearError('jawatan')"
                                                                     placeholder="Masukkan jawatan anda"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.jawatan" 
                                                           x-text="errors.jawatan" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="gred" value="Gred" class="font-semibold text-gray-700" />
                                                        <x-text-input id="gred" 
                                                                     name="gred" 
                                                                     type="text"
                                                                     x-model="memberData.gred"
                                                                     @input="clearError('gred')"
                                                                     placeholder="Contoh: N41"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.gred" 
                                                           x-text="errors.gred" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>
                                                </div>

                                                <div class="grid grid-cols-2 gap-6">
                                                    <div>
                                                        <x-input-label for="no_pf" value="No. Fail Peribadi" class="font-semibold text-gray-700" />
                                                        <x-text-input id="no_pf" 
                                                                     name="no_pf" 
                                                                     type="text"
                                                                     x-model="memberData.no_pf"
                                                                     @input="clearError('no_pf')"
                                                                     placeholder="Masukkan no. fail peribadi"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.no_pf" 
                                                           x-text="errors.no_pf" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="salary" value="Gaji (RM)" class="font-semibold text-gray-700" />
                                                        <x-text-input id="salary" 
                                                                     name="salary" 
                                                                     type="number"
                                                                     step="0.01"
                                                                     x-model="memberData.salary"
                                                                     @input="clearError('salary')"
                                                                     placeholder="Contoh: 3500.00"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.salary" 
                                                           x-text="errors.salary" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>
                                                </div>

                                                <!-- Office Address -->
                                                <div>
                                                    <x-input-label for="office_address" value="Alamat Pejabat" class="font-semibold text-gray-700" />
                                                    <x-text-input id="office_address" 
                                                                 name="office_address" 
                                                                 type="text"
                                                                 x-model="memberData.office_address"
                                                                 @input="clearError('office_address')"
                                                                 placeholder="Masukkan alamat pejabat"
                                                                 class="mt-1 block w-full" />
                                                    <p x-show="errors.office_address" 
                                                       x-text="errors.office_address" 
                                                       class="mt-1 text-sm text-red-600"></p>
                                                </div>

                                                <div class="grid grid-cols-3 gap-6">
                                                    <div>
                                                        <x-input-label for="office_city" value="Bandar" class="font-semibold text-gray-700" />
                                                        <x-text-input id="office_city" 
                                                                     name="office_city" 
                                                                     type="text"
                                                                     x-model="memberData.office_city"
                                                                     @input="clearError('office_city')"
                                                                     placeholder="Masukkan bandar"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.office_city" 
                                                           x-text="errors.office_city" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="office_postcode" value="Poskod" class="font-semibold text-gray-700" />
                                                        <x-text-input id="office_postcode" 
                                                                     name="office_postcode" 
                                                                     type="text"
                                                                     x-model="memberData.office_postcode"
                                                                     @input="clearError('office_postcode')"
                                                                     placeholder="Contoh: 81310"
                                                                     class="mt-1 block w-full" />
                                                        <p x-show="errors.office_postcode" 
                                                           x-text="errors.office_postcode" 
                                                           class="mt-1 text-sm text-red-600"></p>
                                                    </div>

                                                    <div>
                                                        <x-input-label for="office_state" value="Negeri" class="font-semibold text-gray-700" />
                                                        <select id="office_state" 
                                                                name="office_state" 
                                                                x-model="memberData.office_state"
                                                                @change="clearError('office_state')"
                                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                                            <option value="">Pilih Negeri</option>
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
                                                    x-show="currentStep < totalSteps"
                                                    @click="nextStep()"
                                                    class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                                Seterusnya
                                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Family Members -->
                                    <div x-show="currentStep === 3">
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
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                            <template x-for="(member, index) in familyMembers" :key="index">
                                                                <tr>
                                                                    <td class="px-4 py-3" x-text="index + 1"></td>
                                                                    <td class="px-4 py-3">
                                                                        <input type="text" 
                                                                               x-model="member.name"
                                                                               @input="clearError(`family.${index}.name`)"
                                                                               class="border-gray-300 rounded-md shadow-sm w-full"
                                                                               placeholder="Nama ahli keluarga">
                                                                        <p x-show="errors[`family.${index}.name`]" 
                                                                           x-text="errors[`family.${index}.name`]"
                                                                           class="mt-1 text-sm text-red-600"></p>
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <input type="text" 
                                                                               x-model="member.ic"
                                                                               @input="clearError(`family.${index}.ic`)"
                                                                               class="border-gray-300 rounded-md shadow-sm w-full"
                                                                               placeholder="No. K/P">
                                                                        <p x-show="errors[`family.${index}.ic`]" 
                                                                           x-text="errors[`family.${index}.ic`]"
                                                                           class="mt-1 text-sm text-red-600"></p>
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <select x-model="member.relationship"
                                                                                @change="clearError(`family.${index}.relationship`)"
                                                                                class="border-gray-300 rounded-md shadow-sm w-full">
                                                                            <option value="">Pilih Hubungan</option>
                                                                            <option value="Suami">Suami</option>
                                                                            <option value="Isteri">Isteri</option>
                                                                            <option value="Anak">Anak</option>
                                                                            <option value="Ibu">Ibu</option>
                                                                            <option value="Bapa">Bapa</option>
                                                                        </select>
                                                                        <p x-show="errors[`family.${index}.relationship`]" 
                                                                           x-text="errors[`family.${index}.relationship`]"
                                                                           class="mt-1 text-sm text-red-600"></p>
                                                                    </td>
                                                                    <td class="px-4 py-3">
                                                                        <button type="button" 
                                                                                @click="familyMembers.splice(index, 1)"
                                                                                class="text-red-600 hover:text-red-800">
                                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                            </svg>
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            </template>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <!-- Add Family Member Button -->
                                                <div class="mt-4">
                                                    <button type="button" 
                                                            @click="familyMembers.push({name: '', ic: '', relationship: ''})"
                                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700">
                                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                        </svg>
                                                        Tambah Ahli Keluarga
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Navigation Buttons -->
                                        <div class="mt-6 flex justify-between">
                                            <button type="button" @click="currentStep = 2"
                                                    class="inline-flex items-center px-8 py-3 bg-gray-100 text-gray-700 font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                                <svg class="mr-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                                Sebelumnya
                                            </button>
                                            <button type="button" 
                                                    x-show="currentStep < totalSteps"
                                                    @click="nextStep()"
                                                    class="inline-flex items-center px-8 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary-hover transition-colors duration-200">
                                                Seterusnya
                                                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Step 4: Fees and Contributions -->
                                    <div x-show="currentStep === 4">
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
                                                                    <input type="number" 
                                                                           name="fees[{{ $key }}]" 
                                                                           x-model="fees.{{ $key }}"
                                                                           @input="clearError(`fees.${key}`)"
                                                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                                           step="0.01" 
                                                                           :readonly="{{ $fee['fixed'] ?? 'false' }}"
                                                                           value="{{ $fee['value'] }}">
                                                                    <p x-show="errors[`fees.${key}`]" 
                                                                       x-text="errors[`fees.${key}`]"
                                                                       class="mt-1 text-sm text-red-600"></p>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <!-- Payment Method -->
                                                <div class="mt-8">
                                                    <h4 class="text-lg font-semibold mb-4">Kaedah Pembayaran</h4>
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <!-- Cash Payment Option -->
                                                        <div class="relative">
                                                            <input type="radio" 
                                                                   id="payment_cash" 
                                                                   name="payment_method" 
                                                                   value="cash" 
                                                                   x-model="paymentMethod"
                                                                   @change="clearError('paymentMethod')"
                                                                   class="sr-only">
                                                            <label for="payment_cash" 
                                                                   class="block p-4 border-2 rounded-lg cursor-pointer transition-all duration-200"
                                                                   :class="paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center space-x-3">
                                                                        <svg class="w-8 h-8 transition-colors duration-200" 
                                                                             :class="paymentMethod === 'cash' ? 'text-blue-500' : 'text-gray-400'"
                                                                             fill="none" 
                                                                             stroke="currentColor" 
                                                                             viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" 
                                                                                  stroke-linejoin="round" 
                                                                                  stroke-width="2" 
                                                                                  d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                                        </svg>
                                                                        <span class="text-gray-700 font-medium">Tunai</span>
                                                                    </div>
                                                                    <div class="w-6 h-6 border-2 rounded-full flex items-center justify-center"
                                                                         :class="paymentMethod === 'cash' ? 'border-blue-500' : 'border-gray-400'">
                                                                        <div class="w-3 h-3 rounded-full bg-blue-500"
                                                                             x-show="paymentMethod === 'cash'"></div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>

                                                        <!-- Online Payment Option -->
                                                        <div class="relative">
                                                            <input type="radio" 
                                                                   id="payment_online" 
                                                                   name="payment_method" 
                                                                   value="online" 
                                                                   x-model="paymentMethod"
                                                                   @change="clearError('paymentMethod')"
                                                                   class="sr-only">
                                                            <label for="payment_online" 
                                                                   class="block p-4 border-2 rounded-lg cursor-pointer transition-all duration-200"
                                                                   :class="paymentMethod === 'online' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300'">
                                                                <div class="flex items-center justify-between">
                                                                    <div class="flex items-center space-x-3">
                                                                        <svg class="w-8 h-8 transition-colors duration-200" 
                                                                             :class="paymentMethod === 'online' ? 'text-blue-500' : 'text-gray-400'"
                                                                             fill="none" 
                                                                             stroke="currentColor" 
                                                                             viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" 
                                                                                  stroke-linejoin="round" 
                                                                                  stroke-width="2" 
                                                                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                                                        </svg>
                                                                        <span class="text-gray-700 font-medium">Pembayaran Dalam Talian</span>
                                                                    </div>
                                                                    <div class="w-6 h-6 border-2 rounded-full flex items-center justify-center"
                                                                         :class="paymentMethod === 'online' ? 'border-blue-500' : 'border-gray-400'">
                                                                        <div class="w-3 h-3 rounded-full bg-blue-500"
                                                                             x-show="paymentMethod === 'online'"></div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Cash Payment Message -->
                                                <div x-show="paymentMethod === 'cash'" 
                                                     class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                                    <div class="flex items-start space-x-3">
                                                        <svg class="w-6 h-6 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" 
                                                                  stroke-linejoin="round" 
                                                                  stroke-width="2" 
                                                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <p class="text-sm text-blue-800">
                                                            Sila pergi ke kaunter hadapan untuk membuat pembayaran secara tunai.
                                                        </p>
                                                    </div>
                                                </div>

                                                <p x-show="errors.paymentMethod" 
                                                   x-text="errors.paymentMethod"
                                                   class="mt-2 text-sm text-red-600"></p>
                                            </div>
                                        </div>

                                        <!-- Payment Proof Upload (shown only for online payment) -->
                                        <div x-show="paymentMethod === 'online'" 
                                             x-data="{ 
                                                 fileName: null,
                                                 removeFile() {
                                                     this.fileName = null;
                                                     document.getElementById('payment_proof').value = '';
                                                 }
                                             }"
                                             class="mt-6 p-6 border-2 border-dashed border-gray-300 rounded-xl">
                                            
                                            <!-- Upload Area -->
                                            <div x-show="!fileName" class="text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                                </svg>
                                                <div class="mt-4 flex flex-col items-center">
                                                    <label for="payment_proof" class="cursor-pointer">
                                                        <span class="mt-2 block text-sm font-medium text-gray-900">
                                                            Bukti Pembayaran
                                                        </span>
                                                        <span class="mt-1 block text-sm text-gray-500">
                                                            PNG, JPG, GIF sehingga 5MB
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>

                                            <!-- File Preview -->
                                            <div x-show="fileName" class="text-center">
                                                <div class="flex items-center justify-center space-x-2">
                                                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium text-gray-900" x-text="fileName"></span>
                                                    <button type="button" 
                                                            @click="removeFile()"
                                                            class="p-1 rounded-full hover:bg-gray-100">
                                                        <svg class="w-5 h-5 text-gray-500 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                  d="M6 18L18 6M6 6l12 12"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <input type="file" 
                                                   id="payment_proof" 
                                                   name="payment_proof"
                                                   @change="fileName = $event.target.files[0]?.name; clearError('payment_proof')"
                                                   class="hidden"
                                                   accept="image/*,.pdf">
                                                   
                                            <p x-show="errors.payment_proof" 
                                               x-text="errors.payment_proof"
                                               class="mt-2 text-sm text-red-600 text-center"></p>
                                        </div>

                                        <!-- Navigation Buttons -->
                                        <div class="mt-6 flex justify-between">
                                            <button type="button" 
                                                    @click="currentStep = 3"
                                                    class="inline-flex items-center px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                                Sebelumnya
                                            </button>

                                            <div class="flex gap-3">
                                                <button type="button"
                                                        @click="resetForm()"
                                                        class="inline-flex items-center px-6 py-2.5 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                                    Set Semula
                                                </button>
                                                
                                                <button type="submit" 
                                                        @click="validateStep4()"
                                                        class="inline-flex items-center px-6 py-2.5 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    Hantar
                                                </button>
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
                        </select>
                    </td>
                    <td class="px-4 py-3">
                        <button type="button" 
                                @click="familyMembers.splice(index, 1)"
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

        <!-- Add this at the bottom of your file to check if Alpine.js is loaded -->
        <script>
            document.addEventListener('alpine:init', () => {
                console.log('Alpine.js initialized');
            });
        </script>
    </body>
</html>