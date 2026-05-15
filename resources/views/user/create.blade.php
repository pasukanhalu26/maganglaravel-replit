@extends('layouts.admin')
@section('header', 'Tambah Pengguna Baru')
@section('content')
<div class="card shadow mb-4">
    <div class="card-body">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Gagal Simpan!</strong> Cek kesalahan berikut:
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label>Password (Minimal 6 karakter)</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Role / Jabatan</label>
                    <select name="role" class="form-control" required>
                        <option value="">Pilih Jabatan</option>
                        <option value="admin">Admin</option>
                        <option value="pj_program">PJ Program</option>
                        <option value="staff_desa">Staff Desa</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="1">Aktif (1)</option>
                        <option value="0">Tidak Aktif (0)</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan User</button>
            <a href="{{ route('user.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection