@extends('layouts.app')

@section('title', $currentCategory ? $currentCategory->name . ' - HiStore' : 'Products - HiStore')

@section('content')
<!-- Category Title -->
<div class="container mt-4">
    <h2 class="mb-4">{{ $currentCategory ? $currentCategory->name : 'Semua Produk' }}</h2>
</div>

<!-- Search and Filter Section -->
<div class="container">
    <form method="GET" id="filterForm" class="mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-2">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Urutkan</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga Terendah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terlaris</option>
                </select>
            </div>
            @if($colors->isNotEmpty())
            <div class="col-md-2">
                <select name="warna" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ !request('warna') || request('warna') === 'all' ? 'selected' : '' }}>Semua Warna</option>
                    @foreach($colors as $warna)
                        <option value="{{ $warna }}" {{ request('warna') == $warna ? 'selected' : '' }}>{{ $warna }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($conditions->isNotEmpty())
            <div class="col-md-2">
                <select name="kondisi" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ !request('kondisi') || request('kondisi') === 'all' ? 'selected' : '' }}>Semua Kondisi</option>
                    @foreach($conditions as $kondisi)
                        <option value="{{ $kondisi }}" {{ request('kondisi') == $kondisi ? 'selected' : '' }}>{{ $kondisi }}</option>
                    @endforeach
                </select>
            </div>
            @endif
            @if($storages->isNotEmpty())
            <div class="col-md-2">
                <select name="storage" class="form-select" onchange="this.form.submit()">
                    <option value="all" {{ !request('storage') || request('storage') === 'all' ? 'selected' : '' }}>Semua Storage</option>
                    @foreach($storages as $storage)
                        <option value="{{ $storage }}" {{ request('storage') == $storage ? 'selected' : '' }}>{{ $storage }}</option>
                    @endforeach
                </select>
            </div>
            @endif
        </div>
    </form>

    <!-- Products Grid -->
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

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(request()->query())->links() }}
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preserve category parameter in form
    const categorySlug = '{{ $currentCategory ? $currentCategory->slug : "" }}';
    if (categorySlug) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'category';
        input.value = categorySlug;
        document.getElementById('filterForm').appendChild(input);
    }
});
</script>
@endpush
@endsection 