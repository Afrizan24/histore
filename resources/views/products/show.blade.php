@extends('layouts.app')

@section('title', $product->name . ' - Kiansantang Store')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="bg-white rounded-4 shadow-sm overflow-hidden mb-3">
                <img src="{{ $product->image ? Storage::url($product->image) : asset('images/no-image.png') }}" alt="{{ $product->name }}" class="w-100" style="object-fit:cover; min-height:320px;">
            </div>
        </div>
        <!-- Product Details -->
        <div class="col-md-7">
            <h1 class="fw-bold mb-2">{{ $product->name }}</h1>
            <div class="mb-2">
                <span class="badge bg-primary me-2">{{ $product->category->name }}</span>
                <span class="badge bg-secondary">{{ $product->kondisi }}</span>
            </div>
            <h3 class="text-danger mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
            <ul class="list-unstyled mb-3">
                <li><strong>Warna:</strong> {{ $product->warna }}</li>
                <li><strong>Storage:</strong> {{ $product->storage }}</li>
            </ul>
            <div class="mb-3">
                <strong>Deskripsi:</strong>
                <p class="mb-2">{{ $product->description }}</p>
            </div>
            <div class="mb-3">
                <strong>Favorit:</strong> <i class="fas fa-heart text-danger"></i> {{ $product->favorites->count() }}
            </div>
            @if($product->stock > 0)
                <a href="{{ route('sales.index') }}" class="btn btn-success btn-lg mb-2 w-100"><i class="fab fa-whatsapp me-2"></i>Hubungi Sales</a>
            @else
                <div class="alert alert-warning">Stok Habis</div>
            @endif
            @auth
                <form action="{{ route('favorites.store', $product) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger"><i class="fas fa-heart"></i> Tambah ke Favorit</button>
                </form>
            @endauth
        </div>
    </div>
    <!-- Related Products -->
    @if($relatedProducts->count())
    <div class="mt-5">
        <h4 class="mb-4">Produk Terkait</h4>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-6 col-md-3">
                <div class="card h-100">
                    <img src="{{ $related->image ? Storage::url($related->image) : asset('images/no-image.png') }}" class="card-img-top" alt="{{ $related->name }}">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $related->name }}</h6>
                        <div class="text-danger fw-bold mb-2">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                        <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary w-100">Lihat Detail</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection 