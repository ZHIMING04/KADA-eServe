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

        <form action="{{ route('admin.annual-reports.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Cover Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="pdf" class="form-label">PDF File</label>
                <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf" required>
            </div>

            <button type="submit" class="btn btn-primary">Upload Report</button>
        </form>
    </div>
    </x-app-layout>

    <div class="footer">
        &copy; 2025 KADA. All rights reserved.
    </div>
</div>
</body>
</html>
