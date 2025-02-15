<!DOCTYPE html>
<html>
<head>
    <title>Permohonan Keahlian Ditolak</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #2d3748;">Status Permohonan Keahlian</h1>

        <p>Salam {{ $member->name }},</p>

        <p>Permohonan keahlian anda telah ditolak.</p>

        <div style="margin: 20px 0; padding: 15px; background-color: #FEE2E2; border-radius: 4px;">
            <p style="margin: 0; color: #991B1B;"><strong>Sebab Penolakan:</strong><br>
            {{ $rejectionReason }}</p>
        </div>

        <p>Sekiranya anda mempunyai sebarang pertanyaan, sila hubungi pihak kami.</p>

        <p>Salam Hormat,<br>
        Koperasi Kakitangan KADA Kelantan Berhad</p>
    </div>
</body>
</html>
