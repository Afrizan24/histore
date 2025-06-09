@extends('admin.layout')

@section('title', 'Edit User - Admin')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit User</h1>
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="card p-4 shadow-sm">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="is_admin" class="form-label">Role</label>
            <select name="is_admin" id="is_admin" class="form-control">
                <option value="0" @if(!$user->is_admin) selected @endif>User</option>
                <option value="1" @if($user->is_admin) selected @endif>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Batal</a>
    </form>
</div>
@endsection 