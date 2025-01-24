<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Keahlian Diluluskan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2d3748;">Pendaftaran Keahlian Diluluskan</h1>

        <p>Salam {{ $member->name }},</p>

        <p>Tahniah! Permohonan keahlian anda telah diluluskan.</p>

        <p>Anda kini boleh mengakses akaun anda dengan menggunakan email dan kata laluan yang telah didaftarkan.</p>

        <div style="margin: 30px 0;">
            <a href="{{ route('login') }}" 
               style="background-color: #4299e1; 
                      color: white; 
                      padding: 12px 24px; 
                      text-decoration: none; 
                      border-radius: 4px; 
                      display: inline-block;">
                Log Masuk
            </a>
        </div>

        <p>Terima kasih kerana menjadi ahli kami!</p>

        <p>Salam Hormat,<br>
        Koperasi Kakitangan KADA Kelantan Berhad</p>
    </div>
</body>
</html>
