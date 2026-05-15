@extends('layouts.admin')
@section('header', 'Edit Program')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data Program</h6>
                <a href="{{ route('program.index') }}" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">
                <form action="{{ route('program.update', $program->id_program) }}" method="POST">
                    @csrf @method('PUT')

                    {{-- ID Program: Read Only --}}
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #F9F5FF, #F2EAF9); border-radius: 12px; border: 1px dashed #C4A0E8;">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600;">ID Program</div>
                            <div style="font-family: monospace; font-size: 1.3rem; font-weight: 800; color: var(--accent-green); letter-spacing: 2px;">
                                #{{ str_pad($program->id_program, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: #F2EAF9; color: #703799; border: 1px solid #C4A0E8; font-size: 0.7rem;">
                                <i class="fas fa-lock me-1"></i>Auto Generate
                            </span>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="id_klaster" class="text-muted small fw-bold mb-1">Pilih Klaster</label>
                        <select name="id_klaster" id="id_klaster" class="form-select form-select-modern select-searchable" required>
                            @foreach($klasters as $k)
                                <option value="{{ $k->id_klaster }}" {{ $program->id_klaster == $k->id_klaster ? 'selected' : '' }}>{{ $k->nama_klaster }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-floating mb-4">
                        <input type="text" name="nama_program" id="nama_program" class="form-control form-control-modern" value="{{ $program->nama_program }}" placeholder="Nama Program" required>
                        <label for="nama_program">Nama Program</label>
                    </div>
                    
                    <div class="form-floating mb-5">
                        <select name="status" id="status" class="form-select form-select-modern" required>
                            <option value="1" {{ $program->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $program->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <label for="status">Status Program</label>
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('program.index') }}" class="btn-modern-cancel">Batal</a>
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