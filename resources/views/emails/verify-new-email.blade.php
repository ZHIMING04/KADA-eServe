<!DOCTYPE html>
<html>
<head>
    <title>Sahkan Alamat Emel Baru Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        .header, .footer {
            background: #333;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }
        .content {
            background: #fff;
            padding: 20px;
            margin: 20px 0;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sahkan Alamat Emel Baru Anda</h1>
    </div>
    <div class="container">
        <div class="content">
            <p>Halo, {{ $user->name }},</p>
            <p>Sila klik pautan di bawah untuk mengesahkan alamat emel baru anda:</p>
            <p><a href="{{ $verificationUrl }}">Sahkan Emel</a></p>
        </div>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} KADA-eServe. Semua Hak Cipta Terpelihara.</p>
    </div>
</body>
</html>