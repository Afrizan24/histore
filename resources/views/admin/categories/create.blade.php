@extends('admin.layout')

@section('title', 'Add New Category - Admin Dashboard')

@section('content')
<div class="admin-container">
    <!-- Header Section -->
    <div class="admin-header">
        <div class="admin-header-content">
            <div class="admin-header-left">
                <h1 class="admin-title">
                    <i class="fas fa-plus me-2"></i>
                    Add New Category
                </h1>
                <p class="admin-subtitle">Create a new product category to organize your inventory</p>
            </div>
            <div class="admin-header-right">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-arrow-left me-2"></i>
                    Back to Categories
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="form-section">
        <div class="form-card">
            <div class="form-card-header">
                <h5 class="form-card-title">
                    <i class="fas fa-edit me-2"></i>Category Information
                </h5>
                <p class="form-card-subtitle">Fill in the details below to create a new category</p>
            </div>

            <div class="form-card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Basic Information -->
                        <div class="col-lg-8">
                            <div class="form-section-group">
                                <h6 class="form-section-title">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h6>
                                
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">
                                                Category Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name') }}" 
                                                   placeholder="Enter category name (e.g., iPhone, iPad, MacBook)"
                                                   required>
                                            <div class="form-text">This will be used to identify the category</div>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                                      id="description" 
                                                      name="description" 
                                                      rows="4" 
                                                      placeholder="Describe what products belong to this category...">{{ old('description') }}</textarea>
                                            <div class="form-text">Optional description to help identify the category</div>
                                            @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input @error('is_active') is-invalid @enderror" 
                                                       type="checkbox" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    <strong>Active Category</strong>
                                                </label>
                                                <div class="form-text">Inactive categories won't be visible to customers</div>
                                                @error('is_active')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="col-lg-4">
                            <div class="form-section-group">
                                <h6 class="form-section-title">
                                    <i class="fas fa-image me-2"></i>Category Image
                                </h6>
                                
                                <div class="image-upload-section">
                                    <div class="image-upload-area" id="imageUploadArea">
                                        <div class="image-upload-content" id="imageUploadContent">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <h6>Upload Category Image</h6>
                                            <p>Click to browse or drag and drop</p>
                                            <small>PNG, JPG, GIF up to 2MB</small>
                                        </div>
                                        <div class="image-preview" id="imagePreview" style="display: none;">
                                            <img id="previewImage" src="" alt="Preview">
                                            <button type="button" class="btn btn-sm btn-danger image-remove-btn" id="removeImage">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <input type="file" 
                                           class="form-control @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*"
                                           style="display: none;">
                                    
                                    @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="image-upload-info">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Recommended size: 400x400px. Max file size: 2MB.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Section -->
                            <div class="form-section-group">
                                <h6 class="form-section-title">
                                    <i class="fas fa-eye me-2"></i>Preview
                                </h6>
                                
                                <div class="preview-card">
                                    <div class="preview-header">
                                        <h6 id="previewName">Category Name</h6>
                                        <span class="preview-slug" id="previewSlug">category-slug</span>
                                    </div>
                                    <div class="preview-image" id="previewCardImage">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="preview-description" id="previewDescription">
                                        Category description will appear here...
                                    </div>
                                    <div class="preview-status">
                                        <span class="badge bg-success" id="previewStatus">Active</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <div class="form-actions-left">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                        <div class="form-actions-right">
                            <button type="button" class="btn btn-outline-primary" id="previewBtn">
                                <i class="fas fa-eye me-2"></i>Preview
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Category
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Admin Container */
.admin-container {
    padding: 2rem;
    background: #f8f9fa;
    min-height: 100vh;
}

/* Admin Header */
.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
}

.admin-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.admin-title {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
}

.admin-subtitle {
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
    font-size: 1.1rem;
}

/* Form Section */
.form-section {
    margin-bottom: 2rem;
}

.form-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #e9ecef;
    overflow: hidden;
}

.form-card-header {
    padding: 2rem 2rem 0;
    border-bottom: 1px solid #e9ecef;
}

.form-card-title {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-weight: 600;
}

.form-card-subtitle {
    margin: 0;
    color: #6c757d;
    font-size: 0.95rem;
}

.form-card-body {
    padding: 2rem;
}

/* Form Section Groups */
.form-section-group {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-section-title {
    margin: 0 0 1rem 0;
    color: #2c3e50;
    font-weight: 600;
    font-size: 1rem;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-text {
    color: #6c757d;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

/* Image Upload */
.image-upload-section {
    text-align: center;
}

.image-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-upload-area:hover {
    border-color: #667eea;
    background: #f8f9ff;
}

.image-upload-area.dragover {
    border-color: #667eea;
    background: #f0f2ff;
}

.image-upload-content {
    text-align: center;
}

.image-upload-content i {
    font-size: 3rem;
    color: #6c757d;
    margin-bottom: 1rem;
}

.image-upload-content h6 {
    margin: 0 0 0.5rem 0;
    color: #2c3e50;
    font-weight: 600;
}

.image-upload-content p {
    margin: 0 0 0.5rem 0;
    color: #6c757d;
}

.image-upload-content small {
    color: #adb5bd;
}

.image-preview {
    position: relative;
    width: 100%;
    height: 100%;
}

.image-preview img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.image-remove-btn {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.8rem;
}

.image-upload-info {
    margin-top: 1rem;
    padding: 0.75rem;
    background: #e9ecef;
    border-radius: 8px;
}

/* Preview Card */
.preview-card {
    background: white;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
}

.preview-header h6 {
    margin: 0 0 0.25rem 0;
    color: #2c3e50;
    font-weight: 600;
}

.preview-slug {
    color: #6c757d;
    font-size: 0.8rem;
    font-family: monospace;
}

.preview-image {
    width: 80px;
    height: 80px;
    background: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 1rem auto;
    color: #6c757d;
    font-size: 2rem;
}

.preview-description {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 1rem 0;
    line-height: 1.4;
}

.preview-status {
    margin-top: 1rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 2rem;
    border-top: 1px solid #e9ecef;
    margin-top: 2rem;
}

.form-actions-left,
.form-actions-right {
    display: flex;
    gap: 1rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .admin-container {
        padding: 1rem;
    }
    
    .admin-header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .admin-title {
        font-size: 1.5rem;
    }
    
    .form-card-body {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 1rem;
    }
    
    .form-actions-left,
    .form-actions-right {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('categoryForm');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const isActiveCheckbox = document.getElementById('is_active');
    const imageInput = document.getElementById('image');
    const imageUploadArea = document.getElementById('imageUploadArea');
    const imageUploadContent = document.getElementById('imageUploadContent');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const removeImageBtn = document.getElementById('removeImage');
    
    // Preview elements
    const previewName = document.getElementById('previewName');
    const previewSlug = document.getElementById('previewSlug');
    const previewDescription = document.getElementById('previewDescription');
    const previewStatus = document.getElementById('previewStatus');
    const previewCardImage = document.getElementById('previewCardImage');

    // Auto-generate slug from name
    nameInput.addEventListener('input', function() {
        const slug = this.value.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        previewSlug.textContent = slug || 'category-slug';
        previewName.textContent = this.value || 'Category Name';
    });

    // Update description preview
    descriptionInput.addEventListener('input', function() {
        previewDescription.textContent = this.value || 'Category description will appear here...';
    });

    // Update status preview
    isActiveCheckbox.addEventListener('change', function() {
        if (this.checked) {
            previewStatus.textContent = 'Active';
            previewStatus.className = 'badge bg-success';
        } else {
            previewStatus.textContent = 'Inactive';
            previewStatus.className = 'badge bg-secondary';
        }
    });

    // Image upload handling
    imageUploadArea.addEventListener('click', function() {
        imageInput.click();
    });

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Validate file type
            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                return;
            }
            
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                imageUploadContent.style.display = 'none';
                imagePreview.style.display = 'block';
                
                // Update preview card image
                previewCardImage.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">`;
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    removeImageBtn.addEventListener('click', function() {
        imageInput.value = '';
        imageUploadContent.style.display = 'block';
        imagePreview.style.display = 'none';
        previewCardImage.innerHTML = '<i class="fas fa-image"></i>';
    });

    // Drag and drop functionality
    imageUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    imageUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    imageUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files && files[0]) {
            imageInput.files = files;
            imageInput.dispatchEvent(new Event('change'));
        }
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('Please enter a category name.');
            nameInput.focus();
            return;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';
        submitBtn.disabled = true;
    });

    // Preview button
    document.getElementById('previewBtn').addEventListener('click', function() {
        // Scroll to preview section
        document.querySelector('.preview-card').scrollIntoView({ 
            behavior: 'smooth',
            block: 'center'
        });
    });
});
</script>
@endsection 