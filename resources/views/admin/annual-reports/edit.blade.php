@extends('layouts.admin')

@section('content')
<div class="container py-6">
    <h1 class="text-2xl font-semibold text-blue-600 mb-4">EDIT ANNUAL REPORT</h1>
    <form action="{{ route('admin.annual-reports.update', $report->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
        @csrf
        @method('PUT')
        <div class="space-y-6 mb-6">
            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Tajuk</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ $report->title }}"
                    required 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <!-- Description Input -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Penerangan</label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="3" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >{{ $report->description }}</textarea>
            </div>

            <!-- Year Input -->
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                <select 
                    id="year" 
                    name="year" 
                    required 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
                    @for($i = date('Y'); $i >= 2000; $i--)
                        <option value="{{ $i }}" {{ $report->year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- Current Thumbnail -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Current Thumbnail</label>
                @if($report->thumbnail)
                    <img src="{{ asset('storage/' . $report->thumbnail) }}" alt="Current Thumbnail" class="mt-2 h-32 object-cover">
                @else
                    <p class="mt-2 text-gray-500">No thumbnail uploaded</p>
                @endif
            </div>

            <!-- New Thumbnail Input -->
            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">New Thumbnail Image (optional)</label>
                <input 
                    type="file" 
                    id="thumbnail" 
                    name="thumbnail" 
                    accept="image/*" 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <!-- Current PDF -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Current PDF</label>
                @if($report->file_path)
                    <a href="{{ asset('storage/' . $report->file_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                        View Current PDF
                    </a>
                @else
                    <p class="mt-2 text-gray-500">No PDF uploaded</p>
                @endif
            </div>

            <!-- New PDF File Input -->
            <div>
                <label for="file_path" class="block text-sm font-medium text-gray-700">New PDF File (optional)</label>
                <input 
                    type="file" 
                    id="file_path" 
                    name="file_path" 
                    accept=".pdf" 
                    class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >
            </div>

            <!-- Progress bar -->
            <div class="progress mt-3 mb-3 d-none" id="progress-bar-container">
                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>

            <!-- Status message -->
            <div id="status-message" class="alert d-none"></div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-4 mt-6">
                <a 
                    href="{{ route('admin.annual-reports.index') }}" 
                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600"
                >
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Update Report
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#editForm').on('submit', function(e) {
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
                    .text('Report updated successfully!')
                    .show();
                
                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = "{{ route('admin.annual-reports.index') }}";
                }, 2000);
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred during update.';
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