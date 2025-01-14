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

    <!-- Main Container -->
    <div class="container">
        <div class="header">
            <h1>LAPORAN TAHUNAN</h1>
        </div>
        
        <div class="content">
            <h2>Explore Our Annual Reports</h2>
            <p>Browse through the reports for the years. Click on the report title to download.</p>
        </div>

        <div class="reports">
            <!-- Annual Report 1 -->
            <div class="report-card">
                <img src="https://via.placeholder.com/250x150.png?text=Report+1" alt="Report 1">
                <h3>Annual Report 2023 – Integrated Report</h3>
                <p>A comprehensive overview of the Group’s performance in FY2023 and outlook for FY2024.</p>
                <a href="#" download>Download Report</a>
            </div>
            
            <!-- Annual Report 2 -->
            <div class="report-card">
                <img src="{{ asset('image/report2021.png') }}" alt="Report 2021">
                <h3>Laporan Tahunan 2021</h3>
                <p>The full set of the Group’s and Bank’s audited financial statements.</p>
                <a href="https://www.parlimen.gov.my/ipms/eps/2023-06-12/ST.118.2023%20-%20ST%20118.2023.pdf" download>Download Report</a>
            </div>

            <!-- Annual Report 3 -->
            <div class="report-card">
                <img src="{{ asset('image/report2018.png') }}" alt="Report 2018">
                <h3>Laporan Tahunan 2018</h3>
                <p>A comprehensive report of the Group’s sustainability performance.</p>
                <a href="https://www.parlimen.gov.my/ipms/eps/2020-07-21/ST.176.2019%20-%20ST%20176.2019.pdf" download>Download Report</a>
            </div>

            <!-- Annual Report 4 -->
            <div class="report-card">
                <img src="https://via.placeholder.com/250x150.png?text=Report+4" alt="Report 4">
                <h3>Maybank Environmental Report 2023</h3>
                <p>A comprehensive overview of the Group’s approach to environmental issues.</p>
                <a href="#" download>Download Report</a>
            </div>
        </div>
        </x-app-layout>

        <div class="footer">
            &copy; 2025 KADA. All rights reserved.
        </div>
    </div>
</body>
</html>
