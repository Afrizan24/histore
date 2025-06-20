@extends('admin.layout')

@section('title', 'Sales Representatives')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Sales Representatives</h2>
            <p class="text-muted mb-0">Kelola semua sales representative toko</p>
        </div>
        <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Sales
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $sales->total() }}</h4>
                            <small>Total Sales</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $sales->where('is_active', true)->count() }}</h4>
                            <small>Sales Aktif</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $sales->where('is_active', false)->count() }}</h4>
                            <small>Sales Nonaktif</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-pause-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $sales->where('whatsapp_chats_count', '>=', 5)->count() }}</h4>
                            <small>Limit Tercapai</small>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-list me-2 text-primary"></i>
                Daftar Sales Representatives
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0">
                                <i class="fas fa-image me-2"></i>Foto
                            </th>
                            <th class="border-0">
                                <i class="fas fa-user me-2"></i>Nama Sales
                            </th>
                            <th class="border-0">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </th>
                            <th class="border-0">
                                <i class="fas fa-envelope me-2"></i>Email
                            </th>
                            <th class="border-0">
                                <i class="fas fa-comments me-2"></i>Chat Hari Ini
                            </th>
                            <th class="border-0">
                                <i class="fas fa-toggle-on me-2"></i>Status
                            </th>
                            <th class="border-0">
                                <i class="fas fa-calendar me-2"></i>Dibuat
                            </th>
                            <th class="border-0 text-center">
                                <i class="fas fa-cogs me-2"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td class="align-middle">
                                @if($sale->image)
                                <img src="{{ Storage::url($sale->image) }}" alt="{{ $sale->name }}" class="rounded" style="width: 60px; height: 40px; object-fit: cover;">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <strong>{{ $sale->name }}</strong>
                            </td>
                            <td class="align-middle">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sale->whatsapp) }}" target="_blank" class="text-success text-decoration-none">
                                    <i class="fab fa-whatsapp me-1"></i>{{ $sale->whatsapp }}
                                </a>
                            </td>
                            <td class="align-middle">
                                @if($sale->email)
                                    <a href="mailto:{{ $sale->email }}">{{ $sale->email }}</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @php
                                    $chatCount = $sale->whatsapp_chats_count ?? 0;
                                    $isLimitReached = $chatCount >= 5;
                                @endphp
                                <div class="d-flex align-items-center">
                                    <span class="badge {{ $isLimitReached ? 'bg-danger' : ($chatCount > 0 ? 'bg-warning' : 'bg-secondary') }} me-2">
                                        {{ $chatCount }}/5
                                    </span>
                                    @if($isLimitReached)
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Limit
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td class="align-middle">
                                @if($sale->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                                @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-pause-circle me-1"></i>Nonaktif
                                </span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">
                                    {{ $sale->created_at->format('d M Y') }}
                                </small>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.sales.edit', $sale) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Toggle Active/Inactive -->
                                    <form action="{{ route('admin.sales.toggle-active', $sale) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $sale->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }}" 
                                                title="{{ $sale->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas {{ $sale->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <!-- Reset Daily Chats -->
                                    @if($chatCount > 0)
                                    <form action="{{ route('admin.sales.reset-chats', $sale) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Reset chat count untuk hari ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-info" title="Reset Chat Count">
                                            <i class="fas fa-redo"></i>
                                        </button>
                                    </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus sales ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-user fa-3x mb-3"></i>
                                    <h5>Belum ada sales</h5>
                                    <p>Mulai dengan menambahkan sales pertama Anda</p>
                                    <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Sales Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($sales->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $sales->links() }}
    </div>
    @endif
</div>

<style>
.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 12px;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
    border-radius: 12px 12px 0 0 !important;
}

.table th {
    font-weight: 600;
    color: #2c3e50;
    border-top: none;
    padding: 1rem;
}

.table td {
    padding: 1rem;
    vertical-align: middle;
}

.btn-group .btn {
    border-radius: 6px;
    margin: 0 2px;
}

.btn-group .btn:hover {
    transform: translateY(-1px);
}

.badge {
    font-size: 0.85rem;
    padding: 0.5rem 0.75rem;
}

.text-truncate {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Responsive */
@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .table th,
    .table td {
        padding: 0.75rem 0.5rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection 