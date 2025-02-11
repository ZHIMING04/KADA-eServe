@extends('layouts.admin')

@section('title', 'Maklumat Pendaftaran')

@section('content')
    <!-- Back button and header -->
    <div class="mb-6">
        <a href="{{ route('admin.registrations.pending') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pendaftaran Menunggu
        </a>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex gap-4">
        <form action="{{ route('admin.registrations.approve', $member->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                Lulus Pendaftaran
            </button>
        </form>
        
        <form action="{{ route('admin.registrations.reject', $member->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                Tolak Pendaftaran
            </button>
        </form>
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
                    @if($workingInfo)
                        <p class="font-medium">{{ $workingInfo->jawatan }}</p>
                    @else
                        <p class="text-gray-500">Tiada maklumat</p>
                    @endif
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
                    <p class="font-medium">RM {{ number_format($workingInfo->salary, 2) }}</p>
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

        <!-- Payment Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Pembayaran</h2>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Kaedah Pembayaran</p>
                        <p class="font-medium flex items-center">
                            @if($member->payment_method === 'cash')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-money-bill-wave mr-2"></i> Tunai
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <i class="fas fa-credit-card mr-2"></i> Dalam Talian
                                </span>
                            @endif
                        </p>
                    </div>
                    
                    @if($member->payment_method === 'online' && $member->payment_proof)
                    <div class="space-y-1">
                        <p class="text-sm text-gray-600">Bukti Pembayaran</p>
                        <p class="font-medium">
                            <a href="#" 
                               class="text-blue-600 hover:text-blue-800 inline-flex items-center"
                               onclick="showPaymentProof('{{ asset($member->payment_proof) }}'); return false;">
                                <i class="fas fa-image mr-2"></i>
                                Lihat Bukti Pembayaran
                            </a>
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Family Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Keluarga</h2>
            <div class="space-y-4">
                @forelse($familyMembers as $family)
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
                @empty
                    <p class="text-gray-500">Tiada maklumat keluarga</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Payment Proof Modal -->
    <div id="paymentProofModal" 
         class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
         onclick="this.classList.add('hidden')">
        <div class="max-w-3xl w-full bg-white rounded-lg shadow-xl overflow-hidden"
             onclick="event.stopPropagation()">
            <div class="p-4 bg-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-800">Bukti Pembayaran</h3>
                <button onclick="document.getElementById('paymentProofModal').classList.add('hidden')"
                        class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 flex items-center justify-center" style="max-height: 80vh;">
                <img id="paymentProofImage" src="" alt="Bukti Pembayaran" 
                     class="max-w-full max-h-[70vh] object-contain">
            </div>
        </div>
    </div>

    <!-- Modal Script -->
    <script>
    function showPaymentProof(imageUrl) {
        const modal = document.getElementById('paymentProofModal');
        const image = document.getElementById('paymentProofImage');
        image.src = imageUrl;
        modal.classList.remove('hidden');
    }

    // Close modal when pressing ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.getElementById('paymentProofModal').classList.add('hidden');
        }
    });
    </script>
@endsection 