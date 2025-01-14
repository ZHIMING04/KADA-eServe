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
                            <td><input type="checkbox" name="selected_members[]" value="{{ $member->id }}" class="member-checkbox rounded"></td>
                            <td>{{ $member->no_anggota }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->ic }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                <div class="flex justify-center">
                                    <a href="{{ route('admin.members.show', $member->id) }}" 
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
                                Tiada rekod ahli yang diluluskan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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

            // Select All functionality
            $('#selectAll').on('change', function() {
                $('.member-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Update Select All checkbox state based on individual checkboxes
            $('.member-checkbox').on('change', function() {
                var allChecked = $('.member-checkbox:checked').length === $('.member-checkbox').length;
                $('#selectAll').prop('checked', allChecked);
            });
        });
    </script>
@endpush 