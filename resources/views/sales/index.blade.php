@extends('layouts.app')

@section('title', 'Sales Representatives - Kiansantang Store')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Our Sales Representatives</h1>
            <p class="text-center text-muted mb-5">Get in touch with our dedicated sales team for personalized assistance and support.</p>
        </div>
    </div>

    @if($sales->count() > 0)
    <div class="sales-grid">
        @foreach($sales as $sale)
        <div class="sales-box">
            <div class="sales-box-inner">
                @if($sale->image)
                <div class="sales-image">
                    <img src="{{ Storage::url($sale->image) }}" 
                         alt="{{ $sale->name }}">
                </div>
                @else
                <div class="sales-image-placeholder">
                    <i class="fas fa-user"></i>
                </div>
                @endif
                
                <div class="sales-content">
                    <h3 class="sales-name">{{ $sale->name }}</h3>
                    
                    @if($sale->description)
                    <p class="sales-description">{{ $sale->description }}</p>
                    @endif
                    
                    <!-- Chat Status Info -->
                    <div class="chat-status">
                        <span class="chat-count">
                            <i class="fas fa-comments"></i>
                            {{ $sale->getTodayChatCount() }}/5 chats today
                        </span>
                        @if($sale->hasReachedDailyLimit())
                            <span class="limit-reached">
                                <i class="fas fa-exclamation-triangle"></i>
                                Daily limit reached
                            </span>
                        @endif
                    </div>
                    
                    <div class="sales-actions">
                        @if(!$sale->hasReachedDailyLimit())
                            <form action="{{ route('sales.chat', $sale) }}" method="POST" style="flex: 1;">
                                @csrf
                                <button type="submit" class="sales-btn whatsapp-btn">
                                    <i class="fab fa-whatsapp"></i>
                                    <span>Chat WhatsApp</span>
                                </button>
                            </form>
                        @else
                            <button class="sales-btn disabled-btn" disabled>
                                <i class="fas fa-clock"></i>
                                <span>Available Tomorrow</span>
                            </button>
                        @endif
                        
                        @if($sale->email)
                        <a href="mailto:{{ $sale->email }}" 
                           class="sales-btn email-btn">
                            <i class="fas fa-envelope"></i>
                            <span>Email</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>No Sales Representatives Available</h3>
        <p>All sales representatives have reached their daily chat limit. Please check back tomorrow or contact us directly.</p>
    </div>
    @endif
</div>

<style>
/* Sales Grid Layout */
.sales-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Sales Box */
.sales-box {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    min-height: 420px;
    max-width: 320px;
    display: flex;
    flex-direction: column;
    margin: 0 auto;
}

.sales-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    border-color: #e0e0e0;
}

.sales-box-inner {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 420px;
    padding: 18px 16px 16px 16px;
    box-sizing: border-box;
}

/* Sales Image */
.sales-image {
    width: 100%;
    height: 180px;
    overflow: hidden;
    position: relative;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    margin-bottom: 14px;
}

.sales-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    border-radius: 12px;
}

.sales-box:hover .sales-image img {
    transform: scale(1.05);
}

.sales-image-placeholder {
    width: 100%;
    height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    margin-bottom: 14px;
}

.sales-image-placeholder i {
    font-size: 4rem;
    opacity: 0.8;
}

/* Sales Content */
.sales-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 0;
}

.sales-name {
    font-size: 1.15em;
    margin-bottom: 8px;
    font-weight: 700;
    color: #111;
}

.sales-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    flex: 1;
}

/* Chat Status */
.chat-status {
    margin-bottom: 1rem;
    padding: 0.5rem 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}

.chat-count {
    display: block;
    font-size: 0.85rem;
    color: #495057;
    font-weight: 500;
}

.chat-count i {
    margin-right: 0.25rem;
    color: #007bff;
}

.limit-reached {
    display: block;
    font-size: 0.85rem;
    color: #dc3545;
    font-weight: 500;
    margin-top: 0.25rem;
}

.limit-reached i {
    margin-right: 0.25rem;
}

/* Sales Actions */
.sales-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.sales-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    flex: 1;
    justify-content: center;
    min-width: 120px;
    border: none;
    cursor: pointer;
}

.whatsapp-btn {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    color: white;
}

.whatsapp-btn:hover {
    background: linear-gradient(135deg, #128c7e 0%, #075e54 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
}

.disabled-btn {
    background: #6c757d;
    color: #fff;
    cursor: not-allowed;
    opacity: 0.6;
}

.disabled-btn:hover {
    background: #6c757d;
    color: #fff;
    transform: none;
    box-shadow: none;
}

.email-btn {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.email-btn:hover {
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
}

.sales-btn i {
    font-size: 1.1rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    max-width: 500px;
    margin: 0 auto;
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
    font-size: 1.1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .sales-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        padding: 0 1rem;
    }
    
    .sales-content {
        padding: 1.25rem;
    }
    
    .sales-name {
        font-size: 1.1rem;
    }
    
    .sales-description {
        font-size: 0.9rem;
    }
    
    .sales-actions {
        flex-direction: column;
    }
    
    .sales-btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .sales-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .sales-image {
        height: 180px;
    }
    
    .sales-content {
        padding: 1rem;
    }
    
    .sales-name {
        font-size: 1rem;
    }
    
    .sales-description {
        font-size: 0.85rem;
    }
}

/* Container adjustments */
.container {
    max-width: 1400px;
}

/* Page title styling */
h1 {
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 1rem;
}

.text-muted {
    color: #6c757d !important;
    font-size: 1.1rem;
}
</style>
@endsection 