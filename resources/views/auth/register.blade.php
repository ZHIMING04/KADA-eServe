<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            background-color: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
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
            margin-top: 16px;
            text-align: center;
        }
        .form-footer a {
            color: #4f46e5;
            text-decoration: underline;
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
        }
        .submit-button:hover {
            background-color: #3730a3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h1>Daftar Akaun</h1>
            <p>Sila isi maklumat di bawah untuk membuat akaun baharu.</p>
        </div>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Nama Penuh" class="input-field" value="{{ old('name') }}" required>
            @error('name')
                <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
            @enderror
            
            <input type="email" name="email" placeholder="Alamat Emel" class="input-field" value="{{ old('email') }}" required>
            @error('email')
                <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
            @enderror
            
            <input type="password" name="password" placeholder="Kata Laluan" class="input-field" required>
            @error('password')
                <span style="color: #dc2626; font-size: 12px;">{{ $message }}</span>
            @enderror
            
            <input type="password" name="password_confirmation" placeholder="Sahkan Kata Laluan" class="input-field" required>
            
            <div class="form-footer">
                <input type="checkbox" required> Dengan mendaftar, anda bersetuju kepada <a href="#">Terma & Syarat</a> dan <a href="#">Polisi Privasi</a>.
            </div>
            <button type="submit" class="submit-button">Daftar Akaun</button>
        </form>
    </div>
</body>
</html>
