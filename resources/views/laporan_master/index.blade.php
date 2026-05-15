@extends('layouts.admin')

@section('header', 'Master Laporan Capaian')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0 text-primary"><i class="fas fa-file-invoice me-2"></i> Filter Laporan Capaian</h5>
        </div>
        <div class="card-body p-4">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Klaster</label>
                    <select id="id_klaster" name="id_klaster" class="form-select select2-modern" data-placeholder="Pilih Klaster">
                        <option value=""></option>
                        @foreach($klasters as $klaster)
                            <option value="{{ $klaster->id_klaster }}">{{ $klaster->nama_klaster }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Program</label>
                    <select id="id_program" name="id_program" class="form-select select2-modern" data-placeholder="Pilih Program" disabled>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Indikator</label>
                    <select id="id_indikator" name="id_indikator" class="form-select select2-modern" data-placeholder="Pilih Indikator" disabled>
                        <option value=""></option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">Tahun</label>
                    <select id="tahun" name="tahun" class="form-select select2-modern">
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
                    <select id="id_desa" name="id_desa" class="form-select select2-modern" data-placeholder="Semua Desa">
                        <option value="">Semua Desa</option>
                        @foreach($desas as $desa)
                            <option value="{{ $desa->id_desa }}">{{ $desa->nama_desa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="button" id="btnView" class="btn btn-primary px-4 rounded-pill shadow-sm"><i class="fas fa-search me-2"></i> View</button>
                    <button type="button" id="btnSubmit" class="btn btn-success px-4 rounded-pill shadow-sm"><i class="fas fa-save me-2"></i> Submit</button>
                    <button type="button" id="btnPdf" class="btn btn-danger px-4 rounded-pill shadow-sm"><i class="fas fa-file-pdf me-2"></i> Cetak PDF</button>
                    <button type="button" id="btnExcel" class="btn btn-info px-4 rounded-pill shadow-sm text-white"><i class="fas fa-file-excel me-2"></i> Export Excel</button>
                    <button type="button" id="btnReset" class="btn btn-secondary px-4 rounded-pill shadow-sm"><i class="fas fa-undo me-2"></i> Reset</button>
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

<!-- Extra Styles -->
<style>
    .select2-container--bootstrap-5 .select2-selection { border-radius: 10px; }
    .table thead th { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: none; }
    .table tbody td { font-size: 0.9rem; border-top: 1px solid #f8f9fa; }
    .badge-modern { padding: 6px 12px; border-radius: 8px; font-weight: 600; }
    .status-tercapai { background-color: #d1fae5; color: #065f46; }
    .status-maksimal { background-color: #fef3c7; color: #92400e; }
    .status-gagal { background-color: #fee2e2; color: #991b1b; }
    .loading-overlay { position: relative; }
    .loading-overlay::after { content: ""; position: absolute; top:0; left:0; right:0; bottom:0; background: rgba(255,255,255,0.7); display: flex; align-items: center; justify-content: center; z-index: 10; }
</style>

@endsection

@push('scripts')
<!-- Include Select2 and SweetAlert2 if not in layout -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2-modern').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Dependent Dropdown: Klaster -> Program
    $('#id_klaster').on('change', function() {
        let id = $(this).val();
        $('#id_program').html('<option value=""></option>').prop('disabled', true);
        $('#id_indikator').html('<option value=""></option>').prop('disabled', true);
        if (id) {
            $.get('{{ route("laporan.master.programs", "") }}/' + id, function(data) {
                let options = '<option value="">Pilih Program</option>';
                data.forEach(item => {
                    options += `<option value="${item.id_program}">${item.nama_program}</option>`;
                });
                $('#id_program').html(options).prop('disabled', false);
            });
        }
    });

    // Dependent Dropdown: Program -> Indikator
    $('#id_program').on('change', function() {
        let id = $(this).val();
        $('#id_indikator').html('<option value=""></option>').prop('disabled', true);
        if (id) {
            $.get('{{ route("laporan.master.indikators", "") }}/' + id, function(data) {
                let options = '<option value="">Pilih Indikator</option>';
                data.forEach(item => {
                    options += `<option value="${item.id_indikator}">${item.nama_indikator}</option>`;
                });
                $('#id_indikator').html(options).prop('disabled', false);
            });
        }
    });

    // Fetch Data on View
    $('#btnView').on('click', function() {
        let formData = $('#filterForm').serialize();
        
        // Show Loading
        $('#reportContent').html('<tr><td colspan="13" class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><div class="mt-2">Sedang memuat data...</div></td></tr>');

        $.ajax({
            url: '{{ route("laporan.master.get-data") }}',
            type: 'GET',
            data: formData,
            success: function(response) {
                if (response.data.length > 0) {
                    let html = '';
                    response.data.forEach((item, index) => {
                        let targetTahunan = item.target?.target_tahunan || 0;
                        let targetBulanan = (targetTahunan / 12).toFixed(2);
                        let capaian = item.capaian_bulan || 0;
                        let persentase = targetBulanan > 0 ? ((capaian / targetBulanan) * 100).toFixed(1) : 0;
                        
                        let statusClass = 'status-gagal';
                        let statusText = 'Tidak Tercapai';
                        if (persentase >= 90) {
                            statusClass = 'status-tercapai';
                            statusText = 'Tercapai';
                        } else if (persentase >= 50) {
                            statusClass = 'status-maksimal';
                            statusText = 'Belum Maksimal';
                        }

                        html += `
                            <tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${item.target?.klaster?.nama_klaster || '-'}</td>
                                <td>${item.target?.program?.nama_program || '-'}</td>
                                <td>${item.target?.indikator?.nama_indikator || '-'}</td>
                                <td class="text-center">${item.updated_at.substring(0,4)}</td>
                                <td class="text-center">${item.bulan}</td>
                                <td>${item.desa?.nama_desa || '-'}</td>
                                <td class="text-center">${targetTahunan}</td>
                                <td class="text-center">${targetBulanan}</td>
                                <td class="text-center fw-bold text-primary">${capaian}</td>
                                <td class="text-center fw-bold">${persentase}%</td>
                                <td class="text-center">
                                    <span class="badge-modern ${statusClass}">${statusText}</span>
                                </td>
                                <td>${item.analisa_masalah || '-'}</td>
                            </tr>
                        `;
                    });
                    $('#reportContent').html(html);
                } else {
                    $('#reportContent').html('<tr><td colspan="13" class="text-center py-5 text-muted">Data tidak ditemukan untuk filter ini</td></tr>');
                }
            },
            error: function() {
                Swal.fire('Error', 'Gagal mengambil data', 'error');
                $('#reportContent').html('<tr><td colspan="13" class="text-center py-5 text-danger">Terjadi kesalahan sistem</td></tr>');
            }
        });
    });

    // Reset Function
    $('#btnReset').on('click', function() {
        $('#filterForm')[0].reset();
        $('.select2-modern').val(null).trigger('change');
        $('#reportContent').html('<tr><td colspan="13" class="text-center py-5"><div class="text-muted"><i class="fas fa-info-circle fa-3x mb-3 d-block opacity-25"></i><h5>Silakan pilih filter terlebih dahulu</h5></div></td></tr>');
    });

    // Submit Action (Mockup)
    $('#btnSubmit').on('click', function() {
        Swal.fire({
            title: 'Simpan Laporan?',
            text: "Anda akan menyimpan snapshot laporan ini.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#059669',
            confirmButtonText: 'Ya, Simpan!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire('Berhasil!', 'Laporan telah disimpan ke database (simulasi).', 'success');
            }
        });
    });

    // PDF/Excel Export (Simple redirection for now)
    $('#btnPdf').on('click', function() {
        let formData = $('#filterForm').serialize();
        window.open('{{ route("laporan.master.export.pdf") }}?' + formData, '_blank');
    });

    $('#btnExcel').on('click', function() {
        Swal.fire('Info', 'Export Excel sedang diproses...', 'info');
    });
});
</script>
@endpush
