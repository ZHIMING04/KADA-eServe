@extends('layouts.admin')

@section('title', 'Maklumat Pinjaman')

@section('content')
    <div class="container py-6">
        <!-- Back button and header -->
        <div class="mb-6">
            <a href="{{ route('admin.finance.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Senarai Pinjaman
            </a>
        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex gap-4">
            @if($loan->status === 'pending')
                <button class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-150 ease-in-out">
                    Lulus Pinjaman
                </button>
                <button class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-150 ease-in-out">
                    Tolak Pinjaman
                </button>
            @endif
        </div>

        <!-- Loan Information Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Loan Details -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Pinjaman</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">ID Pinjaman</p>
                        <p class="font-medium">{{ $loan->loan_id }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Status Pinjaman</p>
                        <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                            {{ $loan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($loan->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                'bg-red-100 text-red-800') }}">
                            {{ ucfirst($loan->status) }}
                        </span>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Jenis Pinjaman</p>
                        <p class="font-medium">{{ $loan->loanType->loan_type }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Tarikh Mohon</p>
                        <p class="font-medium">{{ $loan->date_apply }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Jumlah Pinjaman</p>
                        <p class="font-medium">RM {{ number_format($loan->loan_amount, 2) }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Tempoh Pinjaman</p>
                        <p class="font-medium">{{ $loan->loan_period }} bulan</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Kadar Faedah</p>
                        <p class="font-medium">{{ $loan->interest_rate }}%</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Bayaran Bulanan</p>
                        <p class="font-medium">RM {{ number_format($loan->monthly_repayment, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Peribadi</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Nama Penuh</p>
                        <p class="font-medium">{{ $loan->member->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. KP</p>
                        <p class="font-medium">{{ $loan->member->ic }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $loan->member->email }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. Telefon</p>
                        <p class="font-medium">{{ $loan->member->phone }}</p>
                    </div>
                    <div class="col-span-2 space-y-1">
                        <p class="text-sm text-gray-600">Alamat Rumah</p>
                        <p class="font-medium">{{ $loan->member->address }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Bandar</p>
                        <p class="font-medium">{{ $loan->member->city }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Poskod</p>
                        <p class="font-medium">{{ $loan->member->postcode }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Negeri</p>
                        <p class="font-medium">{{ $loan->member->state }}</p>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Pekerjaan</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 space-y-1">
                        <p class="text-sm text-gray-600">Alamat Pejabat</p>
                        <p class="font-medium">{{ $loan->member->office_address }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Bandar</p>
                        <p class="font-medium">{{ $loan->member->office_city }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Poskod</p>
                        <p class="font-medium">{{ $loan->member->office_postcode }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Gaji Kasar Bulanan</p>
                        <p class="font-medium">RM {{ number_format($loan->monthly_gross_salary, 2) }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Gaji Bersih Bulanan</p>
                        <p class="font-medium">RM {{ number_format($loan->monthly_net_salary, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Bank Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Bank</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Nama Bank</p>
                        <p class="font-medium">{{ $loan->bank->bank_name }}</p>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">No. Akaun Bank</p>
                        <p class="font-medium">{{ $loan->bank->bank_account }}</p>
                    </div>
                </div>
            </div>

            <!-- Guarantor Information -->
            <div class="bg-white rounded-lg shadow-md p-6 col-span-2">
                <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Penjamin</h2>
                <div class="grid grid-cols-1 gap-6">
                    @foreach($loan->guarantors as $index => $guarantor)
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-semibold mb-3 text-gray-700">Penjamin {{ $index + 1 }}</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">Nama Penuh</p>
                                    <p class="font-medium">{{ $guarantor->name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">No. KP</p>
                                    <p class="font-medium">{{ $guarantor->ic }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">No. Telefon</p>
                                    <p class="font-medium">{{ $guarantor->phone }}</p>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-sm text-gray-600">Hubungan</p>
                                    <p class="font-medium">{{ $guarantor->getRelationshipInMalay() }}</p>
                                </div>
                                <div class="col-span-2 space-y-1">
                                    <p class="text-sm text-gray-600">Alamat</p>
                                    <p class="font-medium">{{ $guarantor->address }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection 