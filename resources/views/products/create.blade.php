@extends('layouts.app')

@section('title', 'Tambah Produk - Kiansantang Store')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Tambah Produk Baru</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" @if(old('category_id')==$cat->id) selected @endif>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label for="warna" class="form-label">Warna</label>
                <input type="text" name="warna" id="warna" class="form-control" value="{{ old('warna') }}">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="kondisi" class="form-label">Kondisi</label>
                <select name="kondisi" id="kondisi" class="form-control">
                    <option value="baru" @if(old('kondisi')=='baru') selected @endif>Baru</option>
                    <option value="bekas" @if(old('kondisi')=='bekas') selected @endif>Bekas</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="storage" class="form-label">Storage</label>
                <input type="text" name="storage" id="storage" class="form-control" value="{{ old('storage') }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('products.all') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection 