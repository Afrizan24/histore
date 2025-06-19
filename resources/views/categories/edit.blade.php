@extends('layouts.app')

@section('title', 'Edit Kategori - Kiansantang Store')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit Kategori</h1>
    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Kategori</label>
            @if($category->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="max-width:120px;">
                </div>
            @endif
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection 