@extends('layouts.admin')
@section('header', 'Edit Indikator')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Indikator</h6>
                <a href="{{ route('indikator.index') }}" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">
                <form action="{{ route('indikator.update', $indikator->id_indikator) }}" method="POST">
                    @csrf @method('PUT')

                    {{-- ID Indikator: Read Only --}}
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #F9F5FF, #F2EAF9); border-radius: 12px; border: 1px dashed #C4A0E8;">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600;">ID Indikator</div>
                            <div style="font-family: monospace; font-size: 1.3rem; font-weight: 800; color: var(--accent-green); letter-spacing: 2px;">
                                #{{ str_pad($indikator->id_indikator, 3, '0', STR_PAD_LEFT) }}
                            </div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: #F2EAF9; color: #703799; border: 1px solid #C4A0E8; font-size: 0.7rem;">
                                <i class="fas fa-lock me-1"></i>Auto Generate
                            </span>
                        </div>
                    </div>

                    {{-- Klaster & Program --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="id_klaster" class="text-muted small fw-bold mb-1">Pilih Klaster</label>
                            <select name="id_klaster" id="id_klaster" class="form-select form-select-modern select-searchable" required>
                                @foreach($klasters as $k)
                                    <option value="{{ $k->id_klaster }}" {{ $indikator->id_klaster == $k->id_klaster ? 'selected' : '' }}>
                                        {{ $k->nama_klaster }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_program" class="text-muted small fw-bold mb-1">Pilih Program</label>
                            <select name="id_program" id="id_program" class="form-select form-select-modern select-searchable" required>
                                @foreach($programs as $p)
                                    <option value="{{ $p->id_program }}" {{ $indikator->id_program == $p->id_program ? 'selected' : '' }}>
                                        {{ $p->nama_program }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-floating mb-4">
                        <textarea name="nama_indikator" id="nama_indikator" class="form-control form-control-modern" style="height: 100px" required>{{ $indikator->nama_indikator }}</textarea>
                        <label for="nama_indikator">Nama Indikator</label>
                    </div>

                    <div class="form-floating mb-5">
                        <select name="status" id="status" class="form-select form-select-modern" required>
                            <option value="1" {{ $indikator->status == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ $indikator->status == 0 ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        <label for="status">Status</label>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('indikator.index') }}" class="btn-modern-cancel">Batal</a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const klasterSelect = document.getElementById('id_klaster');
    const programSelect = document.getElementById('id_program');
    
    let programTomSelect = null;
    
    setTimeout(() => {
        if(programSelect.tomselect) {
            programTomSelect = programSelect.tomselect;
        }
    }, 100);

    klasterSelect.addEventListener('change', function() {
        const idKlaster = this.value;
        if(programTomSelect) {
            programTomSelect.clearOptions();
            programTomSelect.clear();
        } else {
            programSelect.innerHTML = '<option value="">Pilih Program</option>';
        }

        if(idKlaster) {
            fetch(`/api/programs/${idKlaster}`)
                .then(response => response.json())
                .then(data => {
                    if(programTomSelect) {
                        data.forEach(program => {
                            programTomSelect.addOption({value: program.id_program, text: program.nama_program});
                        });
                        programTomSelect.refreshOptions(false);
                    } else {
                        data.forEach(program => {
                            const option = document.createElement('option');
                            option.value = program.id_program;
                            option.textContent = program.nama_program;
                            programSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error fetching programs:', error));
        }
    });
});
</script>
@endsection