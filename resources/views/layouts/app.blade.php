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
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
        }

        /* TOPBAR */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 30px;
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .logo {
            height: 55px;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
            flex: 1;
            margin: 0 50px;
            max-width: 500px;
        }

        .search-bar {
            width: 100%;
            padding: 10px 20px;
            border-radius: 30px;
            border: 3px solid #ccc;
            font-size: 16px;
        }

        .search-icon {
            position: absolute;
            right: 40px;
            color: #888;
            font-size: 16px;
            cursor: pointer;
        }

        .icons .icon {
            font-size: 20px;
            margin-left: 15px;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 15px;
            background-color: #fff;
            border-bottom: 1px solid #eee;
        }

        .navbar a {
            text-decoration: none;
            color: #444;
            font-weight: 500;
            padding-bottom: 5px;
        }

        .navbar a:hover {
            color: #888;
            border-bottom: 2px solid #888;
            transition: all 0.1s ease;
        }

        .navbar a.active {
            color: #d40000;
            border-bottom: 2px solid #d40000;
        }

        /* PRODUCTS */
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 25px;
            padding: 30px 15px;
        }

        .card {
            width: 220px;
            background-color: #fff;
            border: 1.5px solid #ccc;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card img {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .card h3 {
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .price {
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }

        .card .btn {
            display: inline-block;
            padding: 8px 16px;
            background-color: #1e40af;
            color: #fff;
            border-radius: 20px;
            text-decoration: none;
            margin-bottom: 8px;
            transition: background 0.3s;
        }

        .card .btn:hover {
            background-color: #122c8c;
        }

        .favorite {
            font-size: 0.85em;
            color: #777;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .topbar {
                padding: 10px 15px;
            }

            .logo {
                height: 40px;
            }

            .search-container {
                margin: 0 15px;
            }

            .navbar {
                overflow-x: auto;
                white-space: nowrap;
                padding: 10px;
                -webkit-overflow-scrolling: touch;
            }

            .navbar a {
                display: inline-block;
                margin: 0 10px;
            }

            .card {
                width: 100%;
                max-width: 300px;
            }
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 1rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <header>
        <div class="topbar">
            <a href="{{ route('home') }}">
                <img src="{{ asset('images/logohistore.png') }}" alt="HiStore Logo" class="logo" />
            </a>
            
            <div class="search-container">
                <input type="text" placeholder="Cari produk..." class="search-bar" />
                <i class="fas fa-search search-icon"></i>
            </div>

            <div class="icons">
                @auth
                    <a href="{{ route('favorites.index') }}" class="icon" title="Favorit">
                        ⭐ <span id="favorite-count">{{ auth()->user()->favorites()->count() }}</span>
                    </a>
                    <a href="#" class="icon" title="Profil">👤</a>
                @else
                    <a href="{{ route('login') }}" class="icon" title="Login">👤</a>
                @endauth
            </div>
        </div>

        <nav class="navbar">
            <a href="{{ route('products.all') }}" class="{{ !request()->route('category') ? 'active' : '' }}">Semua Produk</a>
            <a href="{{ route('products.index', ['category' => 'ipad']) }}" class="{{ request()->route('category') === 'ipad' ? 'active' : '' }}">iPad</a>
            <a href="{{ route('products.index', ['category' => 'iphone']) }}" class="{{ request()->route('category') === 'iphone' ? 'active' : '' }}">iPhone</a>
            <a href="{{ route('products.index', ['category' => 'iwatch']) }}" class="{{ request()->route('category') === 'iwatch' ? 'active' : '' }}">iWatch</a>
            <a href="{{ route('products.index', ['category' => 'macbook']) }}" class="{{ request()->route('category') === 'macbook' ? 'active' : '' }}">MacBook</a>
            <a href="{{ route('products.index', ['category' => 'airphone']) }}" class="{{ request()->route('category') === 'airphone' ? 'active' : '' }}">Airphone</a>
            <a href="{{ route('products.index', ['category' => 'aksesoris']) }}" class="{{ request()->route('category') === 'aksesoris' ? 'active' : '' }}">Aksesoris</a>
            <a href="{{ route('sales.index') }}" class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">Event & Promo</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
