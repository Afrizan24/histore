@extends('admin.layout')

@section('title', 'Admin Dashboard - Kiansantang Store')

@section('content')
<div class="container py-4">
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <div class="text-3xl text-blue-600 mb-2"><i class="fas fa-box"></i></div>
                    <div class="h2 mb-0">{{ $productCount }}</div>
                    <div class="text-muted">Products</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <div class="text-3xl text-green-600 mb-2"><i class="fas fa-tags"></i></div>
                    <div class="h2 mb-0">{{ $categoryCount }}</div>
                    <div class="text-muted">Categories</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <div class="text-3xl text-pink-600 mb-2"><i class="fas fa-user-tie"></i></div>
                    <div class="h2 mb-0">{{ $saleCount }}</div>
                    <div class="text-muted">Sales</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <div class="text-3xl text-yellow-600 mb-2"><i class="fas fa-users"></i></div>
                    <div class="h2 mb-0">{{ $userCount }}</div>
                    <div class="text-muted">Users</div>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Produk per Kategori</div>
                <div class="card-body">
                    <canvas id="productsCategoryChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">User Growth (Dummy)</div>
                <div class="card-body">
                    <canvas id="userGrowthChart" height="180"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white fw-bold">Sales Aktif vs Nonaktif</div>
                <div class="card-body">
                    <canvas id="salesPieChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Produk per kategori
    const productsCategoryChart = new Chart(document.getElementById('productsCategoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($productsPerCategory->keys()) !!},
            datasets: [{
                label: 'Jumlah Produk',
                data: {!! json_encode($productsPerCategory->values()) !!},
                backgroundColor: '#0d6efd',
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
    // User growth
    const userGrowthChart = new Chart(document.getElementById('userGrowthChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_keys($userGrowth)) !!},
            datasets: [{
                label: 'User',
                data: {!! json_encode(array_values($userGrowth)) !!},
                borderColor: '#198754',
                backgroundColor: 'rgba(25,135,84,0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });
    // Sales aktif vs nonaktif
    const salesPieChart = new Chart(document.getElementById('salesPieChart'), {
        type: 'pie',
        data: {
            labels: ['Aktif', 'Nonaktif'],
            datasets: [{
                data: [{{ $salesActive }}, {{ $salesInactive }}],
                backgroundColor: ['#0d6efd', '#adb5bd']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endpush
@endsection 