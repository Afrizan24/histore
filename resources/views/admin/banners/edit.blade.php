@extends('admin.layout')

@section('title', 'Edit Banner')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Edit Banner</h2>
            <p class="text-muted mb-0">Update informasi banner "{{ $banner->title }}"</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Form Edit Banner
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" id="bannerForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Banner
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label for="title" class="form-label">
                                            Judul Banner <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('title') is-invalid @enderror" 
                                               id="title" 
                                               name="title" 
                                               value="{{ old('title', $banner->title) }}" 
                                               placeholder="Contoh: iPhone 15 Pro Max Launch"
                                               required>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="3" 
                                                  placeholder="Deskripsi banner (opsional)">{{ old('description', $banner->description) }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="button_text" class="form-label">Teks Tombol</label>
                                        <input type="text" 
                                               class="form-control @error('button_text') is-invalid @enderror" 
                                               id="button_text" 
                                               name="button_text" 
                                               value="{{ old('button_text', $banner->button_text) }}" 
                                               placeholder="Contoh: Beli Sekarang">
                                        @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="button_url" class="form-label">URL Tombol</label>
                                        <input type="url" 
                                               class="form-control @error('button_url') is-invalid @enderror" 
                                               id="button_url" 
                                               name="button_url" 
                                               value="{{ old('button_url', $banner->button_url) }}" 
                                               placeholder="https://example.com">
                                        @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="order" class="form-label">Urutan</label>
                                        <input type="number" 
                                               class="form-control @error('order') is-invalid @enderror" 
                                               id="order" 
                                               name="order" 
                                               value="{{ old('order', $banner->order) }}" 
                                               placeholder="0"
                                               min="0">
                                        <small class="text-muted">Urutan tampilan banner (0 = pertama)</small>
                                        @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="col-md-4">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-image me-2"></i>Gambar Banner
                                </h6>
                                
                                <div class="mb-3">
                                    <label for="image" class="form-label">Upload Gambar</label>
                                    
                                    <!-- Current Image Preview -->
                                    @if($banner->image)
                                    <div class="current-image mb-3">
                                        <label class="form-label text-muted">Gambar Saat Ini:</label>
                                        <div class="current-image-container">
                                            <img src="{{ Storage::url($banner->image) }}" 
                                                 alt="{{ $banner->title }}" 
                                                 class="img-fluid rounded current-img">
                                            <div class="current-image-overlay">
                                                <span class="badge bg-success">Gambar Aktif</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <div class="image-upload-container">
                                        <input type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               id="image" 
                                               name="image" 
                                               accept="image/*"
                                               onchange="previewImage(this)">
                                        <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                            <label class="form-label text-muted">Preview Gambar Baru:</label>
                                            <img id="previewImg" class="img-fluid rounded" alt="Preview">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        Format: JPG, PNG, GIF. Maksimal 2MB. 
                                        <br>Rekomendasi ukuran: 1200x400px
                                        <br>Kosongkan untuk mempertahankan gambar saat ini.
                                    </small>
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Settings -->
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="text-muted mb-3">
                                            <i class="fas fa-cog me-2"></i>Pengaturan
                                        </h6>
                                        
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1" 
                                                   {{ $banner->is_active ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                Banner Aktif
                                            </label>
                                        </div>
                                        
                                        <small class="text-muted d-block mt-2">
                                            Banner aktif akan ditampilkan di carousel
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                            <a href="{{ route('admin.banners.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.form-label {
    font-weight: 500;
    color: #495057;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.image-upload-container {
    border: 2px dashed #dee2e6;
    border-radius: 0.5rem;
    padding: 1rem;
    text-align: center;
    transition: all 0.3s ease;
}

.image-upload-container:hover {
    border-color: #0d6efd;
    background-color: #f8f9fa;
}

.current-image-container {
    position: relative;
    display: inline-block;
}

.current-img {
    max-height: 150px;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.current-image-overlay {
    position: absolute;
    top: 10px;
    right: 10px;
}

.image-preview {
    max-width: 100%;
    text-align: center;
}

.image-preview img {
    max-height: 150px;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.btn {
    border-radius: 0.375rem;
    font-weight: 500;
}

.btn:hover {
    transform: translateY(-1px);
    transition: all 0.2s ease;
}
</style>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Form validation
document.getElementById('bannerForm').addEventListener('submit', function(e) {
    const requiredFields = this.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua field yang wajib diisi');
    }
});
</script>
@endsection 