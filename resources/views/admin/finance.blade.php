@extends('layouts.admin')

@section('title', 'Kewangan')

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
        #loansTable_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
        }
        #loansTable_wrapper .dataTables_length select {
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
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(34, 197, 94, 0.1), 0 2px 4px -1px rgba(34, 197, 94, 0.06);
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
        #loansTable {
            width: 100% !important;
        }
        #loansTable th, 
        #loansTable td {
            padding: 1rem 1.5rem !important;
        }
        #loansTable thead th {
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        #loansTable tbody td {
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
        .header-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
        }
        .rate-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            transition: all 0.2s;
        }
        .rate-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
@endpush

@section('content')
    <div class="container py-6">
        <!-- Enhanced Header -->
        <div class="page-header mb-6">
            <div class="header-content">
                <div class="header-icon">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Senarai Pinjaman</h1>
                    <p class="text-white/80 mt-1">Pengurusan pinjaman ahli</p>
                </div>
                <div class="header-actions">
                    <button onclick="toggleInterestRate()" class="rate-button">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Kadar Faedah
                    </button>
                </div>
            </div>
        </div>

        <!-- Collapsible Section -->
        <div id="interestRateSection" class="hidden mb-6 bg-white p-4 rounded-lg shadow-sm transition-all duration-300">
            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kadar Faedah Pinjaman (%)
                    </label>
                    <input type="number" 
                           id="interestRate" 
                           class="form-input rounded-md border-gray-300 shadow-sm w-32" 
                           step="0.01" 
                           min="0" 
                           max="100"
                           value="{{ $currentInterestRate }}">
                </div>
                <button onclick="updateInterestRate()" 
                        class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Kemaskini
                </button>
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
            <table id="loansTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pinjaman</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peminjam</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pinjaman</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (RM)</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tempoh</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td>{{ $loan->loan_id }}</td>
                            <td>{{ $loan->member ? $loan->member->name : 'N/A' }}</td>
                            <td>{{ $loan->loanType->loan_type }}</td>
                            <td>{{ number_format($loan->loan_amount, 2) }}</td>
                            <td>{{ $loan->loan_period }} bulan</td>
                            <td>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $loan->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                       ($loan->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                        'bg-red-100 text-red-800') }}">
                                    {{ $loan->status === 'pending' ? 'Tertunda' : 
                                       ($loan->status === 'approved' ? 'Diluluskan' : 
                                        'Ditolak') }}
                                </span>
                            </td>
                            <td>
                                <div class="flex justify-center">
                                    <a href="{{ route('admin.finance.show', ['loanId' => $loan->loan_id]) }}" 
                                       class="action-button text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tiada pinjaman untuk dipaparkan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add this modal for password confirmation -->
    <div class="modal fade" id="passwordConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-lg shadow-xl">
                <div class="modal-header bg-gray-50 rounded-t-lg">
                    <h5 class="modal-title text-lg font-semibold text-gray-800">Pengesahan Kata Laluan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <p class="text-gray-600 mb-4">Sila masukkan kata laluan anda untuk mengesahkan tindakan ini.</p>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kata Laluan</label>
                        <input type="password" id="confirmPassword" class="form-input w-full rounded-md shadow-sm" required>
                    </div>
                </div>
                <div class="modal-footer bg-gray-50 rounded-b-lg">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="confirmPasswordAndUpdate()">Sahkan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loansTable').DataTable({
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

        function toggleInterestRate() {
            const section = document.getElementById('interestRateSection');
            section.classList.toggle('hidden');
        }

        function updateInterestRate() {
            $('#passwordConfirmModal').modal('show');
        }

        function confirmPasswordAndUpdate() {
            const password = document.getElementById('confirmPassword').value;
            const rate = document.getElementById('interestRate').value;

            // First confirm password
            fetch('/confirm-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ password: password })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // If password is confirmed, proceed with rate update
                    updateRate(rate);
                    $('#passwordConfirmModal').modal('hide');
                    document.getElementById('confirmPassword').value = ''; // Clear password
                } else {
                    alert(data.message || 'Kata laluan tidak sah');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ralat semasa mengesahkan kata laluan');
            });
        }

        function updateRate(rate) {
            fetch('/admin/settings/interest-rate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ rate: rate })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Kadar faedah telah dikemaskini!');
                } else {
                    alert(data.message || 'Ralat semasa mengemaskini kadar faedah');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ralat semasa mengemaskini kadar faedah');
            });
        }
    </script>
@endpush 