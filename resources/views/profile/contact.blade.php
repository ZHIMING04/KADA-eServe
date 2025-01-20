<!DOCTYPE html>
<html lang="ms" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - Lembaga Kemajuan Pertanian Kemubu (KADA)</title>
    <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">
    <!-- Bootstrap CSS -->
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

        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
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

        .hero-animate {
            background: linear-gradient(135deg, #198754 0%, #146c43 100%) !important;
            position: relative;
            top: -200px; /* Start from above the viewport */
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
                        <a class="nav-link" href="{{ route('welcome') }}">Utama</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Laporan Tahunan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Hubungi Kami</a>
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

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <div class="bg-success text-white py-5 hero-animate">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-md-8">
                        <h1 class="display-4 mb-4 slide-down custom-title">HUBUNGI KAMI</h1>
                        <p class="lead slide-down-delay">Kami sentiasa bersedia untuk membantu anda. Hubungi kami melalui saluran-saluran berikut.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Cards Section -->
        <div class="container my-5">
            <div class="row justify-content-center g-4">
                <!-- Office Card -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-success shadow-sm hover-card">
                        <div class="card-body text-center">
                            <div class="icon-wrapper text-success mb-3">
                                <i class="fas fa-building fa-3x"></i>
                            </div>
                            <h5 class="card-title text-success">Pejabat Utama</h5>
                            <p class="card-text">
                                Lembaga Kemajuan Pertanian Kemubu<br>
                                Peti Surat 127, Jalan Dato'Lundang 15710<br>
                                Kota Bharu, Kelantan.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Card -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 border-success shadow-sm hover-card">
                        <div class="card-body text-center">
                            <div class="icon-wrapper text-success mb-3">
                                <i class="fas fa-phone-alt fa-3x"></i>
                            </div>
                            <h5 class="card-title text-success">Talian Utama</h5>
                            <p class="card-text">
                                Tel: +609-7455388<br>
                                
                                Waktu Operasi: 8:00 AM - 5:00 PM
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email Card -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-success shadow-sm hover-card">
                        <div class="card-body text-center">
                            <div class="icon-wrapper text-success mb-3">
                                <i class="fas fa-envelope fa-3x"></i>
                            </div>
                            <h5 class="card-title text-success">E-mel</h5>
                            <p class="card-text">
                                prokada@kada.gov.my<br>
                                
                                &nbsp;
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="row mt-5" data-aos="fade-up">
                <div class="col-12">
                    <div class="card border-success shadow-sm">
                        <div class="card-body p-0">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3967.043771404744!2d102.23843627479773!3d6.125249993860092!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31b6af96a6efffff%3A0x2c7d987f2c8ee840!2sLembaga%20Kemajuan%20Pertanian%20Kemubu%20(KADA)!5e0!3m2!1sen!2smy!4v1710910632099!5m2!1sen!2smy" 
                                width="100%" 
                                height="450" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
</body>
</html>