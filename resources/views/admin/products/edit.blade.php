@extends('admin.layout')

@section('title', 'Edit Produk')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="h3 mb-1">Edit Produk</h2>
                <p class="text-muted mb-0">Update informasi produk "{{ $product->name }}"</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2 text-primary"></i>
                            Form Edit Produk
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST"
                            enctype="multipart/form-data" id="productForm">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Basic Information -->
                                <div class="col-md-8">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                                    </h6>

                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">
                                                Nama Produk <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" value="{{ old('name', $product->name) }}"
                                                placeholder="Contoh: iPhone 15 Pro Max" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="category_id" class="form-label">
                                                Kategori <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id" required>
                                                <option value="">Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="price" class="form-label">
                                                Harga <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number"
                                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                                    name="price" value="{{ old('price', $product->price) }}"
                                                    placeholder="0" min="0" required>
                                            </div>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="stock" class="form-label">
                                                Stok <span class="text-danger">*</span>
                                            </label>
                                            <input type="number"
                                                class="form-control @error('stock') is-invalid @enderror" id="stock"
                                                name="stock" value="{{ old('stock', $product->stock) }}"
                                                placeholder="0" min="0" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="warna" class="form-label">
                                                Warna <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('warna') is-invalid @enderror"
                                                id="warna" name="warna" value="{{ old('warna', $product->warna) }}"
                                                placeholder="Contoh: Hitam, Putih" required>
                                            @error('warna')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="kondisi" class="form-label">
                                                Kondisi <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select @error('kondisi') is-invalid @enderror"
                                                id="kondisi" name="kondisi" required>
                                                <option value="">Pilih Kondisi</option>
                                                <option value="New"
                                                    {{ old('kondisi', $product->kondisi) == 'New' ? 'selected' : '' }}>Baru
                                                </option>
                                                <option value="Second"
                                                    {{ old('kondisi', $product->kondisi) == 'Second' ? 'selected' : '' }}>
                                                    Bekas</option>
                                            </select>
                                            @error('kondisi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="storage" class="form-label">
                                                Storage <span class="text-danger">*</span>
                                            </label>
                                            <input type="text"
                                                class="form-control @error('storage') is-invalid @enderror" id="storage"
                                                name="storage" value="{{ old('storage', $product->storage) }}"
                                                placeholder="Contoh: 128GB, 256GB">
                                            @error('storage')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-12">
                                            <label for="description" class="form-label">
                                                Deskripsi <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                                rows="4" placeholder="Deskripsikan detail produk..." required>{{ old('description', $product->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="col-md-4">
                                    <h6 class="text-primary mb-3">
                                        <i class="fas fa-image me-2"></i>Gambar Produk
                                    </h6>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload Gambar</label>

                                        <!-- Current Image Preview -->
                                        @if ($product->image)
                                            <div class="current-image mb-3">
                                                <label class="form-label text-muted">Gambar Saat Ini:</label>
                                                <div class="current-image-container">
                                                    <img src="{{ Storage::url($product->image) }}"
                                                        alt="{{ $product->name }}" class="img-fluid rounded current-img">
                                                    <div class="current-image-overlay">
                                                        <span class="badge bg-success">Gambar Aktif</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <div class="image-upload-container">
                                            <input type="file"
                                                class="form-control @error('image') is-invalid @enderror" id="image"
                                                name="image" accept="image/*" onchange="previewImage(this)">
                                            <div class="image-preview mt-3" id="imagePreview" style="display: none;">
                                                <label class="form-label text-muted">Preview Gambar Baru:</label>
                                                <img id="previewImg" class="img-fluid rounded" alt="Preview">
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan untuk mempertahankan gambar saat
                                            ini.
                                        </small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Additional Settings -->
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-3">
                                                <i class="fas fa-cog me-2"></i>Pengaturan
                                            </h6>

                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ $product->is_active ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Produk Aktif
                                                </label>
                                            </div>

                                            <small class="text-muted d-block mt-2">
                                                Produk aktif akan ditampilkan di halaman utama
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Product Stats -->
                                    <div class="card bg-info bg-opacity-10 mt-3">
                                        <div class="card-body">
                                            <h6 class="text-info mb-3">
                                                <i class="fas fa-chart-bar me-2"></i>Statistik Produk
                                            </h6>

                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="stat-item">
                                                        <h4 class="text-primary mb-1">{{ $product->favorites()->count() }}
                                                        </h4>
                                                        <small class="text-muted">Favorit</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="stat-item">
                                                        <h4 class="text-success mb-1">
                                                            {{ $product->orderItems()->count() }}</h4>
                                                        <small class="text-muted">Terjual</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-4 border-top">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-outline-info"
                                        target="_blank">
                                        <i class="fas fa-eye me-2"></i>Lihat Produk
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Produk
                                    </button>
                                </div>
                            </div>

                            <!-- Error Display -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Error:</h6>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
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

        .form-control:focus,
        .form-select:focus {
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

        .stat-item h4 {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .stat-item small {
            font-size: 0.75rem;
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
        document.getElementById('productForm').addEventListener('submit', function(e) {
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
