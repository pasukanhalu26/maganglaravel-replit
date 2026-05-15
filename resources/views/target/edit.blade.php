@extends('layouts.admin')
@section('header', 'Edit Target')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Data Target</h6>
                <a href="{{ route('target.index') }}" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">
                <form action="{{ route('target.update', $target->id_target) }}" method="POST">
                    @csrf @method('PUT')

                    {{-- ID Read Only --}}
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #F9F5FF, #F2EAF9); border-radius: 12px; border: 1px dashed #C4A0E8;">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600;">ID Target</div>
                            <div style="font-family: monospace; font-size: 1.3rem; font-weight: 800; color: var(--accent-green); letter-spacing: 2px;">
                                #{{ str_pad($target->id_target, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: #F2EAF9; color: #703799; border: 1px solid #C4A0E8; font-size: 0.7rem;">
                                <i class="fas fa-lock me-1"></i>Auto Generate
                            </span>
                        </div>
                    </div>

                    {{-- Klaster, Program, Indikator --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="text-muted small fw-bold mb-1">Pilih Klaster</label>
                            <select name="id_klaster" id="id_klaster" class="form-select form-select-modern select-searchable" required>
                                @foreach($klasters as $k)
                                    <option value="{{ $k->id_klaster }}" {{ $target->id_klaster == $k->id_klaster ? 'selected' : '' }}>
                                        {{ $k->nama_klaster }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small fw-bold mb-1">Pilih Program</label>
                            <select name="id_program" id="id_program" class="form-select form-select-modern select-searchable" required>
                                @foreach($programs as $p)
                                    <option value="{{ $p->id_program }}" {{ $target->id_program == $p->id_program ? 'selected' : '' }}>
                                        {{ $p->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small fw-bold mb-1">Pilih Indikator</label>
                            <select name="id_indikator" id="id_indikator" class="form-select form-select-modern select-searchable" required>
                                @foreach($indikators as $i)
                                    <option value="{{ $i->id_indikator }}" {{ $target->id_indikator == $i->id_indikator ? 'selected' : '' }}>
                                        {{ Str::limit($i->nama_indikator, 40) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Periode & Target Tahunan --}}
                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="periode" id="periode" class="form-control form-control-modern"
                                    value="{{ $target->periode }}" placeholder="2025" min="2000" max="2100" required>
                                <label for="periode">Periode (Tahun)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="target_tahunan" id="target_tahunan" class="form-control form-control-modern"
                                    value="{{ $target->target_tahunan }}" placeholder="940" min="0" required>
                                <label for="target_tahunan">Target Tahunan</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6"><a href="{{ route('target.index') }}" class="btn-modern-cancel">Batal</a></div>
                        <div class="col-md-6"><button type="submit" class="btn-modern-save"><i class="fas fa-save me-2"></i>Update Target</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const klasterSelect = document.getElementById('id_klaster');
    const programSelect = document.getElementById('id_program');
    const indikatorSelect = document.getElementById('id_indikator');
    
    let programTomSelect = null;
    let indikatorTomSelect = null;
    
    setTimeout(() => {
        if(programSelect.tomselect) programTomSelect = programSelect.tomselect;
        if(indikatorSelect.tomselect) indikatorTomSelect = indikatorSelect.tomselect;
    }, 100);

    klasterSelect.addEventListener('change', function() {
        const idKlaster = this.value;
        
        if(programTomSelect) { programTomSelect.clearOptions(); programTomSelect.clear(); }
        if(indikatorTomSelect) { indikatorTomSelect.clearOptions(); indikatorTomSelect.clear(); }

        if(idKlaster) {
            fetch(`/api/programs/${idKlaster}`)
                .then(res => res.json())
                .then(data => {
                    if(programTomSelect) {
                        data.forEach(p => programTomSelect.addOption({value: p.id_program, text: `${p.nama_program}`}));
                        programTomSelect.refreshOptions(false);
                    }
                });
        }
    });

    programSelect.addEventListener('change', function() {
        const idProgram = this.value;
        
        if(indikatorTomSelect) { indikatorTomSelect.clearOptions(); indikatorTomSelect.clear(); }

        if(idProgram) {
            fetch(`/api/indikators/${idProgram}`)
                .then(res => res.json())
                .then(data => {
                    if(indikatorTomSelect) {
                        data.forEach(i => indikatorTomSelect.addOption({value: i.id_indikator, text: `${i.nama_indikator.substring(0,60)}`}));
                        indikatorTomSelect.refreshOptions(false);
                    }
                });
        }
    });
});
</script>
@endsection
