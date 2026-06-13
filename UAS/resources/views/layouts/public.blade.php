<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blog Kami')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        /* Header */
        .blog-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1.2rem 0;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .blog-header h1 {
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
            margin-bottom: 0.2rem;
        }
        .blog-header p {
            margin-bottom: 0;
            font-size: 0.85rem;
            opacity: 0.9;
        }
        /* Navigasi header (menu + tombol login) */
        .header-nav {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }
        .header-nav .nav-link {
            color: white;
            font-weight: 500;
            padding: 0.4rem 0.8rem;
            transition: 0.2s;
            text-decoration: none;
            border-radius: 30px;
        }
        .header-nav .nav-link:hover {
            background-color: rgba(255,255,255,0.2);
        }
        .header-nav .nav-link.active {
            background-color: rgba(255,255,255,0.3);
        }
        .btn-outline-light {
            border-radius: 30px;
            padding: 6px 18px;
            margin-left: 0.5rem;
        }
        /* Card Artikel */
        .card-artikel {
            border: none;
            border-radius: 20px;
            background: white;
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.8rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .card-artikel:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 30px -12px rgba(0,0,0,0.15);
        }
        .card-img-top {
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
            height: 220px;
            object-fit: cover;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            font-weight: 700;
            font-size: 1.35rem;
            color: #1e3c72;
            margin-bottom: 0.6rem;
        }
        .meta-info {
            font-size: 0.8rem;
            color: #6c757d;
            margin-bottom: 0.8rem;
        }
        .meta-info i {
            margin-right: 4px;
            width: 18px;
        }
        .badge-kategori {
            background-color: #eef2ff;
            color: #2a5298;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        .btn-baca {
            background-color: #2a5298;
            border: none;
            border-radius: 40px;
            padding: 6px 20px;
            font-size: 0.85rem;
            transition: 0.2s;
        }
        .btn-baca:hover {
            background-color: #1e3c72;
            transform: scale(1.02);
        }
        /* Widget Sidebar */
        .widget {
            background: white;
            border-radius: 20px;
            padding: 1.3rem;
            margin-bottom: 1.8rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            border: 1px solid #eef2f6;
        }
        .widget-title {
            font-weight: 700;
            border-left: 4px solid #2a5298;
            padding-left: 12px;
            margin-bottom: 1.2rem;
            font-size: 1.1rem;
            color: #1e3c72;
        }
        .list-kategori {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .list-kategori li {
            padding: 8px 0;
            border-bottom: 1px solid #eef2f6;
        }
        .list-kategori li a {
            text-decoration: none;
            color: #2c3e50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.2s;
        }
        .list-kategori li a:hover {
            color: #2a5298;
            padding-left: 5px;
        }
        .badge-count {
            background-color: #eef2ff;
            border-radius: 20px;
            padding: 2px 10px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #2a5298;
        }
        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.2rem;
        }
        .breadcrumb-custom .breadcrumb-item a {
            text-decoration: none;
            color: #2a5298;
        }
        /* Artikel terkait */
        .artikel-terkait-item {
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #eef2f6;
        }
        .artikel-terkait-item a {
            font-weight: 600;
            text-decoration: none;
            color: #1e3c72;
            display: block;
        }
        .artikel-terkait-item a:hover {
            color: #2a5298;
        }
        .artikel-terkait-item {
            transition: background 0.2s;
            padding: 8px;
            border-radius: 12px;
        }
        .artikel-terkait-item:hover {
            background-color: #f8f9fa;
        }
        .btn-back {
            background-color: #6c757d;
            border-radius: 40px;
            padding: 6px 18px;
            font-size: 0.8rem;
            color: white;
            text-decoration: none;
            display: inline-block;
        }
        .btn-back:hover {
            background-color: #5a6268;
            color: white;
        }
        footer {
            background-color: #1e3c72;
            color: #adb5bd;
            text-align: center;
            padding: 1.5rem;
            margin-top: 3rem;
            border-radius: 20px 20px 0 0;
        }
        @media (max-width: 768px) {
            .card-title { font-size: 1.2rem; }
            .card-img-top { height: 160px; }
            .blog-header h1 { font-size: 1.3rem; }
            .header-nav { gap: 0.5rem; }
            .header-nav .nav-link { padding: 0.3rem 0.6rem; font-size: 0.85rem; }
            .btn-outline-light { padding: 4px 12px; font-size: 0.8rem; }
        }
    </style>
</head>
<body>

<div class="blog-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1><i class="fas fa-blog me-2"></i> Blog Kami</h1>
                <p>Artikel terbaru seputar teknologi dan pemrograman</p>
            </div>
            <div class="col-md-6">
                <div class="header-nav">
                    <!-- Menu Navigasi -->
                    <a href="{{ route('public.home') }}" class="nav-link {{ request()->routeIs('public.home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('public.home') }}" class="nav-link">Artikel</a>
                    <a href="{{ route('public.home') }}" class="nav-link">Kategori</a>
                    <a href="{{ route('public.home') }}" class="nav-link">Tentang</a>
                    
                    <!-- Tombol Login / Dashboard -->
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light rounded-pill">
                            <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill">
                            <i class="fas fa-sign-in-alt me-1"></i> Login Admin
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Konten Utama -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-8">
            @yield('content')
        </div>
        <div class="col-lg-4">
            @yield('sidebar')
        </div>
    </div>
</div>

<footer>
    <p class="mb-0">&copy; {{ date('Y') }} Blog Kami. Seluruh hak cipta dilindungi.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>