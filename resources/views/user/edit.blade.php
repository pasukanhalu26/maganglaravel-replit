@extends('layouts.admin')

@section('header', 'Edit Pengguna')

@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3">
                <label>Password (Kosongkan jika tidak ingin ganti)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="mb-3">
                <label>Role / Jabatan</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pj_program" {{ $user->role == 'pj_program' ? 'selected' : '' }}>PJ Program</option>
                    <option value="staff_desa" {{ $user->role == 'staff_desa' ? 'selected' : '' }}>Staff Desa</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update User</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection