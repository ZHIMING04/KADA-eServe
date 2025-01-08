<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annual Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e8f5e9; /* Pale green background */
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* Navigation Bar */
        nav {
            background-color: #4caf50;
            padding: 10px 20px;
        }
        nav .logo {
            height: 80px;
            background: none; /* Transparent background */
            margin-right: 20px;
            display: flex;
            align-items: center;
        }
        nav img {
            height: 100%;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-end;
        }
        nav ul li {
            margin-left: 20px;
            color: #fff;
            font-size: 18px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
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
            padding: 15px;
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

        @media (max-width: 768px) {
        .nav-links {
            display: none; /* Hide the menu by default */
            flex-direction: column; /* Stack items vertically */
            background-color: #c8e6c9;
            position: absolute;
            top: 60px;
            right: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 10px;
            z-index: 1;
        }

        .nav-links.active {
            display: flex; /* Show menu when active */
        }

        .menu-icon {
            display: block; /* Show hamburger icon */
        }
}
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <!-- Logo in navigation bar -->
            <img src="{{ asset('images/kada.jpg') }}" alt="KADA Logo">
      
        <i class="fas fa-bars menu-icon" id="menu-icon"></i> <!-- Hamburger Icon -->
        <ul id="nav-links" class="nav-links">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </nav>

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
                <img src="{{ asset('images/report2021.png') }}" alt="Report 2021">
                <h3>Laporan Tahunan 2021</h3>
                <p>The full set of the Group’s and Bank’s audited financial statements.</p>
                <a href="https://www.parlimen.gov.my/ipms/eps/2023-06-12/ST.118.2023%20-%20ST%20118.2023.pdf" download>Download Report</a>
            </div>

            <!-- Annual Report 3 -->
            <div class="report-card">
                <img src="{{ asset('images/report2018.png') }}" alt="Report 2018">
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

        <div class="footer">
            &copy; 2025 KADA. All rights reserved.
        </div>
    </div>
</body>
</html>
