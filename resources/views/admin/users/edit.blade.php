@extends('admin.layout')

@section('title', 'Edit User - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Edit User</h2>
            <p class="text-muted mb-0">Perbarui informasi user yang dipilih</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2 text-primary"></i>
                        Form Edit User
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user"></i> Nama <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Nama Lengkap" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope"></i> Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Email" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="is_admin" class="form-label">
                                        <i class="fas fa-user-shield"></i> Role
                                    </label>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_admin" id="roleUser" value="0" @if(!$user->is_admin) checked @endif>
                                            <label class="form-check-label" for="roleUser">
                                                <span class="badge bg-secondary"><i class="fas fa-user"></i> User</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="is_admin" id="roleAdmin" value="1" @if($user->is_admin) checked @endif>
                                            <label class="form-check-label" for="roleAdmin">
                                                <span class="badge bg-primary"><i class="fas fa-user-shield"></i> Admin</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Ganti Password -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-key"></i> Password Baru
                                    </label>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password Baru">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan jika tidak ingin mengganti password.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="form-label">
                                        <i class="fas fa-key"></i> Konfirmasi Password Baru
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ulangi Password Baru">
                                </div>
                            </div>
                        </div>
                        <div class="form-actions mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg ms-2">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 