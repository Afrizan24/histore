@extends('admin.layout')

@section('title', 'Daftar User - Admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h3 mb-1">Daftar User</h2>
            <p class="text-muted mb-0">Kelola semua user yang terdaftar di sistem</p>
        </div>
        {{--
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah User
        </a>
        --}}
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-users me-2 text-primary"></i>
                Daftar User
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0"><i class="fas fa-user me-2"></i>Nama</th>
                            <th class="border-0"><i class="fas fa-envelope me-2"></i>Email</th>
                            <th class="border-0"><i class="fas fa-user-shield me-2"></i>Role</th>
                            <th class="border-0"><i class="fas fa-calendar me-2"></i>Tanggal Daftar</th>
                            <th class="border-0 text-center"><i class="fas fa-cogs me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="align-middle fw-semibold">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @if($user->is_admin)
                                    <span class="badge bg-primary"><i class="fas fa-user-shield me-1"></i>Admin</span>
                                @else
                                    <span class="badge bg-secondary"><i class="fas fa-user me-1"></i>User</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">{{ $user->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3"></i>
                                    <h5>Belum ada user</h5>
                                    <p>Belum ada user yang terdaftar di sistem.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 