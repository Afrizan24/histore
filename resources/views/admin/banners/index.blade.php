@extends('admin.layout')

@section('title', 'Kelola Banner')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Kelola Banner</h2>
            <p class="text-muted mb-0">Kelola banner carousel untuk halaman utama</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Banner
        </a>
    </div>

    <!-- Banners Grid -->
    <div class="row g-4">
        @forelse($banners as $banner)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100">
                <div class="position-relative">
                    <img src="{{ Storage::url($banner->image) }}" 
                         class="card-img-top" 
                         alt="{{ $banner->title }}"
                         style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <span class="badge {{ $banner->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $banner->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <div class="position-absolute top-0 start-0 m-2">
                        <span class="badge bg-primary">Urutan: {{ $banner->order }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $banner->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($banner->description, 100) }}</p>
                    @if($banner->button_text)
                    <p class="mb-2">
                        <small class="text-muted">
                            <i class="fas fa-link me-1"></i>
                            {{ $banner->button_text }} → {{ $banner->button_url }}
                        </small>
                    </p>
                    @endif
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $banner->created_at->format('d M Y') }}
                        </small>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.banners.edit', $banner) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.banners.destroy', $banner) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus banner ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h5>Belum ada banner</h5>
                    <p class="text-muted">Mulai dengan menambahkan banner pertama untuk carousel</p>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Banner
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($banners->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $banners->links() }}
    </div>
    @endif
</div>

<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-radius: 0.5rem;
    transition: transform 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin: 0 2px;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}
</style>
@endsection 