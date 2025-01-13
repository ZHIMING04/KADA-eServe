@extends('layouts.admin')

@section('title', 'Maklumat Ahli')

@section('content')
    <!-- Back button and header -->
    <div class="mb-6">
        <a href="{{ route('admin.members.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Senarai Ahli
        </a>
    </div>

    <!-- Member Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Peribadi</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">No. Ahli</p>
                    <p class="font-medium">{{ $member->no_anggota }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Nama</p>
                    <p class="font-medium">{{ $member->name }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">No. KP</p>
                    <p class="font-medium">{{ $member->ic }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $member->email }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">No. Telefon</p>
                    <p class="font-medium">{{ $member->phone }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Jantina</p>
                    <p class="font-medium">{{ $member->gender }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Tarikh Lahir</p>
                    <p class="font-medium">{{ $member->DOB }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Agama</p>
                    <p class="font-medium">{{ $member->agama }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Bangsa</p>
                    <p class="font-medium">{{ $member->bangsa }}</p>
                </div>
            </div>

            <h3 class="text-lg font-semibold mt-6 mb-3 text-gray-800 border-b pb-2">Alamat Rumah</h3>
            <div class="space-y-2">
                <p class="font-medium">{{ $member->address }}</p>
                <p class="font-medium">{{ $member->postcode }} {{ $member->city }}</p>
                <p class="font-medium">{{ $member->state }}</p>
            </div>
        </div>

        <!-- Working Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Pekerjaan</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Jawatan</p>
                    <p class="font-medium">{{ $workingInfo->jawatan }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Gred</p>
                    <p class="font-medium">{{ $workingInfo->gred }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">No. PF</p>
                    <p class="font-medium">{{ $workingInfo->no_pf }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Gaji</p>
                    <p class="font-medium">RM {{ $workingInfo->salary }}</p>
                </div>
            </div>

            <h3 class="text-lg font-semibold mt-6 mb-3 text-gray-800 border-b pb-2">Alamat Pejabat</h3>
            <div class="space-y-2">
                <p class="font-medium">{{ $member->office_address }}</p>
                <p class="font-medium">{{ $member->office_postcode }} {{ $member->office_city }}</p>
                <p class="font-medium">{{ $member->office_state }}</p>
            </div>
        </div>

        <!-- Savings Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Simpanan</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Yuran Masuk</p>
                    <p class="font-medium">RM {{ number_format($savings->entrance_fee, 2) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Modal Syer</p>
                    <p class="font-medium">RM {{ number_format($savings->share_capital, 2) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Modal Yuran</p>
                    <p class="font-medium">RM {{ number_format($savings->subscription_capital, 2) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Deposit Ahli</p>
                    <p class="font-medium">RM {{ number_format($savings->member_deposit, 2) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Tabung Kebajikan</p>
                    <p class="font-medium">RM {{ number_format($savings->welfare_fund, 2) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Simpanan Tetap</p>
                    <p class="font-medium">RM {{ number_format($savings->fixed_savings, 2) }}</p>
                </div>
                <div class="col-span-2 pt-4 border-t">
                    <p class="text-sm text-gray-600">Jumlah Keseluruhan</p>
                    <p class="font-semibold text-lg text-blue-600">RM {{ number_format($savings->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Family Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Keluarga</h2>
            <div class="space-y-4">
                @foreach($familyMembers as $family)
                    <div class="p-4 border rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <p class="text-sm text-gray-600">Hubungan</p>
                                <p class="font-medium">{{ $family->relationship }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm text-gray-600">Nama</p>
                                <p class="font-medium">{{ $family->name }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-sm text-gray-600">No. KP</p>
                                <p class="font-medium">{{ $family->ic }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection 