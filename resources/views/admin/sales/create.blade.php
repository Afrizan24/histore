@extends('admin.layout')

@section('title', 'Tambah Sales Baru')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Tambah Sales Baru</h2>
            <p class="text-muted mb-0">Isi informasi sales yang akan ditambahkan</p>
        </div>
        <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Form Tambah Sales
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.sales.store') }}" method="POST" enctype="multipart/form-data" id="saleForm">
                        @csrf
                        <div class="form-section">
                            <div class="section-header">
                                <h4><i class="fas fa-info-circle"></i>Informasi Sales</h4>
                                <p>Isi informasi sales yang akan ditampilkan</p>
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            <i class="fas fa-user"></i>Nama Sales <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nama Sales" required>
                                        @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="whatsapp" class="form-label">
                                            <i class="fab fa-whatsapp"></i>No. WhatsApp <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" placeholder="628xxxxxxxxxx" required>
                                        @error('whatsapp')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i>Email
                                        </label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Sales">
                                        @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description" class="form-label">
                                            <i class="fas fa-align-left"></i>Deskripsi
                                        </label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Deskripsi tentang sales...">{{ old('description') }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image" class="form-label">
                                            <i class="fas fa-upload"></i>Upload Foto Sales
                                        </label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                        @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <i class="fas fa-check-circle"></i>Sales Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Sales
                            </button>
                            <a href="{{ route('admin.sales.index') }}" class="btn btn-outline-secondary btn-lg">
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