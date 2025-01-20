@extends('layouts.admin')

@section('title', 'Senarai Ahli')

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
        #membersTable_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
        }
        #membersTable_wrapper .dataTables_length select {
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
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
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
        #membersTable {
            width: 100% !important;
        }
        #membersTable th, 
        #membersTable td {
            padding: 1rem 1.5rem !important;
        }
        #membersTable thead th {
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        #membersTable tbody td {
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
        <!-- Enhanced Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-icon">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold">Senarai Ahli</h1>
                    <p class="text-white/80 mt-1">Pengurusan maklumat ahli yang telah diluluskan</p>
                </div>
            </div>
        </div>

        <!-- Batch Actions Bar -->
        <div class="mb-4 bg-white p-4 rounded-lg shadow-sm flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <select id="batchAction" class="form-select rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Pilih Tindakan</option>
                        <option value="delete">Padam</option>
                        <option value="export">Export PDF</option>
                        <option value="transaction">Tambah Transaksi</option>
                    </select>
                </div>
                <button onclick="executeBatchAction()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50" id="executeAction" disabled>
                    Laksana
                </button>
            </div>
            
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <span id="selectedCount">0</span> ahli dipilih
            </div>
        </div>

        <!-- Table Container -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
            <div class="mb-4 flex items-center">
                <input type="checkbox" id="selectAll" class="rounded mr-2">
                <label for="selectAll" class="text-sm text-gray-600">Pilih Semua</label>
            </div>
            <table id="membersTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                            <div class="flex items-center">
                                <span>No.</span>
                            </div>
                        </th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Anggota</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. KP</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telefon</th>
                        <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td>
                                <input type="checkbox" 
                                       name="selected_members[]" 
                                       value="{{ $member->id }}" 
                                       class="member-checkbox rounded">
                            </td>
                            <td>{{ $member->no_anggota }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->ic }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                <div class="flex justify-center space-x-2">
                                    <!-- View button -->
                                    <a href="{{ route('admin.members.show', $member->id) }}" 
                                       class="action-button text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>

                                    <!-- Add Transaction button -->
                                    <button onclick="openTransactionModal({{ $member->id }})" 
                                            class="action-button text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tiada rekod ahli yang diluluskan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-lg shadow-xl">
                <div class="modal-header bg-gray-50 rounded-t-lg">
                    <h5 class="modal-title text-lg font-semibold text-gray-800">Add Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form id="transactionForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Transaction Type</label>
                            <select class="form-select w-full rounded-md shadow-sm" id="transactionType" name="type" required>
                                <option value="savings">Savings Deposit</option>
                                <option value="loan">Loan Repayment</option>
                            </select>
                        </div>

                        <div class="mb-4" id="savingsTypeDiv">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Simpanan</label>
                            <select class="form-select w-full rounded-md shadow-sm" name="savings_type">
                                <option value="share_capital">Modal Syer</option>
                                <option value="subscription_capital">Modal Yuran</option>
                                <option value="member_deposit">Deposit Ahli</option>
                                <option value="welfare_fund">Tabung Kebajikan</option>
                                <option value="fixed_savings">Simpanan Tetap</option>
                            </select>
                        </div>

                        <div class="mb-4" id="loanDiv" style="display: none;">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Pilih Pembiayaan</label>
                            <select class="form-select w-full rounded-md shadow-sm" name="loan_id">
                                <option value="">Tiada rekod Pembiayaan</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Amount (RM)</label>
                            <input type="number" class="form-input w-full rounded-md shadow-sm" name="amount" step="0.01" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-gray-50 rounded-b-lg">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitTransaction()">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Batch Transaction Modal -->
    <div class="modal fade" id="batchTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-lg shadow-xl">
                <div class="modal-header bg-gray-50 rounded-t-lg">
                    <h5 class="modal-title text-lg font-semibold text-gray-800">Tambah Transaksi Berkumpulan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form id="batchTransactionForm">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Transaksi</label>
                            <select class="form-select w-full rounded-md shadow-sm" id="batchTransactionType" name="type" required>
                                <option value="savings">Simpanan</option>
                            </select>
                        </div>

                        <div class="mb-4" id="batchSavingsTypeDiv">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jenis Simpanan</label>
                            <select class="form-select w-full rounded-md shadow-sm" name="savings_type">
                                <option value="share_capital">Modal Syer</option>
                                <option value="subscription_capital">Modal Yuran</option>
                                <option value="member_deposit">Deposit Ahli</option>
                                <option value="welfare_fund">Tabung Kebajikan</option>
                                <option value="fixed_savings">Simpanan Tetap</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Jumlah (RM)</label>
                            <input type="number" class="form-input w-full rounded-md shadow-sm" name="amount" step="0.01" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-gray-50 rounded-b-lg">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="submitBatchTransaction()">Hantar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this modal structure to blade file -->
    <div class="modal fade" id="exportFieldsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-lg shadow-xl">
                <div class="modal-header bg-gray-50 rounded-t-lg">
                    <h5 class="modal-title text-lg font-semibold text-gray-800">Select Fields to Export</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-6">
                    <form id="exportFieldsForm">
                        <div class="grid grid-cols-2 gap-6">
                            <!-- Personal Information -->
                            <div>
                                <h6 class="font-medium text-gray-700 mb-3">Personal Information</h6>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="no_anggota" class="rounded" checked>
                                        <label class="ml-2">No. Anggota</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="name" class="rounded" checked>
                                        <label class="ml-2">Name</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="email" class="rounded" checked>
                                        <label class="ml-2">Email</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="ic" class="rounded">
                                        <label class="ml-2">IC Number</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="phone" class="rounded">
                                        <label class="ml-2">Phone</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Information -->
                            <div>
                                <h6 class="font-medium text-gray-700 mb-3">Address Information</h6>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="address" class="rounded">
                                        <label class="ml-2">Address</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="city" class="rounded">
                                        <label class="ml-2">City</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="postcode" class="rounded">
                                        <label class="ml-2">Postcode</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="export_fields[]" value="state" class="rounded">
                                        <label class="ml-2">State</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-gray-50 rounded-b-lg">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="exportPDF()">Export PDF</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#membersTable').DataTable({
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
                ],
                order: [[1, 'asc']] // Sort by No. Anggota by default
            });

            // Select All checkbox functionality
            $('#selectAll').on('change', function() {
                $('.member-checkbox').prop('checked', $(this).prop('checked'));
                updateSelectedCount();
                updateExecuteButton();
            });

            // Individual checkbox functionality
            $(document).on('change', '.member-checkbox', function() {
                // Check if all checkboxes are checked
                const totalCheckboxes = $('.member-checkbox').length;
                const checkedCheckboxes = $('.member-checkbox:checked').length;
                
                // Update the "Select All" checkbox state
                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
                $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
                
                updateSelectedCount();
                updateExecuteButton();
            });

            // Update selected count display
            function updateSelectedCount() {
                const selectedCount = $('.member-checkbox:checked').length;
                $('#selectedCount').text(selectedCount);
            }

            // Update execute button state
            function updateExecuteButton() {
                const selectedCount = $('.member-checkbox:checked').length;
                $('#executeAction').prop('disabled', selectedCount === 0);
            }
        });

        let currentMemberId = null;

        function openTransactionModal(memberId) {
            // Reset form
            $('#transactionForm')[0].reset();
            
            // Show modal
            $('#transactionModal').modal('show');
            
            // Store member ID
            currentMemberId = memberId;
            
            // Fetch and populate loans
            $.ajax({
                url: `/admin/members/${memberId}/loans`,
                method: 'GET',
                success: function(response) {
                    const loanSelect = $('select[name="loan_id"]');
                    loanSelect.empty();
                    
                    if (response && response.length > 0) {
                        loanSelect.append('<option value="">-- Pilih Pembiayaan --</option>');
                        response.forEach(loan => {
                            loanSelect.append(`<option value="${loan.loan_id}">LOAN-${loan.loan_id} (RM${loan.loan_amount.toFixed(2)})</option>`);
                        });
                    } else {
                        loanSelect.append('<option value="">Tiada rekod Pembiayaan</option>');
                    }
                },
                error: function() {
                    const loanSelect = $('select[name="loan_id"]');
                    loanSelect.empty();
                    loanSelect.append('<option value="">Tiada rekod Pembiayaan</option>');
                }
            });
        }

        $('#transactionType').change(function() {
            const type = $(this).val();
            if (type === 'savings') {
                $('#savingsTypeDiv').show();
                $('#loanDiv').hide();
            } else {
                $('#savingsTypeDiv').hide();
                $('#loanDiv').show();
                if (currentMemberId) {
                    fetchMemberLoans(currentMemberId);
                }
            }
        });

        function submitTransaction() {
            const form = $('#transactionForm');
            const formData = new FormData(form[0]);

            // Create data object with the correct type
            const data = {
                type: $('#transactionType').val(), // Get the selected type
                amount: formData.get('amount')
            };

            // Add appropriate fields based on transaction type
            if (data.type === 'savings') {
                data.savings_type = formData.get('savings_type');
            } else if (data.type === 'loan') {
                data.loan_id = formData.get('loan_id');
            }

            fetch(`/admin/members/${currentMemberId}/transaction`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaksi berjaya!');
                    $('#transactionModal').modal('hide');
                    location.reload();
                } else {
                    alert(data.message || 'Transaksi gagal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ralat: ' + error.message);
            });
        }

        function executeBatchAction() {
            const selectedIds = $('.member-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            const action = $('#batchAction').val();

            switch(action) {
                case 'delete':
                    if (!confirm('Adakah anda pasti untuk memadam ahli yang dipilih?')) {
                        return;
                    }

                    // Submit delete request
                    fetch('/admin/members/batch-delete', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            selected_members: selectedIds
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message || 'Ralat semasa memproses permintaan');
                        }
                    });
                    break;
                    
                case 'export':
                    showExportModal();
                    break;
                    
                case 'transaction':
                    $('#batchTransactionModal').modal('show');
                    break;
            }
        }

        function submitBatchTransaction() {
            const selectedIds = $('.member-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            const form = $('#batchTransactionForm');
            const formData = new FormData(form[0]);

            const data = {
                member_ids: selectedIds,
                type: formData.get('type'),
                savings_type: formData.get('savings_type'),
                amount: formData.get('amount')
            };

            fetch('/admin/members/batch-transaction', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Transaksi berjaya disimpan!');
                    $('#batchTransactionModal').modal('hide');
                    location.reload();
                } else {
                    alert(data.message || 'Transaksi gagal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ralat: ' + error.message);
            });
        }

        function showExportModal() {
            $('#exportFieldsModal').modal('show');
        }

        function exportPDF() {
            const selectedIds = $('.member-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            const selectedFields = $('input[name="export_fields[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            // Create form for PDF export
            const form = document.createElement('form');
            form.method = 'GET';
            form.action = '/admin/members/export';
            
            // Add selected IDs
            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'selected_ids';
            idsInput.value = selectedIds.join(',');
            form.appendChild(idsInput);

            // Add selected fields
            const fieldsInput = document.createElement('input');
            fieldsInput.type = 'hidden';
            fieldsInput.name = 'selected_fields';
            fieldsInput.value = selectedFields.join(',');
            form.appendChild(fieldsInput);

            // Add to document and submit
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);

            // Close the modal
            $('#exportFieldsModal').modal('hide');
        }
    </script>
@endpush 