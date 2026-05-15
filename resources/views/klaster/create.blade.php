@extends('layouts.admin')

@section('header', 'Tambah Klaster')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Klaster Baru</h6>
                <a href="{{ route('klaster.index') }}" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">
                <form action="{{ route('klaster.store') }}" method="POST">
                    @csrf

                    {{-- Info ID auto generate --}}
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #F9F5FF, #F2EAF9); border-radius: 12px; border: 1px dashed #C4A0E8;">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600;">ID Klaster</div>
                            <div style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: #A39DB0; letter-spacing: 2px;">
                                #AUTO
                            </div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: #F2EAF9; color: #703799; border: 1px solid #C4A0E8; font-size: 0.7rem;">
                                <i class="fas fa-magic me-1"></i>Auto Generate
                            </span>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" name="nama_klaster" id="nama_klaster" class="form-control form-control-modern" placeholder="Nama Klaster" required>
                        <label for="nama_klaster">Nama Klaster</label>
                    </div>
                    
                    <div class="form-floating mb-5">
                        <select name="status" id="status" class="form-select form-select-modern" required>
                            <option value="1">Aktif (1)</option>
                            <option value="0">Tidak Aktif (0)</option>
                        </select>
                        <label for="status">Status Klaster</label>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('klaster.index') }}" class="btn-modern-cancel">Batal</a>
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