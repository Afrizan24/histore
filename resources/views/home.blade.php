@extends('layouts.app')

@section('title', 'Kiansantang Store - Home')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-4">Welcome to Kiansantang Store</h1>
                <p class="lead mb-4">Discover the latest Apple products with the best prices and quality guaranteed.</p>
                <a href="{{ route('products.all') }}" class="btn btn-light btn-lg">Browse Products</a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Featured Products</h2>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
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
            @endforeach
        </div>
    </div>
</section>
@endsection
