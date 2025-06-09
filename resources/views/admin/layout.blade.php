<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; }
        .admin-sidebar {
            min-height: 100vh;
            background: #212529;
            color: #fff;
        }
        .admin-sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 4px;
            margin-bottom: 4px;
        }
        .admin-sidebar a.active, .admin-sidebar a:hover {
            background: #0d6efd;
            color: #fff;
        }
        .admin-header {
            background: #fff;
            border-bottom: 1px solid #e0e0e0;
            padding: 16px 24px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 admin-sidebar d-flex flex-column py-4">
            <div class="mb-4 text-center">
                <h4 class="fw-bold">Admin Panel</h4>
                <small class="text-light">Kiansantang Store</small>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
            <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="fas fa-box me-2"></i> Produk</a>
            <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="fas fa-tags me-2"></i> Kategori</a>
            <a href="{{ route('admin.sales.index') }}" class="{{ request()->routeIs('admin.sales.*') ? 'active' : '' }}"><i class="fas fa-user-tie me-2"></i> Sales</a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fas fa-users me-2"></i> User</a>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto">
                @csrf
                <button type="submit" class="btn btn-danger w-100 mt-4"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
            </form>
        </nav>
        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-4 py-4">
            <div class="admin-header mb-4">
                <h2 class="h4 mb-0">@yield('title', 'Admin Panel')</h2>
            </div>
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 