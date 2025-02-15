<!DOCTYPE html>
<html>
<head>
    <title>Permohonan Pinjaman Ditolak</title>
</head>
<body style="
    font-family: Arial, sans-serif; 
    line-height: 1.6; 
    color: #333;
    background-image: url('http://kada-eserve.test/images/paddy.jpg');
    background-size: cover;
    background-position: center;
    margin: 0;
    padding: 40px 20px;">
    <div style="
        max-width: 600px; 
        margin: 0 auto; 
        padding: 30px;
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        
        <h1 style="
            color: #1a5f7a;
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);">
            Permohonan Pinjaman Ditolak
        </h1>

        <p style="
            font-size: 16px;
            margin-bottom: 20px;
            color: #2d3748;
            font-weight: 500;">
            Salam {{ $loan->member->name }},
        </p>

        <p style="
            font-size: 16px;
            margin-bottom: 20px;
            color: #2d3748;">
            Kami ingin memaklumkan bahawa permohonan pinjaman anda telah ditolak.
        </p>

        <div style="
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <p style="
                font-size: 16px;
                margin-bottom: 10px;
                color: #2d3748;">
                <strong>Maklumat Pinjaman</strong>
            </p>
            <p style="
                font-size: 16px;
                margin-bottom: 10px;
                color: #2d3748;">
                - ID Pinjaman: {{ $loan->loan_id }}<br>
                - Jumlah Pinjaman: RM {{ number_format($loan->loan_amount, 2) }}<br>
                - Tarikh Permohonan: {{ $loan->date_apply->format('d/m/Y') }}
            </p>
        </div>

        <div style="
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <p style="
                font-size: 16px;
                margin-bottom: 10px;
                color: #2d3748;">
                <strong>Sebab Penolakan:</strong>
            </p>
            <p style="
                font-size: 16px;
                margin-bottom: 10px;
                color: #2d3748;">
                {{ $rejection_reason }}
            </p>
        </div>

        <div style="text-align: center; margin: 40px 0;">
            <a href="{{ route('login') }}" 
               style="
                    background-color: #1a5f7a; 
                    color: white; 
                    padding: 15px 30px; 
                    text-decoration: none; 
                    border-radius: 6px; 
                    display: inline-block;
                    font-weight: bold;
                    font-size: 16px;
                    transition: background-color 0.3s ease;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                Log Masuk
            </a>
        </div>

        <p style="
            font-size: 16px;
            margin-bottom: 20px;
            color: #2d3748;">
            Jika anda mempunyai sebarang pertanyaan, sila hubungi pihak kami.
        </p>

        <div style="
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
            color: #2d3748;
            font-size: 16px;">
            <p>Salam Hormat,<br>
            <strong>Koperasi Kakitangan KADA Kelantan Berhad</strong></p>
        </div>
    </div>
</body>
</html>