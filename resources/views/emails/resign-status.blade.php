<!DOCTYPE html>
<html>
<head>
    <title>Status Permohonan Berhenti</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2d3748;">Permohonan anda untuk berhenti telah {{ $status }}</h1>

        <p>Salam {{ $member->name }},</p>

        @if($status === 'approved')
            <p>Permohonan anda untuk berhenti telah diluluskan.</p>
        @elseif($status === 'rejected')
            <p>Permohonan anda untuk berhenti tidak diluluskan. Sila hubungi pihak pentadbiran untuk maklumat lanjut.</p>
        @endif

        <p>Anda boleh menyemak status permohonan anda melalui profil dalam sistem.</p>

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
            Terima kasih!
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
