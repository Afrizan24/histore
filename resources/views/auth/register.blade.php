@extends('layouts.app')

@section('title', 'Register - Kiansantang Store')

@section('content')
<style>
    body.auth-bg {
        background: #fff;
        min-height: 100vh;
    }
    .auth-card {
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(44,62,80,0.10);
        background: #111;
        color: #fff;
        padding: 2.5rem 2rem 2rem 2rem;
        max-width: 400px;
        margin: 0 auto;
    }
    .auth-card-header {
        background: none;
        border-bottom: none;
        text-align: center;
        padding-bottom: 0;
    }
    .auth-card-header h4 {
        font-weight: 700;
        font-size: 2rem;
        color: #fff;
    }
    .auth-card .btn-primary {
        border-radius: 2rem;
        font-weight: 600;
        padding: 0.75rem 0;
        font-size: 1.1rem;
        background: #fff;
        color: #111;
        border: none;
        transition: all 0.2s;
    }
    .auth-card .btn-primary:hover {
        background: #111;
        color: #fff;
        border: 1px solid #fff;
    }
    .auth-card .form-label {
        font-weight: 500;
        color: #fff;
    }
    .auth-card .form-control {
        border-radius: 1rem;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        background: #222;
        color: #fff;
        border: 1px solid #333;
    }
    .auth-card .form-control:focus {
        background: #222;
        color: #fff;
        border-color: #fff;
        box-shadow: 0 0 0 2px #fff2;
    }
    .auth-card .form-check-label {
        font-size: 0.95rem;
        color: #fff;
    }
    .auth-card .text-center.mt-3 {
        margin-top: 2rem !important;
        color: #fff;
    }
    .auth-card a { color: #fff; text-decoration: underline; }
    .auth-card a:hover { color: #fff; opacity: 0.8; }
    @media (max-width: 576px) {
        .auth-card {
            padding: 1.5rem 0.5rem 1.5rem 0.5rem;
        }
        .auth-card-header h4 {
            font-size: 1.5rem;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('auth-bg');
    });
</script>
<div class="container py-5 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="auth-card">
        <div class="auth-card-header">
            <h4 class="mb-0">Register</h4>
        </div>
        <div class="card-body p-0 mt-3">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>
                <div class="text-center mt-3">
                    <p class="mb-0">Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 