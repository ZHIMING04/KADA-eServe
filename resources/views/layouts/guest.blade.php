<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('images/KADAlogoresize.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Include SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        @if(session('showAlert'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: '{{ session('alertType') }}',
                    title: '{{ session('alertTitle') }}',
                    html: `
                        <div class="text-left">
                            <p class="mb-2">{{ session('alertMessage') }}</p>
                            @if(session('alertType') === 'info')
                                <p class="text-sm text-gray-600 mt-2">
                                    Sila semak status permohonan anda di papan pemuka.
                                </p>
                            @endif
                        </div>
                    `,
                    confirmButtonText: 'Faham',
                    confirmButtonColor: '#3085d6',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Optional: You can add any action after the user clicks the button
                    }
                });
            });
        </script>
        @endif

        @stack('scripts')
    </body>
</html>
