@extends('layouts.admin')
@section('header', 'Data Capaian')
@section('content')
<div class="container-fluid">
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white py-4 border-0 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark mb-1"><i class="fas fa-database text-success me-2"></i>Manajemen Capaian Bulanan</h5>
                <p class="text-muted small mb-0">Kelola data pencapaian program kesehatan di setiap desa.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('capaian.import') }}" class="btn btn-outline-success rounded-pill px-4 shadow-sm fw-bold border-2">
                    <i class="fas fa-file-excel me-2"></i> Import Excel
                </a>
                <a href="{{ route('capaian.create') }}" class="btn btn-success rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fas fa-plus-circle me-2"></i> Tambah Data
                </a>
            </div>
        </div>
        <div class="card-body p-4 pt-0">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <form action="{{ route('capaian.index') }}" method="GET">
                        <div class="input-group bg-light rounded-pill p-1 shadow-sm border">
                            <span class="input-group-text bg-transparent border-0"><i class="fas fa-search text-muted ms-2"></i></span>
                            <input type="text" name="katakunci" class="form-control bg-transparent border-0" placeholder="Cari Indikator, Desa, atau ID..." value="{{ Request::get('katakunci') }}">
                            <button class="btn btn-success rounded-pill px-4" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive rounded-4 border overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-dark" style="font-size: 0.85rem; font-weight: 700;">
                            <th class="py-3 ps-4" style="width: 80px;">ID</th>
                            <th class="py-3">KLASTER / PROGRAM</th>
                            <th class="py-3">INDIKATOR</th>
                            <th class="py-3 text-center">TARGET TAHUNAN</th>
                            <th class="py-3 text-center">BULAN/TAHUN</th>
                            <th class="py-3">DESA</th>
                            <th class="py-3 text-center">CAPAIAN</th>
                            <th class="py-3 text-center" style="width: 100px;">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $currentBulan = null;
                            $bulans = [1=>'JANUARI',2=>'FEBRUARI',3=>'MARET',4=>'APRIL',5=>'MEI',6=>'JUNI',
                                      7=>'JULI',8=>'AGUSTUS',9=>'SEPTEMBER',10=>'OKTOBER',11=>'NOVEMBER',12=>'DESEMBER'];
                        @endphp
                        
                        @forelse($data as $key => $item)
                        @php
                            $target = $item->target->target_tahunan ?? 0;
                            $capaian_bulanan = $item->capaian_bulan;
                            $bulanStr = strtoupper($bulans[$item->bulan] ?? $item->bulan);
                            $tahun = $item->target->periode ?? '2025';
                        @endphp
                        
                        @if($currentBulan != $bulanStr)
                            <tr class="bg-success bg-opacity-10">
                                <td colspan="8" class="fw-bold text-success py-2 ps-4" style="font-size: 0.75rem; letter-spacing: 1px;">
                                    <i class="fas fa-calendar-alt me-2"></i> BULAN {{ $bulanStr }}
                                </td>
                            </tr>
                            @php $currentBulan = $bulanStr; @endphp
                        @endif

                        <tr class="bg-white">
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border px-2">#{{ $item->id_capaian }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark mb-0 small">{{ $item->target->klaster->nama_klaster ?? '-' }}</div>
                                <div class="text-muted" style="font-size: 0.7rem;">{{ $item->target->program->nama_program ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="text-dark small" style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $item->target->indikator->nama_indikator ?? '-' }}">
                                    {{ $item->target->indikator->nama_indikator ?? '-' }}
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="fw-bold text-dark">{{ number_format($target) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="badge bg-white text-success border border-success border-opacity-25 px-2">{{ $bulanStr }}</div>
                                <div class="text-muted mt-1" style="font-size: 0.65rem;">TAHUN {{ $tahun }}</div>
                            </td>
                            <td>
                                <span class="small fw-bold text-dark"><i class="fas fa-map-marker-alt text-danger me-1"></i> {{ $item->desa->nama_desa ?? '-' }}</span>
                            </td>
                            <td class="text-center">
                                <div class="fw-bold text-primary fs-5">{{ number_format($capaian_bulanan) }}</div>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle shadow-sm border" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="width: 32px; height: 32px;">
                                        <i class="fas fa-ellipsis-v text-secondary" style="font-size: 0.8rem;"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                        <li><a class="dropdown-item py-2" href="{{ route('capaian.edit', $item->id_capaian) }}"><i class="fas fa-edit text-primary me-2"></i> Edit Data</a></li>
                                        <li><hr class="dropdown-divider opacity-25"></li>
                                        <li>
                                            <form action="{{ route('capaian.destroy', $item->id_capaian) }}" method="POST" class="d-inline form-delete">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-trash-alt me-2"></i> Hapus Data</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <h5>Belum ada data capaian</h5>
                                    <p class="small">Silakan tambah data baru atau sesuaikan filter pencarian.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.form-delete').forEach(form => {
    form.addEventListener('submit', function(e) {
        if(!confirm('Apakah Anda yakin ingin menghapus data ini?')) {
            e.preventDefault();
        }
    });
});
</script>

<style>
    .pagination { margin-bottom: 0; }
    .page-link { border-radius: 8px !important; margin: 0 3px; border: none; color: #198754; background: #f8f9fa; font-weight: 600; }
    .page-item.active .page-link { background-color: #198754; color: white; }
    .table thead th { border-bottom: none; }
    .table tbody tr { transition: all 0.2s; }
    .table tbody tr:hover { background-color: #f8f9fa !important; }
</style>
@endsection