@extends('layouts.app')

@section('title', 'My Orders - Kiansantang Store')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">My Orders</h1>

    @if($orders->isEmpty())
    <div class="text-center py-5">
        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
        <h3>No orders yet</h3>
        <p class="text-muted">Start shopping to see your orders here.</p>
        <a href="{{ route('products.all') }}" class="btn btn-primary">Browse Products</a>
    </div>
    @else
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Payment Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                    <td>{{ $order->formatted_total_amount }}</td>
                    <td>
                        <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : 'info') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-primary">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $orders->links() }}
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