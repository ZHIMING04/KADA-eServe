<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembaga Kemajuan Pertanian Kemubu (KADA)</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="#">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Perkhidmatan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Hubungi</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <a class="nav-link" href="/login">Log Masuk</a>
                    <a class="nav-link" href="/register">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container-fluid bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">Selamat Datang ke KADA</h1>
                    <p class="lead">Memacu Pembangunan Pertanian dan Kesejahteraan Komuniti</p>
                    <a href="#" class="btn btn-success btn-lg">Ketahui Lebih Lanjut</a>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('image/paddy.jpg') }}" alt="KADA" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container my-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pembangunan Pertanian</h5>
                        <p class="card-text">Menyokong pembangunan sektor pertanian melalui teknologi moden dan amalan terbaik.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Sokongan Petani</h5>
                        <p class="card-text">Menyediakan bantuan dan sokongan kepada petani untuk meningkatkan hasil pertanian.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Pembangunan Komuniti</h5>
                        <p class="card-text">Membantu dalam pembangunan sosio-ekonomi komuniti pertanian.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Lembaga Kemajuan Pertanian Kemubu (KADA)</h5>
                    <p>Membangunkan sektor pertanian untuk masa depan yang lebih baik.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>© 2024 KADA. Hak Cipta Terpelihara.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
