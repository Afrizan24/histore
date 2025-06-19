@extends('layouts.app')

@section('title', 'Favorit Saya - HiStore')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Favorit Saya</h2>

    @if($favorites->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
        <h4>Belum ada produk favorit</h4>
        <p class="text-muted">Tambahkan produk ke favorit untuk melihatnya di sini</p>
        <a href="{{ route('products.all') }}" class="btn btn-primary mt-3">Lihat Produk</a>
    </div>
    @else
    <div class="products">
        @foreach($favorites as $favorite)
        <div class="card">
            <div class="position-relative">
                @if($favorite->product->image)
                <img src="{{ Storage::url($favorite->product->image) }}" alt="{{ $favorite->product->name }}" class="card-img-top">
                @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="fas fa-laptop fa-3x text-muted"></i>
                </div>
                @endif
                <form action="{{ route('favorites.destroy', $favorite->product) }}" method="POST" class="position-absolute top-0 end-0 m-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-favorite">
                        <i class="fas fa-heart"></i>
                    </button>
                </form>
            </div>
            <h3>{{ $favorite->product->name }}</h3>
            <p class="price">Rp {{ number_format($favorite->product->price, 0, ',', '.') }}</p>
            <p class="favorite">
                <i class="fas fa-heart"></i> {{ $favorite->product->favorites_count }} terfavorite
            </p>
            <a href="{{ route('products.show', $favorite->product->slug) }}" class="btn">View Details</a>
        </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $favorites->links() }}
    </div>
    @endif
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
</style>
@endsection 