<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'HiStore')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
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

        .card,
        .product-card {
            width: 240px;
            background: #fff;
            border: 1.5px solid #eee;
            border-radius: 18px;
            padding: 18px 16px 16px 16px;
            text-align: center;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
            color: #111;
            transition: transform 0.18s, box-shadow 0.18s;
        }

        .card:hover,
        .product-card:hover {
            transform: translateY(-7px) scale(1.03);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.10);
        }

        .card img,
        .product-card img {
            width: 100%;
            border-radius: 12px;
            margin-bottom: 14px;
            background: #f5f5f5;
        }

        .card h3,
        .product-card .card-title {
            font-size: 1.15em;
            margin-bottom: 8px;
            font-weight: 700;
            color: #111;
        }

        .price,
        .price-text {
            font-weight: bold;
            color: #111;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .card .btn,
        .product-card .btn {
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: background 0.2s, color 0.2s;
        }

        .card .btn:hover,
        .product-card .btn:hover {
            background: #fff;
            color: #111;
            border: 1.5px solid #111;
        }

        .favorite,
        .favorites-count {
            font-size: 0.95em;
            color: #888;
        }

        /* Responsive Design */
        @media (max-width: 900px) {
            .products {
                gap: 18px;
                padding: 24px 5px;
            }

            .card,
            .product-card {
                width: 100%;
                max-width: 320px;
            }

            .search-container {
                margin: 0 10px;
            }
        }

        @media (max-width: 768px) {
            .topbar {
                padding: 10px 8px;
            }

            .logo {
                height: 36px;
            }

            .navbar {
                gap: 10px;
                padding: 8px 0;
            }

            .navbar a,
            .navbar a.active,
            .navbar a:hover {
                padding: 6px 8px 8px 8px;
                font-size: 0.98em;
            }
        }

        @media (max-width: 576px) {

            .card,
            .product-card {
                padding: 12px 4px 12px 4px;
            }

            .search-container {
                margin: 0 2px;
            }
        }

        /* Alert Styling */
        .alert {
            border: none;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
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

        .alert-warning {
            background: #fff;
            color: #111;
            border: 1.5px solid #ffc107;
        }

        .alert-info {
            background: #fff;
            color: #111;
            border: 1.5px solid #0dcaf0;
        }

        /* Favorite Button Styles */
        .btn-favorite {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            color: #666;
        }

        .btn-favorite:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-favorite:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .btn-favorite i {
            font-size: 16px;
            transition: color 0.3s ease;
        }

        .btn-favorite i.favorited {
            color: #dc3545;
        }

        .btn-favorite.favorited {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .btn-favorite.favorited:hover {
            background: rgba(220, 53, 69, 0.2);
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
                <input type="text" name="search" class="search-bar" placeholder="Cari produk..."
                    value="{{ request('search') }}">
                <button type="submit" class="search-icon" style="background:none;border:none;padding:0;outline:none;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="icons">
                @auth
                    <a href="{{ route('favorites.index') }}" class="icon" title="Favorit">
                        <i class="fas fa-heart"></i> <span
                            id="favorite-count">{{ auth()->user()->favorites()->count() }}</span>
                    </a>
                    <a href="#" class="icon" title="Profil"><i class="fas fa-user"></i></a>
                @else
                    <a href="{{ route('favorites.index') }}" class="icon" title="Favorit">
                        <i class="fas fa-heart"></i> <span
                            id="favorite-count">{{ count(session('favorites', [])) }}</span>
                    </a>
                    <a href="{{ route('login') }}" class="icon" title="Login"><i class="fas fa-user"></i></a>
                @endauth
            </div>
        </div>

        <nav class="navbar">
            <a href="{{ route('products.all') }}"
                class="{{ !request()->route('category') && !request()->routeIs('sales.index') ? 'active' : '' }}">Semua
                Produk</a>
            <a href="{{ route('products.index', ['category' => 'ipad']) }}"
                class="{{ request()->route('category') === 'ipad' ? 'active' : '' }}">iPad</a>
            <a href="{{ route('products.index', ['category' => 'iphone']) }}"
                class="{{ request()->route('category') === 'iphone' ? 'active' : '' }}">iPhone</a>
            <a href="{{ route('products.index', ['category' => 'iwatch']) }}"
                class="{{ request()->route('category') === 'iwatch' ? 'active' : '' }}">iWatch</a>
            <a href="{{ route('products.index', ['category' => 'macbook']) }}"
                class="{{ request()->route('category') === 'macbook' ? 'active' : '' }}">MacBook</a>
            <a href="{{ route('products.index', ['category' => 'airpods']) }}"
                class="{{ request()->route('category') === 'airpods' ? 'active' : '' }}">Airphone</a>
            <a href="{{ route('products.index', ['category' => 'aksesoris']) }}"
                class="{{ request()->route('category') === 'aksesoris' ? 'active' : '' }}">Aksesoris</a>
            <a href="{{ route('sales.index') }}"
                class="{{ request()->routeIs('sales.index') ? 'active' : '' }}">Sales</a>
        </nav>
    </header>

    <main>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
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
        if (topbarSearchForm && topbarSearchInput && topbarSearchBtn) {
            topbarSearchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    topbarSearchForm.submit();
                }
            });
            topbarSearchBtn.addEventListener('click', function(e) {
                topbarSearchForm.submit();
            });
        }

        // Favorite functionality for guest users
        function toggleFavorite(productId) {
            const button = document.getElementById(`favorite-btn-${productId}`);
            const textSpan = document.getElementById(`favorite-text-${productId}`);
            const favoriteCount = document.getElementById('favorite-count');
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            
            console.log('Toggle favorite for product:', productId); // Debug log
            console.log('Button found:', !!button); // Debug log
            console.log('Text span found:', !!textSpan); // Debug log
            console.log('Favorite count element found:', !!favoriteCount); // Debug log
            console.log('CSRF token found:', !!csrfToken); // Debug log
            
            if (!csrfToken) {
                console.error('CSRF token not found!');
                showNotification('Terjadi kesalahan: CSRF token tidak ditemukan', 'error');
                return;
            }
            
            // Disable button during request
            button.disabled = true;
            
            fetch(`/favorites/${productId}/toggle`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Toggle response:', data); // Debug log
                
                // Update button appearance
                const icon = button.querySelector('i');
                if (data.is_favorite) {
                    icon.style.color = '#dc3545';
                    icon.classList.add('favorited');
                    button.classList.add('favorited');
                    // Handle large buttons in product detail pages
                    if (button.classList.contains('btn-outline-danger')) {
                        button.classList.remove('btn-outline-danger');
                        button.classList.add('btn-danger');
                        icon.classList.add('text-white');
                    }
                    if (textSpan) {
                        textSpan.textContent = 'Hapus dari Favorit';
                    }
                } else {
                    icon.style.color = '';
                    icon.classList.remove('favorited');
                    button.classList.remove('favorited');
                    // Handle large buttons in product detail pages
                    if (button.classList.contains('btn-danger')) {
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-outline-danger');
                        icon.classList.remove('text-white');
                    }
                    if (textSpan) {
                        textSpan.textContent = 'Tambah ke Favorit';
                    }
                }
                
                // Update favorite count in topbar
                if (favoriteCount && data.count !== undefined) {
                    favoriteCount.textContent = data.count;
                    console.log('Updated favorite count to:', data.count); // Debug log
                } else {
                    console.log('Favorite count element not found or count not provided'); // Debug log
                    console.log('favoriteCount element:', favoriteCount); // Debug log
                    console.log('data.count:', data.count); // Debug log
                }
                
                // Update specific product favorite count
                updateProductFavoriteCount(productId);
                
                // Show notification
                showNotification(data.message, data.is_favorite ? 'success' : 'info');
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan saat mengubah favorit', 'error');
            })
            .finally(() => {
                button.disabled = false;
            });
        }

        // Show notification function
        function showNotification(message, type = 'info') {
            // Remove existing notifications
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());
            
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                border-radius: 8px;
            `;
            
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 3 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 3000);
        }

        // Initialize favorite buttons on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, checking favorite elements...'); // Debug log
            
            // Check if favorite count element exists
            const favoriteCount = document.getElementById('favorite-count');
            console.log('Favorite count element found:', !!favoriteCount); // Debug log
            if (favoriteCount) {
                console.log('Current favorite count:', favoriteCount.textContent); // Debug log
            }
            
            // Check favorite status for all products on the page
            const favoriteButtons = document.querySelectorAll('[id^="favorite-btn-"]');
            console.log('Found favorite buttons:', favoriteButtons.length); // Debug log
            favoriteButtons.forEach(button => {
                const productId = button.id.replace('favorite-btn-', '');
                checkFavoriteStatus(productId);
            });
            
            // Refresh favorite count on page load
            refreshFavoriteCount();
        });

        // Check favorite status for a specific product
        function checkFavoriteStatus(productId) {
            console.log('Checking favorite status for product:', productId); // Debug log
            
            fetch(`/favorites/${productId}/check`)
            .then(response => {
                console.log('Check response status for product', productId, ':', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Check response for product', productId, ':', data); // Debug log
                
                const button = document.getElementById(`favorite-btn-${productId}`);
                const textSpan = document.getElementById(`favorite-text-${productId}`);
                
                if (!button) {
                    console.error('Button not found for product:', productId); // Debug log
                    return;
                }
                
                const icon = button.querySelector('i');
                
                if (data.is_favorite) {
                    icon.style.color = '#dc3545';
                    icon.classList.add('favorited');
                    button.classList.add('favorited');
                    // Handle large buttons in product detail pages
                    if (button.classList.contains('btn-outline-danger')) {
                        button.classList.remove('btn-outline-danger');
                        button.classList.add('btn-danger');
                        icon.classList.add('text-white');
                    }
                    if (textSpan) {
                        textSpan.textContent = 'Hapus dari Favorit';
                    }
                } else {
                    icon.style.color = '';
                    icon.classList.remove('favorited');
                    button.classList.remove('favorited');
                    // Handle large buttons in product detail pages
                    if (button.classList.contains('btn-danger')) {
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-outline-danger');
                        icon.classList.remove('text-white');
                    }
                    if (textSpan) {
                        textSpan.textContent = 'Tambah ke Favorit';
                    }
                }
            })
            .catch(error => {
                console.error('Error checking favorite status for product', productId, ':', error);
            });
        }

        // Refresh favorite count from server
        function refreshFavoriteCount() {
            console.log('Refreshing favorite count...'); // Debug log
            
            fetch('/favorites/count')
            .then(response => {
                console.log('Count response status:', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Count response:', data); // Debug log
                const favoriteCount = document.getElementById('favorite-count');
                if (favoriteCount && data.count !== undefined) {
                    favoriteCount.textContent = data.count;
                    console.log('Refreshed favorite count to:', data.count); // Debug log
                } else {
                    console.log('Favorite count element not found or count not provided'); // Debug log
                    console.log('favoriteCount element:', favoriteCount); // Debug log
                    console.log('data.count:', data.count); // Debug log
                }
            })
            .catch(error => {
                console.error('Error refreshing favorite count:', error);
            });
        }

        // Update specific product favorite count
        function updateProductFavoriteCount(productId) {
            console.log('Updating favorite count for product:', productId); // Debug log
            
            fetch(`/favorites/${productId}/count`)
            .then(response => {
                console.log('Product count response status:', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Product count response:', data); // Debug log
                const favoriteCounts = document.querySelectorAll(`[id="favorites-count-${productId}"]`);
                favoriteCounts.forEach(count => {
                    const icon = count.querySelector('i');
                    if (count.tagName === 'P') {
                        // For product cards
                        count.innerHTML = `${icon.outerHTML} ${data.count} terfavorite`;
                    } else {
                        // For product detail page
                        count.innerHTML = `${icon.outerHTML} ${data.count} orang`;
                    }
                    console.log(`Updated favorite count for product ${productId} to: ${data.count}`); // Debug log
                });
            })
            .catch(error => {
                console.error('Error updating product favorite count:', error);
            });
        }

        // Refresh favorite counts in product cards
        function refreshProductFavoriteCounts() {
            console.log('Refreshing product favorite counts...'); // Debug log
            
            fetch('/favorites/refresh-product-counts')
            .then(response => {
                console.log('Refresh product counts response status:', response.status); // Debug log
                return response.json();
            })
            .then(data => {
                console.log('Refresh product counts response:', data); // Debug log
                const favoriteCounts = document.querySelectorAll('[id^="favorites-count-"]');
                favoriteCounts.forEach(count => {
                    const productId = count.id.replace('favorites-count-', '');
                    if (data[productId] !== undefined) {
                        const icon = count.querySelector('i');
                        if (count.tagName === 'P') {
                            // For product cards
                            count.innerHTML = `${icon.outerHTML} ${data[productId]} terfavorite`;
                        } else {
                            // For product detail page
                            count.innerHTML = `${icon.outerHTML} ${data[productId]} orang`;
                        }
                        console.log(`Updated favorite count for product ${productId} to: ${data[productId]}`); // Debug log
                    }
                });
            })
            .catch(error => {
                console.error('Error refreshing product favorite counts:', error);
            });
        }
    </script>
</body>

</html>
