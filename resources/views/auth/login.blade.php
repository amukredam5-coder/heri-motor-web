<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Hery Motor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --spark-orange: #ff4d00;
            --spark-dark: #111111;
            --spark-gray: #f5f5f5;
        }

        body { 
            background-color: var(--spark-gray); 
            font-family: 'Inter', sans-serif; 
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 450px;
            padding: 50px;
            border-radius: 0; 
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        }

        .brand-logo {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 28px;
            letter-spacing: -1.5px;
            color: var(--spark-dark);
            text-decoration: none;
            display: block;
            text-align: center;
            margin-bottom: 40px;
        }

        .login-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 800;
            font-size: 20px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            text-align: center;
        }

        .form-label {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #888;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 0;
            border: 2px solid #eee;
            padding: 12px 15px;
            font-weight: 500;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: var(--spark-dark);
            box-shadow: none;
            background-color: #fafafa;
        }

        .btn-spark-login {
            background: var(--spark-dark);
            color: white;
            border: none;
            border-radius: 0;
            padding: 15px;
            width: 100%;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13px;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-spark-login:hover {
            background: var(--spark-orange);
            color: white;
            transform: translateY(-2px);
        }

        .error-box {
            background: #fff5f5;
            color: #e53e3e;
            padding: 12px;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 25px;
            border-left: 4px solid #e53e3e;
        }
    </style>
</head>
<body>

<div class="login-card">
    <a href="#" class="brand-logo">HERY MOTOR<span style="color:var(--spark-orange)">.</span></a>
    
    <h2 class="login-title">Account Login</h2>
    <p class="text-center text-muted small mb-4">Masukkan kredensial Anda untuk masuk ke sistem.</p>

    {{-- Pesan Error dari LoginController --}}
    @if ($errors->any())
        <div class="error-box">
            <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
        </div>
    @endif

    {{-- Pesan Sukses (Misal setelah Logout) --}}
    @if(session('success'))
        <div class="alert alert-success border-0 rounded-0 small fw-bold mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="admin@herymotor.com" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" name="remember" type="checkbox" id="remember">
                <label class="form-check-label small fw-bold text-muted" for="remember">
                    Ingat Saya
                </label>
            </div>
            <a href="#" class="small fw-bold text-decoration-none" style="color: var(--spark-orange);">Lupa Password?</a>
        </div>

        <button type="submit" class="btn btn-spark-login shadow">Login</button>
    </form>

    <div class="mt-5 text-center">
        <p class="small text-muted mb-0">Hery Motor Management System v2.0</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>