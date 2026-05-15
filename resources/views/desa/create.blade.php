@extends('layouts.admin')
@section('header', 'Tambah Desa')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Desa Baru</h6>
                <a href="{{ route('desa.index') }}" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">
                <form action="{{ route('desa.store') }}" method="POST">
                    @csrf
                    <div class="form-floating mb-4">
                        <input type="text" name="nama_desa" id="nama_desa" class="form-control form-control-modern" placeholder="Nama Desa" required>
                        <label for="nama_desa">Nama Desa</label>
                    </div>
                    
                    <div class="form-floating mb-5">
                        <select name="status" id="status" class="form-select form-select-modern" required>
                            <option value="1">Aktif (1)</option>
                            <option value="0">Tidak Aktif (0)</option>
                        </select>
                        <label for="status">Status Desa</label>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('desa.index') }}" class="btn-modern-cancel">Batal</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn-modern-save"><i class="fas fa-save me-2"></i>Simpan Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection