<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CMS Blog')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            min-height: 100vh;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 20px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.05);
            border-left-color: #3b82f6;
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: rgba(59,130,246,0.2);
            border-left-color: #3b82f6;
            color: white;
        }
        .sidebar-header {
            padding: 20px;
            font-size: 1.3rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
            color: white;
        }
        .main-content {
            padding: 25px;
        }
        .logout-btn {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            color: #cbd5e1;
            padding: 12px 20px;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .logout-btn:hover {
            background-color: #dc2626;
            color: white;
            border-left-color: #dc2626;
        }
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s;
        }
        .stat-card i {
            font-size: 2.5rem;
            color: #3b82f6;
        }
        .btn-custom {
            border-radius: 30px;
            padding: 8px 20px;
        }
        .table th {
            font-weight: 600;
            color: #1e293b;
            border-bottom-width: 1px;
        }
        .badge-category {
            background-color: #e2e8f0;
            color: #1e293b;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-auto sidebar" style="width: 270px;">
                <div class="sidebar-header">
                    📝 <span class="ms-1">Blog CMS</span>
                </div>
                <div class="nav flex-column">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('artikel.index') }}" class="nav-link {{ request()->routeIs('artikel.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper me-2"></i> Artikel
                    </a>
                    <a href="{{ route('penulis.index') }}" class="nav-link {{ request()->routeIs('penulis.*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i> Penulis
                    </a>
                    <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="fas fa-tags me-2"></i> Kategori
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col main-content">
                @if(session('sukses'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('sukses') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('gagal'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('gagal') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>