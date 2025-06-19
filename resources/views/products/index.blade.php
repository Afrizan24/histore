@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name . ' - HiStore' : 'Products - HiStore')

@section('content')
<!-- Category Title -->
<div class="container mt-4">
    <h2 class="mb-4">{{ $currentCategory ? $currentCategory->name : 'Semua Produk' }}</h2>
</div>

<!-- Search and Filter Section -->
<div class="container">
    <div class="modern-filter-wrapper">
        <div class="modern-filter-bar">
            <div class="modern-filter-group">
                <button class="modern-filter-btn" id="sortDropdownBtn" type="button">
                    <i class="fas fa-sort me-1"></i>
                    {{
                        match(request('sort')) {
                            'price_asc' => 'Harga Terendah',
                            'price_desc' => 'Harga Tertinggi',
                            'newest' => 'Terbaru',
                            'popular' => 'Terlaris',
                            default => 'Urutkan',
                        }
                    }}
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
                <div class="modern-dropdown" id="sortDropdown">
                    <a href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'price_asc'])) }}" class="dropdown-item{{ request('sort') == 'price_asc' ? ' active' : '' }}">Harga Terendah</a>
                    <a href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'price_desc'])) }}" class="dropdown-item{{ request('sort') == 'price_desc' ? ' active' : '' }}">Harga Tertinggi</a>
                    <a href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" class="dropdown-item{{ request('sort') == 'newest' ? ' active' : '' }}">Terbaru</a>
                    <a href="?{{ http_build_query(array_merge(request()->except('sort'), ['sort' => 'popular'])) }}" class="dropdown-item{{ request('sort') == 'popular' ? ' active' : '' }}">Terlaris</a>
                </div>
            </div>
            @if($colors->isNotEmpty())
            <div class="modern-filter-group">
                <button class="modern-filter-btn" id="warnaDropdownBtn" type="button">
                    <i class="fas fa-palette me-1"></i>
                    {{ request('warna') && request('warna') !== 'all' ? request('warna') : 'Warna' }}
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
                <div class="modern-dropdown" id="warnaDropdown">
                    <a href="?{{ http_build_query(array_merge(request()->except('warna'), ['warna' => 'all'])) }}" class="dropdown-item{{ !request('warna') || request('warna') === 'all' ? ' active' : '' }}">Semua Warna</a>
                    @foreach($colors as $warna)
                        <a href="?{{ http_build_query(array_merge(request()->except('warna'), ['warna' => $warna])) }}" class="dropdown-item{{ request('warna') == $warna ? ' active' : '' }}">{{ $warna }}</a>
                    @endforeach
                </div>
            </div>
            @endif
            @if($conditions->isNotEmpty())
            <div class="modern-filter-group">
                <button class="modern-filter-btn" id="kondisiDropdownBtn" type="button">
                    <i class="fas fa-star me-1"></i>
                    {{ request('kondisi') && request('kondisi') !== 'all' ? request('kondisi') : 'Kondisi' }}
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
                <div class="modern-dropdown" id="kondisiDropdown">
                    <a href="?{{ http_build_query(array_merge(request()->except('kondisi'), ['kondisi' => 'all'])) }}" class="dropdown-item{{ !request('kondisi') || request('kondisi') === 'all' ? ' active' : '' }}">Semua Kondisi</a>
                    @foreach($conditions as $kondisi)
                        <a href="?{{ http_build_query(array_merge(request()->except('kondisi'), ['kondisi' => $kondisi])) }}" class="dropdown-item{{ request('kondisi') == $kondisi ? ' active' : '' }}">{{ $kondisi }}</a>
                    @endforeach
                </div>
            </div>
            @endif
            @if($storages->isNotEmpty())
            <div class="modern-filter-group">
                <button class="modern-filter-btn" id="storageDropdownBtn" type="button">
                    <i class="fas fa-hdd me-1"></i>
                    {{ request('storage') && request('storage') !== 'all' ? request('storage') : 'Storage' }}
                    <i class="fas fa-chevron-down ms-1"></i>
                </button>
                <div class="modern-dropdown" id="storageDropdown">
                    <a href="?{{ http_build_query(array_merge(request()->except('storage'), ['storage' => 'all'])) }}" class="dropdown-item{{ !request('storage') || request('storage') === 'all' ? ' active' : '' }}">Semua Storage</a>
                    @foreach($storages as $storage)
                        <a href="?{{ http_build_query(array_merge(request()->except('storage'), ['storage' => $storage])) }}" class="dropdown-item{{ request('storage') == $storage ? ' active' : '' }}">{{ $storage }}</a>
                    @endforeach
                </div>
            </div>
            @endif
            @if(request('sort') || (request('warna') && request('warna') !== 'all') || (request('kondisi') && request('kondisi') !== 'all') || (request('storage') && request('storage') !== 'all'))
            <div class="modern-filter-group">
                <a href="{{ route('products.all') }}" class="btn btn-reset-filter"><i class="fas fa-times me-1"></i>Reset</a>
            </div>
            @endif
        </div>
        <div class="modern-filter-badges mt-2">
            @if(request('sort'))
                <span class="filter-badge"><i class="fas fa-sort me-1"></i>{{
                        match(request('sort')) {
                            'price_asc' => 'Harga Terendah',
                            'price_desc' => 'Harga Tertinggi',
                            'newest' => 'Terbaru',
                            'popular' => 'Terlaris',
                            default => request('sort'),
                        }
                    }}</span>
            @endif
            @if(request('warna') && request('warna') !== 'all')
                <span class="filter-badge"><i class="fas fa-palette me-1"></i>{{ request('warna') }}</span>
            @endif
            @if(request('kondisi') && request('kondisi') !== 'all')
                <span class="filter-badge"><i class="fas fa-star me-1"></i>{{ request('kondisi') }}</span>
            @endif
            @if(request('storage') && request('storage') !== 'all')
                <span class="filter-badge"><i class="fas fa-hdd me-1"></i>{{ request('storage') }}</span>
            @endif
        </div>
    </div>
    <div class="row g-4">
        @forelse($products as $product)
        <div class="col-lg-3 col-md-6">
            <div class="product-card p-3">
                <div class="position-relative">
                    @if($product->image)
                    <img src="{{ Storage::url($product->image) }}" class="card-img-top product-image w-100" alt="{{ $product->name }}">
                    @else
                    <div class="product-image w-100 d-flex align-items-center justify-content-center bg-light">
                        <i class="fas fa-laptop fa-3x text-muted"></i>
                    </div>
                    @endif
                    @auth
                    <form action="{{ route('favorites.store', $product) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                        @csrf
                        <button type="submit" class="btn-favorite">
                            <i class="fas fa-heart"></i>
                        </button>
                    </form>
                    @endauth
                </div>
                <div class="mt-3">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="price-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    <div class="d-flex flex-wrap gap-2 mb-2 justify-content-center align-items-center">
                        <span class="badge bg-light text-dark border"><i class="fas fa-palette me-1"></i>{{ $product->warna }}</span>
                        <span class="badge bg-{{ $product->kondisi === 'New' ? 'success' : 'warning' }} text-white"><i class="fas fa-{{ $product->kondisi === 'New' ? 'star' : 'certificate' }} me-1"></i>{{ $product->kondisi }}</span>
                        <span class="badge bg-secondary text-white"><i class="fas fa-hdd me-1"></i>{{ $product->storage }}</span>
                    </div>
                    <p class="favorites-count">
                        <i class="fas fa-heart"></i> {{ $product->favorites_count }} terfavorite
                    </p>
                    <div class="d-flex gap-2">
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm flex-grow-1">View Details</a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                Tidak ada produk yang ditemukan.
            </div>
        </div>
        @endforelse
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $products->appends(request()->query())->links() }}
</div>

<style>
/* Custom User Pagination Styles - White & Black Theme */
.pagination {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    align-items: center;
    margin-bottom: 0;
    padding: 0;
    list-style: none;
}

.pagination .page-item {
    margin: 0 2px;
}

.pagination .page-link {
    min-width: 45px;
    min-height: 45px;
    padding: 0.75rem 1rem;
    font-size: 0.95rem;
    font-weight: 600;
    border-radius: 12px;
    color: #333;
    background: #ffffff;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    position: relative;
    overflow: hidden;
}

.pagination .page-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent);
    transition: left 0.5s ease;
}

.pagination .page-link:hover::before {
    left: 100%;
}

.pagination .page-item.active .page-link {
    background: linear-gradient(135deg, #333333, #000000);
    color: #ffffff;
    border-color: #333333;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    transform: translateY(-2px);
}

.pagination .page-link:focus, 
.pagination .page-link:hover {
    background: #f8f9fa;
    color: #000000;
    border-color: #333333;
    outline: none;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    transform: translateY(-1px);
}

.pagination .page-item.disabled .page-link {
    color: #adb5bd;
    background: #f8f9fa;
    border-color: #e9ecef;
    cursor: not-allowed;
    box-shadow: none;
    transform: none;
}

.pagination .page-item.disabled .page-link:hover {
    transform: none;
    box-shadow: none;
}

/* Pagination Info Styling */
.pagination-info {
    text-align: center;
    margin-bottom: 1rem;
    color: #6c757d;
    font-size: 0.9rem;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .pagination .page-link {
        min-width: 40px;
        min-height: 40px;
        padding: 0.6rem 0.8rem;
        font-size: 0.9rem;
        border-radius: 10px;
    }
    
    .pagination {
        gap: 0.3rem;
    }
}

@media (max-width: 576px) {
    .pagination .page-link {
        min-width: 35px;
        min-height: 35px;
        padding: 0.5rem 0.7rem;
        font-size: 0.85rem;
        border-radius: 8px;
    }
    
    .pagination {
        gap: 0.25rem;
    }
}

/* Animation for page transitions */
.pagination .page-link {
    animation: fadeInUp 0.3s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced focus states for accessibility */
.pagination .page-link:focus-visible {
    outline: 2px solid #333333;
    outline-offset: 2px;
}

/* Loading state for pagination */
.pagination.loading .page-link {
    pointer-events: none;
    opacity: 0.7;
}

/* Custom scrollbar for pagination container if needed */
.pagination-container {
    scrollbar-width: thin;
    scrollbar-color: #333333 #f8f9fa;
}

.pagination-container::-webkit-scrollbar {
    height: 6px;
}

.pagination-container::-webkit-scrollbar-track {
    background: #f8f9fa;
    border-radius: 3px;
}

.pagination-container::-webkit-scrollbar-thumb {
    background: #333333;
    border-radius: 3px;
}

.pagination-container::-webkit-scrollbar-thumb:hover {
    background: #000000;
}

/* Modern Filter Section */
.filter-modern {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    padding: 1.5rem 1.2rem 1.2rem 1.2rem;
    margin-bottom: 2.5rem;
}
.filter-search-group {
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    border-radius: 2rem;
    overflow: hidden;
    background: #f8f9fa;
}
.filter-input {
    border: none;
    border-radius: 2rem 0 0 2rem;
    background: #f8f9fa;
    color: #111;
    font-size: 1.05rem;
    padding: 0.85rem 1.2rem;
    box-shadow: none;
}
.filter-input:focus {
    background: #fff;
    outline: none;
    box-shadow: 0 0 0 2px #1112;
}
.btn-search-modern {
    background: #111;
    color: #fff;
    border: none;
    border-radius: 0 2rem 2rem 0;
    padding: 0.85rem 1.3rem;
    font-size: 1.1rem;
    font-weight: 600;
    transition: background 0.2s, color 0.2s;
    box-shadow: none;
}
.btn-search-modern:hover {
    background: #fff;
    color: #111;
    border: 1.5px solid #111;
}
.filter-select {
    border-radius: 2rem;
    background: #f8f9fa;
    color: #111;
    font-size: 1.05rem;
    padding: 0.85rem 1.2rem;
    border: 1.5px solid #eee;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    transition: border 0.2s, background 0.2s;
}
.filter-select:focus {
    background: #fff;
    border: 1.5px solid #111;
    outline: none;
}
@media (max-width: 768px) {
    .filter-modern { padding: 1rem 0.5rem; }
    .filter-search-group { border-radius: 1.2rem; }
    .filter-input, .btn-search-modern, .filter-select { padding: 0.7rem 0.8rem; font-size: 0.98rem; }
}

/* Modern Interactive Filter */
.modern-filter-wrapper {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    padding: 1.5rem 1.2rem 1.2rem 1.2rem;
    margin-bottom: 2.5rem;
}
.modern-filter-bar {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: center;
}
.modern-filter-group {
    position: relative;
}
.modern-filter-btn {
    background: #f8f9fa;
    color: #111;
    border: 1.5px solid #eee;
    border-radius: 2rem;
    padding: 0.7rem 1.4rem;
    font-size: 1.05rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: background 0.18s, color 0.18s, border 0.18s;
    outline: none;
}
.modern-filter-btn:hover, .modern-filter-btn.active {
    background: #111;
    color: #fff;
    border: 1.5px solid #111;
}
.modern-dropdown {
    display: none;
    position: absolute;
    top: 110%;
    left: 0;
    min-width: 180px;
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    z-index: 10;
    padding: 0.5rem 0;
    animation: fadeInDropdown 0.25s;
}
@keyframes fadeInDropdown {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.modern-dropdown .dropdown-item {
    display: flex;
    align-items: center;
    padding: 0.7rem 1.2rem;
    color: #111;
    font-weight: 500;
    background: none;
    border: none;
    width: 100%;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    text-decoration: none;
}
.modern-dropdown .dropdown-item:hover, .modern-dropdown .dropdown-item.active {
    background: #111;
    color: #fff;
}
.btn-reset-filter {
    background: #fff;
    color: #111;
    border: 1.5px solid #eee;
    border-radius: 2rem;
    padding: 0.7rem 1.4rem;
    font-size: 1.05rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: background 0.18s, color 0.18s, border 0.18s;
    outline: none;
}
.btn-reset-filter:hover {
    background: #111;
    color: #fff;
    border: 1.5px solid #111;
}
.modern-filter-badges {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 0.5rem;
}
.filter-badge {
    background: #f8f9fa;
    color: #111;
    border-radius: 1.2rem;
    padding: 0.4rem 1.1rem;
    font-size: 0.98rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}
@media (max-width: 768px) {
    .modern-filter-wrapper { padding: 1rem 0.5rem; }
    .modern-filter-bar { gap: 0.5rem; }
    .modern-filter-btn, .btn-reset-filter { padding: 0.6rem 1rem; font-size: 0.97rem; }
    .modern-dropdown { min-width: 120px; }
}

/* Reset margin dan padding pada grid produk */
/* .row.g-4 {
    margin-left: 0 !important;
    margin-right: 0 !important;
} */
/* HAPUS: .row.g-4 > .col-lg-3, .row.g-4 > .col-md-6 agar gap default Bootstrap */
/* .row.g-4 > .col-lg-3,
.row.g-4 > .col-md-6 {
    padding-left: 0.5rem !important;
    padding-right: 0.5rem !important;
    margin-right: 0 !important;
    margin-left: 0 !important;
    display: flex;
    justify-content: center;
} */
/* Product card sama persis dengan featured products */
.product-card {
    width: 240px;
    background: #fff;
    border: 1.5px solid #eee;
    border-radius: 18px;
    padding: 18px 16px 16px 16px !important;
    text-align: center;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    color: #111;
    transition: transform 0.18s, box-shadow 0.18s;
    margin: 0 auto;
}

.product-card:hover {
    transform: translateY(-7px) scale(1.03);
    box-shadow: 0 8px 32px rgba(0,0,0,0.10);
}

.product-card img {
    width: 100%;
    border-radius: 12px;
    margin-bottom: 14px;
    background: #f5f5f5;
}

.product-card .card-title {
    font-size: 1.15em;
    margin-bottom: 8px;
    font-weight: 700;
    color: #111;
}

.product-card .price-text {
    font-weight: bold;
    color: #111;
    margin-bottom: 10px;
    font-size: 1.1em;
}

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
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: background 0.2s, color 0.2s;
}

.product-card .btn:hover {
    background: #fff;
    color: #111;
    border: 1.5px solid #111;
}

.product-card .favorites-count {
    font-size: 0.95em;
    color: #888;
}

/* Override Bootstrap default */
.container {
    padding-left: 15px;
    padding-right: 15px;
}

/* Responsive Design untuk Product Card - sama dengan featured products */
@media (max-width: 900px) {
    .product-card { 
        width: 100%; 
        max-width: 320px; 
    }
}

@media (max-width: 576px) {
    .product-card { 
        padding: 12px 4px 12px 4px !important; 
    }
}
</style>

@push('scripts')
<script>
// Dropdown interactivity
function closeAllDropdowns() {
    document.querySelectorAll('.modern-dropdown').forEach(dd => dd.style.display = 'none');
    document.querySelectorAll('.modern-filter-btn').forEach(btn => btn.classList.remove('active'));
}
document.addEventListener('DOMContentLoaded', function() {
    const dropdowns = [
        {btn: 'sortDropdownBtn', dd: 'sortDropdown'},
        {btn: 'warnaDropdownBtn', dd: 'warnaDropdown'},
        {btn: 'kondisiDropdownBtn', dd: 'kondisiDropdown'},
        {btn: 'storageDropdownBtn', dd: 'storageDropdown'},
    ];
    dropdowns.forEach(({btn, dd}) => {
        const btnEl = document.getElementById(btn);
        const ddEl = document.getElementById(dd);
        if(btnEl && ddEl) {
            btnEl.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = ddEl.style.display === 'block';
                closeAllDropdowns();
                if(!isOpen) {
                    ddEl.style.display = 'block';
                    btnEl.classList.add('active');
                }
            });
        }
    });
    document.addEventListener('click', closeAllDropdowns);
    document.querySelectorAll('.modern-dropdown .dropdown-item').forEach(item => {
        item.addEventListener('click', closeAllDropdowns);
    });
});
</script>
@endpush
@endsection 