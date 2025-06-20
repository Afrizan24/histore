@extends('layouts.app')

@section('title', $product->name . ' - Kiansantang Store')

@section('content')
<div class="container py-5">
    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
            <div class="product-image-container">
                <div class="main-image-wrapper">
                    <img src="{{ $product->image ? Storage::url($product->image) : asset('images/no-image.png') }}" 
                         alt="{{ $product->name }}" 
                         class="main-product-image"
                         id="mainProductImage">
            </div>
                <!-- Image placeholder if no image -->
                @if(!$product->image)
                <div class="no-image-placeholder">
                    <i class="fas fa-image fa-4x text-muted"></i>
                    <p class="text-muted mt-2">Gambar tidak tersedia</p>
        </div>
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details-container">
                <!-- Product Header -->
                <div class="product-header mb-4">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    <div class="product-badges mb-3">
                        <span class="badge bg-primary me-2">
                            <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                        </span>
                        <span class="badge bg-{{ $product->kondisi === 'New' ? 'success' : 'warning' }}">
                            <i class="fas fa-{{ $product->kondisi === 'New' ? 'star' : 'certificate' }} me-1"></i>
                            {{ $product->kondisi }}
                        </span>
            </div>
            </div>

                <!-- Product Price -->
                <div class="product-price-section mb-4">
                    <div class="price-display">
                        <span class="currency">Rp</span>
                        <span class="price-amount">{{ number_format($product->price, 0, ',', '.') }}</span>
            </div>
                    @if($product->kondisi === 'Second')
                    <div class="price-note">
                        <i class="fas fa-info-circle me-1"></i>
                        Harga sudah termasuk garansi 3 bulan
                    </div>
            @endif
                </div>

                <!-- Product Specifications -->
                <div class="product-specs mb-4">
                    <h5 class="specs-title">
                        <i class="fas fa-cogs me-2"></i>Spesifikasi Produk
                    </h5>
                    <div class="specs-grid">
                        <div class="spec-item">
                            <div class="spec-label">
                                <i class="fas fa-palette me-2"></i>Warna
                            </div>
                            <div class="spec-value">{{ $product->warna }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">
                                <i class="fas fa-hdd me-2"></i>Storage
                            </div>
                            <div class="spec-value">{{ $product->storage }}</div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">
                                <i class="fas fa-shield-alt me-2"></i>Kondisi
                            </div>
                            <div class="spec-value">
                                <span class="badge bg-{{ $product->kondisi === 'New' ? 'success' : 'warning' }}">
                                    {{ $product->kondisi }}
                                </span>
                            </div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">
                                <i class="fas fa-heart me-2"></i>Favorit
                            </div>
                            <div class="spec-value">
                                <i class="fas fa-heart text-danger me-1"></i>
                                {{ $product->favorites->count() }} orang
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description mb-4">
                    <h5 class="description-title">
                        <i class="fas fa-info-circle me-2"></i>Deskripsi Produk
                    </h5>
                    <div class="description-content">
                        <p>{{ $product->description }}</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="product-actions">
                    @if($product->stock > 0)
                        <div class="action-buttons">
                            <button type="button" class="btn btn-success btn-lg w-100 mb-3" data-bs-toggle="modal" data-bs-target="#salesModal">
                                <i class="fab fa-whatsapp me-2"></i>Hubungi Sales
                            </button>
                            
            @auth
                                <div class="d-flex gap-2">
                                    <form action="{{ route('favorites.store', $product) }}" method="POST" class="flex-grow-1">
                    @csrf
                                        <button type="submit" class="btn btn-outline-danger w-100">
                                            <i class="fas fa-heart me-2"></i>Tambah ke Favorit
                                        </button>
                </form>
                                    <button type="button" class="btn btn-outline-primary" onclick="shareProduct()">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            @else
                                <div class="d-flex gap-2">
                                    <a href="{{ route('login') }}" class="btn btn-outline-danger flex-grow-1">
                                        <i class="fas fa-heart me-2"></i>Login untuk Favorit
                                    </a>
                                    <button type="button" class="btn btn-outline-primary" onclick="shareProduct()">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
            @endauth
        </div>
                    @else
                        <div class="stock-warning">
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>
                                    <strong>Stok Habis</strong>
                                    <br>
                                    <small>Produk ini sedang tidak tersedia. Silakan hubungi sales untuk informasi lebih lanjut.</small>
    </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Product Meta -->
                <div class="product-meta mt-4">
                    <div class="meta-item">
                        <i class="fas fa-calendar-alt me-2"></i>
                        <small class="text-muted">Ditambahkan: {{ $product->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-eye me-2"></i>
                        <small class="text-muted">ID Produk: #{{ $product->id }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count())
    <div class="related-products-section mt-5">
        <div class="section-header">
            <h3 class="section-title">
                <i class="fas fa-th-large me-2"></i>Produk Terkait
            </h3>
            <p class="section-subtitle">Produk serupa yang mungkin Anda suka</p>
        </div>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
            <div class="col-6 col-md-3">
                <div class="related-product-card">
                    <div class="product-image-wrapper">
                        <img src="{{ $related->image ? Storage::url($related->image) : asset('images/no-image.png') }}" 
                             class="related-product-image" 
                             alt="{{ $related->name }}">
                        <div class="product-overlay">
                            <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye me-1"></i>Lihat
                            </a>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="product-name">{{ $related->name }}</h6>
                        <div class="product-price">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                        <div class="product-badge">
                            <span class="badge bg-{{ $related->kondisi === 'New' ? 'success' : 'warning' }} badge-sm">
                                {{ $related->kondisi }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Sales Selection Modal -->
<div class="modal fade" id="salesModal" tabindex="-1" aria-labelledby="salesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="salesModalLabel">
                    <i class="fab fa-whatsapp me-2"></i>Pilih Sales untuk Konsultasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Product Summary -->
                <div class="product-summary mb-4">
                    <div class="summary-card">
                        <div class="summary-header">
                            <h6 class="summary-title">
                                <i class="fas fa-info-circle me-2"></i>Detail Produk
                            </h6>
                        </div>
                        <div class="summary-content">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    <div class="product-image-wrapper">
                                        <img src="{{ $product->image ? Storage::url($product->image) : asset('images/no-image.png') }}" 
                                             class="summary-product-image" 
                                             alt="{{ $product->name }}">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="product-info-details">
                                        <h5 class="product-name">{{ $product->name }}</h5>
                                        <div class="price-tag">
                                            <span class="currency">Rp</span>
                                            <span class="price">{{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="product-badges">
                                            <span class="badge category-badge">
                                                <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                            </span>
                                            <span class="badge condition-badge {{ $product->kondisi === 'New' ? 'new' : 'second' }}">
                                                <i class="fas fa-{{ $product->kondisi === 'New' ? 'star' : 'certificate' }} me-1"></i>
                                                {{ $product->kondisi }}
                                            </span>
                                        </div>
                                        <div class="product-specs">
                                            <div class="spec-item">
                                                <i class="fas fa-palette me-2"></i>
                                                <span class="spec-label">Warna:</span>
                                                <span class="spec-value">{{ $product->warna }}</span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-hdd me-2"></i>
                                                <span class="spec-label">Storage:</span>
                                                <span class="spec-value">{{ $product->storage }}</span>
                                            </div>
                                            <div class="spec-item">
                                                <i class="fas fa-heart me-2"></i>
                                                <span class="spec-label">Favorit:</span>
                                                <span class="spec-value">{{ $product->favorites->count() }} orang</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales List -->
                <div class="sales-section">
                    <div class="section-header">
                        <h6 class="section-title">
                            <i class="fas fa-users me-2"></i>Tim Sales Kami
                        </h6>
                        <p class="section-subtitle">Pilih sales yang akan membantu Anda dengan konsultasi produk</p>
                    </div>
                    
                    <div class="sales-grid">
                        @foreach($sales as $sale)
                        <div class="sales-card" data-sales='{"name":"{{ $sale->name }}","phone":"{{ $sale->phone }}","description":"{{ $sale->description }}"}'>
                            <div class="sales-header">
                                <div class="sales-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <div class="online-status">
                                    <span class="status-dot"></span>
                                    <span class="status-text">Online</span>
                                </div>
                            </div>
                            
                            <div class="sales-info">
                                <h6 class="sales-name">{{ $sale->name }}</h6>
                                <p class="sales-description">{{ $sale->description }}</p>
                                
                                <div class="contact-info">
                                    <div class="contact-item">
                                        <i class="fas fa-phone me-2"></i>
                                        <span>{{ $sale->phone }}</span>
                                    </div>
                                    @if($sale->email)
                                    <div class="contact-item">
                                        <i class="fas fa-envelope me-2"></i>
                                        <span>{{ $sale->email }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="sales-stats">
                                    <div class="stat-item">
                                        <i class="fas fa-star text-warning"></i>
                                        <span>4.9/5</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-comments text-info"></i>
                                        <span>150+ chat</span>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-clock text-success"></i>
                                        <span>5 min</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="sales-actions">
                                <button class="select-btn">
                                    <i class="fas fa-comments me-2"></i>
                                    Pilih Sales
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- WhatsApp Preview Modal -->
<div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="whatsappModalLabel">
                    <i class="fab fa-whatsapp me-2"></i>Preview Pesan WhatsApp
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Sales Info Header -->
                <div class="sales-preview-header mb-4">
                    <div class="sales-avatar-large">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="sales-details">
                        <h6 class="sales-name-preview" id="selectedSalesName"></h6>
                        <p class="sales-phone-preview" id="selectedSalesPhone"></p>
                        <div class="sales-status">
                            <span class="status-indicator"></span>
                            <span class="status-text">Online</span>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Chat Preview -->
                <div class="whatsapp-chat-preview mb-4">
                    <div class="chat-header">
                        <div class="chat-info">
                            <i class="fab fa-whatsapp chat-icon"></i>
                            <span class="chat-title">WhatsApp Chat</span>
                        </div>
                        <div class="chat-time">
                            <i class="fas fa-clock"></i>
                            <span>Now</span>
                        </div>
                    </div>
                    <div class="chat-messages">
                        <div class="message-bubble outgoing">
                            <div class="message-content" id="messagePreview"></div>
                            <textarea id="waMessageTextarea" class="form-control d-none" rows="4" style="resize:vertical;"></textarea>
                            <div class="message-time">
                                <i class="fas fa-check-double"></i>
                                <span>Now</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="editMsgBtn">
                            <i class="fas fa-edit me-1"></i> Edit Pesan
                        </button>
                        <button type="button" class="btn btn-success btn-sm d-none" id="saveMsgBtn">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </div>

                <!-- Product Summary in Chat -->
                <div class="product-chat-summary mb-4">
                    <div class="product-card-chat">
                        <div class="product-image-chat">
                            <img src="{{ $product->image ? Storage::url($product->image) : asset('images/no-image.png') }}" 
                                 alt="{{ $product->name }}">
                        </div>
                        <div class="product-info-chat">
                            <h6 class="product-name-chat">{{ $product->name }}</h6>
                            <div class="product-price-chat">
                                <span class="currency">Rp</span>
                                <span class="price">{{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <div class="product-specs-chat">
                                <span class="spec-item">
                                    <i class="fas fa-tag"></i>
                                    {{ $product->category->name }}
                                </span>
                                <span class="spec-item">
                                    <i class="fas fa-palette"></i>
                                    {{ $product->warna }}
                                </span>
                                <span class="spec-item">
                                    <i class="fas fa-hdd"></i>
                                    {{ $product->storage }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <form action="" method="POST" id="whatsappChatForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="message" id="waMessageInput" value="">
                    <button type="submit" class="btn btn-whatsapp btn-lg w-100">
                        <i class="fab fa-whatsapp me-2"></i>
                        Buka WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Product Detail Styles */
.product-image-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.3s ease;
}

.product-image-container:hover {
    transform: translateY(-5px);
}

.main-image-wrapper {
    position: relative;
    overflow: hidden;
}

.main-product-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.main-product-image:hover {
    transform: scale(1.05);
}

.no-image-placeholder {
    height: 400px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    color: #6c757d;
}

/* Product Details Container */
.product-details-container {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    height: fit-content;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    line-height: 1.2;
    margin-bottom: 1rem;
}

.product-badges .badge {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
}

/* Price Section */
.product-price-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 1.5rem;
    color: white;
}

.price-display {
    display: flex;
    align-items: baseline;
    gap: 0.5rem;
}

.currency {
    font-size: 1.5rem;
    font-weight: 600;
}

.price-amount {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
}

.price-note {
    margin-top: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

/* Specifications */
.product-specs {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
}

.specs-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.spec-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.spec-label {
    font-weight: 500;
    color: #6c757d;
    font-size: 0.9rem;
}

.spec-value {
    font-weight: 600;
    color: #2c3e50;
}

/* Description */
.product-description {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
}

.description-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.description-content {
    color: #495057;
    line-height: 1.6;
}

/* Action Buttons */
.product-actions {
    margin-top: 2rem;
}

.action-buttons .btn {
    border-radius: 12px;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    transition: all 0.3s ease;
}

.action-buttons .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border: none;
}

.btn-outline-danger {
    border: 2px solid #dc3545;
    color: #dc3545;
}

.btn-outline-danger:hover {
    background: #dc3545;
    border-color: #dc3545;
}

.btn-outline-primary {
    border: 2px solid #007bff;
    color: #007bff;
}

.btn-outline-primary:hover {
    background: #007bff;
    border-color: #007bff;
}

/* Stock Warning */
.stock-warning .alert {
    border-radius: 12px;
    border: none;
    background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
    color: #856404;
}

/* Product Meta */
.product-meta {
    border-top: 1px solid #e9ecef;
    padding-top: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.meta-item:last-child {
    margin-bottom: 0;
}

/* Related Products */
.related-products-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-title {
    color: #2c3e50;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #6c757d;
    font-size: 1.1rem;
}

.related-product-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.related-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    height: 200px;
}

.related-product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.related-product-card:hover .product-overlay {
    opacity: 1;
}

.related-product-card:hover .related-product-image {
    transform: scale(1.1);
}

.product-info {
    padding: 1rem;
}

.product-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
    line-height: 1.3;
    height: 2.6rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-price {
    font-weight: 700;
    color: #dc3545;
    font-size: 1rem;
    margin-bottom: 0.5rem;
}

.product-badge .badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-title {
        font-size: 2rem;
    }
    
    .price-amount {
        font-size: 2.5rem;
    }
    
    .specs-grid {
        grid-template-columns: 1fr;
    }
    
    .product-details-container {
        padding: 1.5rem;
    }
    
    .main-product-image {
        height: 400px;
    }
    
    .no-image-placeholder {
        height: 300px;
    }
}

@media (max-width: 576px) {
    .product-title {
        font-size: 1.75rem;
    }
    
    .price-amount {
        font-size: 2rem;
    }
    
    .product-details-container {
        padding: 1rem;
    }
    
    .main-product-image {
        height: 300px;
    }
    
    .no-image-placeholder {
        height: 250px;
    }
    
    .action-buttons .d-flex {
        flex-direction: column;
    }
    
    .action-buttons .d-flex .btn {
        margin-bottom: 0.5rem;
    }
}

/* Animation */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.product-details-container {
    animation: slideInUp 0.6s ease-out;
}

/* Loading States */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Modal Styles */
.modal-xl {
    max-width: 1000px;
}

.modal-content {
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
    border-bottom: none;
    padding: 1.5rem;
}

.modal-header .modal-title {
    font-weight: 700;
    font-size: 1.3rem;
}

.modal-header .btn-close {
    filter: invert(1);
    opacity: 0.8;
    transition: opacity 0.3s ease;
}

.modal-header .btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 2rem;
    background: #f8f9fa;
}

/* Product Summary Styles */
.summary-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 1px solid #e9ecef;
}

.summary-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #dee2e6;
}

.summary-title {
    margin: 0;
    color: #495057;
    font-weight: 600;
    font-size: 1.1rem;
}

.summary-content {
    padding: 1.5rem;
}

.product-image-wrapper {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
}

.summary-product-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-image-wrapper:hover .summary-product-image {
    transform: scale(1.05);
}

.product-info-details {
    padding-left: 1rem;
}

.product-name {
    font-size: 1.4rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.price-tag {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-bottom: 1rem;
}

.currency {
    font-size: 1.2rem;
    font-weight: 600;
    color: #dc3545;
}

.price {
    font-size: 2rem;
    font-weight: 800;
    color: #dc3545;
    line-height: 1;
}

.product-badges {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.category-badge {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.85rem;
    font-weight: 500;
    border: none;
}

.condition-badge.new {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.condition-badge.second {
    background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    color: white;
}

.product-specs {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
}

.product-specs .spec-item {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 0.9rem;
}

.product-specs .spec-label {
    font-weight: 500;
    color: #6c757d;
    margin-right: 0.5rem;
}

.product-specs .spec-value {
    font-weight: 600;
    color: #2c3e50;
}

/* Sales Section Styles */
.sales-section {
    margin-top: 2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.section-subtitle {
    color: #6c757d;
    font-size: 1rem;
    margin: 0;
}

.sales-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.sales-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
    border: 2px solid transparent;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}

.sales-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.sales-card:hover::before {
    transform: scaleX(1);
}

.sales-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 48px rgba(0,0,0,0.15);
    border-color: #667eea;
}

.sales-card.selected {
    border-color: #667eea;
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f2ff 100%);
    transform: scale(1.02);
}

.sales-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.sales-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
}

.sales-card:hover .sales-avatar {
    transform: scale(1.1);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
}

.online-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #28a745;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-text {
    font-size: 0.85rem;
    color: #28a745;
    font-weight: 500;
}

.sales-info {
    margin-bottom: 1.5rem;
}

.sales-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.sales-description {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
}

.contact-info {
    margin-bottom: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    color: #495057;
}

.contact-item:last-child {
    margin-bottom: 0;
}

.contact-item i {
    width: 16px;
    color: #667eea;
}

.sales-stats {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    color: #6c757d;
    font-weight: 500;
}

.stat-item i {
    font-size: 0.9rem;
}

.sales-actions {
    text-align: center;
}

.select-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    width: 100%;
    cursor: pointer;
}

.select-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}

.select-btn:active {
    transform: translateY(0);
}

/* WhatsApp Preview Modal Styles */
.whatsapp-preview .card {
    border: 2px solid #25d366;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 16px;
}

.whatsapp-preview .card-header {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
    border-bottom: none;
    border-radius: 14px 14px 0 0;
}

/* Sales Preview Header */
.sales-preview-header {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    border: 1px solid #dee2e6;
    animation: slideInUp 0.6s ease-out;
    box-shadow: 0 4px 16px rgba(0,0,0,0.05);
}

.sales-avatar-large {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    margin-right: 1rem;
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    animation: fadeIn 0.8s ease-out 0.2s both;
}

.sales-details {
    flex: 1;
    animation: slideInUp 0.6s ease-out 0.4s both;
}

.sales-name-preview {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
}

.sales-phone-preview {
    color: #6c757d;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.sales-status {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.status-indicator {
    width: 8px;
    height: 8px;
    background: #28a745;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.status-text {
    font-size: 0.85rem;
    color: #28a745;
    font-weight: 500;
}

/* WhatsApp Chat Preview */
.whatsapp-chat-preview {
    background: #f0f2f5;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e4e6ea;
    animation: slideInUp 0.6s ease-out 0.6s both;
    box-shadow: 0 4px 16px rgba(0,0,0,0.05);
}

.chat-header {
    background: #25d366;
    color: white;
    padding: 1rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.chat-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.chat-icon {
    font-size: 1.5rem;
}

.chat-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.chat-time {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.chat-messages {
    padding: 1.5rem;
    background: #f0f2f5;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.message-bubble {
    max-width: 80%;
    margin-bottom: 1rem;
    animation: slideInUp 0.6s ease-out 0.8s both;
}

.message-bubble.outgoing {
    align-self: flex-end;
}

.message-content {
    background: #dcf8c6;
    padding: 1rem;
    border-radius: 18px 18px 4px 18px;
    font-size: 0.95rem;
    line-height: 1.5;
    white-space: pre-line;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    position: relative;
}

.message-bubble.outgoing .message-content {
    background: #25d366;
    color: white;
    border-radius: 18px 18px 4px 18px;
}

.message-time {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

.message-bubble.outgoing .message-time {
    color: #25d366;
}

.message-time i {
    font-size: 0.7rem;
}

/* Product Chat Summary */
.product-chat-summary {
    background: white;
    border-radius: 12px;
    padding: 1rem;
    border: 1px solid #e4e6ea;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    animation: slideInUp 0.6s ease-out 1s both;
}

.product-card-chat {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.product-image-chat {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-image-chat img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info-chat {
    flex: 1;
}

.product-name-chat {
    font-size: 1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.product-price-chat {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
}

.product-price-chat .currency {
    font-size: 0.9rem;
    font-weight: 600;
    color: #dc3545;
}

.product-price-chat .price {
    font-size: 1.2rem;
    font-weight: 800;
    color: #dc3545;
}

.product-specs-chat {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.product-specs-chat .spec-item {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    color: #6c757d;
    background: #f8f9fa;
    padding: 0.25rem 0.5rem;
    border-radius: 12px;
}

.product-specs-chat .spec-item i {
    font-size: 0.7rem;
}

/* WhatsApp Actions */
.whatsapp-actions {
    margin-top: 2rem;
    animation: slideInUp 0.6s ease-out 1.2s both;
}

.btn-whatsapp {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    border: none;
    color: white;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(37, 211, 102, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-whatsapp::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
}

.btn-whatsapp:hover::before {
    left: 100%;
}

.btn-whatsapp:hover {
    background: linear-gradient(135deg, #20c997 0%, #0f7a6b 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
    color: white;
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    font-weight: 600;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    border-color: #6c757d;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
}

/* Responsive Design for WhatsApp Modal */
@media (max-width: 768px) {
    .sales-preview-header {
        padding: 1rem;
    }
    
    .sales-avatar-large {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }
    
    .sales-name-preview {
        font-size: 1.1rem;
    }
    
    .chat-messages {
        padding: 1rem;
        min-height: 150px;
    }
    
    .message-content {
        font-size: 0.9rem;
        padding: 0.75rem;
    }
    
    .product-card-chat {
        flex-direction: column;
        text-align: center;
    }
    
    .product-image-chat {
        width: 100px;
        height: 100px;
    }
    
    .product-specs-chat {
        justify-content: center;
    }
    
    .whatsapp-actions .row {
        flex-direction: column;
    }
    
    .whatsapp-actions .col-md-8,
    .whatsapp-actions .col-md-4 {
        width: 100%;
    }
    
    /* General modal responsive */
    .modal-xl {
        max-width: 95%;
        margin: 1rem;
    }
    
    .modal-body {
        padding: 1rem;
    }
    
    .sales-grid {
        grid-template-columns: 1fr;
    }
    
    .product-specs {
        grid-template-columns: 1fr;
    }
    
    .sales-stats {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .product-name {
        font-size: 1.2rem;
    }
    
    .price {
        font-size: 1.5rem;
    }
}

@media (max-width: 576px) {
    .chat-header {
        padding: 0.75rem 1rem;
    }
    
    .chat-title {
        font-size: 1rem;
    }
    
    .message-bubble {
        max-width: 90%;
    }
    
    .product-specs-chat {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .product-specs-chat .spec-item {
        justify-content: center;
    }
    
    /* General modal responsive */
    .modal-header {
        padding: 1rem;
    }
    
    .summary-content {
        padding: 1rem;
    }
    
    .sales-card {
        padding: 1rem;
    }
    
    .sales-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }
    
    .online-status {
        justify-content: center;
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
function shareProduct() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $product->name }}',
            text: 'Lihat produk ini di Kiansantang Store',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        const text = 'Lihat produk ini di Kiansantang Store: ' + url;
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Link produk telah disalin ke clipboard!');
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Link produk telah disalin ke clipboard!');
        }
    }
}

// Add loading state to buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            if (!this.classList.contains('btn-outline-primary')) {
                this.classList.add('loading');
                setTimeout(() => {
                    this.classList.remove('loading');
                }, 2000);
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up modal events');
    
    // Test if modal exists
    const salesModal = document.getElementById('salesModal');
    console.log('Sales modal found:', !!salesModal);
    
    if (salesModal) {
        // Add click event to sales cards and select buttons
        document.querySelectorAll('.sales-card').forEach(card => {
            // Click on entire card
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the select button
                if (e.target.closest('.select-btn')) {
                    return;
                }
                console.log('Sales card clicked');
                selectSalesCard(this);
            });
            
            // Click on select button specifically
            const selectBtn = card.querySelector('.select-btn');
            if (selectBtn) {
                selectBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent card click event
                    console.log('Select button clicked');
                    selectSalesCard(card);
                });
            }
        });
        
        // Test button click
        const salesButton = document.querySelector('[data-bs-target="#salesModal"]');
        if (salesButton) {
            console.log('Sales button found:', !!salesButton);
            salesButton.addEventListener('click', function() {
                console.log('Sales button clicked');
            });
        }
    }

    function selectSalesCard(card) {
        // Remove previous selection
        document.querySelectorAll('.sales-card').forEach(c => c.classList.remove('selected'));
        // Add selection to current card
        card.classList.add('selected');
        
        const salesData = JSON.parse(card.dataset.sales);
        openWhatsAppModal(salesData);
    }

    function openWhatsAppModal(salesData) {
        console.log('Opening WhatsApp modal for:', salesData);
        
        // Close sales selection modal using Bootstrap
        const salesModal = bootstrap.Modal.getInstance(document.getElementById('salesModal'));
        if (salesModal) {
            salesModal.hide();
        }
        
        // Set sales info
        document.getElementById('selectedSalesName').textContent = salesData.name;
        document.getElementById('selectedSalesPhone').textContent = salesData.phone;
        
        // Generate message
        const message = generateWhatsAppMessage(salesData);
        document.getElementById('messagePreview').innerText = message;
        document.getElementById('waMessageInput').value = message;
        
        // Set WhatsApp link
        const whatsappLink = `https://wa.me/${salesData.phone}?text=${encodeURIComponent(message)}`;
        document.getElementById('whatsappLink').href = whatsappLink;
        
        // Show WhatsApp modal using Bootstrap
        const whatsappModal = new bootstrap.Modal(document.getElementById('whatsappModal'));
        whatsappModal.show();
    }

    function generateWhatsAppMessage(salesData) {
        const product = {
            name: '{{ $product->name }}',
            price: '{{ number_format($product->price, 0, ",", ".") }}',
            category: '{{ $product->category->name }}',
            warna: '{{ $product->warna }}',
            storage: '{{ $product->storage }}',
            kondisi: '{{ $product->kondisi }}',
            url: '{{ route("products.show", $product->slug) }}'
        };

        return `Halo ${salesData.name}! 👋

Saya tertarik dengan produk berikut:

📱 *${product.name}*
💰 Harga: Rp ${product.price}
📂 Kategori: ${product.category}
🎨 Warna: ${product.warna}
💾 Storage: ${product.storage}
✨ Kondisi: ${product.kondisi}

🔗 Link produk: ${product.url}

Mohon informasi lebih lanjut mengenai produk ini. Terima kasih! 🙏`;
    }

    // Add smooth animations for modal transitions
    const whatsappModal = document.getElementById('whatsappModal');
    if (whatsappModal) {
        whatsappModal.addEventListener('show.bs.modal', function() {
            // Reset animations
            const elements = this.querySelectorAll('.sales-preview-header, .whatsapp-chat-preview, .product-chat-summary, .whatsapp-actions');
            elements.forEach(el => {
                el.style.animation = 'none';
                el.offsetHeight; // Trigger reflow
                el.style.animation = null;
            });
        });
    }

    // Add hover effects for WhatsApp button
    const whatsappBtn = document.getElementById('whatsappLink');
    if (whatsappBtn) {
        whatsappBtn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px) scale(1.02)';
        });
        
        whatsappBtn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    }

    // Add click feedback for sales cards
    document.querySelectorAll('.sales-card').forEach(card => {
        card.addEventListener('click', function() {
            // Add click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });

    // Add loading state for WhatsApp button
    if (whatsappBtn) {
        whatsappBtn.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuka WhatsApp...';
            this.disabled = true;
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 2000);
        });
    }
});

// Data sales dan produk
const salesData = @json($sales);
const product = @json($product);

let selectedSaleId = null;
let defaultMsg = `Halo, saya tertarik dengan produk *${product.name}* (ID: ${product.id})\nHarga: Rp${product.price.toLocaleString('id-ID')}\nWarna: ${product.warna}\nStorage: ${product.storage}\nMohon info lebih lanjut.`;

// Fungsi untuk set preview dan input hidden
function setMessagePreview(msg) {
    document.getElementById('messagePreview').innerText = msg;
    document.getElementById('waMessageInput').value = msg;
}

// Ketika pilih sales, buka modal pesan dan isi data
document.querySelectorAll('.sales-card .select-btn').forEach(function(btn, idx) {
    btn.addEventListener('click', function() {
        selectedSaleId = salesData[idx].id;
        document.getElementById('selectedSalesName').textContent = salesData[idx].name;
        document.getElementById('selectedSalesPhone').textContent = salesData[idx].phone;
        document.getElementById('whatsappChatForm').action = "{{ url('/sales') }}/" + selectedSaleId + "/chat";
        setMessagePreview(defaultMsg);
        document.getElementById('waMessageTextarea').classList.add('d-none');
        document.getElementById('messagePreview').classList.remove('d-none');
        document.getElementById('editMsgBtn').classList.remove('d-none');
        document.getElementById('saveMsgBtn').classList.add('d-none');
        var waModal = new bootstrap.Modal(document.getElementById('whatsappModal'));
        waModal.show();
    });
});

// Edit/Simpan pesan
const editBtn = document.getElementById('editMsgBtn');
const saveBtn = document.getElementById('saveMsgBtn');
const msgPreview = document.getElementById('messagePreview');
const msgTextarea = document.getElementById('waMessageTextarea');

editBtn.addEventListener('click', function() {
    msgTextarea.value = msgPreview.innerText;
    msgPreview.classList.add('d-none');
    msgTextarea.classList.remove('d-none');
    editBtn.classList.add('d-none');
    saveBtn.classList.remove('d-none');
});

saveBtn.addEventListener('click', function() {
    setMessagePreview(msgTextarea.value);
    msgPreview.classList.remove('d-none');
    msgTextarea.classList.add('d-none');
    editBtn.classList.remove('d-none');
    saveBtn.classList.add('d-none');
});
</script>
@endsection 