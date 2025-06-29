@extends('layouts.app')

@section('title', 'Kiansantang Store - Home')

@section('content')
<!-- Banner Carousel -->
@if($banners->count() > 0)
<section class="banner-carousel-section mb-5">
    <div class="container-fluid p-0">
        <!-- Loading Skeleton -->
        <div id="bannerLoading" class="banner-loading">
            <div class="loading-skeleton">
                <div class="skeleton-image"></div>
                <div class="skeleton-content">
                    <div class="skeleton-title"></div>
                    <div class="skeleton-description"></div>
                    <div class="skeleton-button"></div>
                </div>
            </div>
        </div>

        <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" style="display: none;">
            <!-- Carousel Indicators -->
            @if($banners->count() > 1)
            <div class="carousel-indicators">
                @foreach($banners as $index => $banner)
                <button type="button"
                        data-bs-target="#bannerCarousel"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}">
                </button>
                @endforeach
            </div>
            @endif

            <!-- Carousel Items -->
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <div class="banner-slide position-relative">
                        <img src="{{ Storage::url($banner->image) }}"
                             class="d-block w-100 banner-image"
                             alt="{{ $banner->title }}"
                             loading="eager"
                             onload="this.style.opacity='1'"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                        <!-- Fallback for failed images -->
                        <div class="banner-fallback" style="display: none;">
                            <div class="fallback-content">
                                <i class="fas fa-image fa-4x text-white mb-3"></i>
                                <h3 class="text-white">{{ $banner->title }}</h3>
                            </div>
                        </div>

                        <!-- Banner Content Overlay -->
                        <div class="banner-content">
                            <div class="container">
                                <div class="row align-items-center min-vh-50">
                                    <div class="col-lg-6">
                                        <div class="banner-text">
                                            <h1 class="banner-title display-4 fw-bold text-white mb-3">
                                                {{ $banner->title }}
                                            </h1>
                                            @if($banner->description)
                                            <p class="banner-description lead text-white mb-4">
                                                {{ $banner->description }}
                                            </p>
                                            @endif
                                            @if($banner->button_text && $banner->button_url)
                                            <a href="{{ $banner->button_url }}"
                                               class="btn btn-light btn-lg px-4 py-2 fw-bold">
                                                {{ $banner->button_text }}
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Carousel Controls -->
            @if($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    </div>
</section>

<!-- Preload Banner Images -->
<div style="display: none;">
    @foreach($banners as $banner)
    <img src="{{ Storage::url($banner->image) }}" alt="preload">
    @endforeach
</div>
@endif

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
        <div class="row align-items-center">
            <div class="col-lg-8">
                    <h1 class="hero-title">Welcome to Kiansantang Store</h1>
                    <p class="hero-subtitle">Discover the latest Apple products with the best prices and quality guaranteed. We provide authentic products with excellent customer service.</p>

                    <div class="hero-buttons">
                        <a href="{{ route('products.all') }}" class="hero-btn hero-btn-primary">
                            <i class="fas fa-shopping-bag"></i>
                            Browse Products
                        </a>
                        <a href="#featured" class="hero-btn hero-btn-secondary">
                            <i class="fas fa-star"></i>
                            Featured Items
                        </a>
                    </div>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-number">500+</span>
                            <span class="hero-stat-label">Happy Customers</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">100+</span>
                            <span class="hero-stat-label">Products</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-number">24/7</span>
                            <span class="hero-stat-label">Support</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="hero-visual">
                        <i class="fas fa-mobile-alt fa-6x mb-3" style="opacity: 0.8;"></i>
                        <div class="hero-badge">
                            <span class="badge bg-light text-dark px-3 py-2">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Authentic Products
                            </span>
                        </div>
                    </div>
                </div>
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
                        @else
                        <button type="button" class="btn-favorite position-absolute top-0 end-0 m-2 @isFavorite($product->id) favorited @endisFavorite" onclick="toggleFavorite({{ $product->id }})" id="favorite-btn-{{ $product->id }}">
                            <i class="fas fa-heart @isFavorite($product->id) favorited @endisFavorite"></i>
                        </button>
                        @endauth
                    </div>
                    <div class="mt-3">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="price-text">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="favorites-count" id="favorites-count-{{ $product->id }}">
                            <i class="fas fa-heart"></i> @totalFavorites($product->id) terfavorite
                        </p>
                        <div class="stock-info mb-2">
                            <span class="badge bg-{{ $product->stock > 5 ? 'success' : ($product->stock > 0 ? 'warning' : 'danger') }}">
                                <i class="fas fa-boxes me-1"></i>
                                {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                            </span>
                        </div>
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

<style>
/* Banner Loading Skeleton */
.banner-loading {
    position: relative;
    height: 600px;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    overflow: hidden;
    opacity: 1;
    transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
}

.banner-loading.fade-out {
    opacity: 0;
    transform: translateY(-20px);
}

.loading-skeleton {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    padding: 2rem;
}

.skeleton-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

.skeleton-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
    width: 100%;
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.6s ease-in-out, transform 0.6s ease-in-out;
}

.skeleton-content.fade-out {
    opacity: 0;
    transform: translateY(-30px);
}

.skeleton-title {
    height: 3rem;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 25%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0.3) 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.skeleton-description {
    height: 1.5rem;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 25%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0.3) 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 4px;
    margin-bottom: 1rem;
    width: 80%;
}

.skeleton-button {
    height: 3rem;
    width: 150px;
    background: linear-gradient(90deg, rgba(255,255,255,0.3) 25%, rgba(255,255,255,0.5) 50%, rgba(255,255,255,0.3) 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 25px;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Banner Carousel Styles */
.banner-carousel-section {
    margin-top: 0;
    position: relative;
    overflow: hidden;
}

.banner-slide {
    position: relative;
    height: 600px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

/* Additional Banner Image Optimizations */
.banner-slide::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg,
        rgba(0,0,0,0.3) 0%,
        rgba(0,0,0,0.1) 50%,
        rgba(0,0,0,0.3) 100%);
    z-index: 1;
    pointer-events: none;
}

.banner-image {
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center center;
    opacity: 0;
    transform: scale(1.1);
    transition: opacity 1s ease-in-out, transform 1.2s ease-in-out;
    filter: blur(2px);
    position: absolute;
    top: 0;
    left: 0;
    z-index: 0;
}

.banner-image.loaded {
    opacity: 1;
    transform: scale(1);
    filter: blur(0);
}

/* Smart image positioning based on aspect ratio */
.banner-image[data-aspect="portrait"] {
    object-position: center 20%;
}

.banner-image[data-aspect="landscape"] {
    object-position: center center;
}

.banner-image[data-aspect="square"] {
    object-position: center center;
}

/* Responsive image positioning for different screen sizes */
@media (min-width: 1200px) {
    .banner-image {
        object-position: center 25%;
    }

    .banner-image[data-aspect="portrait"] {
        object-position: center 15%;
    }
}

@media (min-width: 768px) and (max-width: 1199px) {
    .banner-image {
        object-position: center 30%;
    }

    .banner-image[data-aspect="portrait"] {
        object-position: center 25%;
    }
}

@media (max-width: 767px) {
    .banner-image {
        object-position: center 40%;
    }

    .banner-image[data-aspect="portrait"] {
        object-position: center 35%;
    }
}

.banner-fallback {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    opacity: 0;
    transform: scale(0.9);
    transition: opacity 0.8s ease-in-out, transform 0.8s ease-in-out;
}

.banner-fallback.show {
    opacity: 1;
    transform: scale(1);
}

.fallback-content {
    color: white;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-in-out 0.3s, transform 0.6s ease-in-out 0.3s;
}

.banner-fallback.show .fallback-content {
    opacity: 1;
    transform: translateY(0);
}

.banner-content {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg,
        rgba(0,0,0,0.7) 0%,
        rgba(0,0,0,0.4) 50%,
        rgba(0,0,0,0.2) 100%);
    display: flex;
    align-items: center;
    opacity: 0;
    transition: opacity 0.8s ease-in-out 0.5s;
    z-index: 2;
    pointer-events: none;
}

.banner-content.show {
    opacity: 1;
}

.banner-text {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease-in-out 0.8s, transform 0.8s ease-in-out 0.8s;
    max-width: 600px;
    padding: 2rem;
    position: relative;
    z-index: 3;
    pointer-events: auto;
}

.banner-content.show .banner-text {
    opacity: 1;
    transform: translateY(0);
}

.banner-title {
    text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
    line-height: 1.2;
    font-weight: 800;
    margin-bottom: 1.5rem;
    font-size: 3.5rem;
    letter-spacing: -0.5px;
}

.banner-description {
    text-shadow: 1px 1px 4px rgba(0,0,0,0.8);
    opacity: 0.95;
    font-size: 1.25rem;
    line-height: 1.6;
    margin-bottom: 2rem;
    font-weight: 400;
}

.banner-content .btn {
    font-size: 1.1rem;
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.banner-content .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.banner-content .btn:hover::before {
    left: 100%;
}

.banner-content .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.4);
}

/* Improved Carousel Controls Positioning */
.carousel-control-prev,
.carousel-control-next {
    width: 60px;
    height: 60px;
    opacity: 0;
    transform: translateX(-20px);
    transition: opacity 0.6s ease-in-out 1.2s, transform 0.6s ease-in-out 1.2s;
    position: absolute;
    top: 50%;
    transform: translateY(-50%) translateX(-20px);
    z-index: 10;
    pointer-events: auto;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0,0,0,0.3);
    border-radius: 50%;
    backdrop-filter: blur(10px);
}

.carousel-control-next {
    right: 20px;
    left: auto;
    transform: translateY(-50%) translateX(20px);
}

.carousel-control-prev.show,
.carousel-control-next.show {
    opacity: 0.9;
    transform: translateY(-50%) translateX(0);
}

.carousel-control-next.show {
    transform: translateY(-50%) translateX(0);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 2rem;
    height: 2rem;
    background-color: rgba(255,255,255,0.9);
    border-radius: 50%;
    background-size: 50%;
    transition: all 0.3s ease;
    cursor: pointer;
    pointer-events: auto;
    position: relative;
    z-index: 11;
    display: flex;
    align-items: center;
    justify-content: center;
    mask: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z' fill='%23000'/%3e%3c/svg%3e") no-repeat center;
    -webkit-mask: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 8 8'%3e%3cpath d='M5.25 0l-4 4 4 4 1.5-1.5L4.25 4l2.5-2.5L5.25 0z' fill='%23000'/%3e%3c/svg%3e") no-repeat center;
}

.carousel-control-next-icon {
    mask: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l4 4-4 4-1.5-1.5L3.75 4l-2.5-2.5L2.75 0z' fill='%23000'/%3e%3c/svg%3e") no-repeat center;
    -webkit-mask: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 8 8'%3e%3cpath d='M2.75 0l4 4-4 4-1.5-1.5L3.75 4l-2.5-2.5L2.75 0z' fill='%23000'/%3e%3c/svg%3e") no-repeat center;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background: rgba(0,0,0,0.6);
    transform: translateY(-50%) scale(1.1);
}

.carousel-control-next:hover {
    transform: translateY(-50%) scale(1.1);
}

/* Fix for carousel indicators */
.carousel-indicators {
    bottom: 30px;
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.6s ease-in-out 1s, transform 0.6s ease-in-out 1s;
    z-index: 10;
    pointer-events: auto;
    position: relative;
}

.carousel-indicators.show {
    opacity: 1;
    transform: translateY(0);
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 4px;
    background-color: rgba(255,255,255,0.6);
    border: 2px solid rgba(255,255,255,0.9);
    transition: all 0.3s ease;
    cursor: pointer;
    pointer-events: auto;
    position: relative;
    z-index: 11;
}

.carousel-indicators button.active {
    background-color: #fff;
    border-color: #fff;
    transform: scale(1.3);
    box-shadow: 0 0 15px rgba(255,255,255,0.5);
}

/* Enhanced Hero Section */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 100px 0;
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
    animation: float 20s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
    animation: slideInLeft 1s ease-out;
}

.hero-subtitle {
    font-size: 1.3rem;
    margin-bottom: 2rem;
    opacity: 0.9;
    line-height: 1.6;
    animation: slideInLeft 1s ease-out 0.2s both;
}

.hero-buttons {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    animation: slideInLeft 1s ease-out 0.4s both;
}

.hero-btn {
    padding: 1rem 2rem;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.hero-btn-primary {
    background: rgba(255,255,255,0.2);
    color: white;
    border: 2px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(10px);
}

.hero-btn-primary:hover {
    background: rgba(255,255,255,0.3);
    border-color: rgba(255,255,255,0.5);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    color: white;
}

.hero-btn-secondary {
    background: transparent;
    color: white;
    border: 2px solid rgba(255,255,255,0.5);
}

.hero-btn-secondary:hover {
    background: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.8);
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    color: white;
}

.hero-stats {
    display: flex;
    gap: 3rem;
    margin-top: 3rem;
    animation: slideInLeft 1s ease-out 0.6s both;
}

.hero-stat {
    text-align: center;
}

.hero-stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    display: block;
    margin-bottom: 0.5rem;
}

.hero-stat-label {
    font-size: 0.9rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.min-vh-50 {
    min-height: 50vh;
}

/* Responsive Design */
@media (max-width: 768px) {
    .banner-slide,
    .banner-loading {
        height: 450px;
    }

    .banner-title {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .banner-description {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .banner-text {
        padding: 1.5rem;
        max-width: 100%;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 50px;
        height: 50px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 1.5rem;
        height: 1.5rem;
    }

    .carousel-indicators {
        bottom: 20px;
    }

    .carousel-indicators button {
        width: 10px;
        height: 10px;
        margin: 0 3px;
    }

    /* Hero Section Mobile */
    .hero-section {
        padding: 60px 0;
    }

    .hero-title {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .hero-buttons {
        flex-direction: column;
        gap: 0.75rem;
    }

    .hero-btn {
        width: 100%;
        justify-content: center;
    }

    .hero-stats {
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .hero-stat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-align: left;
    }

    .hero-visual {
        margin-top: 2rem;
    }

    .hero-visual i {
        font-size: 4rem !important;
    }
}

@media (max-width: 576px) {
    .banner-slide,
    .banner-loading {
        height: 350px;
    }

    .banner-title {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .banner-description {
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .banner-text {
        padding: 1rem;
    }

    .banner-content .btn {
        font-size: 1rem;
        padding: 0.75rem 1.5rem;
    }

    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
    }

    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 1.25rem;
        height: 1.25rem;
    }

    .carousel-indicators {
        bottom: 15px;
    }

    .carousel-indicators button {
        width: 8px;
        height: 8px;
        margin: 0 2px;
    }

    /* Hero Section Small Mobile */
    .hero-section {
        padding: 40px 0;
    }

    .hero-title {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .hero-subtitle {
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    .hero-stat-number {
        font-size: 2rem;
    }

    .hero-stat-label {
        font-size: 0.8rem;
    }

    .hero-visual i {
        font-size: 3rem !important;
    }
}


/* Ensure carousel container has proper z-index */
.carousel {
    position: relative;
    z-index: 1;
}

.carousel-inner {
    position: relative;
    z-index: 1;
}

.carousel-item {
    position: relative;
    z-index: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preload banner images
    const bannerImages = document.querySelectorAll('#bannerCarousel img[src]');
    const totalImages = bannerImages.length;
    let loadedImages = 0;

    if (totalImages > 0) {
        bannerImages.forEach(img => {
            const image = new Image();
            image.onload = function() {
                loadedImages++;
                // Detect aspect ratio and set positioning
                detectAndSetAspectRatio(img, this.width, this.height);
                if (loadedImages === totalImages) {
                    // All images loaded, show carousel with smooth transition
                    showBannerCarousel();
                }
            };
            image.onerror = function() {
                loadedImages++;
                if (loadedImages === totalImages) {
                    // All images processed, show carousel
                    showBannerCarousel();
                }
            };
            image.src = img.src;
        });

        // Fallback: show carousel after 4 seconds even if images haven't loaded
        setTimeout(() => {
            if (document.getElementById('bannerLoading').style.display !== 'none') {
                showBannerCarousel();
            }
        }, 4000);
    } else {
        // No images to load, show carousel immediately
        showBannerCarousel();
    }

    function detectAndSetAspectRatio(imgElement, width, height) {
        const aspectRatio = width / height;
        let aspectType = 'landscape';

        if (aspectRatio < 0.8) {
            aspectType = 'portrait';
        } else if (aspectRatio > 1.2) {
            aspectType = 'landscape';
        } else {
            aspectType = 'square';
        }

        imgElement.setAttribute('data-aspect', aspectType);

        // Apply custom positioning based on aspect ratio
        if (aspectType === 'portrait') {
            imgElement.style.objectPosition = 'center 20%';
        } else if (aspectType === 'landscape') {
            imgElement.style.objectPosition = 'center center';
        } else {
            imgElement.style.objectPosition = 'center center';
        }
    }

    function showBannerCarousel() {
        const loadingElement = document.getElementById('bannerLoading');
        const carouselElement = document.getElementById('bannerCarousel');

        if (loadingElement && carouselElement) {
            // Start fade out animation for loading skeleton
            const skeletonContent = loadingElement.querySelector('.skeleton-content');
            if (skeletonContent) {
                skeletonContent.classList.add('fade-out');
            }

            // Fade out the entire loading section
            setTimeout(() => {
                loadingElement.classList.add('fade-out');
            }, 300);

            // Show carousel after loading fade out
            setTimeout(() => {
                loadingElement.style.display = 'none';
                carouselElement.style.display = 'block';

                // Initialize Bootstrap carousel
                const carousel = new bootstrap.Carousel(carouselElement, {
                    interval: 5000,
                    wrap: true
                });

                // --- Tambahan: pastikan teks pada slide aktif langsung muncul ---
                const activeSlide = carouselElement.querySelector('.carousel-item.active');
                if (activeSlide) {
                    const bannerContent = activeSlide.querySelector('.banner-content');
                    if (bannerContent) {
                        bannerContent.classList.add('show');
                    }
                    // Jika pakai efek gambar, pastikan juga .loaded pada gambar
                    const bannerImage = activeSlide.querySelector('.banner-image');
                    if (bannerImage) {
                        bannerImage.classList.add('loaded');
                    }
                }

                // Start carousel animations
                animateCarouselElements();

                // Initialize controls immediately after carousel is shown
                setTimeout(() => {
                    initializeCarouselControls();
                    console.log('Carousel controls initialized');
                }, 100);
            }, 800);
        }
    }

    function animateCarouselElements() {
        // Animate carousel indicators
        setTimeout(() => {
            const indicators = document.querySelector('.carousel-indicators');
            if (indicators) {
                indicators.classList.add('show');
            }
        }, 1000);

        // Animate carousel controls
        setTimeout(() => {
            const controls = document.querySelectorAll('.carousel-control-prev, .carousel-control-next');
            controls.forEach(control => {
                control.classList.add('show');
            });
        }, 1200);
    }

    // Handle image load events for individual images with smooth transitions
    document.querySelectorAll('.banner-image').forEach(img => {
        img.addEventListener('load', function() {
            // Add loaded class for smooth transition
            this.classList.add('loaded');

            // Show banner content after image is loaded
            setTimeout(() => {
                const bannerContent = this.closest('.banner-slide').querySelector('.banner-content');
                if (bannerContent) {
                    bannerContent.classList.add('show');
                }
            }, 500);
        });

        img.addEventListener('error', function() {
            this.style.display = 'none';
            const fallback = this.nextElementSibling;
            if (fallback && fallback.classList.contains('banner-fallback')) {
                fallback.classList.add('show');
            }
        });
    });

    // Add smooth transitions for carousel slide changes
    const carouselElement = document.getElementById('bannerCarousel');
    if (carouselElement) {
        carouselElement.addEventListener('slide.bs.carousel', function(event) {
            const activeSlide = event.relatedTarget;
            const bannerContent = activeSlide.querySelector('.banner-content');
            const bannerImage = activeSlide.querySelector('.banner-image');

            // Reset animations for new slide
            if (bannerContent) {
                bannerContent.classList.remove('show');
                setTimeout(() => {
                    bannerContent.classList.add('show');
                }, 100);
            }

            if (bannerImage && !bannerImage.classList.contains('loaded')) {
                bannerImage.classList.add('loaded');
            }
        });
    }

    // Add hover effects for carousel controls
    document.addEventListener('mouseover', function(e) {
        if (e.target.closest('.carousel-control-prev') || e.target.closest('.carousel-control-next')) {
            const control = e.target.closest('.carousel-control-prev, .carousel-control-next');
            control.style.opacity = '1';
        }
    });

    document.addEventListener('mouseout', function(e) {
        if (e.target.closest('.carousel-control-prev') || e.target.closest('.carousel-control-next')) {
            const control = e.target.closest('.carousel-control-prev, .carousel-control-next');
            control.style.opacity = '0.9';
        }
    });

    // Add click event listeners for carousel controls
    document.addEventListener('click', function(e) {
        if (e.target.closest('.carousel-control-prev')) {
            console.log('Previous button clicked');
            const carousel = document.getElementById('bannerCarousel');
            if (carousel) {
                const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                if (bsCarousel) {
                    bsCarousel.prev();
                }
            }
        }

        if (e.target.closest('.carousel-control-next')) {
            console.log('Next button clicked');
            const carousel = document.getElementById('bannerCarousel');
            if (carousel) {
                const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                if (bsCarousel) {
                    bsCarousel.next();
                }
            }
        }

        if (e.target.closest('.carousel-indicators button')) {
            console.log('Indicator button clicked');
        }
    });

    // Ensure carousel controls are properly initialized
    function initializeCarouselControls() {
        const carousel = document.getElementById('bannerCarousel');
        if (carousel) {
            // Remove any existing event listeners
            const prevButton = carousel.querySelector('.carousel-control-prev');
            const nextButton = carousel.querySelector('.carousel-control-next');

            if (prevButton) {
                prevButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Previous button clicked via direct listener');
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    if (bsCarousel) {
                        bsCarousel.prev();
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Next button clicked via direct listener');
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    if (bsCarousel) {
                        bsCarousel.next();
                    }
                });
            }

            // Add indicator click listeners
            const indicators = carousel.querySelectorAll('.carousel-indicators button');
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Indicator clicked:', index);
                    const bsCarousel = bootstrap.Carousel.getInstance(carousel);
                    if (bsCarousel) {
                        bsCarousel.to(index);
                    }
                });
            });
        }
    }

    // Add intersection observer for performance optimization
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.classList.contains('banner-image') && !img.classList.contains('loaded')) {
                        img.classList.add('loaded');
                    }
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.banner-image').forEach(img => {
            observer.observe(img);
        });
    }

    // Add window resize handler for responsive positioning
    window.addEventListener('resize', function() {
        const bannerImages = document.querySelectorAll('.banner-image');
        bannerImages.forEach(img => {
            const aspectType = img.getAttribute('data-aspect');
            if (aspectType) {
                // Reapply positioning based on current screen size
                if (window.innerWidth >= 1200) {
                    if (aspectType === 'portrait') {
                        img.style.objectPosition = 'center 15%';
                    } else {
                        img.style.objectPosition = 'center 25%';
                    }
                } else if (window.innerWidth >= 768) {
                    if (aspectType === 'portrait') {
                        img.style.objectPosition = 'center 25%';
                    } else {
                        img.style.objectPosition = 'center 30%';
                    }
                } else {
                    if (aspectType === 'portrait') {
                        img.style.objectPosition = 'center 35%';
                    } else {
                        img.style.objectPosition = 'center 40%';
                    }
                }
            }
        });
    });
});
</script>
@endsection
