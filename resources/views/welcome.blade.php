<!DOCTYPE html>
<html lang="ms" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembaga Kemajuan Pertanian Kemubu (KADA)</title>
    <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
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

        /* Icon navigation styles */
        .icon-nav {
            background: #f8f9fa;
            padding: 1rem 0;
            border-top: 1px solid #dee2e6;
            margin-top: 2rem;
        }

        .icon-nav .nav-item {
            text-align: center;
            color: #198754;
        }

        .icon-nav .nav-link {
            color: inherit;
            text-decoration: none;
        }

        .icon-nav i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .icon-nav span {
            font-size: 0.875rem;
            display: block;
        }

                /* Updated hero section styles */
                .hero-section {
            background-image: url('{{ asset("images/paddy.jpg") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
        }
        .hero-content {
            position: relative;
            z-index: 2;
            background: rgba(0, 0, 0, 0.7);
            padding: 3rem 4rem;
            border-radius: 30px;
            max-width: 700px;
            margin-left: 5%;
            text-align: left;
            color: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
        .hero-content h1 {
            color: white;
            font-size: 3.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
        }
        .hero-content .lead {
            color: white;
            font-size: 1.25rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .hero-content .btn-success {
            padding: 0.8rem 2rem;
            font-size: 1.1rem;
            text-transform: uppercase;
            border-radius: 25px;
        }
        /* Add these new styles */
        .card {
            background: white;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .icon-wrapper {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .text-success {
            color: #198754 !important;
        }
        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
        }
        /* Add these styles to your existing styles */
        .about-section {
            background-color: #f8f9fa;
        }
        .about-section img {
            width: 100%;
            height: auto;
            object-fit: cover;
            border-radius: 15px;
        }
        .about-section h2 {
            color: #198754;
            font-weight: bold;
        }
        .about-section p {
            line-height: 1.8;
            font-size: 1.1rem;
        }
        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
        /* Add Mission & Vision Section */
        .mission-vision-section {
            background-color: rgba(255, 255, 255, 0.9);
            background-image: url('{{ asset("images/paddy.jpg") }}');
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
            padding: 80px 0;
        }
        .timeline {
            position: relative;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .timeline::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            width: 2px;
            height: 100%;
            background: #ddd;
            transform: translateX(-50%);
        }
        .timeline-item {
            margin-bottom: 30px;
            position: relative;
        }
        .timeline-content {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            position: relative;
            margin-left: 50px;
            transition: transform 0.3s ease;
        }
        .timeline-content:hover {
            transform: translateY(-5px);
        }
        .timeline-dot {
            width: 20px;
            height: 20px;
            background: #198754;
            border-radius: 50%;
            position: absolute;
            left: -60px;
            top: 50%;
            transform: translateY(-50%);
            border: 4px solid white;
        }
        .vision-content {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            max-width: 800px;
            margin: 0 auto;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
        }
        .vision-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #198754;
            margin-right: 20px;
            padding: 10px 20px;
            background: rgba(25, 135, 84, 0.1);
            border-radius: 10px;
        }
        .vision-text {
            font-size: 1.2rem;
            color: #333;
            line-height: 1.6;
        }
        h2, h3 {
            color: #198754;
            font-weight: bold;
        }
        /* New Horizontal Timeline Styles */
        .horizontal-timeline {
            position: relative;
            width: 100%;
            margin: 0 auto;
        }
        .timeline-row {
            position: relative;
            padding: 0 0 20px 0;
            margin-bottom: 20px;
        }
        .timeline-line {
            position: absolute;
            width: 90%;
            height: 2px;
            background: #ddd;
            bottom: 0;
            left: 5%;
        }
        .timeline-items {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 0 40px;
            gap: 20px;
        }
        .timeline-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }
        .timeline-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            width: 100%;
            height: 150px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
            position: relative;
        }
        .timeline-number {
            position: absolute;
            top: -15px;
            font-size: 1.2rem;
            font-weight: bold;
            color: white;
            padding: 5px 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        /* Different colors for each number */
        .timeline-item:nth-child(1) .timeline-number {
            background: #FF6B6B;  /* Coral Red */
        }
        .timeline-item:nth-child(2) .timeline-number {
            background: #4ECDC4;  /* Turquoise */
        }
        .timeline-item:nth-child(3) .timeline-number {
            background: #45B7D1;  /* Sky Blue */
        }
        .timeline-item:nth-child(4) .timeline-number {
            background: #96CEB4;  /* Sage Green */
        }
        .timeline-item:nth-child(5) .timeline-number {
            background: #FFEEAD;  /* Light Yellow */
            color: #666; /* Darker text for better contrast */
        }
        .timeline-item:nth-child(6) .timeline-number {
            background: #D4A5A5;  /* Dusty Rose */
        }
        .timeline-text {
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
            margin-top: 10px;
        }
        .timeline-content:hover {
            transform: translateY(-5px);
        }
        @media (max-width: 768px) {
            .timeline-items {
                flex-direction: column;
                margin: 0;
            }
            .timeline-item {
                width: 100%;
                margin: 10px 0;
            }
            .timeline-content {
                height: auto;
                min-height: 120px;
                padding: 25px 15px 15px;
            }
            .timeline-number {
                font-size: 1.1rem;
                top: -12px;
            }
            .timeline-line {
                display: none;
            }
            footer .d-flex {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
        }
        html {
            scroll-behavior: smooth;
        }
        
        /* Optional: Add some padding-top to account for fixed navbar if you have one */
        #tentang-kami {
            scroll-margin-top: 80px; /* Adjust this value based on your navbar height */
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="#">KADA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Utama</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#visi-misi" onclick="smoothScroll(event, 'visi-misi')">Visi & Misi</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">Laporan Tahunan</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">Hubungi Kami</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            @if(auth()->user()->isAn('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a>
                            @elseif(auth()->user()->isA('member'))
                                <a href="{{ route('member.dashboard') }}" class="nav-link">Dashboard Ahli</a>
                            @else
                                <a href="{{ route('guest.dashboard') }}" class="nav-link">Dashboard</a>
                            @endif
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Log Keluar</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Log Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- After nav section -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

     <!-- Updated Hero Section -->
     <div class="hero-section">
        <div class="hero-content">
            <h1>Selamat Datang ke KADA</h1>
            <p class="lead">Memacu Pembangunan Pertanian dan Kesejahteraan Komuniti</p>
            <a href="#tentang-kami" class="btn btn-success" onclick="smoothScroll(event, 'tentang-kami')">Tentang Kami</a>
        </div>
    </div>

    <!-- Updated Features Section -->
    <div class="container" style="margin-top: -50px; position: relative; z-index: 3;">
        <div class="row">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm text-center p-4">
                    <div class="icon-wrapper mb-4">
                        <i class="fas fa-seedling text-success fa-3x"></i>
                    </div>
                    <h4 class="mb-3">Pembangunan Pertanian</h4>
                    <p class="text-muted">Menyokong pembangunan sektor pertanian melalui teknologi moden dan amalan terbaik.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card border-0 shadow-sm text-center p-4">
                    <div class="icon-wrapper mb-4">
                        <i class="fas fa-users text-success fa-3x"></i>
                    </div>
                    <h4 class="mb-3">Sokongan Petani</h4>
                    <p class="text-muted">Menyediakan bantuan dan sokongan kepada petani untuk meningkatkan hasil pertanian.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card border-0 shadow-sm text-center p-4">
                    <div class="icon-wrapper mb-4">
                        <i class="fas fa-home text-success fa-3x"></i>
                    </div>
                    <h4 class="mb-3">Pembangunan Komuniti</h4>
                    <p class="text-muted">Membantu dalam pembangunan sosio-ekonomi komuniti pertanian.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this after the Features Section -->
    <div id="tentang-kami" class="about-section py-5 mt-5">
    <div class="container">
    <div class="row align-items-center">
    <div class="col-md-5" data-aos="fade-right">
                    <img src="{{ asset('images/slide1.jpg') }}" alt="KADA Paddy Field" class="img-fluid rounded shadow-lg">
                </div>
                <div class="col-md-7" data-aos="fade-left">
                    <h2 class="mb-4">Tentang Kami</h2>
                    <p class="text-muted">
                        KADA merupakan sebuah agensi kerajaan yang bertanggungjawab dalam pembangunan sektor pertanian di kawasan Kemubu. 
                        Kami komited dalam menyediakan perkhidmatan terbaik kepada komuniti petani dan memastikan pembangunan pertanian yang mampan.
                    </p>
                    <p class="text-muted">
                        Dengan pengalaman lebih 50 tahun, KADA telah berjaya membangunkan infrastruktur pengairan, 
                        memberikan sokongan teknikal, dan meningkatkan taraf hidup petani melalui pelbagai program pembangunan.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-success mt-3">Ketahui Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>

         <!-- Vision & Mission Section -->
    <div id="visi-misi" class="vision-mission-section py-5">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">VISI & MISI</h2>

            <!-- Vision Section First -->
            <div class="vision-section mb-5">
                <h3 class="text-center mb-4 text-success" data-aos="fade-up">VISI</h3>
                <div class="vision-content" data-aos="fade-up">
                    <div class="vision-number">01</div>
                    <div class="vision-text">
                        Menjadi Satu Agensi Peneraju Dalam Bidang Penanaman Padi dan Agro-makanan Kearah Melahirkan Golongan Sasar Berpendapatan Tinggi.
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- Mission Section Second -->
     <div class="mission-section mt-5">
                <h3 class="text-center mb-4 text-success" data-aos="fade-up">MISI</h3>
                <p class="text-center mb-4" data-aos="fade-up">Bagi merealisasikan visi, KADA akan menerajui dengan cekap dan berkesan melalui :</p>

                <!-- Horizontal Timeline -->
                <div class="horizontal-timeline" data-aos="fade-up">
                    <!-- First Row -->
                    <div class="timeline-row">
                        <div class="timeline-items">
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-number">01</div>
                                    <div class="timeline-text">Pengeluaran padi dan agromakanan sebagai urusan utama KADA.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-number">02</div>
                                    <div class="timeline-text">Sistem pentadbiran yang berkualiti, efisyen, berteknologi dan integriti.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-number">03</div>
                                    <div class="timeline-text">Penerokaan pasaran di dalam dan di luar negara.</div>
                                </div>
                            </div>
                        </div>
                    </div>
        <!-- Second Row -->
        <div class="timeline-row mt-5">
                        <div class="timeline-items">
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-number">04</div>
                                    <div class="timeline-text">Mempertingkatkan keupayaan petani dan usahawan tani.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-number">05</div>
                                    <div class="timeline-text">Pembangunan kegiatan yang mampan.</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <div class="timeline-number">06</div>
                                    <div class="timeline-text">Pewujudan persekitaran kerja yang kondusif.</div>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-line"></div>
                    </div>
                </div>
            </div>
    <!-- Footer -->
    <footer class="bg-dark text-light py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="mb-1">Lembaga Kemajuan Pertanian Kemubu (KADA)</h6>
                </div>
                <div class="col-md-6 text-md-end">
                    <small>© 2024 KADA. Hak Cipta Terpelihara.</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <!-- Add AOS JS before closing body tag -->
 <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-quad',
            once: true
        });
        function smoothScroll(event, targetId) {
            event.preventDefault();
            const targetSection = document.getElementById(targetId);
            targetSection.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    </script>

    <!-- Add the required scripts -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        var botmanWidget = {
            frameEndpoint: '/botman/widget',
            chatServer: '/botman',
            title: 'Pembantu KADA',
            introMessage: 'Selamat datang ke KADA! Bagaimana saya boleh bantu anda?',
            placeholderText: 'Taip mesej anda...',
            mainColor: '#198754',
            bubbleBackground: '#198754',
            aboutText: 'Pembantu Chat KADA',
            bubbleIcon: 'mail',
            displayMessageTime: true,
            bubbleHint: "Ada Pertanyaan?",
            widgetHeight: 430
        };
    </script>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>
</body>
</html>
