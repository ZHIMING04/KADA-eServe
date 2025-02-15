@extends('layouts.admin')

@section('title', 'Senarai Transaksi')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .table-header {
            background: linear-gradient(to right, #f8fafc, #edf2f7);
        }
        #transactionsTable_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
        }
        #transactionsTable_wrapper .dataTables_length select {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.25rem 2rem 0.25rem 0.5rem;
        }
        .action-button {
            transition: all 0.3s ease;
        }
        .action-button:hover {
            transform: scale(1.1);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border: none !important;
            padding: 8px 16px !important;
            margin: 0 4px !important;
            border-radius: 8px !important;
            background: #f3f4f6 !important;
            color: #4b5563 !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e5e7eb !important;
            color: #1f2937 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important;
            transform: translateY(-1px);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #3b82f6 !important;
            color: white !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(59,130,246,0.3) !important;
        }
        .page-header {
            background: linear-gradient(135deg, #EE8B7C 00%,#D14D72 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.1), 0 2px 4px -1px rgba(234, 88, 12, 0.06);
        }
        .header-content {
            display: flex;
            align-items: center;
            color: white;
        }
        .header-icon {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 12px;
            margin-right: 1.5rem;
        }
        .container {
            max-width: 95% !important;
            margin: 0 auto;
        }
        #transactionsTable {
            width: 100% !important;
        }
        #transactionsTable th, 
        #transactionsTable td {
            padding: 1rem 1.5rem !important;
        }
        #transactionsTable thead th {
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        #transactionsTable tbody td {
            font-size: 0.95rem;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 1.5rem;
            margin-left: 0.5rem;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1.5rem;
            margin-right: 0.5rem;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1.5rem;
            margin-bottom: 1rem;
            padding-right: 1rem;
        }
        .dataTables_wrapper .dataTables_info {
            margin-top: 1.5rem;
            margin-left: 1rem;
            padding-bottom: 1rem;
        }
    </style>
@endpush

@section('content')
<div class="container py-6">
    <!-- Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Senarai Transaksi</h1>
                <p class="text-white/80 mt-1">Pengurusan transaksi ahli</p>
            </div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container p-6">
        <table id="transactionsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Transaksi</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Ahli</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (RM)</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh</th>
                    <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50">
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->member->name }}</td>
                        <td>
                        @if($transaction->type === 'savings')
                                @switch($transaction->savings_type)
                                    @case('share_capital')
                                        Modal Syer
                                        @break
                                    @case('subscription_capital')
                                        Modal Yuran
                                        @break
                                    @case('member_deposit')
                                        Simpanan Anggota
                                        @break
                                    @case('welfare_fund')
                                        Tabung Anggota
                                        @break
                                    @case('fixed_savings')
                                        Simpanan Tetap
                                        @break
                                    @default
                                        {{ ucfirst($transaction->savings_type) }}
                                @endswitch
                            @else
                                Bayaran Pinjaman
                            @endif
                        </td>
                        <td>{{ number_format($transaction->amount, 2) }}</td>
                        <td>
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($transaction->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                    'bg-red-100 text-red-800') }}">
                                    {{ $transaction->status === 'pending' ? 'Tertunda' : 
                                        ($transaction->status === 'approved' ? 'Diluluskan' : 'Ditolak') }}
                            </span>
                        </td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction->transaction_id) }}" 
                               class="text-blue-600 hover:text-blue-900 action-button inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Tiada transaksi untuk dipaparkan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#transactionsTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Papar _MENU_ entri",
                info: "Memaparkan _START_ hingga _END_ daripada _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Seterusnya",
                    previous: "Sebelumnya"
                }
            },
            pageLength: 10,
            responsive: true,
            columnDefs: [
                { className: "px-6 py-4 whitespace-nowrap", targets: "_all" }
            ]
        });
    });
</script>
@endpush
@endsection 