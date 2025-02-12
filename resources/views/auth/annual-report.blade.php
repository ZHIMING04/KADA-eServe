<!DOCTYPE html>
<html lang="ms" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahunan - Lembaga Kemajuan Pertanian Kemubu (KADA) </title>
    <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Poppins:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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

        .custom-select {
            transition: all 0.3s ease;
            border-color: #198754;
        }

        .custom-select:hover {
            border-color: #146c43;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        .custom-select:focus {
            border-color: #146c43;
            box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
        }

        #searchForm {
            transition: all 0.3s ease;
        }

        #searchForm:hover {
            transform: translateY(-2px);
        }

        .input-group {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        #yearSelector {
            min-width: 200px;
            border-radius: 0.5rem;
            padding: 0.5rem;
            border: 1px solid #dee2e6;
        }

        #yearSelector:focus {
            border-color: #5ba4fc;
            box-shadow: 0 0 0 0.2rem rgba(91, 164, 252, 0.25);
        }

        #clearFilter {
            transition: all 0.3s ease;
        }

        #clearFilter:hover {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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

        <div class="container mx-auto px-4 py-4">
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <select id="yearSelector" class="form-select me-2">
                                    <option value="all">Semua Tahun</option>
                                    @for($year = 2025; $year >= 2000; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                                <button id="clearFilter" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Reset
                                </button>
                            </div>
                        </div>
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

            // Add filtering functionality
            document.addEventListener('DOMContentLoaded', function() {
                const yearSelector = document.getElementById('yearSelector');
                const clearFilter = document.getElementById('clearFilter');
                const reportCards = document.querySelectorAll('.card.h-100');

                function filterReports(selectedYear) {
                    reportCards.forEach(card => {
                        const yearText = card.querySelector('.text-muted.mb-3.small').textContent;
                        const cardYear = yearText.match(/Tahun: (\d{4})/)[1];
                        const rowContainer = card.closest('.col-md-6').parentElement;
                        const cardContainer = card.closest('.col-md-6');
                        
                        if (selectedYear === 'all' || selectedYear === cardYear) {
                            cardContainer.style.display = '';
                            cardContainer.style.animation = 'fadeIn 0.5s ease-in';
                        } else {
                            cardContainer.style.display = 'none';
                        }

                        // Hide empty rows
                        if (Array.from(rowContainer.children).every(col => col.style.display === 'none')) {
                            rowContainer.style.display = 'none';
                        } else {
                            rowContainer.style.display = '';
                        }
                    });
                }

                yearSelector.addEventListener('change', function() {
                    filterReports(this.value);
                });

                clearFilter.addEventListener('click', function() {
                    yearSelector.value = 'all';
                    filterReports('all');
                });
            });
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
                            <h1 class="display-4 mb-0 slide-down custom-title">Laporan Tahunan</h1>
                        </div>
                        <p class="lead slide-down-delay text-blue-800 mb-2">Terokai Laporan Tahunan</p>
                        <p class="lead slide-down-delay">Akses dan muat turun laporan tahunan KADA di sini.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <form id="searchForm" class="shadow-sm rounded-3 p-4 bg-white border">
                        <div class="position-relative">
                            <label for="yearOfReport" class="form-label fw-bold text-success mb-3">
                                <i class="bi bi-calendar3"></i> Carian Laporan Tahunan
                            </label>
                            <div class="input-group">
                                <select name="year" id="yearOfReport" class="form-select form-select-lg custom-select">
                                    <option value="" disabled selected>-- Pilih Tahun --</option>
                                    @for($i = date('Y'); $i >= 2000; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                                <button type="button" id="clearFilter" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>
                    </form>
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

    @endif
</body>
</html>