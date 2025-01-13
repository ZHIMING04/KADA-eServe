<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembaga Kemajuan Pertanian Kemubu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .feature-icon {
            background-color: #007BFF;
            color: white;
            border-radius: 50%;
            width: 70px;
            height: 70px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
            transition: all 0.3s ease;
        }
        .feature-section {
            padding: 60px 0;
            background-color: #f9f9f9;
        }
        .feature-section h2 {
            color: #007BFF;
        }
        .feature-card {
            text-align: center;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1);
            background-color: #0056b3;
        }
        .feature-card:hover h4 {
            color: #007BFF;
        }


        .display-4:hover {
            background-size: 300% auto;
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientText 8s ease infinite;
            transition: all 0.3s ease;
        }

        @keyframes gradientText {
            0% {
                background-image: linear-gradient(45deg, 
                    #007BFF 0%, 
                    #00BCD4 50%, 
                    #007BFF 100%
                );
            }
            20% {
                background-image: linear-gradient(45deg,
                    #00BCD4 0%,
                    #28a745 50%,
                    #00BCD4 100%
                );
            }
            40% {
                background-image: linear-gradient(45deg,
                    #28a745 0%,
                    #9C27B0 50%,
                    #28a745 100%
                );
            }
            60% {
                background-image: linear-gradient(45deg,
                    #9C27B0 0%,
                    #FF5722 50%,
                    #9C27B0 100%
                );
            }
            80% {
                background-image: linear-gradient(45deg,
                    #FF5722 0%,
                    #007BFF 50%,
                    #FF5722 100%
                );
            }
            100% {
                background-image: linear-gradient(45deg,
                    #007BFF 0%,
                    #00BCD4 50%,
                    #007BFF 100%
                );
            }
        }

        @keyframes smoothUnderlineColorChange {
            0%, 100% { background-color: #007BFF; }
            20% { background-color: #00BCD4; }
            40% { background-color: #28a745; }
            60% { background-color: #9C27B0; }
            80% { background-color: #FF5722; }
        }

        .display-4:hover::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 4px;
            border-radius: 2px;
            animation: smoothUnderlineColorChange 8s ease infinite;
        }
    </style>
</head>
<body>

<x-app-layout>
    

    <section class="feature-section text-center" style="padding:60px 0; background-color: #f9f9f9;">
        <div class="text-center py-5"">
            <div class="container">
                <h2 class="display-4 fw-bold text-primary mb-4" style="position: relative; display: inline-block;">
                    Nikmati Faedah Keahlian Kada!
                </h2>
            </div>
        </div>
        <div class="container">
            <h2 style="color: #007BFF;">Ciri-Ciri Utama</h2>
            <p>Platform digital untuk meningkatkan kemajuan sektor pertanian di Kemubu.</p>
            <div class="row mt-5">
                <div class="col-md-3">
                    <div class="feature-card" style="text-align: center; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); margin: 15px;">
                        <div class="feature-icon" style="background-color: #007BFF; color: white; border-radius: 50%; width: 70px; height: 70px; display: flex; justify-content: center; align-items: center; margin: 0 auto;">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <h4 class="mt-3">Mudah Digunakan</h4>
                        <p>Sistem yang mesra pengguna untuk memudahkan akses dan penggunaan.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card" style="text-align: center; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); margin: 15px;">
                        <div class="feature-icon" style="background-color: #007BFF; color: white; border-radius: 50%; width: 70px; height: 70px; display: flex; justify-content: center; align-items: center; margin: 0 auto;">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h4 class="mt-3">Reka Bentuk Moden</h4>
                        <p>Antara muka yang moden dan responsif untuk pengalaman terbaik.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card" style="text-align: center; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); margin: 15px;">
                        <div class="feature-icon" style="background-color: #007BFF; color: white; border-radius: 50%; width: 70px; height: 70px; display: flex; justify-content: center; align-items: center; margin: 0 auto;">
                            <i class="fas fa-tools"></i>
                        </div>
                        <h4 class="mt-3">Boleh Diubahsuai</h4>
                        <p>Mudah untuk menyesuaikan sistem mengikut keperluan organisasi.</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="feature-card" style="text-align: center; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); margin: 15px;">
                        <div class="feature-icon" style="background-color: #007BFF; color: white; border-radius: 50%; width: 70px; height: 70px; display: flex; justify-content: center; align-items: center; margin: 0 auto;">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h4 class="mt-3">Sokongan 24/7</h4>
                        <p>Bantuan teknikal sepanjang masa untuk memastikan kelancaran sistem.</p>
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
