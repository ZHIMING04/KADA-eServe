<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Annual Report</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body .container {
            max-width: 1200px;  /*Adjust this value to make it smaller */
            margin: 20px auto;
            padding: 15px;  /*Reduced padding for a more compact feel */
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #c8e6c9;
        }
        .header h1 {
            font-size: 2em;
            margin: 0;
            color: #388e3c;
        }

        .content {
            padding: 20px;
            line-height: 1.6;
            text-align: center; /* Centers text inside the content */
            /* max-width: 800px;  You can adjust this value to make the content container smaller */
        }

        .reports {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .report-card {
            width: 250px;
            background-color: #f9f9f9;
            background-color: #e8f5e9; /* Pale green background */
            padding: 20px; /* Increased padding */
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .report-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .report-card h3 {
            margin-top: 10px;
            font-size: 1.2em;
        }

        .footer {
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            border-top: 2px solid #c8e6c9;
            font-size: 0.9em;
            color: #777;
        }
    </style>

</head>
<body>
    <x-app-layout>

    <div class="container">
        <div class="header">
            <h1>LAPORAN TAHUNAN</h1>
        </div>
        
        <div class="content">
            <h2>Selamat datang ke Laman Laporan Tahunan kami.</h2>
        </div>

        <div class="reports">
            @forelse($reports as $report)
                <div class="report-card">
                    <img src="{{ Storage::url($report->image_path) }}" alt="{{ $report->title }}">
                    <h3>{{ $report->title }}</h3>
                    <p>{{ $report->description }}</p>
                    <a href="{{ Storage::url($report->pdf_path) }}" download>Download Report</a>
                </div>
            @empty
                <div class="text-center w-100">
                    <p>Tiada laporan tahunan yang tersedia pada masa ini.</p>
                </div>
            @endforelse
        </div>

        <div class="footer">
            &copy; 2025 KADA. All rights reserved.
        </div>
    </div>
    </x-app-layout>
</body>
</html> 