@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="welcome-section mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2 class="welcome-title">Selamat Datang, {{ Auth::user()->name }}! 👋</h2>
            <p class="welcome-subtitle">Kelola toko Kiansantang Store Anda dari dashboard ini</p>
        </div>
        <div class="col-md-4 text-end">
            <div class="current-time">
                <i class="fas fa-clock me-2"></i>
                <span id="currentTime"></span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
    <div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number">{{ number_format($productCount) }}</h3>
                    <p class="stat-card-label">Total Products</p>
                </div>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12%</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-success">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number">{{ number_format($categoryCount) }}</h3>
                    <p class="stat-card-label">Categories</p>
                </div>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+5%</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number">{{ number_format($saleCount) }}</h3>
                    <p class="stat-card-label">Sales Team</p>
                </div>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8%</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-card-info">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-card-content">
                    <h3 class="stat-card-number">{{ number_format($userCount) }}</h3>
                    <p class="stat-card-label">Registered Users</p>
                </div>
                <div class="stat-card-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
    <div class="row g-4">
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-chart-bar me-2"></i>
                    Products by Category
                </h5>
                <div class="chart-card-actions">
                    <button class="btn btn-sm btn-outline-primary" onclick="refreshChart()">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
            <div class="chart-card-body">
                <canvas id="productsCategoryChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-card-header">
                <h5 class="chart-card-title">
                    <i class="fas fa-chart-pie me-2"></i>
                    Sales Status
                </h5>
            </div>
            <div class="chart-card-body">
                <canvas id="salesPieChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Actions -->
<div class="row g-4 mt-4">
        <div class="col-lg-6">
        <div class="activity-card">
            <div class="activity-card-header">
                <h5 class="activity-card-title">
                    <i class="fas fa-history me-2"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="activity-card-body">
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-success">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h6>New Product Added</h6>
                            <p>iPhone 15 Pro Max has been added to the store</p>
                            <small class="text-muted">2 hours ago</small>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-warning">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="activity-content">
                            <h6>Product Updated</h6>
                            <p>MacBook Pro price has been updated</p>
                            <small class="text-muted">4 hours ago</small>
                        </div>
                    </div>
                    
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-info">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="activity-content">
                            <h6>New User Registered</h6>
                            <p>John Doe has registered as a new user</p>
                            <small class="text-muted">6 hours ago</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <div class="col-lg-6">
        <div class="quick-actions-card">
            <div class="quick-actions-card-header">
                <h5 class="quick-actions-card-title">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="quick-actions-card-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('admin.products.create') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <span>Add Product</span>
                    </a>
                    
                    <a href="{{ route('admin.banners.create') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <span>Add Banner</span>
                    </a>
                    
                    <a href="{{ route('admin.categories.create') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-tag"></i>
                        </div>
                        <span>Add Category</span>
                    </a>
                    
                    <a href="{{ route('admin.sales.create') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <span>Add Sale</span>
                    </a>
                    
                    <a href="{{ route('home') }}" class="quick-action-item" target="_blank">
                        <div class="quick-action-icon">
                            <i class="fas fa-external-link-alt"></i>
                        </div>
                        <span>View Website</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span>Manage Users</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Welcome Section */
.welcome-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(102, 126, 234, 0.3);
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.current-time {
    background: rgba(255,255,255,0.2);
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    backdrop-filter: blur(10px);
    font-weight: 600;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.stat-card-primary::before { background: linear-gradient(90deg, #667eea, #764ba2); }
.stat-card-success::before { background: linear-gradient(90deg, #28a745, #20c997); }
.stat-card-warning::before { background: linear-gradient(90deg, #ffc107, #fd7e14); }
.stat-card-info::before { background: linear-gradient(90deg, #17a2b8, #6f42c1); }

.stat-card-body {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-card-primary .stat-card-icon { background: linear-gradient(135deg, #667eea, #764ba2); }
.stat-card-success .stat-card-icon { background: linear-gradient(135deg, #28a745, #20c997); }
.stat-card-warning .stat-card-icon { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.stat-card-info .stat-card-icon { background: linear-gradient(135deg, #17a2b8, #6f42c1); }

.stat-card-content {
    flex: 1;
}

.stat-card-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #2c3e50;
}

.stat-card-label {
    color: #6c757d;
    margin-bottom: 0;
    font-weight: 500;
}

.stat-card-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    color: #28a745;
    font-weight: 600;
    font-size: 0.9rem;
}

/* Chart Cards */
.chart-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.chart-card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.chart-card-title {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}

.chart-card-body {
    padding: 1.5rem;
}

/* Activity Card */
.activity-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.activity-card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.activity-card-title {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}

.activity-card-body {
    padding: 1.5rem;
}

.activity-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.activity-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: #f8f9fa;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.activity-icon-success { background: linear-gradient(135deg, #28a745, #20c997); }
.activity-icon-warning { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.activity-icon-info { background: linear-gradient(135deg, #17a2b8, #6f42c1); }

.activity-content h6 {
    margin-bottom: 0.25rem;
    font-weight: 600;
    color: #2c3e50;
}

.activity-content p {
    margin-bottom: 0.25rem;
    color: #6c757d;
    font-size: 0.9rem;
}

/* Quick Actions Card */
.quick-actions-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.quick-actions-card-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.quick-actions-card-title {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}

.quick-actions-card-body {
    padding: 1.5rem;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
}

.quick-action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    border-radius: 12px;
    background: #f8f9fa;
    text-decoration: none;
    color: #2c3e50;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.quick-action-item:hover {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    text-decoration: none;
}

.quick-action-icon {
    width: 50px;
    height: 50px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
}

.quick-action-item:hover .quick-action-icon {
    background: rgba(255,255,255,0.2);
}

.quick-action-item span {
    font-weight: 600;
    font-size: 0.9rem;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-section {
        padding: 1.5rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .welcome-subtitle {
        font-size: 1rem;
    }
    
    .current-time {
        margin-top: 1rem;
        text-align: center;
    }
    
    .stat-card-body {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .stat-card-number {
        font-size: 1.75rem;
    }
    
    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
    
    .chart-card-header {
        padding: 1rem;
    }
    
    .chart-card-body {
        padding: 1rem;
    }
}

/* Animation */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update current time
    function updateTime() {
        const now = new Date();
        const timeString = now.toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById('currentTime').textContent = timeString;
    }
    
    updateTime();
    setInterval(updateTime, 1000);

    // Products by Category Chart
    const productsCategoryChart = new Chart(document.getElementById('productsCategoryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($productsPerCategory->keys()) !!},
            datasets: [{
                label: 'Jumlah Produk',
                data: {!! json_encode($productsPerCategory->values()) !!},
                backgroundColor: [
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(23, 162, 184, 0.8)'
                ],
                borderColor: [
                    'rgba(102, 126, 234, 1)',
                    'rgba(118, 75, 162, 1)',
                    'rgba(40, 167, 69, 1)',
                    'rgba(255, 193, 7, 1)',
                    'rgba(23, 162, 184, 1)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
        }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Sales Status Pie Chart
    const salesPieChart = new Chart(document.getElementById('salesPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Aktif', 'Nonaktif'],
            datasets: [{
                data: [{{ $salesActive }}, {{ $salesInactive }}],
                backgroundColor: [
                    'rgba(40, 167, 69, 0.8)',
                    'rgba(108, 117, 125, 0.8)'
                ],
                borderColor: [
                    'rgba(40, 167, 69, 1)',
                    'rgba(108, 117, 125, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Add animation to stat cards
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach((card, index) => {
        card.style.animation = `slideIn 0.6s ease-out ${index * 0.1}s both`;
    });
});

function refreshChart() {
    location.reload();
}
</script>
@endsection 