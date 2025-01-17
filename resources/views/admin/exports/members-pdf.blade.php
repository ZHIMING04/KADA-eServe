<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script type="text/php">
        if (isset($pdf)) {
            $text = "Muka " . $PAGE_NUM . " daripada " . $PAGE_COUNT;
            $size = 10;
            $font = $fontMetrics->getFont("DejaVu Sans");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 35;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .logo-container {
            margin-bottom: 15px;
        }
        .logo {
            max-width: 200px;
            height: auto;
        }
        .title {
            color: #1e40af;
            font-size: 24px;
            margin: 10px 0;
        }
        .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
        }
        th {
            background-color: #2563eb;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-size: 14px;
        }
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 30px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        .page-number {
            font-size: 10px;
            text-align: center;
            color: #9ca3af;
            margin-top: 20px;
        }
        .timestamp {
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo-container">
            <img src="{{ public_path('images/KADAlogoresize.png') }}" class="logo" alt="KADA Logo">
        </div>
        <h2 class="title">Senarai Ahli</h2>
        <p class="subtitle">Koperasi Ahli KADA</p>
        <p class="timestamp">Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                @foreach($selectedFields as $field)
                    <th>{{ $fieldTranslations[$field] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($membersData as $member)
                <tr>
                    @foreach($selectedFields as $field)
                        <td>{{ $member->$field }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Jumlah Rekod: {{ $membersData->count() }}</p>
    </div>
</body>
</html> 