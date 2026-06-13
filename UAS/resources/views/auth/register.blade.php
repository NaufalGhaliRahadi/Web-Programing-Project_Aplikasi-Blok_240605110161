<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Aplikasi Blog</title>
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
            padding: 40px 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            box-shadow: 0 25px 45px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 550px;
            transition: transform 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 30px 25px;
            text-align: center;
            border-bottom: none;
        }

        .card-header h2 {
            color: white;
            font-weight: 700;
            font-size: 1.8rem;
            margin-bottom: 0;
        }

        .card-header p {
            color: rgba(255, 255, 255, 0.85);
            margin-top: 8px;
            font-size: 0.9rem;
        }

        .card-body {
            padding: 30px 30px 40px;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 8px;
            color: #1e293b;
        }

        .form-control {
            border-radius: 50px;
            padding: 11px 20px;
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

        .btn-register {
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

        .btn-register:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #64748b;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .alert {
            border-radius: 50px;
            border: none;
            font-size: 0.85rem;
        }

        .position-relative {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            z-index: 10;
            font-size: 0.9rem;
        }

        .form-control.with-icon {
            padding-left: 45px;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper input[type=file] {
            padding-top: 10px;
            padding-bottom: 10px;
            cursor: pointer;
        }

        small.text-muted {
            font-size: 0.7rem;
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="card-header">
            <h2><i class="fas fa-user-plus me-2"></i> Daftar Akun</h2>
            <p>Bergabunglah dengan komunitas blog kami</p>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-triangle me-2"></i> 
                    <ul class="mb-0 mt-1 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i> Nama Depan</label>
                        <div class="position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="nama_depan" class="form-control with-icon" value="{{ old('nama_depan') }}" required autofocus>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label"><i class="fas fa-user me-1"></i> Nama Belakang</label>
                        <div class="position-relative">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="nama_belakang" class="form-control with-icon" value="{{ old('nama_belakang') }}" required>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-at me-1"></i> Username</label>
                    <div class="position-relative">
                        <i class="fas fa-at input-icon"></i>
                        <input type="text" name="user_name" class="form-control with-icon" value="{{ old('user_name') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-lock me-1"></i> Password</label>
                    <div class="position-relative">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" class="form-control with-icon" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="fas fa-check-circle me-1"></i> Konfirmasi Password</label>
                    <div class="position-relative">
                        <i class="fas fa-check-circle input-icon"></i>
                        <input type="password" name="password_confirmation" class="form-control with-icon" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label"><i class="fas fa-camera me-1"></i> Foto Profil (Opsional)</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="foto" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted"><i class="fas fa-info-circle me-1"></i> Format JPG, JPEG, PNG, maks 2MB. Kosongkan untuk foto default.</small>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i> Daftar
                </button>
            </form>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>