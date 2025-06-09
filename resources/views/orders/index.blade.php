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
@endsection 