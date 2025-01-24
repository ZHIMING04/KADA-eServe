<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header with pale green border and fixed width -->
        <div class="text-center border-2 border-green-100 bg-green-50 rounded-lg p-6 mb-4 mx-auto" style="width: 800px;">
            <h1 class="text-5xl font-bold text-green-600 mb-3">LAPORAN TAHUNAN</h1>
            <h2 class="text-3xl font-bold text-blue-800 mb-4">Terokai Laporan Tahunan</h2>
            <p class="text-gray-600">Semak laporan tahunan mengikut tahun yang disediakan. Klik pada tajuk laporan untuk memuat turun.</p>
        </div>

        @if($reports->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @foreach($reports as $report)
                    <div class="bg-white rounded-lg shadow-sm p-6 max-w-sm mx-auto w-full text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            Laporan Tahunan {{ $report->year }}
                        </h3>

                        @if($report->thumbnail)
                            <div class="mb-4">
                                <img src="/{{ $report->thumbnail }}" 
                                     alt="Laporan Tahunan {{ $report->year }}" 
                                     class="mx-auto max-h-[200px] w-auto object-contain">
                            </div>
                        @endif

                        <p class="text-sm text-gray-600 mb-4 text-center">
                            {{ $report->description }}
                        </p>

                        @if($report->file_path)
                            <a href="/{{ $report->file_path }}" 
                               class="block w-full text-white text-center py-2 rounded-md transition duration-200 gradient-btn"
                               target="_blank">
                                Paparkan
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center text-gray-500">
                <p>Tiada laporan tahunan pada masa ini.</p>
            </div>
        @endif
    </div>

    <style>
        body {
            background: linear-gradient(135deg, #e8f4ff, #d1e8ff) !important;
            position: relative;
            overflow-x: hidden;
            min-height: 100vh;
        }

        /* Add decorative blobs */
        body::before, body::after {
            content: '';
            position: fixed;
            width: 70vw;
            height: 70vw;
            border-radius: 50%;
            z-index: -1;
            opacity: 0.6;
        }

        body::before {
            background: radial-gradient(circle, rgba(147, 197, 253, 0.4) 0%, rgba(147, 197, 253, 0) 70%);
            top: -30%;
            right: -20%;
        }

        body::after {
            background: radial-gradient(circle, rgba(191, 219, 254, 0.4) 0%, rgba(191, 219, 254, 0) 70%);
            bottom: -30%;
            left: -20%;
        }

        /* Gradient button styling for both search and display buttons */
        .btn-search,
        .button-gradient {
            background: linear-gradient(to right, #10B981, #3B82F6);
            color: white;
            border-radius: 50px;
            padding: 8px 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-search:hover,
        .button-gradient:hover {
            background: linear-gradient(to right, #059669, #2563EB);
            transform: scale(1.05);
            color: white;
        }

        .gradient-btn {
            background: linear-gradient(to right, #10B981, #3B82F6);
            transition: all 0.3s ease;
        }

        .gradient-btn:hover {
            background: linear-gradient(to right, #059669, #2563EB);
            transform: scale(1.02);
        }
    </style>
</x-app-layout>