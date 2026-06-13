<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aplikasi Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            width: 100%;
            max-width: 460px;
            transition: transform 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px 30px;
            text-align: center;
            border-bottom: none;
        }

        .card-header h2 {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0;
            letter-spacing: -0.5px;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.85);
            margin-top: 8px;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 35px 30px 40px;
        }

        .form-control {
            border-radius: 50px;
            padding: 12px 20px;
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            background-color: white;
        }

        .input-group-text {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 50px 0 0 50px;
            color: #94a3b8;
        }

        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            padding: 12px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            transition: all 0.3s;
            width: 100%;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-home {
            background-color: #6c757d;
            border: none;
            border-radius: 50px;
            padding: 10px 16px;
            font-size: 0.85rem;
            font-weight: 500;
            color: white;
            transition: all 0.2s;
            width: 100%;
            margin-top: 12px;
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }

        .btn-home:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            border-radius: 50px;
            border: none;
            font-size: 0.85rem;
        }

        .icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 10;
        }

        .form-control.with-icon {
            padding-left: 45px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="card-header">
            <h2><i class="fas fa-blog me-2"></i> Aplikasi Blog</h2>
            <p>Silakan masuk ke akun Anda</p>
        </div>
        <div class="card-body">
            @if(session('sukses'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> {{ session('sukses') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ $errors->first('gagal') }}
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                <div class="mb-3 position-relative">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text" 
                           class="form-control with-icon @error('user_name') is-invalid @enderror" 
                           id="user_name" 
                           name="user_name" 
                           value="{{ old('user_name') }}" 
                           placeholder="Username"
                           autofocus>
                    @error('user_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4 position-relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" 
                           class="form-control with-icon @error('password') is-invalid @enderror" 
                           id="password" 
                           name="password" 
                           placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i> Login
                </button>
            </form>

            <div class="register-link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>

            <!-- Tombol kembali ke halaman utama -->
            <a href="{{ route('public.home') }}" class="btn-home">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>