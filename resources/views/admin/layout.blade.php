<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel') - Kiansantang Store</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-width: 280px;
            --header-height: 70px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .admin-sidebar {
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: #fff;
            z-index: 1000;
            transition: var(--transition);
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
            overflow-y: auto;
        }

        .admin-sidebar.collapsed {
            width: 70px;
        }

        .admin-sidebar.collapsed .nav-text {
            display: none;
        }

        .admin-sidebar.collapsed .brand-text {
            display: none;
        }

        .admin-sidebar.collapsed .nav-item {
            text-align: center;
        }

        .admin-sidebar.collapsed .nav-link {
            padding: 15px 10px;
            justify-content: center;
        }

        .sidebar-header {
            padding: 2rem 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .brand-text h4 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            font-size: 1.2rem;
        }

        .brand-text small {
            opacity: 0.8;
            font-size: 0.85rem;
        }

        .nav-menu {
            padding: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: var(--transition);
            border-radius: 0 25px 25px 0;
            margin-right: 1rem;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 20px;
            background: #fff;
            border-radius: 2px 0 0 2px;
        }

        .nav-icon {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
            text-align: center;
        }

        .nav-text {
            font-weight: 500;
            font-size: 0.95rem;
        }

        .nav-badge {
            background: #e74c3c;
            color: #fff;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-size: 0.75rem;
            margin-left: auto;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            transition: var(--transition);
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        /* Header */
        .admin-header {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0,0,0,0.1);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #2c3e50;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: var(--transition);
        }

        .toggle-sidebar:hover {
            background: rgba(102, 126, 234, 0.1);
            color: var(--primary-color);
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 25px;
            color: #2c3e50;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 600;
        }

        .logout-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 600;
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
        }

        /* Content Area */
        .content-wrapper {
            padding: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                width: 100%;
                max-width: 300px;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .admin-header {
                padding: 1rem;
            }

            .content-wrapper {
                padding: 1rem;
            }

            .user-info {
                display: none;
            }
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }

        .sidebar-overlay.show {
            display: block;
        }

        /* Animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-wrapper {
            animation: slideIn 0.5s ease-out;
        }

        /* Scrollbar Styling */
        .admin-sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .admin-sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .admin-sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        .admin-sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }
    </style>
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <div class="brand-logo">
                <i class="fas fa-store"></i>
            </div>
            <div class="brand-text">
                <h4>Admin Panel</h4>
                <small>Kiansantang Store</small>
            </div>
        </div>

        <div class="nav-menu">
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.banners.index') }}" class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <i class="fas fa-images nav-icon"></i>
                    <span class="nav-text">Banner Management</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-box nav-icon"></i>
                    <span class="nav-text">Product Management</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags nav-icon"></i>
                    <span class="nav-text">Category Management</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.sales.index') }}" class="nav-link {{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                    <i class="fas fa-percentage nav-icon"></i>
                    <span class="nav-text">Sales & Promotions</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <span class="nav-text">User Management</span>
                </a>
            </div>

            <div class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt nav-icon"></i>
                    <span class="nav-text">View Website</span>
                </a>
            </div>
        </div>

        <!-- Logout Section -->
        <div class="mt-auto p-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn w-100">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="nav-text">Logout</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 class="page-title">@yield('title', 'Admin Panel')</h1>
            </div>
            
            <div class="header-right">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                        <small class="text-muted">Administrator</small>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar
            toggleBtn.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    // Mobile: show/hide sidebar
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                } else {
                    // Desktop: collapse/expand sidebar
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('expanded');
                }
            });

            // Close sidebar on overlay click (mobile)
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });

            // Add active state animation
            const activeLinks = document.querySelectorAll('.nav-link.active');
            activeLinks.forEach(link => {
                link.style.animation = 'slideIn 0.3s ease-out';
            });

            // Add hover effects
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(5px)';
                });
                
                link.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                    }
                });
            });
        });
    </script>
</body>
</html> 