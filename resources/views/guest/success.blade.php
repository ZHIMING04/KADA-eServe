<!DOCTYPE html>
<x-app-layout>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <style>
            body, html {
                height: 100%;
                margin: 0;
                font-family: 'Nunito', sans-serif;
                overflow: hidden; /* Prevent scrolling */
            }
            .bg {
                background-image: url('{{ asset('images/paddy.jpg') }}');
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: fixed;
                width: 100%;
                z-index: 0;
            }
            .content {
                display: flex;
                justify-content: center;
                align-items: flex-start;
                height: 100%;
                padding-top: 5rem ; /* Adjust this value to move the content box lower */
                z-index: 2;
            }
            .box-container {
                background-color: rgba(255, 255, 255, 0.8);
                padding: 2rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                text-align: center;
                z-index: inherit;;
            }
            .success-icon {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 1rem;
            }
            .success-icon svg {
                height: 3rem;
                width: 3rem;
                color: #38a169;
            }
            .success-message {
                font-size: 1.5rem;
                font-weight: bold;
                color: #2d3748;
                margin-bottom: 1rem;
            }
            .details {
                color: #4a5568;
                margin-bottom: 1rem;
            }
            .attention {
                background-color: #f7fafc;
                padding: 1rem;
                border-radius: 0.5rem;
                margin-bottom: 1rem;
                color: #4a5568;
                text-align: left;
            }
            .attention ul {
                list-style-type: disc;
                padding-left: 1.5rem;
            }
            .back-button {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                background-color: #2d3748;
                color: #fff;
                border: none;
                border-radius: 0.375rem;
                font-weight: 600;
                text-transform: uppercase;
                cursor: pointer;
                transition: background-color 0.2s;
            }
            .back-button:hover {
                background-color: #1a202c;
            }
        </style>
    </head>
        <div class="bg"></div>
        <div class="content">
            <div class="box-container">
                <div class="success-icon">
                    <div class="rounded-full bg-green-100 p-3">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                <div class="success-message">
                    Pendaftaran Berjaya!
                </div>
                <div class="details">
                    <p class="mb-3">Terima kasih kerana mendaftar sebagai ahli KADA.</p>
                    <p>Permohonan anda akan diproses dalam tempoh 3-5 hari bekerja.</p>
                </div>
                <div class="attention">
                    <p class="text-sm">
                        Sila ambil perhatian:
                    </p>
                    <ul class="list-disc list-inside text-sm mt-2 space-y-1">
                        <li>Email pengesahan akan dihantar ke alamat email yang didaftarkan</li>
                        <li>Sila semak email anda termasuk folder SPAM</li>
                        <li>Untuk sebarang pertanyaan, sila hubungi pihak KADA</li>
                    </ul>
                </div>
                <button class="back-button" onclick="window.location.href='{{ route('guest.dashboard') }}'">
                    Kembali ke Halaman Utama
                </button>
            </div>
        </div>
    </body>
</html>
</x-app-layout>