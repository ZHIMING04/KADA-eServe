<!DOCTYPE html>
<html lang="ms" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan - Lembaga Kemajuan Pertanian Kemubu (KADA)</title>
    <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1 0 auto;
        }

        footer {
            margin-top: auto;
        }

        .icon-wrapper {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-success {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
        }

        .text-success {
            color: #198754 !important;
        }

        .border-success {
            border-color: #198754 !important;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #0057A5 0%, #198754 60%, #E67A00 100%) !important;
        }

        .hero-animate {
            position: relative;
            top: -200px;
            animation: slideDown 1s ease-out forwards;
        }

        .slide-down {
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInSlideDown 0.8s ease-out 0.5s forwards;
        }

        .slide-down-delay {
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeInSlideDown 0.8s ease-out 0.8s forwards;
        }

        @keyframes slideDown {
            to {
                top: 0;
            }
        }

        @keyframes fadeInSlideDown {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .custom-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .custom-btn {
            background-color: #5ba4fc !important;
            border: none;
            color: white !important;
            transition: all 0.3s ease;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }

        .custom-btn:hover {
            background-color: #4183db !important;
            transform: translateY(-2px);
            color: white !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        @media (min-width: 768px) {
            .pe-md-2 {
                padding-right: 1rem !important;
            }
            .ps-md-2 {
                padding-left: 1rem !important;
            }
        }

        .modal-dialog.modal-lg {
            max-width: 800px;
        }

        .thumbnail-img {
            transition: opacity 0.3s ease;
        }

        .thumbnail-img:hover {
            opacity: 0.8;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .modal-content {
            border: none;
        }
    </style>
</head>
<body>
    @if(auth()->check() && (auth()->user()->isA('member') || auth()->user()->isA('guest')))
        <x-app-layout>
        <div class="bg-gradient text-white py-5 hero-animate">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <svg class="w-16 h-16 text-white me-3" style="width: 40px; height: 40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h1 class="display-4 mb-0 slide-down custom-title">LAPORAN TAHUNAN</h1>
                        </div>
                        <p class="lead slide-down-delay mb-2">Terokai Laporan Tahunan</p>
                        <p class="lead slide-down-delay">Akses dan muat turun laporan tahunan KADA di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Report Cards Section -->
            <div class="row mt-4 justify-content-center hero-animate">
                @foreach($reports->sortByDesc('year')->chunk(2) as $chunk)
                    <div class="row mb-4" style="max-width: 1000px;">
                        @foreach($chunk as $report)
                            <div class="col-md-6 mb-4 {{ $loop->first ? 'pe-md-2' : 'ps-md-2' }}">
                                <div class="card h-100">
                                    <div class="card-body d-flex">
                                        <!-- Thumbnail on the left -->
                                        <div class="me-3" style="width: 120px; min-width: 120px;">
                                            <img src="{{ asset($report->thumbnail) }}" 
                                                alt="Thumbnail" 
                                                class="img-fluid rounded-4 thumbnail-img" 
                                                style="height: 160px; width: 100%; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#imageModal"
                                                onclick="showImage(this.src)">
                                        </div>
                                        <!-- Content on the right -->
                                        <div class="d-flex flex-column justify-content-between" style="min-width: 0;">
                                            <div>
                                                <h5 class="card-title text-success mb-2 text-truncate">{{ $report->title }}</h5>
                                                <p class="card-text text-muted mb-2 small">{{ $report->description }}</p>
                                                <p class="text-muted mb-3 small">Tahun: {{ $report->year }}</p>
                                            </div>
                                            <div>
                                                <a href="{{ asset($report->file_path) }}" 
                                                class="btn custom-btn" 
                target="_blank">
                                                    Akses PDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            @if($reports->isEmpty())
                <div class="text-center text-gray-500 my-8">
                    <p>Tiada laporan tahunan pada masa ini.</p>
                </div>
            @endif
        </div>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="" class="img-fluid rounded-4" id="modalImage" alt="Thumbnail Preview" style="max-height: 80vh; width: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function showImage(src) {
                document.getElementById('modalImage').src = src;
            }
        </script>

        </x-app-layout>

    @else
        <!-- Unauthorized User Content -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-success">
            <div class="container">
                <a class="navbar-brand" href="#">KADA</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('welcome') }}">Utama</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('annual-reports') }}">Laporan Tahunan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}">Hubungi Kami</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Log Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Daftar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="bg-gradient text-white py-5 hero-animate">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <svg class="w-16 h-16 text-white me-3" style="width: 40px; height: 40px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h1 class="display-4 mb-0 slide-down custom-title">LAPORAN TAHUNAN</h1>
                        </div>
                        <p class="lead slide-down-delay text-blue-800 mb-2">Terokai Laporan Tahunan</p>
                        <p class="lead slide-down-delay">Akses dan muat turun laporan tahunan KADA di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <!-- Report Cards Section -->
            <div class="row mt-4 justify-content-center hero-animate">
                @foreach($reports->sortByDesc('year')->chunk(2) as $chunk)
                    <div class="row mb-4" style="max-width: 1000px;">
                        @foreach($chunk as $report)
                            <div class="col-md-6 mb-4 {{ $loop->first ? 'pe-md-2' : 'ps-md-2' }}">
                                <div class="card h-100">
                                    <div class="card-body d-flex">
                                        <!-- Thumbnail on the left -->
                                        <div class="me-3" style="width: 120px; min-width: 120px;">
                                            <img src="{{ asset($report->thumbnail) }}" 
                                                alt="Thumbnail" 
                                                class="img-fluid rounded-4 thumbnail-img" 
                                                style="height: 160px; width: 100%; object-fit: cover; cursor: pointer;"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#imageModal"
                                                onclick="showImage(this.src)">
                                        </div>
                                        <!-- Content on the right -->
                                        <div class="d-flex flex-column justify-content-between" style="min-width: 0;">
                                            <div>
                                                <h5 class="card-title text-success mb-2 text-truncate">{{ $report->title }}</h5>
                                                <p class="card-text text-muted mb-2 small">{{ $report->description }}</p>
                                                <p class="text-muted mb-3 small">Tahun: {{ $report->year }}</p>
                                            </div>
                                            <div>
                                                <a href="{{ asset($report->file_path) }}" 
                                                class="btn custom-btn" 
                target="_blank">
                                                    Akses PDF
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            @if($reports->isEmpty())
                <div class="text-center text-gray-500 my-8">
                    <p>Tiada laporan tahunan pada masa ini.</p>
                </div>
            @endif
        </div>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <img src="" class="img-fluid rounded-4" id="modalImage" alt="Thumbnail Preview" style="max-height: 80vh; width: 100%; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function showImage(src) {
                document.getElementById('modalImage').src = src;
            }
        </script>
    @endif
</body>
</html>
