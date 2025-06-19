@extends('admin.layout')

@section('title', 'Product Management')

@section('content')
<!-- Header Section -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="page-title">Product Management</h1>
            <p class="page-subtitle">Kelola semua produk dalam sistem toko Anda</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-lg">
                <i class="fas fa-plus me-2"></i>Add New Product
            </a>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="search-filter-card mb-4">
    <div class="search-filter-header">
        <h5 class="search-filter-title">
            <i class="fas fa-search me-2"></i>Search & Filter
        </h5>
    </div>
    <div class="search-filter-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
            <div class="col-lg-4 col-md-6">
                <div class="form-group">
                    <label for="search" class="form-label">Search Products</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Product name...">
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select" id="category" name="category">
                        <option value="">All Categories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="form-group">
                    <label for="condition" class="form-label">Condition</label>
                    <select class="form-select" id="condition" name="condition">
                        <option value="">All Conditions</option>
                        <option value="New" {{ request('condition') == 'New' ? 'selected' : '' }}>New</option>
                        <option value="Second" {{ request('condition') == 'Second' ? 'selected' : '' }}>Second</option>
                    </select>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="fas fa-search me-1"></i>Search
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary" title="Clear Filters">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Products Table -->
<div class="products-table-card">
    <div class="products-table-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="products-table-title">
                <i class="fas fa-box me-2"></i>Products List
            </h5>
            <div class="products-table-stats">
                <span class="badge bg-primary">{{ $products->total() }} Products</span>
            </div>
        </div>
    </div>

    <div class="products-table-body">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th class="product-image-col">Image</th>
                        <th class="product-name-col">Product Name</th>
                        <th class="product-category-col">Category</th>
                        <th class="product-price-col">Price</th>
                        <th class="product-specs-col">Specifications</th>
                        <th class="product-status-col">Status</th>
                        <th class="product-actions-col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                    <tr class="product-row">
                        <td class="product-image-cell">
                            <div class="product-image-wrapper">
                                @if($product->image)
                                    <img src="{{ Storage::url($product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image">
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="fas fa-image"></i>
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="product-name-cell">
                            <div class="product-info">
                                <h6 class="product-name">{{ $product->name }}</h6>
                                <p class="product-description">{{ Str::limit($product->description, 60) }}</p>
                            </div>
                        </td>
                        <td class="product-category-cell">
                            <span class="category-badge">{{ $product->category->name }}</span>
                        </td>
                        <td class="product-price-cell">
                            <div class="price-info">
                                <span class="price-amount">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="product-specs-cell">
                            <div class="specs-info">
                                <div class="spec-item">
                                    <span class="spec-label">Color:</span>
                                    <span class="spec-value">{{ $product->warna }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Storage:</span>
                                    <span class="spec-value">{{ $product->storage }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Condition:</span>
                                    <span class="condition-badge {{ $product->kondisi === 'New' ? 'new' : 'second' }}">
                                        {{ $product->kondisi === 'New' ? 'New' : 'Second' }}
                                    </span>
                                </div>
                            </div>
                            </td>
                        <td class="product-status-cell">
                            <span class="status-badge {{ $product->is_active ? 'active' : 'inactive' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        <td class="product-actions-cell">
                            <div class="action-buttons">
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="action-btn action-btn-edit" 
                                   title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                <a href="{{ route('products.show', $product) }}" 
                                   class="action-btn action-btn-view" 
                                   title="View Details" 
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                    <button type="submit" 
                                            class="action-btn action-btn-delete" 
                                            title="Delete Product">
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
            <div class="empty-state-icon">
                <i class="fas fa-box"></i>
            </div>
            <h5 class="empty-state-title">No Products Found</h5>
            <p class="empty-state-description">Start by adding your first product to the store</p>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add First Product
            </a>
        </div>
        @endif
            </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="products-table-footer">
        <div class="d-flex justify-content-center">
            <div class="pagination-links">
                {{ $products->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
/* Page Header */
.page-header {
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 1.1rem;
}

/* Search & Filter Card */
.search-filter-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.search-filter-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.search-filter-title {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}

.search-filter-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 0;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.input-group-text {
    background: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

/* Products Table Card */
.products-table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.products-table-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.products-table-title {
    margin: 0;
    font-weight: 600;
    color: #2c3e50;
}

.products-table-body {
    padding: 0;
}

/* Table Styles */
.table {
    margin-bottom: 0;
}

.table thead th {
    background: #f8f9fa;
    border: none;
    padding: 1rem 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody td {
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 1px solid #f1f3f4;
    vertical-align: middle;
}

.product-row:hover {
    background: #f8f9fa;
}

/* Product Image */
.product-image-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-image-placeholder {
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 1.2rem;
}

/* Product Info */
.product-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.product-description {
    color: #6c757d;
    margin-bottom: 0;
    font-size: 0.85rem;
    line-height: 1.4;
}

/* Badges */
.category-badge {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.condition-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.condition-badge.new {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.condition-badge.second {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
    color: white;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.status-badge.active {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.status-badge.inactive {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

/* Price */
.price-amount {
    font-weight: 700;
    color: #28a745;
    font-size: 1.1rem;
}

/* Specifications */
.specs-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.spec-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
}

.spec-label {
    color: #6c757d;
    font-weight: 500;
    min-width: 60px;
}

.spec-value {
    color: #2c3e50;
    font-weight: 600;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.action-btn {
    width: 35px;
    height: 35px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    font-size: 0.9rem;
}

.action-btn-edit {
    background: linear-gradient(135deg, #17a2b8, #6f42c1);
    color: white;
}

.action-btn-edit:hover {
    background: linear-gradient(135deg, #138496, #5a32a3);
    color: white;
    transform: translateY(-2px);
}

.action-btn-view {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
}

.action-btn-view:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    color: white;
    transform: translateY(-2px);
}

.action-btn-delete {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
}

.action-btn-delete:hover {
    background: linear-gradient(135deg, #c82333, #a71e2a);
    color: white;
    transform: translateY(-2px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.empty-state-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.empty-state-description {
    color: #6c757d;
    margin-bottom: 2rem;
}

/* Table Footer */
.products-table-footer {
    padding: 1.5rem;
    border-top: 1px solid #e9ecef;
    background: #f8f9fa;
}

/* Custom Pagination Styles */
.pagination {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
    align-items: center;
    margin-bottom: 0;
}
.pagination .page-item {
    margin: 0 2px;
}
.pagination .page-link {
    min-width: 40px;
    min-height: 40px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    font-weight: 600;
    border-radius: 10px;
    color: #6f42c1;
    background: #f8f9fa;
    border: none;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #6f42c1, #17a2b8);
    color: #fff;
    box-shadow: 0 2px 8px rgba(111,66,193,0.08);
}
.pagination .page-link:focus, .pagination .page-link:hover {
    background: #e9ecef;
    color: #6f42c1;
    outline: none;
    box-shadow: 0 2px 8px rgba(111,66,193,0.08);
}
.pagination .page-item.disabled .page-link {
    color: #bcbcbc;
    background: #f1f3f4;
    cursor: not-allowed;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .search-filter-body {
        padding: 1rem;
    }
    
    .products-table-header {
        padding: 1rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 0.75rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .action-btn {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .specs-info {
        font-size: 0.8rem;
    }
    
    .product-name {
        font-size: 0.9rem;
    }
    
    .product-description {
        font-size: 0.8rem;
    }
    
    .pagination .page-link {
        min-width: 32px;
        min-height: 32px;
        padding: 0.3rem 0.6rem;
        font-size: 0.85rem;
    }
}
</style>
@endsection 