@extends('layouts.admin')

@section('title', 'Ahli')

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

        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #2563eb !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding: 1rem 0 !important;
        }
    </style>
@endpush

@section('content')
    <!-- Header with gradient background -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-6 mb-8 text-white">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">Senarai Ahli</h1>
                <p class="mt-2 opacity-90">Pengurusan maklumat ahli KADA</p>
            </div>
            <!-- Add batch actions dropdown -->
            <div class="flex space-x-4">
                <div class="relative" id="batchActionsContainer" style="display: none;">
                    <select id="batchActions" class="bg-white text-gray-700 font-semibold py-2 px-4 rounded-lg shadow-md">
                        <option value="">Tindakan Pukal</option>
                        <option value="delete">Padam</option>
                        <option value="export">Export</option>
                    </select>
                </div>
                <a href="{{ route('admin.members.create') }}" 
                   class="bg-white text-blue-600 hover:bg-blue-50 font-semibold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md">
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        <span>Tambah Ahli Baru</span>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Table -->
    <div class="table-container p-6">
        <table id="membersTable" class="w-full text-left">
            <thead class="table-header">
                <tr>
                    <th class="px-6 py-4">
                        <input type="checkbox" id="selectAll" class="rounded">
                    </th>
                    <th class="px-6 py-4 font-semibold text-gray-700">No. Anggota</th>
                    <th class="px-6 py-4 font-semibold text-gray-700">Nama</th>
                    <th class="px-6 py-4 font-semibold text-gray-700">Email</th>
                    <th class="px-6 py-4 font-semibold text-gray-700">No. KP</th>
                    <th class="px-6 py-4 font-semibold text-gray-700">No. Telefon</th>
                    <th class="px-6 py-4 font-semibold text-gray-700">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                    <tr class="border-b hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4">
                            <input type="checkbox" name="selected_members[]" value="{{ $member->id }}" class="member-checkbox rounded">
                        </td>
                        <td class="px-6 py-4">{{ $member->no_anggota }}</td>
                        <td class="px-6 py-4">{{ $member->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $member->email }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $member->ic }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $member->phone }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.members.show', $member->id) }}" 
                                   class="action-button text-blue-500 hover:text-blue-700 p-1 rounded-full hover:bg-blue-50">
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
                                    <button type="submit" class="action-button text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-50">
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

    <!-- Add this form after your table -->
    <form id="batchActionForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="selected_ids" id="selected_ids">
    </form>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <!-- Export Modal -->
    <div x-data="{ open: false }" 
         x-show="open"
         @open-export-modal.window="open = true"
         @keydown.escape.window="open = false"
         class="fixed inset-0 overflow-y-auto z-50" 
         style="display: none;">
        
        <!-- Modal Backdrop -->
        <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

        <!-- Modal Content -->
        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6"
                     @click.away="open = false">
                    
                    <div class="mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Select Fields to Export</h3>
                    </div>
                    
                    <form id="exportForm" method="GET" action="{{ route('admin.members.export') }}">
                        <input type="hidden" name="selected_ids" id="export_selected_ids">
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Personal Information -->
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Personal Information</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="no_anggota" class="rounded border-gray-300" checked>
                                        <span class="ml-2">No. Anggota</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="name" class="rounded border-gray-300" checked>
                                        <span class="ml-2">Name</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="email" class="rounded border-gray-300" checked>
                                        <span class="ml-2">Email</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="ic" class="rounded border-gray-300">
                                        <span class="ml-2">IC Number</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="phone" class="rounded border-gray-300">
                                        <span class="ml-2">Phone</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Address Information -->
                            <div>
                                <h4 class="font-medium text-gray-700 mb-2">Address Information</h4>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="address" class="rounded border-gray-300">
                                        <span class="ml-2">Address</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="city" class="rounded border-gray-300">
                                        <span class="ml-2">City</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="postcode" class="rounded border-gray-300">
                                        <span class="ml-2">Postcode</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[]" value="state" class="rounded border-gray-300">
                                        <span class="ml-2">State</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
                            <button type="button" 
                                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                                    @click="open = false">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                                Export PDF
                            </button>
                        </div>
                    </form>
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
                }
            });

            // Select all checkbox functionality
            $('#selectAll').change(function() {
                $('.member-checkbox').prop('checked', $(this).prop('checked'));
                updateBatchActionsVisibility();
            });

            // Individual checkbox change handler
            $('.member-checkbox').change(function() {
                updateBatchActionsVisibility();
            });

            // Show/hide batch actions based on selection
            function updateBatchActionsVisibility() {
                const checkedBoxes = $('.member-checkbox:checked').length;
                $('#batchActionsContainer').toggle(checkedBoxes > 0);
            }

            // Update batch actions handler
            $('#batchActions').change(function() {
                const action = $(this).val();
                const selectedIds = $('.member-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
                
                if (!selectedIds.length) {
                    alert('Please select at least one member');
                    return;
                }

                switch(action) {
                    case 'delete':
                        if (confirm('Are you sure you want to delete the selected members?')) {
                            const form = $('#batchActionForm');
                            $('#selected_ids').val(selectedIds.join(','));
                            form.attr('action', '{{ route("admin.members.batch-delete") }}');
                            form.find('input[name="_method"]').val('DELETE');
                            form.submit();
                        }
                        break;
                    case 'export':
                        $('#export_selected_ids').val(selectedIds.join(','));
                        window.dispatchEvent(new CustomEvent('open-export-modal'));
                        break;
                }

                $(this).val('');
            });
        });
    </script>
@endpush 