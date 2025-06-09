@extends('layouts.app')

@section('title', 'Our Sales Team - Kiansantang Store')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Our Sales Team</h1>

    <div class="row g-4">
        @foreach($sales as $sale)
        <div class="col-lg-4 col-md-6">
            <div class="card h-100">
                @if($sale->image)
                <img src="{{ Storage::url($sale->image) }}" class="card-img-top" alt="{{ $sale->name }}" style="height: 300px; object-fit: cover;">
                @else
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="fas fa-user fa-3x text-muted"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $sale->name }}</h5>
                    @if($sale->description)
                    <p class="card-text">{{ $sale->description }}</p>
                    @endif
                    <div class="d-flex gap-2">
                        <a href="{{ $sale->whatsapp_url }}" target="_blank" class="btn btn-success flex-grow-1">
                            <i class="fab fa-whatsapp me-2"></i>Contact via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection 