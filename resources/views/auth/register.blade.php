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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Figtree', sans-serif;
        }
        .form-container {
            background-color: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            margin: 1rem;
        }
        .form-header {
            text-align: center;
            margin-bottom: 24px;
        }
        .form-header h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
        .form-header p {
            font-size: 14px;
            color: #6b7280;
            margin-top: 8px;
        }
        .input-field {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            margin-top: 12px;
            transition: border-color 0.3s, box-shadow 0.3s;
        }
        .input-field:focus {
            border-color: #4f46e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }
        .form-footer {
            font-size: 12px;
            color: #6b7280;
            margin-top: 0;
            text-align: left;
        }
        .form-footer a {
            color: #4f46e5;
            text-decoration: underline;
        }
        .form-footer a:hover {
            color: #3730a3;
        }
        .submit-button {
            background-color: #4f46e5;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            margin-top: 16px;
            border: none;
        }
        .submit-button:hover {
            background-color: #3730a3;
        }
        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 16px;
        }
        .checkbox-wrapper input[type="checkbox"] {
            margin-top: 0;
            width: 16px;
            height: 16px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Daftar Akaun</h1>
            <p>Sila isi maklumat di bawah untuk membuat akaun baharu.</p>
        </div>
        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            
            <div>
                <input type="text" 
                       name="name" 
                       placeholder="Nama Penuh" 
                       class="input-field" 
                       value="{{ old('name') }}" 
                       required 
                       autocomplete="name">
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <input type="email" 
                       name="email" 
                       placeholder="Alamat Emel" 
                       class="input-field" 
                       value="{{ old('email') }}" 
                       required 
                       autocomplete="email">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <input type="password" 
                       name="password" 
                       placeholder="Kata Laluan" 
                       class="input-field" 
                       required 
                       autocomplete="new-password">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <input type="password" 
                       name="password_confirmation" 
                       placeholder="Sahkan Kata Laluan" 
                       class="input-field" 
                       required 
                       autocomplete="new-password">
            </div>
            
            <div class="checkbox-wrapper">
                <input type="checkbox" required id="terms" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                <label for="terms" class="form-footer">
                    Dengan mendaftar, anda bersetuju kepada <a href="#">Terma & Syarat</a> dan <a href="#">Polisi Privasi</a>.
                </label>
            </div>
            
            <button type="submit" class="submit-button">
                Daftar Akaun
            </button>
        </form>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
