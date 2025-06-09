@extends('admin.layout')

@section('title', 'Kelola Sales - Admin')

@section('content')
<div class="container py-5">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Daftar Sales</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">+ Tambah Sales</a>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-bordered w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th>Nama</th>
                    <th>WhatsApp</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td>{{ $sale->name }}</td>
                    <td>{{ $sale->whatsapp }}</td>
                    <td>
                        @if($sale->is_active)
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus sales ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-gray-400">Tidak ada sales.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $sales->links() }}</div>
</div>
@endsection 