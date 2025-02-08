<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - KADA</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f4f6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .content-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .login-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
            padding: 2rem;
        }
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .login-header h2 {
            color: #1f2937;
            font-weight: 700;
            font-size: 1.875rem;
        }
        .login-header p {
            color: #6b7280;
            font-size: 0.875rem;
        }
        .form-control {
            border-radius: 12px;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.2);
        }
        .btn-success {
            border-radius: 12px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(25, 135, 84, 0.2);
        }
        .form-check-input:checked {
            background-color: #198754;
            border-color: #198754;
        }
        .form-check-label {
            color: #6b7280;
        }
        .forgot-password {
            color: #198754;
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.3s ease;
        }
        .forgot-password:hover {
            color: #146c43;
        }
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }
        .register-link p {
            color: #6b7280;
            margin-bottom: 0;
        }
        .register-link a {
            color: #198754;
            text-decoration: none;
            font-weight: 600;
        }
        .register-link a:hover {
            color: #146c43;
        }
        footer {
            background-color: white;
            border-top: 1px solid #e5e7eb;
            padding: 1rem 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container">
            <a class="navbar-brand" href="/">KADA</a>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="login-card">
            <div class="login-header">
                <h2>Log Masuk</h2>
                <p>Sila log masuk untuk mengakses akaun anda</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        name="email" value="{{ old('email') }}" 
                        required autofocus autocomplete="username">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        name="password" required autocomplete="current-password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Ingat saya') }}
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success">{{ __('Log in') }}</button>
                </div>

                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            {{ __('Lupa kata laluan anda?') }}
                        </a>
                    @endif
                </div>

                <!-- Registration Link -->
                <div class="register-link">
                    <p>Belum mempunyai akaun? 
                        <a href="{{ route('register') }}">Daftar sekarang</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <small>© 2024 Lembaga Kemajuan Pertanian Kemubu (KADA). Hak Cipta Terpelihara.</small>
                </div>
                <div class="col-md-4 text-md-end">
                    <small>Membangunkan sektor pertanian</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
