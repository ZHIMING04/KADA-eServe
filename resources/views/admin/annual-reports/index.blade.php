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
            background: linear-gradient(135deg, #8e5cbf 0%, #6c3baa 100%);
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
        #annualReportsTable {
            width: 100% !important;
        }
        #annualReportsTable th, 
        #annualReportsTable td {
            padding: 1rem 1.5rem !important;
        }
        #annualReportsTable thead th {
            font-weight: 600;
            white-space: nowrap;
        }
        #annualReportsTable tbody td {
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

@section('content')
<div class="container py-6">
    @if(session()->has('update_success') || session()->has('delete_success'))
        <div id="alert-message" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">
                @if(session()->has('update_success'))
                    Laporan berjaya dikemaskini!
                @elseif(session()->has('delete_success'))
                    Laporan berjaya dipadam!
                @endif
            </span>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alert = document.getElementById('alert-message');
                if (alert) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 1s';
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 1000);
                    }, 3000);
                }
            });
        </script>
    @endif

    <!-- Purple Header Section -->
    <div class="page-header mb-6">
        <div class="header-content">
            <div class="header-icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l4-4m0 0l4 4m-4-4v12M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Laporan Tahunan</h1>
                <p class="text-white/80 mt-1">Pengurusan laporan tahunan</p>
            </div>
            <div class="ml-auto">
                <a href="{{ route('admin.annual-reports.view') }}" 
                   class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Paparan Laporan
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section - NO green border -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
        <h2 class="text-xl font-semibold text-blue-600 mb-4">MUAT NAIK FAIL</h2>
        
        <form action="{{ route('admin.annual-reports.store') }}" method="POST" enctype="multipart/form-data">
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

                <!-- File Upload Area - ONLY green for upload success, not delete -->
                <div class="border-2 border-dashed {{ session()->has('success') && !session()->has('delete_success') ? 'border-green-500 bg-green-50' : 'border-gray-300' }} rounded-lg p-4" id="outerFrame">
                    <div id="uploadContainer" class="space-y-4">
                        <!-- Thumbnail Upload -->
                        <div class="file-upload-frame p-4 bg-gray-50 border border-gray-300 rounded-lg" id="thumbnailFrame">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="file" name="thumbnail" accept="image/*" class="hidden" id="thumbnailInput" required>
                                    <label for="thumbnailInput" class="cursor-pointer">
                                        <span class="text-gray-600">Pilih Imej Muka Depan</span>
                                        <span class="text-sm text-gray-500 ml-3">PNG, JPG sehingga 5MB</span>
                                    </label>
                                </div>
                                <span id="thumbnailName" class="text-sm text-gray-500"></span>
                            </div>
                        </div>

                        <!-- PDF Upload -->
                        <div class="file-upload-frame p-4 bg-gray-50 border border-gray-300 rounded-lg" id="pdfFrame">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input type="file" name="file_path" accept=".pdf" class="hidden" id="pdfInput" required>
                                    <label for="pdfInput" class="cursor-pointer">
                                        <span class="text-gray-600">Pilih Fail PDF</span>
                                        <span class="text-sm text-gray-500 ml-3">PDF sehingga 100MB</span>
                                    </label>
                                </div>
                                <span id="pdfName" class="text-sm text-gray-500"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status message -->
                <div id="statusMessage" class="hidden p-4 rounded-md mt-4"></div>

                <!-- Submit Button -->
                <div class="flex justify-center mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Muat Naik
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Reports Table -->
    <div class="mt-6">
        <h1 class="text-xl font-semibold text-blue-600 mb-2">LAPORAN DIMUAT NAIK</h1>
        <div class="overflow-hidden rounded-lg shadow">
            {{-- Debug info - temporary --}}
            {{ count($reports) }} reports found<br>
            
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
                        @foreach($reports->sortByDesc('year') as $report)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->year }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $report->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.annual-reports.edit', $report->id) }}"
                                       class="bg-yellow-500 text-white hover:bg-yellow-600 font-semibold py-1 px-2 rounded inline-block">
                                        Kemaskini
                                    </a>
                                    <span class="mx-2 text-gray-600">|</span>
                                    <form action="{{ route('admin.annual-reports.destroy', $report->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Adakah anda pasti mahu memadamkan laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:bg-gray-800 hover:text-red-800 border-0 bg-transparent">Padam</button>
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
    const thumbnailFrame = document.getElementById('thumbnailFrame');
    const pdfFrame = document.getElementById('pdfFrame');
    const statusMessage = document.getElementById('statusMessage');

    // Show file names when selected
    thumbnailInput.addEventListener('change', function() {
        const frame = this.closest('.file-upload-frame');
        if (this.files[0]) {
            const fileSize = this.files[0].size / (1024 * 1024); // Convert to MB
            if (fileSize > 5) {
                frame.style.border = '2px dashed #ef4444'; // red-500
                frame.style.backgroundColor = '#fef2f2'; // red-50
                document.getElementById('thumbnailName').textContent = 'File size exceeds 5MB';
            } else {
                frame.style.border = '2px dashed #22c55e'; // green-500
                frame.style.backgroundColor = '#f0fdf4'; // green-50
                document.getElementById('thumbnailName').textContent = this.files[0].name;
            }
        } else {
            frame.style.border = '1px solid #d1d5db'; // gray-300
            frame.style.backgroundColor = '#f9fafb'; // gray-50
            document.getElementById('thumbnailName').textContent = '';
        }
    });

    pdfInput.addEventListener('change', function() {
        const frame = this.closest('.file-upload-frame');
        if (this.files[0]) {
            const fileSize = this.files[0].size / (1024 * 1024); // Convert to MB
            if (fileSize > 100) {
                frame.style.border = '2px dashed #ef4444'; // red-500
                frame.style.backgroundColor = '#fef2f2'; // red-50
                document.getElementById('pdfName').textContent = 'File size exceeds 100MB';
            } else {
                frame.style.border = '2px dashed #22c55e'; // green-500
                frame.style.backgroundColor = '#f0fdf4'; // green-50
                document.getElementById('pdfName').textContent = this.files[0].name;
            }
        } else {
            frame.style.border = '1px solid #d1d5db'; // gray-300
            frame.style.backgroundColor = '#f9fafb'; // gray-50
            document.getElementById('pdfName').textContent = '';
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
                throw new Error('Server error');
            }
            // Handle success without JSON
            alert('Files uploaded successfully!');
        })
        .catch(error => {
            console.error('Upload error:', error);
            alert('Upload failed: ' + error.message);
        });
    });

    // Close button functionality
    document.getElementById('closeMessage').addEventListener('click', function() {
        document.getElementById('uploadMessage').classList.add('hidden');
    });

    // Flash message handling
    const flashMessage = document.getElementById('flashMessage');
    if (flashMessage && "{{ session()->has('success') }}" || "{{ session()->has('delete_success') }}") {
        flashMessage.classList.remove('hidden');
        setTimeout(() => {
            flashMessage.classList.add('hidden');
        }, 3000);
    }

    // Only handle green frame for upload success, never for delete
    if ("{{ session()->has('success') }}" && !"{{ session()->has('delete_success') }}") {
        setTimeout(() => {
            const outerFrame = document.getElementById('outerFrame');
            outerFrame.classList.remove('border-green-500', 'bg-green-50');
            outerFrame.classList.add('border-gray-300');
        }, 3000);
    }
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
                // You can log the response text directly
                console.error('Upload error:', xhr.responseText);
                alert('Upload failed: ' + errorMessage);
            },
            complete: function() {
                submitButton.prop('disabled', false);
            }
        });
    });
});
</script>

<script>
    // Auto hide alert after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('alert-message');
        if (alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 1000);
            }, 3000);
        }
    });
</script>

<script>
    // Optional: Add animation to the success border
    document.addEventListener('DOMContentLoaded', function() {
        const formBox = document.querySelector('.border-green-500');
        if (formBox) {
            setTimeout(() => {
                formBox.classList.remove('border-green-500');
                formBox.style.transition = 'border-color 0.5s ease';
            }, 3000); // Remove green border after 3 seconds
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnailInput = document.getElementById('thumbnailInput');
        const pdfInput = document.getElementById('pdfInput');
        const outerFrame = document.getElementById('outerFrame');

        thumbnailInput.addEventListener('change', function() {
            if (this.files[0]) {
                document.getElementById('thumbnailName').textContent = this.files[0].name;
            }
        });

        pdfInput.addEventListener('change', function() {
            if (this.files[0]) {
                document.getElementById('pdfName').textContent = this.files[0].name;
            }
        });

        // Remove success styling after 3 seconds if it exists
        if (outerFrame.classList.contains('border-green-500')) {
            setTimeout(() => {
                outerFrame.classList.remove('border-green-500', 'bg-green-50');
                outerFrame.classList.add('border-gray-300');
            }, 3000);
        }
    });
</script>

<script>
    function closeFlashMessage() {
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage) {
            flashMessage.classList.add('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.getElementById('flashMessage');
        if (flashMessage && !flashMessage.classList.contains('hidden')) {
            // Auto-hide after 3 seconds
            setTimeout(() => {
                flashMessage.style.transition = 'opacity 0.5s ease-out';
                flashMessage.style.opacity = '0';
                setTimeout(() => {
                    flashMessage.classList.add('hidden');
                    flashMessage.style.opacity = '1';
                }, 500);
            }, 3000);

            // Close on click outside
            flashMessage.addEventListener('click', function(e) {
                if (e.target === flashMessage) {
                    closeFlashMessage();
                }
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeFlashMessage();
                }
            });
        }
    });
</script>
@endpush

@endsection