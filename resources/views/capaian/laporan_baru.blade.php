@extends('layouts.admin')

@section('header', 'Laporan Capaian')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-success"><i class="fas fa-file-invoice me-2"></i> Filter Laporan Capaian</h5>
        </div>
        <div class="card-body p-4">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Klaster</label>
                    <select id="id_klaster" name="id_klaster" class="form-select" onchange="loadPrograms(this.value)">
                        <option value="">Semua Klaster</option>
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id_klaster }}">{{ $klaster->nama_klaster }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Program</label>
                    <select id="id_program" name="id_program" class="form-select" onchange="loadIndikators(this.value)" disabled>
                        <option value="">Semua Program</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Indikator</label>
                    <select id="id_indikator" name="id_indikator" class="form-select" disabled>
                        <option value="">Semua Indikator</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Tahun</label>
                    <select id="tahun" name="tahun" class="form-select">
                        @foreach($tahuns as $t)
                            <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Bulan Dari</label>
                    <select id="bulan_dari" name="bulan_dari" class="form-select">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Bulan Sampai</label>
                    <select id="bulan_sampai" name="bulan_sampai" class="form-select">
                        @for($i=1; $i<=12; $i++)
                            <option value="{{ $i }}" {{ $i == 12 ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Desa</label>
                    <select id="id_desa" name="id_desa" class="form-select">
                        <option value="">Semua Desa</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id_desa }}">{{ $desa->nama_desa }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="button" onclick="viewData()" class="btn btn-primary px-4 rounded-pill shadow-sm"><i class="fas fa-search me-2"></i> View</button>
                    <button type="button" onclick="exportPdf()" class="btn btn-danger px-4 rounded-pill shadow-sm"><i class="fas fa-file-pdf me-2"></i> Cetak PDF</button>
                    <button type="button" onclick="exportExcel()" class="btn btn-success px-4 rounded-pill shadow-sm"><i class="fas fa-file-excel me-2"></i> Export Excel</button>
                    <button type="button" onclick="resetForm()" class="btn btn-secondary px-4 rounded-pill shadow-sm"><i class="fas fa-undo me-2"></i> Reset</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="reportTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center py-3">No</th>
                            <th>Klaster</th>
                            <th>Program</th>
                            <th>Indikator</th>
                            <th class="text-center">Tahun</th>
                            <th class="text-center">Bulan</th>
                            <th>Desa</th>
                            <th class="text-center">Target Tahunan</th>
                            <th class="text-center">Target Bulanan</th>
                            <th class="text-center">Capaian Bulanan</th>
                            <th class="text-center">Persentase</th>
                            <th class="text-center">Status</th>
                            <th>Analisa PH</th>
                        </tr>
                    </thead>
                    <tbody id="reportContent">
                        <tr>
                            <td colspan="13" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-info-circle fa-3x mb-3 d-block opacity-25"></i>
                                    <h5>Silakan pilih filter terlebih dahulu</h5>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
const BASE_URL = '{{ url("/") }}';

function loadPrograms(klasterId) {
    const selProgram = document.getElementById('id_program');
    const selIndikator = document.getElementById('id_indikator');
    
    selProgram.innerHTML = '<option value="">Memuat...</option>';
    selProgram.disabled = true;
    selIndikator.innerHTML = '<option value=""></option>';
    selIndikator.disabled = true;
    
    if (!klasterId) return;

    fetch(BASE_URL + '/api/programs/' + klasterId)
        .then(res => res.json())
        .then(data => {
            let html = '<option value="">Semua Program</option>';
            data.forEach(p => {
                html += `<option value="${p.id_program}">${p.nama_program}</option>`;
            });
            selProgram.innerHTML = html;
            selProgram.disabled = false;
        })
        .catch(err => console.error('Gagal load program:', err));
}

function loadIndikators(programId) {
    const selIndikator = document.getElementById('id_indikator');
    selIndikator.innerHTML = '<option value="">Memuat...</option>';
    selIndikator.disabled = true;

    if (!programId) return;

    fetch(BASE_URL + '/api/indikators/' + programId)
        .then(res => res.json())
        .then(data => {
            let html = '<option value="">Semua Indikator</option>';
            data.forEach(i => {
                html += `<option value="${i.id_indikator}">${i.nama_indikator}</option>`;
            });
            selIndikator.innerHTML = html;
            selIndikator.disabled = false;
        });
}

function viewData() {
    const filterForm = document.getElementById('filterForm');
    const reportContent = document.getElementById('reportContent');
    const klasterId = document.getElementById('id_klaster').value;

    if (!klasterId) {
        // If klaster is not selected, it views all data. We don't block it.
        // alert('Silakan pilih Klaster terlebih dahulu');
        // return;
    }
    
    const params = new URLSearchParams(new FormData(filterForm)).toString();
    reportContent.innerHTML = '<tr><td colspan="13" class="text-center py-5"><div class="spinner-border text-success" role="status"></div><div class="mt-2 fw-bold">Memproses data...</div></td></tr>';

    fetch(BASE_URL + '/laporan/capaian/data?' + params)
        .then(res => res.json())
        .then(res => {
            if (res.data && res.data.length > 0) {
                let html = '';
                const bulans = ["","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
                res.data.forEach((item, index) => {
                    const targetTahunan = item.target?.target_tahunan || 0;
                    const targetBulanan = (targetTahunan / 12).toFixed(0);
                    const capaian = item.capaian_bulan || 0;
                    const persentase = targetBulanan > 0 ? ((capaian / targetBulanan) * 100).toFixed(1) : 0;
                    
                    let statusClass = 'status-gagal';
                    let statusText = 'Tidak Tercapai';
                    if (persentase >= 90) { statusClass = 'status-tercapai'; statusText = 'Tercapai'; }
                    else if (persentase >= 50) { statusClass = 'status-maksimal'; statusText = 'Belum Maksimal'; }

                    html += `
                        <tr>
                            <td class="text-center small">${index + 1}</td>
                            <td class="small">${item.target?.klaster?.nama_klaster || '-'}</td>
                            <td class="small">${item.target?.program?.nama_program || '-'}</td>
                            <td class="fw-bold small">${item.target?.indikator?.nama_indikator || '-'}</td>
                            <td class="text-center small">${item.updated_at ? item.updated_at.substring(0,4) : '-'}</td>
                            <td class="text-center"><span class="badge bg-light text-dark border">${bulans[item.bulan]}</span></td>
                            <td class="small">${item.desa?.nama_desa || '-'}</td>
                            <td class="text-center small">${targetTahunan}</td>
                            <td class="text-center small">${targetBulanan}</td>
                            <td class="text-center fw-bold text-primary">${capaian}</td>
                            <td class="text-center fw-bold text-success">${persentase}%</td>
                            <td class="text-center">
                                <span class="badge-modern ${statusClass}">${statusText}</span>
                            </td>
                            <td class="small text-muted">${item.analisa_masalah || '-'}</td>
                        </tr>
                    `;
                });
                reportContent.innerHTML = html;
            } else {
                reportContent.innerHTML = '<tr><td colspan="13" class="text-center py-5 text-muted">Data tidak ditemukan</td></tr>';
            }
        })
        .catch(err => {
            console.error(err);
            reportContent.innerHTML = '<tr><td colspan="13" class="text-center py-5 text-danger">Gagal memuat data</td></tr>';
        });
}

function resetForm() {
    location.reload();
}

function exportPdf() {
    const params = new URLSearchParams(new FormData(document.getElementById('filterForm'))).toString();
    window.open(BASE_URL + '/laporan/capaian/export/pdf?' + params, '_blank');
}

function exportExcel() {
    const params = new URLSearchParams(new FormData(document.getElementById('filterForm'))).toString();
    window.open(BASE_URL + '/laporan/capaian/export/excel?' + params, '_blank');
}
</script>

<style>
    .form-select { border-radius: 10px; }
    .table thead th { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; background: #f8f9fa; }
    .badge-modern { padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 0.75rem; }
    .status-tercapai { background-color: #d1fae5; color: #065f46; }
    .status-maksimal { background-color: #fef3c7; color: #92400e; }
    .status-gagal { background-color: #fee2e2; color: #991b1b; }
</style>
@endsection
