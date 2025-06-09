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
@endsection 