<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Upload Annual Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="upload-container">
                        <form action="{{ route('admin.annual-reports.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
                            @csrf
                            
                            <div class="form-group">
                                <input type="text" name="title" class="form-control" placeholder="Report Title" required>
                            </div>
                            
                            <div class="form-group">
                                <textarea name="description" class="form-control" placeholder="Description" required></textarea>
                            </div>
                            
                            <div class="form-group">
                                <input type="number" name="year" class="form-control" placeholder="Year" required>
                            </div>

                            <div class="upload-box">
                                <div class="upload-area" id="drop-zone">
                                    <div class="upload-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                            <polyline points="17 8 12 3 7 8"/>
                                            <line x1="12" y1="3" x2="12" y2="15"/>
                                        </svg>
                                    </div>
                                    <p>Drop your files here</p>
                                    <span>or</span>
                                    <label class="browse-btn">Browse
                                        <input type="file" name="image" id="image-upload" hidden accept="image/*">
                                        <input type="file" name="pdf" id="pdf-upload" hidden accept="application/pdf">
                                    </label>
                                </div>
                                
                                <div class="file-list" id="file-list">
                                    <!-- Files will be listed here -->
                                </div>
                            </div>

                            <button type="submit" class="submit-btn">Upload Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<style>
.upload-container {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
}

.upload-box {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 2rem;
}

.upload-area {
    border: 2px dashed #4A90E2;
    border-radius: 8px;
    padding: 2rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.upload-area:hover {
    background: #f8f9fa;
}

.upload-icon {
    color: #4A90E2;
    margin-bottom: 1rem;
}

.browse-btn {
    display: inline-block;
    color: #4A90E2;
    cursor: pointer;
    padding: 0.5rem 1rem;
    margin-top: 0.5rem;
}

.file-list {
    margin-top: 1rem;
}

.file-item {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border-bottom: 1px solid #eee;
}

.file-item .file-icon {
    margin-right: 0.5rem;
    color: #4A90E2;
}

.file-item .file-name {
    flex-grow: 1;
}

.file-item .file-size {
    color: #666;
    font-size: 0.875rem;
}

.submit-btn {
    background: #4A90E2;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 5px;
    margin-top: 1rem;
    cursor: pointer;
}

.submit-btn:hover {
    background: #357ABD;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('drop-zone');
    const fileList = document.getElementById('file-list');
    const imageUpload = document.getElementById('image-upload');
    const pdfUpload = document.getElementById('pdf-upload');

    function handleFileSelect(file, type) {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item';
        
        const icon = type === 'image' ? '🖼️' : '📄';
        const fileSize = (file.size / 1024 / 1024).toFixed(2); // Convert to MB
        
        fileItem.innerHTML = `
            <span class="file-icon">${icon}</span>
            <span class="file-name">${file.name}</span>
            <span class="file-size">${fileSize} MB</span>
        `;
        
        // Clear previous files of same type
        const existingFiles = fileList.querySelectorAll('.file-item');
        existingFiles.forEach(item => {
            if (item.querySelector('.file-icon').textContent === icon) {
                item.remove();
            }
        });
        
        fileList.appendChild(fileItem);
    }

    imageUpload.addEventListener('change', function(e) {
        if (this.files[0]) handleFileSelect(this.files[0], 'image');
    });

    pdfUpload.addEventListener('change', function(e) {
        if (this.files[0]) handleFileSelect(this.files[0], 'pdf');
    });

    // Drag and drop functionality
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.style.background = '#f8f9fa';
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.style.background = 'white';
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.style.background = 'white';
        
        const files = e.dataTransfer.files;
        for (let file of files) {
            if (file.type.startsWith('image/')) {
                imageUpload.files = e.dataTransfer.files;
                handleFileSelect(file, 'image');
            } else if (file.type === 'application/pdf') {
                pdfUpload.files = e.dataTransfer.files;
                handleFileSelect(file, 'pdf');
            }
        }
    });
});
</script> 