@extends('layouts.admin')
@section('header', 'Edit Capaian')
@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-4 border-0 d-flex justify-content-between align-items-center" style="border-bottom: 2px solid #f1f5f9 !important;">
                <div>
                    <h5 class="fw-bold text-dark mb-1"><i class="fas fa-edit text-primary me-2"></i>Edit Data Capaian</h5>
                    <p class="text-muted small mb-0">Perbarui informasi capaian bulanan yang sudah diinput sebelumnya.</p>
                </div>
                <a href="{{ route('capaian.index') }}" class="btn btn-light text-secondary rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
            
            <div class="card-body p-5 bg-light">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 rounded-3 mb-4 shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <h6 class="mb-0 fw-bold">Terjadi Kesalahan</h6>
                        </div>
                        <ul class="mb-0 small">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('capaian.update', $capaian->id_capaian) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="row g-4">
                        <!-- Left Column: Master Data Selection -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-success mb-4 border-bottom pb-2">
                                        <span class="bg-success text-white rounded-circle d-inline-flex justify-content-center align-items-center me-2" style="width:24px;height:24px;font-size:0.8rem">1</span> 
                                        Identitas Indikator
                                    </h6>
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Klaster</label>
                                        <select id="filter_klaster" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem">
                                            @foreach($klasters as $k)
                                                <option value="{{ $k->id_klaster }}" {{ $capaian->target->id_klaster == $k->id_klaster ? 'selected' : '' }}>{{ $k->nama_klaster }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Program</label>
                                        <select id="filter_program" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem">
                                            @if($capaian->target && $capaian->target->program)
                                                <option value="{{ $capaian->target->id_program }}" selected>{{ $capaian->target->program->nama_program }}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Indikator</label>
                                        <select id="filter_indikator" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem">
                                            @if($capaian->target && $capaian->target->indikator)
                                                <option value="{{ $capaian->target->id_indikator }}" selected>{{ $capaian->target->indikator->nama_indikator }}</option>
                                            @endif
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark small">Periode Tahun (Target)</label>
                                        <select name="id_target" id="id_target" class="form-select form-select-lg rounded-3 shadow-sm border-success bg-white" style="font-size:0.9rem; border-width: 2px;" required>
                                            @if($capaian->target)
                                                <option value="{{ $capaian->id_target }}" selected>{{ $capaian->target->periode }} (Target: {{ number_format($capaian->target->target_tahunan) }})</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Input Data -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-primary mb-4 border-bottom pb-2">
                                        <span class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center me-2" style="width:24px;height:24px;font-size:0.8rem">2</span> 
                                        Update Nilai Capaian
                                    </h6>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark small">Desa</label>
                                            <select name="id_desa" id="id_desa" class="form-select rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem" required>
                                                @foreach($desas as $d)
                                                    <option value="{{ $d->id_desa }}" {{ $capaian->id_desa == $d->id_desa ? 'selected' : '' }}>{{ $d->nama_desa }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark small">Bulan Pelaporan</label>
                                            <select name="bulan" class="form-select rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem" required>
                                                @php
                                                    $bulans = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                                              7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                                                @endphp
                                                @foreach($bulans as $num => $name)
                                                    <option value="{{ $num }}" {{ $capaian->bulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div id="infoPanel" class="mb-4 p-3 rounded-4 shadow-sm" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1px solid #bbf7d0;">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="fw-bold small text-success"><i class="fas fa-bullseye me-2"></i>Info Target Puskesmas</span>
                                        </div>
                                        <div class="row g-2 text-center">
                                            <div class="col-6">
                                                <div class="p-2 bg-white rounded-3 shadow-sm">
                                                    <div class="text-muted" style="font-size:0.65rem;text-transform:uppercase;">Target Tahunan</div>
                                                    <div id="info_target" class="fw-bold text-dark" style="font-size:1.1rem">{{ $capaian->target ? number_format($capaian->target->target_tahunan, 0, ',', '.') : '-' }}</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-2 bg-white rounded-3 shadow-sm border border-success">
                                                    <div class="text-success fw-bold" style="font-size:0.65rem;text-transform:uppercase;">Estimasi Target/Bulan</div>
                                                    <div id="info_per_bulan" class="fw-bold text-success" style="font-size:1.1rem">± {{ $capaian->target ? number_format(round($capaian->target->target_tahunan / 12), 0, ',', '.') : '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Pencapaian Bulanan (Angka)</label>
                                        <div class="input-group shadow-sm rounded-3">
                                            <button type="button" class="btn btn-light border-end" onclick="stepValue('capaian_bulan', -1)">
                                                <i class="fas fa-minus text-danger"></i>
                                            </button>
                                            <input type="number" name="capaian_bulan" id="capaian_bulan" class="form-control border-0 text-center fw-bold text-primary"
                                                value="{{ $capaian->capaian_bulan }}" placeholder="0" min="0" required style="font-size: 1.5rem; height: 60px;">
                                            <button type="button" class="btn btn-light border-start" onclick="stepValue('capaian_bulan', 1)">
                                                <i class="fas fa-plus text-success"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark small">Analisa Masalah</label>
                                        <textarea name="analisa_masalah" class="form-control rounded-3 border-0 shadow-sm bg-light" rows="2" placeholder="Ketikan kendala jika belum tercapai...">{{ $capaian->analisa_masalah }}</textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Rencana Tindak Lanjut (RTL)</label>
                                        <textarea name="rtl" class="form-control rounded-3 border-0 shadow-sm bg-light" rows="2" placeholder="Ketikan solusi bulan depan...">{{ $capaian->rtl }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4 text-end">
                            <hr class="mb-4 opacity-25">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow fw-bold">
                                <i class="fas fa-save me-2"></i> Perbarui Capaian
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function stepValue(id, delta) {
    const el = document.getElementById(id);
    let val = parseInt(el.value) || 0;
    val += delta;
    if (val < 0) val = 0;
    el.value = val;
}

document.addEventListener('DOMContentLoaded', function() {
    const filterKlaster = document.getElementById('filter_klaster');
    const filterProgram = document.getElementById('filter_program');
    const filterIndikator = document.getElementById('filter_indikator');
    const selectTarget = document.getElementById('id_target');
    const fmt = v => new Intl.NumberFormat('id-ID').format(v);

    let targetMap = {};

    function updateInfoTarget() {
        const idTarget = selectTarget.value;
        if (idTarget && targetMap[idTarget]) {
            const t = targetMap[idTarget];
            const targetBulan = Math.round(t.target_tahunan / 12);
            document.getElementById('info_target').textContent = fmt(t.target_tahunan);
            document.getElementById('info_per_bulan').textContent = '± ' + fmt(targetBulan);
        }
    }

    // 1. Klaster -> Program
    filterKlaster.addEventListener('change', function() {
        const idKlaster = this.value;
        filterProgram.innerHTML = '<option value="">-- Pilih Program --</option>';
        filterIndikator.innerHTML = '<option value="">-- Pilih Indikator --</option>';
        selectTarget.innerHTML = '<option value="">-- Pilih Target Tahun --</option>';

        if(idKlaster) {
            fetch(`/api/programs/${idKlaster}`)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Program --</option>';
                    data.forEach(p => html += `<option value="${p.id_program}">${p.nama_program}</option>`);
                    filterProgram.innerHTML = html;
                });
        }
    });

    // 2. Program -> Indikator
    filterProgram.addEventListener('change', function() {
        const idProgram = this.value;
        filterIndikator.innerHTML = '<option value="">-- Pilih Indikator --</option>';
        selectTarget.innerHTML = '<option value="">-- Pilih Target Tahun --</option>';

        if(idProgram) {
            fetch(`/api/indikators/${idProgram}`)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Indikator --</option>';
                    data.forEach(i => html += `<option value="${i.id_indikator}">${i.nama_indikator}</option>`);
                    filterIndikator.innerHTML = html;
                });
        }
    });

    // 3. Indikator -> Target (Tahun)
    filterIndikator.addEventListener('change', function() {
        const idIndikator = this.value;
        selectTarget.innerHTML = '<option value="">-- Pilih Target Tahun --</option>';
        targetMap = {};

        if(idIndikator) {
            fetch(`/api/targets/${idIndikator}`)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Target Tahun --</option>';
                    data.forEach(t => {
                        targetMap[t.id_target] = t;
                        html += `<option value="${t.id_target}">${t.periode} (Target: ${fmt(t.target_tahunan)})</option>`;
                    });
                    selectTarget.innerHTML = html;
                });
        }
    });

    selectTarget.addEventListener('change', updateInfoTarget);
});
</script>
@endsection