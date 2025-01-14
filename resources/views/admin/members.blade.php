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

        /* Container width */
        .container {
            max-width: 95% !important;
            margin: 0 auto;
        }

        /* Table styling */
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

        /* Column widths */
        #membersTable th:nth-child(1),
        #membersTable td:nth-child(1) {
            width: 5%;
        }

        #membersTable th:nth-child(2),
        #membersTable td:nth-child(2) {
            width: 15%;
        }

        #membersTable th:nth-child(3),
        #membersTable td:nth-child(3) {
            width: 20%;
        }

        #membersTable th:nth-child(4),
        #membersTable td:nth-child(4) {
            width: 20%;
        }

        #membersTable th:nth-child(5),
        #membersTable td:nth-child(5) {
            width: 15%;
        }

        #membersTable th:nth-child(6),
        #membersTable td:nth-child(6) {
            width: 15%;
        }

        #membersTable th:nth-child(7),
        #membersTable td:nth-child(7) {
            width: 10%;
        }

        /* DataTables controls */
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

        .dataTables_wrapper .dataTables_length {
            margin-bottom: 1.5rem;
            margin-left: 0.5rem;
        }

        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 1.5rem;
            margin-right: 0.5rem;
        }

        /* Pagination */
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

        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
        }

        .action-button {
            transition: all 0.3s ease;
            padding: 0.5rem;
            border-radius: 8px;
        }

        .action-button:hover {
            transform: scale(1.1);
        }

        /* Header styling */
        .page-header {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
            <table id="membersTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td>
                                <input type="checkbox" name="selected_members[]" value="{{ $member->id }}" class="member-checkbox rounded">
                            </td>
                            <td>{{ $member->no_anggota }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email }}</td>
                            <td>{{ $member->ic }}</td>
                            <td>{{ $member->phone }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.members.show', $member->id) }}" 
                                       class="action-button text-blue-500 hover:text-blue-700 hover:bg-blue-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.members.destroy', $member->id) }}" 
                                          method="POST" 
                                          class="inline" 
                                          onsubmit="return confirm('Adakah anda pasti untuk memadam ahli ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-button text-red-500 hover:text-red-700 hover:bg-red-50">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
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
            $('#membersTable').DataTable({
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

            // Select all checkbox functionality
            $('#selectAll').change(function() {
                $('.member-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endpush 