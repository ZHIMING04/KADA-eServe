@extends('layouts.admin')

@section('title', 'Maklumat Transaksi')

@section('content')
<div class="container py-6">
    <!-- Back button -->
    <div class="mb-6">
        <a href="{{ route('admin.transactions.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Senarai Transaksi
        </a>
    </div>

    <!-- Action Buttons -->
    @if($transaction->status === 'pending')
    <div class="mb-6 flex gap-4">
        <form action="{{ route('admin.transactions.approve', $transaction->transaction_id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">
                Lulus Transaksi
            </button>
        </form>
        
        <form action="{{ route('admin.transactions.reject', $transaction->transaction_id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">
                Tolak Transaksi
            </button>
        </form>
    </div>
    @endif

    <!-- Transaction Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Transaction Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Transaksi</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">ID Transaksi</p>
                    <p class="font-medium">{{ $transaction->transaction_id }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Status</p>
                    <span class="px-3 py-1 inline-flex text-sm font-semibold rounded-full 
                        {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($transaction->status === 'approved' ? 'bg-green-100 text-green-800' : 
                            'bg-red-100 text-red-800') }}">
                        {{ ucfirst($transaction->status) }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Jenis Transaksi</p>
                    <p class="font-medium">
                        @if($transaction->type === 'savings')
                            {{ ucfirst($transaction->savings_type) }}
                        @else
                            Bayaran Pinjaman
                        @endif
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Jumlah (RM)</p>
                    <p class="font-medium">{{ number_format($transaction->amount, 2) }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Kaedah Pembayaran</p>
                    <p class="font-medium">{{ $transaction->payment_method === 'online' ? 'Online Banking' : 'Tunai' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Tarikh Transaksi</p>
                    <p class="font-medium">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Member Information -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-800 border-b pb-2">Maklumat Ahli</h2>
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Nama Penuh</p>
                    <p class="font-medium">{{ $transaction->member->name }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">No. KP</p>
                    <p class="font-medium">{{ $transaction->member->ic }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">Email</p>
                    <p class="font-medium">{{ $transaction->member->email }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-sm text-gray-600">No. Telefon</p>
                    <p class="font-medium">{{ $transaction->member->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Proof -->
        @if($transaction->payment_proof)
            <div class="mt-4">
                <h3 class="text-lg font-medium">Bukti Pembayaran</h3>
                <div class="mt-2">
                    <img src="{{ asset($transaction->payment_proof) }}" 
                         alt="Bukti Pembayaran" 
                         class="max-w-lg rounded-lg shadow-md">
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 