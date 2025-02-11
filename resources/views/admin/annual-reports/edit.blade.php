@extends('layouts.admin')

@section('title', 'Kemaskini Laporan Tahunan')

@section('content')
@push('styles')
    <style>
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
    </style>
@endpush

<div class="container py-6">
    <div class="page-header">
        <div class="header-content">
            <div class="header-icon">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l4-4m0 0l4 4m-4-4v12M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold">Kemaskini Laporan Tahunan</h1>
                <p class="text-white/80 mt-1">Sila ubah maklumat laporan tahunan mengikut keperluan</p>
            </div>
        </div>
    </div>

    <!-- Warning message - above the form frame -->
    @if(session('warning') || session('no_changes_warning'))
        <div id="warning-message" class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">Tiada perubahan dilakukan. Sila lakukan kemas kini yang diperluan.</span>
        </div>
    @endif

    @if(session('update_error'))
        <div class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('update_error') }}</span>
        </div>
    @endif

    <!-- Form Section - matched with index card size -->
    <div class="bg-white rounded-lg shadow-sm p-4">
        <h2 class="text-lg font-semibold text-blue-600 mb-4">KEMASKINI FAIL</h2>
        
        <form id="updateForm" method="POST" action="{{ route('admin.annual-reports.update', $report->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6 mb-6">
                <!-- Title Input -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Tajuk</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $report->title) }}" 
                           required 
                           class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2">
                </div>

                <!-- Description Input -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Penerangan</label>
                    <textarea id="description" 
                              name="description" 
                              rows="3" 
                              required 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2 pt-2">{{ old('description', $report->description) }}</textarea>
                </div>

                <!-- Year Input -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select id="year" 
                            name="year" 
                            required 
                            class="mt-1 block w-full h-12 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 pl-2">
                        @for($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ (old('year', $report->year) == $i) ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Thumbnail Input -->
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Thumbnail (Imej)</label>
                @if($report->thumbnail)
                    <div class="mb-2">
                        <a href="#" 
                           onclick="showThumbnail('{{ asset($report->thumbnail) }}')" 
                           class="text-blue-600 hover:underline">
                            Lihat Thumbnail Semasa
                        </a>
                        <input type="hidden" id="current-thumbnail-url" value="{{ asset($report->thumbnail) }}">
                    </div>
                @endif
                <div class="relative">
                    <input type="file" 
                           name="thumbnail" 
                           accept="image/*"
                           id="thumbnail-input"
                           class="hidden">
                    <div class="flex items-center gap-2">
                        <label for="thumbnail-input" id="thumbnail-label" class="inline-block bg-gray-200 px-4 py-2 rounded cursor-pointer hover:bg-gray-300 transition-colors duration-200">
                            Pilih Fail
                        </label>
                        <span id="thumbnail-name" class="ml-2 text-gray-600">Tiada fail dipilih</span>
                        <button type="button" id="cancel-thumbnail" class="hidden text-gray-500 hover:text-red-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <p id="thumbnail-error" class="text-sm text-red-500 mt-1 hidden">Format fail tidak sah. Sila pilih fail imej.</p>
                <p id="thumbnail-same" class="text-sm text-yellow-500 mt-1 hidden">Anda telah memuat naik fail yang sama.</p>
                <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak mahu menukar thumbnail</p>
            </div>

                <!-- PDF File Input -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Fail Laporan (PDF)</label>
                @if($report->file_path)
                    <div class="mb-2">
                            <a href="{{ asset($report->file_path) }}" target="_blank" class="text-blue-600 hover:underline">Lihat PDF Semasa</a>
                            <input type="hidden" id="current-pdf-url" value="{{ asset($report->file_path) }}">
                        </div>
                    @endif
                    <div class="relative">
                        <input type="file" 
                               name="file_path" 
                               accept=".pdf"
                               id="pdf-input"
                               class="hidden">
                        <div class="flex items-center gap-2">
                            <label for="pdf-input" id="pdf-label" class="inline-block bg-gray-200 px-4 py-2 rounded cursor-pointer hover:bg-gray-300 transition-colors duration-200">
                                Pilih Fail
                            </label>
                            <span id="pdf-name" class="ml-2 text-gray-600">Tiada fail dipilih</span>
                            <button type="button" id="cancel-pdf" class="hidden text-gray-500 hover:text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <p id="pdf-error" class="text-sm text-red-500 mt-1 hidden">Format fail tidak sah. Sila pilih fail PDF.</p>
                    <p id="pdf-same" class="text-sm text-yellow-500 mt-1 hidden">Anda telah memuat naik fail yang sama.</p>
                    <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak mahu menukar fail PDF</p>
            </div>

                <div class="flex items-center gap-4">
                    <button id="submit-button" type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-2 px-4 rounded transition-colors duration-200">
                    Kemaskini Laporan
                </button>
                    <a href="{{ route('admin.annual-reports.index') }}" 
                       class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition-colors duration-200">
                    Batal
                </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add this modal HTML after your form section -->
<div class="modal fade" id="thumbnailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img id="modalImage" src="" alt="Thumbnail Preview" class="img-fluid rounded-4" style="max-height: 80vh; width: 100%; object-fit: contain;">
            </div>
        </div>
    </div>
</div>

<script>
async function compareFiles(newFile, currentUrl) {
    if (!currentUrl) return false;
    
    try {
        // Fetch the current file
        const response = await fetch(currentUrl);
        const currentBlob = await response.blob();
        
        // If file sizes are different, files are different
        if (currentBlob.size !== newFile.size) return false;
        
        // Compare file contents
        const currentBuffer = await currentBlob.arrayBuffer();
        const newBuffer = await newFile.arrayBuffer();
        
        // Compare the ArrayBuffers
        const current = new Uint8Array(currentBuffer);
        const newArr = new Uint8Array(newBuffer);
        
        if (current.length !== newArr.length) return false;
        
        for (let i = 0; i < current.length; i++) {
            if (current[i] !== newArr[i]) return false;
        }
        
        return true;
    } catch (error) {
        console.error('Error comparing files:', error);
        return false;
    }
}

let hasSameFile = false;

async function updateButtonState(input, label, errorElement, sameElement, validTypes, currentUrl) {
    const file = input.files[0];
    const labelElement = document.getElementById(label);
    const errorMsg = document.getElementById(errorElement);
    const sameMsg = document.getElementById(sameElement);
    
    // Reset classes and messages
    labelElement.classList.remove(
        'bg-gray-200', 'hover:bg-gray-300',
        'bg-green-500', 'hover:bg-green-600',
        'bg-red-500', 'hover:bg-red-600',
        'bg-yellow-500', 'hover:bg-yellow-600',
        'text-white'
    );
    errorMsg.classList.add('hidden');
    sameMsg.classList.add('hidden');
    
    if (!file) {
        labelElement.classList.add('bg-gray-200', 'hover:bg-gray-300');
        hasSameFile = false;
        return;
    }
    
    // Check if same file
    const isSameFile = await compareFiles(file, currentUrl);
    if (isSameFile) {
        labelElement.classList.add('bg-yellow-500', 'hover:bg-yellow-600', 'text-white');
        sameMsg.classList.remove('hidden');
        hasSameFile = true;
        return;
    }
    
    hasSameFile = false;
    
    // Check file type
    const isValid = validTypes.some(type => {
        if (type === 'image/*') {
            return file.type.startsWith('image/');
        }
        return file.type === 'application/pdf';
    });
    
    if (isValid) {
        labelElement.classList.add('bg-green-500', 'hover:bg-green-600', 'text-white');
    } else {
        labelElement.classList.add('bg-red-500', 'hover:bg-red-600', 'text-white');
        errorMsg.classList.remove('hidden');
    }
}

let hasThumbnailChanged = false;
let hasPDFChanged = false;

document.getElementById('thumbnail-input').addEventListener('change', async function(e) {
    const fileName = e.target.files[0]?.name || 'Tiada fail dipilih';
    document.getElementById('thumbnail-name').textContent = fileName;
    document.getElementById('cancel-thumbnail').classList.remove('hidden');
    
    const currentUrl = document.getElementById('current-thumbnail-url')?.value;
    updateButtonState(this, 'thumbnail-label', 'thumbnail-error', 'thumbnail-same', ['image/*'], currentUrl);
});

document.getElementById('pdf-input').addEventListener('change', async function(e) {
    const fileName = e.target.files[0]?.name || 'Tiada fail dipilih';
    document.getElementById('pdf-name').textContent = fileName;
    document.getElementById('cancel-pdf').classList.remove('hidden');
    
    const currentUrl = document.getElementById('current-pdf-url')?.value;
    updateButtonState(this, 'pdf-label', 'pdf-error', 'pdf-same', ['application/pdf'], currentUrl);
});

document.querySelector('form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;
    const year = document.getElementById('year').value;
    
    // Check for unchanged text fields
    if (title === '{{ $report->title }}' && 
        description === '{{ $report->description }}' && 
        year === '{{ $report->year }}') {
        
        // If no file changes either, show warning
        if (!document.getElementById('thumbnail-input').files[0] && 
            !document.getElementById('pdf-input').files[0]) {
            showWarningMessage('Tiada perubahan dilakukan. Sila lakukan kemas kini yang diperluan.');
            return;
        }
    }
    
    // Check for duplicate files
    const thumbnailFile = document.getElementById('thumbnail-input').files[0];
    const pdfFile = document.getElementById('pdf-input').files[0];
    
    let sameFile = false;

    if (thumbnailFile && await compareFiles(thumbnailFile, '{{ asset($report->thumbnail) }}')) {
        sameFile = true; // Mark as same file
        document.getElementById('thumbnail-same').classList.remove('hidden');
    }
    
    if (pdfFile && await compareFiles(pdfFile, '{{ asset($report->file_path) }}')) {
        sameFile = true; // Mark as same file
        document.getElementById('pdf-same').classList.remove('hidden');
    }

    // If there are changes in title, description, or year, submit the form regardless of same file
    if (title !== '{{ $report->title }}' || 
        description !== '{{ $report->description }}' || 
        year !== '{{ $report->year }}' || 
        (thumbnailFile && !sameFile) || 
        (pdfFile && !sameFile)) {
        this.submit(); // Submit the form
    } else {
        showWarningMessage('Tiada perubahan dilakukan. Sila lakukan kemas kini yang diperluan.');
    }
});

function showWarningMessage(message) {
    const warningDiv = document.createElement('div');
    warningDiv.id = 'warning-message';
    warningDiv.className = 'bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4';
    warningDiv.innerHTML = '<span class="block sm:inline">' + message + '</span>';
    
    const existingWarning = document.getElementById('warning-message');
    if (existingWarning) {
        existingWarning.remove();
    }
    
    const formFrame = document.querySelector('.bg-white.rounded-lg');
    formFrame.parentNode.insertBefore(warningDiv, formFrame);
    
    setTimeout(() => {
        warningDiv.style.opacity = '0';
        warningDiv.style.transition = 'opacity 0.5s';
            setTimeout(() => {
            warningDiv.style.display = 'none';
        }, 500);
            }, 3000);
        }

// Update cancel button handlers
document.getElementById('cancel-thumbnail').addEventListener('click', function() {
    const input = document.getElementById('thumbnail-input');
    const label = document.getElementById('thumbnail-label');
    input.value = '';
    document.getElementById('thumbnail-name').textContent = 'Tiada fail dipilih';
    document.getElementById('thumbnail-same').classList.add('hidden');
    this.classList.add('hidden');
    
    // Reset button style
    label.classList.remove(
        'bg-green-500', 'hover:bg-green-600',
        'bg-red-500', 'hover:bg-red-600',
        'bg-yellow-500', 'hover:bg-yellow-600',
        'text-white'
    );
    label.classList.add('bg-gray-200', 'hover:bg-gray-300');
});

document.getElementById('cancel-pdf').addEventListener('click', function() {
    const input = document.getElementById('pdf-input');
    const label = document.getElementById('pdf-label');
    input.value = '';
    document.getElementById('pdf-name').textContent = 'Tiada fail dipilih';
    document.getElementById('pdf-same').classList.add('hidden');
    this.classList.add('hidden');
    
    // Reset button style
    label.classList.remove(
        'bg-green-500', 'hover:bg-green-600',
        'bg-red-500', 'hover:bg-red-600',
        'bg-yellow-500', 'hover:bg-yellow-600',
        'text-white'
    );
    label.classList.add('bg-gray-200', 'hover:bg-gray-300');
    });
</script>

<!-- Add SweetAlert2 CDN in the head section -->
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function showThumbnail(src) {
    document.getElementById('modalImage').src = src;
    var myModal = new bootstrap.Modal(document.getElementById('thumbnailModal'));
    myModal.show();
}
</script>
@endpush
@endsection
