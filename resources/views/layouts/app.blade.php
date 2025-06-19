<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'HiStore')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="icon" href="/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #fff;
            color: #111;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 32px;
            background: #fff;
            border-bottom: 1.5px solid #eee;
            box-shadow: 0 2px 12px rgba(0,0,0,0.03);
        }

        .logo {
            height: 48px;
            filter: none;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            flex: 1;
            margin: 0 40px;
            max-width: 420px;
        }

        .search-bar {
            width: 100%;
            padding: 10px 20px;
            border-radius: 30px;
            border: 1.5px solid #ddd;
            background: #fff;
            color: #111;
            font-size: 16px;
            font-weight: 500;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }

        .search-bar::placeholder {
            color: #bbb;
        }

        .search-icon {
            position: absolute;
            right: 24px;
            color: #888;
            font-size: 18px;
            cursor: pointer;
        }

        .icons .icon {
            font-size: 20px;
            margin-left: 18px;
            cursor: pointer;
            text-decoration: none;
            color: #111;
            background: #f5f5f5;
            border-radius: 50%;
            padding: 8px 10px;
            transition: background 0.2s, color 0.2s;
        }

        .icons .icon:hover {
            background: #111;
            color: #fff;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: center;
            gap: 24px;
            padding: 14px 0;
            background: #fff;
            border-bottom: 1.5px solid #eee;
        }

        .navbar a {
            text-decoration: none;
            color: #111;
            font-weight: 600;
            padding: 6px 0 8px 0;
            border-bottom: 2.5px solid transparent;
            border-radius: 0;
            transition: color 0.2s, border 0.2s, background 0.2s;
            letter-spacing: 0.5px;
        }

        .navbar a:hover {
            color: #fff;
            background: #111;
            border-radius: 8px 8px 0 0;
            border-bottom: 2.5px solid #111;
            padding: 6px 12px 8px 12px;
        }

        .navbar a.active {
            color: #fff;
            background: #111;
            border-radius: 8px 8px 0 0;
            border-bottom: 2.5px solid #111;
            padding: 6px 12px 8px 12px;
        }

        /* PRODUCTS */
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 28px;
            padding: 36px 10px;
        }

        .card, .product-card {
            width: 240px;
            background: #fff;
            border: 1.5px solid #eee;
            border-radius: 18px;
            padding: 18px 16px 16px 16px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            color: #111;
            transition: transform 0.18s, box-shadow 0.18s;
        }

        .card:hover, .product-card:hover {
            transform: translateY(-7px) scale(1.03);
            box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        }

        .card img, .product-card img {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 14px;
            background: #f5f5f5;
        }

        .card h3, .product-card .card-title {
            font-size: 1.15em;
            margin-bottom: 8px;
            font-weight: 700;
            color: #111;
        }

        .price, .price-text {
            font-weight: bold;
            color: #111;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .card .btn, .product-card .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #111;
            color: #fff;
            border-radius: 22px;
            text-decoration: none;
            font-weight: 700;
            font-size: 1em;
            margin-bottom: 8px;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: background 0.2s, color 0.2s;
        }

        .card .btn:hover, .product-card .btn:hover {
            background: #fff;
            color: #111;
            border: 1.5px solid #111;
        }

        .favorite, .favorites-count {
            font-size: 0.95em;
            color: #888;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .products { gap: 18px; padding: 24px 5px; }
            .card, .product-card { width: 100%; max-width: 320px; }
            .search-container { margin: 0 10px; }
        }

        @media (max-width: 768px) {
            .topbar { padding: 10px 8px; }
            .logo { height: 36px; }
            .navbar { gap: 10px; padding: 8px 0; }
            .navbar a, .navbar a.active, .navbar a:hover { padding: 6px 8px 8px 8px; font-size: 0.98em; }
        }

        @media (max-width: 576px) {
            .card, .product-card { padding: 12px 4px 12px 4px; }
            .search-container { margin: 0 2px; }
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
            margin: 1.2rem;
            font-weight: 600;
        }

        .alert-success {
            background: #111;
            color: #fff;
        }

        .alert-danger {
            background: #fff;
            color: #111;
            border: 1.5px solid #111;
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <a href="{{ route('home') }}">
                <img src="{{ asset('storage/th.jpg') }}" alt="HiStore Logo" class="logo" />
            </a>
            <form class="search-container" method="GET" action="{{ route('products.all') }}" id="topbarSearchForm">
                <input type="text" name="search" class="search-bar" placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="search-icon" style="background:none;border:none;padding:0;outline:none;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="icons">
                @auth
                    <a href="{{ route('favorites.index') }}" class="icon" title="Favorit">
                        <i class="fas fa-heart"></i> <span id="favorite-count">{{ auth()->user()->favorites()->count() }}</span>
                    </a>
                    <a href="#" class="icon" title="Profil"><i class="fas fa-user"></i></a>
                @else
                    <a href="{{ route('login') }}" class="icon" title="Login"><i class="fas fa-user"></i></a>
                @endauth
            </div>
        </div>

        <nav class="navbar">
            <a href="{{ route('products.all') }}" class="{{ !request()->route('category')&&!request()->routeIs('sales.index') ? 'active' : '' }}">Semua Produk</a>
            <a href="{{ route('products.index', ['category' => 'ipad']) }}" class="{{ request()->route('category') === 'ipad' ? 'active' : '' }}">iPad</a>
            <a href="{{ route('products.index', ['category' => 'iphone']) }}" class="{{ request()->route('category') === 'iphone' ? 'active' : '' }}">iPhone</a>
            <a href="{{ route('products.index', ['category' => 'iwatch']) }}" class="{{ request()->route('category') === 'iwatch' ? 'active' : '' }}">iWatch</a>
            <a href="{{ route('products.index', ['category' => 'macbook']) }}" class="{{ request()->route('category') === 'macbook' ? 'active' : '' }}">MacBook</a>
            <a href="{{ route('products.index', ['category' => 'airpods']) }}" class="{{ request()->route('category') === 'airpods' ? 'active' : '' }}">Airphone</a>
            <a href="{{ route('products.index', ['category' => 'aksesoris']) }}" class="{{ request()->route('category') === 'aksesoris' ? 'active' : '' }}">Aksesoris</a>
            <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">Sales</a>
        </nav>
    </header>
    
    <main>
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
    // Submit topbar search on enter or icon click
    const topbarSearchForm = document.getElementById('topbarSearchForm');
    const topbarSearchInput = topbarSearchForm.querySelector('.search-bar');
    const topbarSearchBtn = topbarSearchForm.querySelector('.search-icon');
    if(topbarSearchForm && topbarSearchInput && topbarSearchBtn) {
        topbarSearchInput.addEventListener('keydown', function(e) {
            if(e.key === 'Enter') {
                topbarSearchForm.submit();
            }
        });
        topbarSearchBtn.addEventListener('click', function(e) {
            topbarSearchForm.submit();
        });
    }
    </script>
</body>
</html>
