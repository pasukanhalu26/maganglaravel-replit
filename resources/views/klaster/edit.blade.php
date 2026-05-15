@extends('layouts.admin')

@section('header', 'Edit Data Klaster')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data Klaster</h6>
                <a href="{{ route('klaster.index') }}" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">
                <form action="{{ route('klaster.update', $klaster->id_klaster) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- ID Klaster: tampil saja, tidak bisa diubah (sesuai spec: hide/disable) --}}
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #F9F5FF, #F2EAF9); border-radius: 12px; border: 1px dashed #C4A0E8;">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600;">ID Klaster</div>
                            <div style="font-family: monospace; font-size: 1.3rem; font-weight: 800; color: var(--accent-green); letter-spacing: 2px;">
                                #{{ str_pad($klaster->id_klaster, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: #F2EAF9; color: #703799; border: 1px solid #C4A0E8; font-size: 0.7rem;">
                                <i class="fas fa-lock me-1"></i>Auto Generate
                            </span>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" name="nama_klaster" id="nama_klaster" class="form-control form-control-modern" value="{{ $klaster->nama_klaster }}" placeholder="Nama Klaster" required>
                        <label for="nama_klaster">Nama Klaster</label>
                    </div>
                    
                    <div class="form-floating mb-5">
                        <select name="status" id="status" class="form-select form-select-modern" required>
                            <option value="1" {{ $klaster->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $klaster->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <label for="status">Status Klaster</label>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('klaster.index') }}" class="btn-modern-cancel">Batal</a>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn-modern-save"><i class="fas fa-save me-2"></i>Update Data</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection