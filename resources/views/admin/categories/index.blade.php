@extends('admin.layout')

@section('title', 'Category Management - Admin Dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header-category">
        <div class="admin-header-content">
            <div class="admin-header-left">
                <h1 class="admin-title">
                    <i class="fas fa-tags me-2"></i>
                    Category Management
                </h1>
                <p class="admin-subtitle">Manage product categories and organize your inventory</p>
            </div>
            <div class="admin-header-right">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    Add New Category
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-section">
        <div class="row g-3">
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-primary">
                    <div class="stat-card-body">
                        <div class="stat-card-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-number">{{ $categories->total() }}</h3>
                            <p class="stat-card-label">Total Categories</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-success">
                    <div class="stat-card-body">
                        <div class="stat-card-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-number">{{ $categories->where('is_active', true)->count() }}</h3>
                            <p class="stat-card-label">Active Categories</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-warning">
                    <div class="stat-card-body">
                        <div class="stat-card-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-number">{{ $totalProducts }}</h3>
                            <p class="stat-card-label">Total Products</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="stat-card stat-card-info">
                    <div class="stat-card-body">
                        <div class="stat-card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="stat-card-content">
                            <h3 class="stat-card-number">{{ $avgProductsPerCategory }}</h3>
                            <p class="stat-card-label">Avg Products/Category</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="search-filter-section">
        <div class="search-filter-card">
            <div class="search-filter-header">
                <h5 class="search-filter-title">
                    <i class="fas fa-search me-2"></i>Search & Filter Categories
                </h5>
            </div>
            <div class="search-filter-body">
                <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label for="search" class="form-label">Search Categories</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Category name or description...">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="form-group">
                            <label for="sort" class="form-label">Sort By</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
                                <option value="products_desc" {{ request('sort') == 'products_desc' ? 'selected' : '' }}>Most Products</option>
                                <option value="products_asc" {{ request('sort') == 'products_asc' ? 'selected' : '' }}>Least Products</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-grow-1">
                                    <i class="fas fa-search me-1"></i>Search
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Categories Table Section -->
    <div class="categories-table-section">
        <div class="categories-table-card">
            <div class="categories-table-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="categories-table-title">
                        <i class="fas fa-list me-2"></i>Categories List
                    </h5>
                    <div class="categories-table-stats">
                        <span class="badge bg-primary">{{ $categories->total() }} Categories</span>
                        <span class="badge bg-success">{{ $categories->where('is_active', true)->count() }} Active</span>
                    </div>
                </div>
            </div>

            <div class="categories-table-body">
                @if($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th class="category-image-col">Image</th>
                                    <th class="category-name-col">Category Name</th>
                                    <th class="category-description-col">Description</th>
                                    <th class="category-products-col">Products</th>
                                    <th class="category-status-col">Status</th>
                                    <th class="category-date-col">Created</th>
                                    <th class="category-actions-col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td class="category-image-cell">
                                        @if($category->image)
                                            <img src="{{ Storage::url($category->image) }}" 
                                                 alt="{{ $category->name }}" 
                                                 class="category-thumbnail">
                                        @else
                                            <div class="category-placeholder">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="category-name-cell">
                                        <div class="category-name">
                                            <strong>{{ $category->name }}</strong>
                                            <small class="text-muted d-block">/{{ $category->slug }}</small>
                                        </div>
                                    </td>
                                    <td class="category-description-cell">
                                        <div class="category-description">
                                            {{ Str::limit($category->description, 60) ?: 'No description' }}
                                        </div>
                                    </td>
                                    <td class="category-products-cell">
                                        <div class="category-products-count">
                                            <span class="badge bg-info">{{ $category->products_count }}</span>
                                            <small class="text-muted d-block">products</small>
                                        </div>
                                    </td>
                                    <td class="category-status-cell">
                                        <span class="status-badge status-{{ $category->is_active ? 'active' : 'inactive' }}">
                                            <i class="fas fa-{{ $category->is_active ? 'check' : 'times' }}-circle me-1"></i>
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="category-date-cell">
                                        <div class="category-date">
                                            <small class="text-muted">{{ $category->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </td>
                                    <td class="category-actions-cell">
                                        <div class="category-actions">
                                            <a href="{{ route('admin.categories.edit', $category) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Edit Category">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                                               class="btn btn-sm btn-outline-info" 
                                               target="_blank"
                                               title="View Products">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-warning toggle-status-btn"
                                                    data-category-id="{{ $category->id }}"
                                                    data-current-status="{{ $category->is_active }}"
                                                    title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                                <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                            </button>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                                  method="POST" 
                                                  class="d-inline delete-category-form"
                                                  onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all products in this category.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Delete Category">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <h3>No Categories Found</h3>
                        <p>Start by creating your first category to organize your products.</p>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Create First Category
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
    <div class="pagination-section">
        <div class="pagination-info">
            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} categories
        </div>
        <div class="pagination-links">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    </div>
    @endif
</div>

<style>
/* Admin Container */
.admin-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Admin Header */
.admin-header-category {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.admin-header-category-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.admin-title {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
}

.admin-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

/* Statistics Section */
.stats-section {
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 20px rgba(0,0,0,0.12);
}

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

.stat-card-primary .stat-card-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
.stat-card-success .stat-card-icon { background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%); }
.stat-card-warning .stat-card-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
.stat-card-info .stat-card-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

.stat-card-number {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
    color: #2c3e50;
}

.stat-card-label {
    margin: 0;
    color: #6c757d;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Search Filter Section */
.search-filter-section {
    margin-bottom: 2rem;
}

.search-filter-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

.search-filter-header {
    padding: 1.5rem 1.5rem 0;
}

.search-filter-title {
    margin: 0;
    color: #2c3e50;
    font-weight: 600;
}

.search-filter-body {
    padding: 1.5rem;
}

/* Categories Table Section */
.categories-table-section {
    margin-bottom: 2rem;
}

.categories-table-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.categories-table-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: #f8f9fa;
}

.categories-table-title {
    margin: 0;
    color: #2c3e50;
    font-weight: 600;
}

.categories-table-stats {
    display: flex;
    gap: 0.5rem;
}

.categories-table-body {
    padding: 0;
}

/* Table Styles */
.table {
    margin: 0;
}

.table th {
    background: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
    font-weight: 600;
    color: #495057;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

/* Category Image */
.category-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #e9ecef;
}

.category-placeholder {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    border: 2px solid #e9ecef;
}

/* Status Badge */
.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.status-active {
    background: #d4edda;
    color: #155724;
}

.status-inactive {
    background: #f8d7da;
    color: #721c24;
}

/* Category Actions */
.category-actions {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}

.category-actions .btn {
    padding: 0.375rem 0.5rem;
    font-size: 0.8rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    color: #6c757d;
    margin-bottom: 1.5rem;
    opacity: 0.6;
}

.empty-state h3 {
    color: #495057;
    margin-bottom: 1rem;
    font-weight: 600;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 2rem;
}

/* Pagination Section */
.pagination-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
}

.pagination-info {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .admin-header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .admin-title {
        font-size: 1.5rem;
    }
    
    .categories-table-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .category-actions {
        flex-direction: column;
    }
    
    .pagination-section {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}

/* Column Widths */
.category-image-col { width: 80px; }
.category-name-col { width: 200px; }
.category-description-col { width: 250px; }
.category-products-col { width: 100px; }
.category-status-col { width: 120px; }
.category-date-col { width: 120px; }
.category-actions-col { width: 150px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle category status
    document.querySelectorAll('.toggle-status-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const categoryId = this.dataset.categoryId;
            const currentStatus = this.dataset.currentStatus === '1';
            const newStatus = !currentStatus;
            
            if (confirm(`Are you sure you want to ${newStatus ? 'activate' : 'deactivate'} this category?`)) {
                fetch(`/admin/categories/${categoryId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ is_active: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error updating category status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error updating category status');
                });
            }
        });
    });

    // Auto-submit form on select change
    document.querySelectorAll('select[name="status"], select[name="sort"]').forEach(select => {
        select.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });

    // Setelah carousel tampil, pastikan banner-content pada slide aktif langsung muncul
    const activeSlide = document.querySelector('.carousel-item.active');
    if (activeSlide) {
        const bannerContent = activeSlide.querySelector('.banner-content');
        if (bannerContent) {
            bannerContent.classList.add('show');
        }
    }
});
</script>
@endsection 