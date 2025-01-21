@extends('layouts.admin')

@section('title', 'Laporan Tahunan')

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
            background: linear-gradient(135deg, #6c3baa 0%, #8e5cbf 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(108, 59, 170, 0.1), 0 2px 4px -1px rgba(108, 59, 170, 0.06);
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
        .file-upload-frame {
            border: 1px solid #e2e8f0; /* Light gray border */
            border-radius: 0.375rem; /* Rounded corners */
            padding: 1rem; /* Padding inside the frame */
            background-color: #f7fafc; /* Light background color */
        }
        #flashMessage {
            display: none; /* Initially hidden */
        }
        #flashMessage.show {
            display: flex; /* Show when triggered */
        }
        #uploadMessage {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
            z-index: 1000; /* Ensure it appears above other content */
        }
    </style>
@endpush

<!-- Add this section for required scripts -->
@prepend('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
        // Setup CSRF token for all Ajax requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
@endprepend

@section('content')
<div class="container py-6">
    <!-- Enhanced Header -->
    <div class="page-header mb-1">
        <div class="header-content">
            <div class="header-icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 2h12a2 2 0 012 2v16a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2zM6 6h12M6 10h12M6 14h12M6 18h12"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Laporan Tahunan</h1>
                <p class="text-white/80 mt-1">Pengurusan laporan tahunan</p>
            </div>
        </div>
    </div>
    
    <div class="py-6">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-blue-600 mb-4">MUAT NAIK FAIL</h1>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin.annual-reports.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="space-y-6 mb-6">
                    <!-- Title Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tajuk</label>
                        <input type="text" name="title" required class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2">
                    </div>

                    <!-- Description Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penerangan</label>
                        <textarea name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2 pt-2"></textarea>
                    </div>

                    <!-- Year Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="year" required class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2">
                            @for($i = date('Y'); $i >= 2000; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <!-- File Upload Area -->
                    <div id="uploadContainer" class="space-y-4 p-6 border-2 border-dashed rounded-lg transition-colors duration-300">
                        <!-- Thumbnail Upload -->
                        <div class="file-upload-frame">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="file" name="thumbnail" accept="image/*" class="hidden" id="thumbnailInput" required>
                                    <label for="thumbnailInput" class="cursor-pointer flex items-center">
                                        <span class="text-gray-600 ml-2">Pilih Imej Muka Depan</span>
                                        <span class="text-sm text-gray-500 ml-3">PNG, JPG sehingga 5MB</span>
                                    </label>
                                </div>
                                <span id="thumbnailName" class="text-sm text-gray-500"></span>
                            </div>
                        </div>

                        <!-- PDF Upload -->
                        <div class="file-upload-frame">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="file" name="file_path" accept=".pdf" class="hidden" id="pdfInput" required>
                                    <label for="pdfInput" class="cursor-pointer flex items-center">
                                        <span class="text-gray-600 ml-2">Pilih Fail PDF</span>
                                        <span class="text-sm text-gray-500 ml-3">PDF sehingga 100MB</span>
                                    </label>
                                </div>
                                <span id="pdfName" class="text-sm text-gray-500"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Status message -->
                    <div id="statusMessage" class="hidden p-4 rounded-md mt-4"></div>

                    <!-- Submit Button -->
                    <div class="flex justify-center mt-6">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Upload Report
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="mt-6">
        <h1 class="text-xl font-semibold text-blue-600 mb-2 pl-3">LAPORAN DIMUAT NAIK</h1>
        <div class="overflow-hidden rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-yellow-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider w-1/4">Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Tajuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($reports->isEmpty())
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">Tiada maklumat laporan</td>
                        </tr>
                    @else
                        @foreach($reports as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.annual-reports.edit', $report->id) }}" class="text-yellow-600 hover:text-yellow-800">Edit</a>
                                    <form action="{{ route('admin.annual-reports.destroy', $report->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-4">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Flash Message -->
<div id="flashMessage" class="fixed inset-0 hidden z-50"> <!-- Centered in the viewport -->
    <div class="bg-red-100 text-red-700 text-center px-4 py-3 rounded-lg shadow-lg"> <!-- Adjusted background and text color -->
        {{ session('message') }} <!-- Display the message -->
    </div>
</div>

<div class="progress" style="display: none;">
    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
</div>

<div id="uploadMessage" class="fixed inset-0 hidden flex items-center justify-center z-50">
    <div class="bg-white p-4 rounded shadow-lg">
        <span id="messageText" class="text-gray-800"></span>
        <button id="closeMessage" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded">Close</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('uploadForm');
    const uploadContainer = document.getElementById('uploadContainer');
    const thumbnailInput = document.getElementById('thumbnailInput');
    const pdfInput = document.getElementById('pdfInput');
    const thumbnailName = document.getElementById('thumbnailName');
    const pdfName = document.getElementById('pdfName');
    const statusMessage = document.getElementById('statusMessage');

    // Show file names when selected
    thumbnailInput.addEventListener('change', function() {
        if (this.files[0]) {
            thumbnailName.textContent = this.files[0].name;
        }
    });

    pdfInput.addEventListener('change', function() {
        if (this.files[0]) {
            pdfName.textContent = this.files[0].name;
        }
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        // Reset status
        uploadContainer.classList.remove('border-green-500', 'border-red-500', 'bg-green-50', 'bg-red-50');
        statusMessage.classList.add('hidden');

        fetch(form.action, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Server error');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Success state
                uploadContainer.classList.add('border-green-500', 'bg-green-50');
                statusMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700');
                statusMessage.classList.add('bg-green-100', 'text-green-700');
                statusMessage.textContent = data.message;
                
                // Reset form
                form.reset();
                thumbnailName.textContent = '';
                pdfName.textContent = '';
                
                // Reload page after success
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            } else {
                throw new Error(data.message || 'Upload failed');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            // Error state
            uploadContainer.classList.add('border-red-500', 'bg-red-50');
            statusMessage.classList.remove('hidden', 'bg-green-100', 'text-green-700');
            statusMessage.classList.add('bg-red-100', 'text-red-700');
            statusMessage.textContent = error.message || 'An error occurred during upload';
        });
    });

    // Close button functionality
    document.getElementById('closeMessage').addEventListener('click', function() {
        document.getElementById('uploadMessage').classList.add('hidden');
    });
});
</script>

@push('scripts')
<script>
$(document).ready(function() {
    $('#uploadForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const progressBar = $('.progress-bar');
        const progressContainer = $('#progress-bar-container');
        const statusMessage = $('#status-message');
        const submitButton = $(this).find('button[type="submit"]');
        
        // Show progress bar
        progressContainer.removeClass('d-none');
        statusMessage.addClass('d-none');
        submitButton.prop('disabled', true);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        progressBar.css('width', percent + '%').text(percent + '%');
                    }
                });
                return xhr;
            },
            success: function(response) {
                statusMessage
                    .removeClass('d-none alert-danger')
                    .addClass('alert-success')
                    .text('Report uploaded successfully!')
                    .show();
                
                // Reload page after 2 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred during upload.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                statusMessage
                    .removeClass('d-none alert-success')
                    .addClass('alert-danger')
                    .text(errorMessage)
                    .show();
                
                progressBar.css('width', '0%').text('0%');
            },
            complete: function() {
                submitButton.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush

@endsection 