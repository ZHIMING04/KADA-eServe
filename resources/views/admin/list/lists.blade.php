@extends('layouts.admin')

@section('title', 'Senarai Pemohon')

@push('styles')
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            padding: 1rem;  /* Reduced from 1.5rem */
        }
        .table-header {
            background: linear-gradient(to right, #f8fafc, #edf2f7);
        }
        #listsTable_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
        }
        #listsTable_wrapper .dataTables_length select {
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
            box-shadow: 0 2px 4px rgba(219, 39, 119, 0.05) !important;
            transform: translateY(-1px);
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #3b82f6 !important;
            color: white !important;
            font-weight: 600 !important;
            box-shadow: 0 2px 4px rgba(59,130,246,0.3) !important;
        }
        .page-header {
            background: linear-gradient(135deg, #EC4899 0%, #BE185D 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 0.5rem;  /* Reduced from 2rem to 1rem */
            box-shadow: 0 4px 6px -1px rgba(219, 39, 119, 0.1), 0 2px 4px -1px rgba(219, 39, 119, 0.06);
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
        #listsTable {
            width: 100% !important;
        }
        #listsTable th, 
        #listsTable td {
            padding: 1rem 1.5rem !important;
        }
        #listsTable thead th {
            font-weight: 600;
            font-size: 0.875rem;
            white-space: nowrap;
        }
        #listsTable tbody td {
            font-size: 0.95rem;
        }
        .dataTables_wrapper .dataTables_length {
            margin-bottom: 0.75rem;  /* Reduced from 1.5rem */
            margin-left: 0.5rem;
        }
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 0.75rem;  /* Reduced from 1.5rem */
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
        .flex.items-center.justify-between.mb-4 {
            margin-bottom: 0.5rem; /* Reduced from 1rem */
        }
        .highlight-row {
            position: relative;
        }

        .highlight-row::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            width: 3px;
            background-color: #FFA500;
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <div class="flex-1">
                <h1 class="text-2xl font-bold">Senarai Pemohon</h1>
                <p class="text-white/80 mt-1">Pengurusan status pemohon</p>
            </div>
            <!-- Status Filter -->
            <div class="flex items-center ml-4">
                <label for="statusFilter" class="mr-2 text-sm font-medium text-white">Status:</label>
                <select id="statusFilter" 
                        class="rounded-md border-none shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-white/90 text-gray-700">
                    <option value="">Semua Status</option>
                    <option value="approved">Ahli</option>
                    <option value="pending">Sedang Diproses</option>
                    <option value="resigned">Berhenti</option>
                    <option value="deceased">Wafat</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-4">
            <!-- DataTables Search will be inserted here -->
            <div class="dataTables_filter"></div>
        </div>
    </div>

    <!-- Table Container -->
    <div class="table-container p-6">
        <table id="listsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left text-xs font-medium text-gray-500 tracking-wider">NO. ANGGOTA</th>
                    <th class="text-left text-xs font-medium text-gray-500 tracking-wider">NAMA</th>
                    <th class="text-left text-xs font-medium text-gray-500 tracking-wider">EMAIL</th>
                    <th class="text-left text-xs font-medium text-gray-500 tracking-wider">NO. TELEFON</th>
                    <th class="text-left text-xs font-medium text-gray-500 tracking-wider">STATUS</th>
                    <th class="text-left text-xs font-medium text-gray-500 tracking-wider">TINDAKAN</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sortedMembers as $member)
                    @php
                        // Check if the member has an active resignation request
                        $activeResignation = $member->resignations()->where('status', 'pending')->first();
                    @endphp
                    <tr class="{{ $activeResignation ? 'highlight-row' : '' }}">
                        <td>{{ $member->no_anggota }}</td>
                        <td>{{ $member->name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone }}</td>
                        <td class="px-6 py-4 whitespace-nowrap" id="status-{{ $member->id }}">
                            @php
                                $statusClass = match($member->status) {
                                    'approved' => 'bg-green-100 text-green-800',
                                    'deceased' => 'bg-gray-100 text-gray-800',
                                    'resigned' => 'bg-orange-100 text-orange-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800'
                                };

                                $statusText = match($member->status) {
                                    'approved' => 'Ahli',
                                    'pending' => 'Sedang Diproses',
                                    'resigned' => 'Berhenti',
                                    'deceased' => 'Wafat',
                                    'rejected' => 'Ditolak',
                                    default => 'Sedang Diproses'
                                };
                            @endphp
                            <span class="px-3 py-1.5 text-sm font-medium rounded-full {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <div class="flex justify-center space-x-3">
                                <!-- View Resignation Details -->
                                @if($member->resignation)
                                    <a href="{{ route('admin.list.resign', ['id' => $member->resignation->id]) }}" 
                                       class="action-button text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @else
                                    <a href="#" onclick="showNoResignationWarning()"
                                       class="action-button text-blue-500 hover:text-blue-700 p-2 rounded-full hover:bg-blue-50">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif

                                <!-- Update Status -->
                                <a href="#" onclick="openUpdateStatusModal('{{ $member->id }}')"
                                   class="text-green-500 hover:text-green-700 p-2 rounded-full hover:bg-green-50">
                                    <i class="fas fa-edit fa-lg"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tiada pendaftaran yang menunggu
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $sortedMembers->appends(['search' => request('search'), 'status' => request('status')])->links() }}
    </div>

    <!-- Update Modal -->
    <div id="updateStatusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-lg font-medium text-gray-900">Kemaskini Status</h3>
                    <button onclick="closeUpdateStatusModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <form id="updateStatusForm" method="POST">
                    @csrf
                    <input type="hidden" id="member_id" name="member_id">
                    
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="approved">Ahli</option>
                            <option value="pending">Sedang Diproses</option>
                            <option value="resigned">Berhenti</option>
                            <option value="deceased">Wafat</option>
                            <option value="rejected">Ditolak</option>
                        </select>
                    </div>

                    <div class="mt-5 flex justify-end space-x-3">
                        <button type="button" onclick="closeUpdateStatusModal()" 
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add this modal HTML at the bottom of your file -->
    <div id="reasonModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full" style="z-index: 20;">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-lg font-medium text-gray-900">Sebab-sebab Permohonan Berhenti</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-2 px-7 py-3">
                    <div id="reasonContent" class="text-gray-600">
                        <!-- Reasons will be populated here -->
                    </div>
                </div>
                <div class="items-center px-4 py-3">
                    <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md w-full hover:bg-gray-300 focus:outline-none">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const table = $('#listsTable').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Papar _MENU_ entri",
                info: "Memaparkan _START_ hingga _END_ daripada _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Seterusnya",
                    previous: "Sebelumnya"
                },
                zeroRecords: "Tiada rekod ditemui",
                emptyTable: "Tiada data dalam jadual"
            },
            pageLength: 10,
            responsive: true,
            columnDefs: [
                { 
                    className: "px-6 py-4 whitespace-nowrap", 
                    targets: "_all" 
                },
                {
                    // Add custom row styling for rows with pending resignations
                    targets: [0], // Target first column
                    createdCell: function(td, cellData, rowData, row, col) {
                        const $row = $(td).closest('tr');
                        if ($row.hasClass('highlight-row')) {
                            $row.find('td:first').addClass('rounded-l-lg');
                            $row.find('td:last').addClass('rounded-r-lg');
                        }
                    }
                }
            ],
            drawCallback: function(settings) {
                // Reapply the orange background after table redraw
                $('.highlight-row').each(function() {
                    $(this).find('td:first').addClass('rounded-l-lg');
                    $(this).find('td:last').addClass('rounded-r-lg');
                });
            },
            dom: '<"flex items-center justify-between"lf>rtip'
        });

        // Custom status filter
        $('#statusFilter').on('change', function() {
            const status = $(this).val();
            let searchValue = '';
            
            switch(status) {
                case 'approved':
                    table.column(4).search('Ahli').draw();
                    break;
                case 'pending':
                    table.column(4).search('Sedang Diproses').draw();
                    break;
                case 'resigned':
                    table.column(4).search('Berhenti').draw();
                    break;
                case 'deceased':
                    table.column(4).search('Wafat').draw();
                    break;
                case 'rejected':
                    table.column(4).search('Ditolak').draw();
                    break;
                default:
                    table.column(4).search('').draw();
            }
        });
    });

function openUpdateStatusModal(memberId) {
    document.getElementById('member_id').value = memberId;
    document.getElementById('updateStatusModal').classList.remove('hidden');
}

function closeUpdateStatusModal() {
    document.getElementById('updateStatusModal').classList.add('hidden');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('updateStatusModal');
    if (event.target == modal) {
        closeUpdateStatusModal();
    }
}

document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const memberId = document.getElementById('member_id').value;
    const formData = new FormData(this);
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/admin/list/${memberId}/update-status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeUpdateStatusModal();
            Swal.fire({
                icon: 'success',
                title: 'Berjaya',
                text: data.message,
                confirmButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        } else {
            throw new Error(data.message || 'Error updating status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Ralat',
            text: error.message,
            confirmButtonColor: '#3085d6'
        });
    });
});

// Debounce function to limit API calls
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Handle search input
const searchInput = document.getElementById('searchInput');
const statusFilter = document.getElementById('statusFilter');

const performSearch = debounce(() => {
    const searchValue = searchInput.value;
    const statusValue = statusFilter.value;
    
    const url = new URL(window.location.href);
    url.searchParams.set('search', searchValue);
    url.searchParams.set('status', statusValue);
    url.searchParams.set('page', '1'); // Reset to first page on new search
    
    window.location.href = url.toString();
}, 500);

searchInput.addEventListener('input', performSearch);
statusFilter.addEventListener('change', performSearch);

// Set initial values from URL params
window.addEventListener('DOMContentLoaded', () => {
    const url = new URL(window.location.href);
    const searchValue = url.searchParams.get('search');
    const statusValue = url.searchParams.get('status');
    
    if (searchValue) searchInput.value = searchValue;
    if (statusValue) statusFilter.value = statusValue;
});

function showSuccessMessage(message) {
    Swal.fire({
        html: `
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">${message}</span>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
}

function showNoResignationWarning() {
    Swal.fire({
        html: `
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">Tiada rekod permohonan berhenti.</span>
            </div>
        `,
        showConfirmButton: true,
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
}

function openModal(resignationId) {
    // Updated fetch URL to use the ListController endpoint
    fetch(`/admin/list/resignation-reasons/${resignationId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            let reasonsHtml = '';
            let reasonCount = 0;
            
            // Check for each reason field from the database
            const reasons = [
                data.reason1,
                data.reason2,
                data.reason3,
                data.reason4,
                data.reason5
            ];

            reasons.forEach((reason, index) => {
                if (reason && reason.trim()) {
                    reasonCount++;
                    reasonsHtml += `
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-orange-100 text-orange-600 rounded-full mr-3">
                                    ${reasonCount}
                                </div>
                                <p class="text-gray-700">${reason}</p>
                            </div>
                        </div>
                    `;
                }
            });

            // If no reasons found
            if (reasonCount === 0) {
                reasonsHtml = `
                    <div class="text-center py-4 text-gray-500">
                        Tiada sebab yang direkodkan
                    </div>
                `;
            }

            // Update modal content and show
            document.getElementById('reasonContent').innerHTML = reasonsHtml;
            document.getElementById('reasonModal').classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('reasonContent').innerHTML = `
                <div class="text-red-500 text-center">
                    Ralat semasa memuat turun data: ${error.message}
                </div>
            `;
            document.getElementById('reasonModal').classList.remove('hidden');
        });
}

function closeModal() {
    document.getElementById('reasonModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('reasonModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal on escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endpush
@endsection