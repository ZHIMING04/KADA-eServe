<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembaga Kemajuan Pertanian Kemubu</title>
    <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-green: #20B2AA;
            --secondary-green: #27ae60;
            --primary-blue: #0066cc;
            --secondary-blue: #4d94ff;
            --light-blue: #e6f2ff;
            --accent-blue: #00a3ff;
            --deep-blue: #004d99;
            --light-green: #e8f5e9;
            --text-gray: #666;
            --accent-red: #e74c3c;
        }

        body {
            font-family: Arial, sans-serif;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--light-blue) 0%, #f8f9fa 100%);
            padding: 120px 0;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
        }

        .shape-1 {
            width: 100px;
            height: 100px;
            background: var(--primary-green);
            top: 10%;
            left: 5%;
        }

        .shape-2 {
            width: 150px;
            height: 150px;
            background: var(--primary-blue);
            bottom: 10%;
            right: 5%;
        }

        .category-icon {
            width: 80px;
            height: 80px;
            background: var(--light-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 4px 15px rgba(46, 204, 113, 0.1);
            transition: all 0.3s ease;
        }

        .category-icon i {
            color: var(--primary-green) !important;
        }

        .category-card:hover .category-icon {
            background: var(--primary-green);
        }

        .category-card:hover .category-icon i {
            color: white !important;
        }

        .category-card {
            text-align: center;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .promo-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .promo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .main-title {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-description {
            font-size: 1.2rem;
            color: var(--text-gray);
            margin-bottom: 2rem;
            max-width: 600px;
        }

        .btn-custom {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            background: linear-gradient(45deg, var(--primary-blue), var(--accent-blue));
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 102, 204, 0.3);
            background: linear-gradient(45deg, var(--accent-blue), var(--primary-blue));
            color: white;
        }

        .main-title:hover {
            /* No effects on hover */
        }

        .description-text {
            color: #444;
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            background: var(--light-blue);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .feature-box {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 102, 204, 0.1);
        }
        
        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 102, 204, 0.1);
            border-color: var(--secondary-blue);
        }
        
        .feature-box:hover .icon-circle {
            background: linear-gradient(45deg, var(--primary-blue), var(--accent-blue));
        }

        .feature-box:hover .icon-circle i {
            color: white !important;
        }

        .icon-circle i {
            font-size: 1.5rem;
            color: var(--primary-blue);
            transition: all 0.3s ease;
        }

        .feature-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--deep-blue);
            margin-bottom: 1rem;
        }

        .feature-text {
            color: var(--text-gray);
            line-height: 1.6;
        }

        .features-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa, var(--light-blue));
        }

        .vertical-separator {
            width: 3px;
            height: 300px;  /* Adjust height as needed */
            background: grey;
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            border-radius: 3px;
        }

        .kategori-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: var(--primary-green);
            margin-bottom: 2rem;
            position: relative;
        }

        .right-section {
            position: relative;
            padding-left: 2rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--deep-blue);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: var(--text-gray);
            max-width: 700px;
            margin: 0 auto 3rem;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fadeInRight {
            animation: fadeInRight 0.8s ease-out forwards;
        }

        .animate-scaleIn {
            animation: scaleIn 0.8s ease-out forwards;
        }

        .delay-1 {
            animation-delay: 0.2s;
        }

        .delay-2 {
            animation-delay: 0.4s;
        }

        .delay-3 {
            animation-delay: 0.6s;
        }

        .feature-box:nth-child(1) { border-top: 3px solid var(--primary-blue); }
        .feature-box:nth-child(2) { border-top: 3px solid var(--secondary-blue); }
        .feature-box:nth-child(3) { border-top: 3px solid var(--accent-blue); }
        .feature-box:nth-child(4) { border-top: 3px solid var(--deep-blue); }

        @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }
            
            .hero-section {
                padding: 80px 0;
            }
        }

        .welcome-text {
            color: #d35400; /* Same as member dashboard */
            font-weight: 800;
        }

        .membership-text {
            color: var(--deep-blue);
        }

        .apply-now-btn {
            display: inline-block;
            padding: 15px 40px;
            background: #e67e22; /* Warm orange */
            color: white;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
        }

        .apply-now-btn:hover {
            background: #d35400;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
            color: white;
        }
    </style>
</head>
<body>

<x-app-layout>
    <section class="hero-section">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        
        <div class="container">
            <div class="hero-content text-center animate-fadeInUp">
                <h1 class="main-title">
                    <span class="welcome-text">Nikmati Faedah</span><br>
                    <span class="membership-text">Keahlian Koperasi KADA!</span>
                </h1>
                <p class="hero-description mx-auto">Platform digital untuk meningkatkan kemajuan sektor pertanian di Kemubu.</p>
                <a href="http://kada-eserve.test/guest/register" class="btn apply-now-btn animate-fadeInUp delay-1">Sertai Kami</a>
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title animate-scaleIn">Mengapa Pilih Kami?</h2>
                <p class="section-subtitle animate-scaleIn delay-1">Kami menawarkan pelbagai perkhidmatan dan faedah untuk membantu anda mencapai kejayaan</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-6 animate-fadeInRight delay-1">
                    <div class="feature-box">
                        <div class="icon-circle">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h3 class="feature-title">Bantuan Kewangan</h3>
                        <p class="feature-text">Pinjaman dengan kadar faedah rendah dan tempoh pembayaran yang fleksibel untuk membantu pembangunan pertanian anda.</p>
                    </div>
                </div>

                <div class="col-lg-6 animate-fadeInRight delay-2">
                    <div class="feature-box">
                        <div class="icon-circle">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h3 class="feature-title">Sokongan Teknikal</h3>
                        <p class="feature-text">Khidmat nasihat dan bantuan teknikal dari pakar pertanian untuk meningkatkan hasil tanaman.</p>
                    </div>
                </div>

                <div class="col-lg-6 animate-fadeInRight delay-2">
                    <div class="feature-box">
                        <div class="icon-circle">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="feature-title">Komuniti Aktif</h3>
                        <p class="feature-text">Rangkaian petani yang saling membantu dan berkongsi pengalaman untuk kemajuan bersama.</p>
                    </div>
                </div>

                <div class="col-lg-6 animate-fadeInRight delay-3">
                    <div class="feature-box">
                        <div class="icon-circle">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <h3 class="feature-title">Program Latihan</h3>
                        <p class="feature-text">Latihan berkala untuk meningkatkan kemahiran dan pengetahuan dalam bidang pertanian moden.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
