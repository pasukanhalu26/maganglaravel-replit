@extends('layouts.admin')
@section('header', 'Master Data Target')
@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0">Manajemen Target</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('target.create') }}" class="btn btn-green px-4"><i class="fas fa-plus-circle me-2"></i> Tambah Target</a>
        </div>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('target.index') }}" method="GET" class="mb-4">
            <div class="input-group shadow-sm" style="max-width: 400px;">
                <input type="text" name="katakunci" class="form-control border-end-0" placeholder="Cari ID atau Nama..." value="{{ Request::get('katakunci') }}">
                <button class="btn btn-green" type="submit"><i class="fas fa-search me-1"></i> Cari</button>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle">
                <thead class="text-center">
                    <tr>
                        <th>
                            <button type="button" id="toggleColumns" class="btn btn-sm btn-light border rounded-circle shadow-sm" style="width: 32px; height: 32px; padding: 0;" title="Sembunyikan/Tampilkan Relasi">
                                <i class="fas fa-chevron-left text-primary" id="toggleIcon" style="font-size: 0.85rem;"></i>
                            </button>
                            <div class="mt-1">No</div>
                        </th>
                        <th class="relation-col">Klaster</th>
                        <th class="relation-col">Program</th>
                        <th class="relation-col">Indikator</th>
                        <th>ID Target</th>
                        <th>Periode</th>
                        <th>Target Tahunan</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Updated By</th>
                        <th>Updated Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $t)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $key }}</td>
                        <td class="text-center relation-col">
                            <span class="badge" style="background: linear-gradient(135deg, #92400e, #b45309); font-family: monospace; font-size: 0.82rem; padding: 6px 10px;">
                                #{{ str_pad($t->id_klaster, 3, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="mt-1 small text-dark fw-bold text-wrap relation-name" style="font-size: 0.75rem; max-width: 150px; margin: 0 auto;">
                                {{ $t->klaster->nama_klaster ?? '-' }}
                            </div>
                        </td>
                        <td class="text-center relation-col">
                            <span class="badge" style="background: linear-gradient(135deg, #0e7490, #0891b2); font-family: monospace; font-size: 0.82rem; padding: 6px 10px;">
                                #{{ str_pad($t->id_program, 3, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="mt-1 small text-dark fw-bold text-wrap relation-name" style="font-size: 0.75rem; max-width: 150px; margin: 0 auto;">
                                {{ $t->program->nama_program ?? '-' }}
                            </div>
                        </td>
                        <td class="text-center relation-col">
                            <span class="badge" style="background: linear-gradient(135deg, #065f46, #059669); font-family: monospace; font-size: 0.82rem; padding: 6px 10px;">
                                #{{ str_pad($t->id_indikator, 3, '0', STR_PAD_LEFT) }}
                            </span>
                            <div class="mt-1 small text-dark fw-bold text-wrap relation-name" style="font-size: 0.75rem; max-width: 150px; margin: 0 auto;">
                                {{ $t->indikator->nama_indikator ?? '-' }}
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge" style="background: linear-gradient(135deg, #703799, #5D2E80); font-family: monospace; font-size: 0.85rem; padding: 7px 12px; letter-spacing: 1px;">
                                #{{ str_pad($t->id_target, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </td>
                        <td class="text-center fw-bold">{{ $t->periode }}</td>
                        <td class="text-center">
                            <span class="fw-bold fs-6" style="color: var(--accent-green);">{{ number_format($t->target_tahunan) }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $t->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $t->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="text-center"><small>{{ $t->create_by ?? '-' }}</small></td>
                        <td class="text-center"><small>{{ $t->created_at ? $t->created_at->format('d-m-Y H:i') : '-' }}</small></td>
                        <td class="text-center"><small>{{ $t->update_by ?? '-' }}</small></td>
                        <td class="text-center"><small>{{ $t->updated_at ? $t->updated_at->format('d-m-Y H:i') : '-' }}</small></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('target.edit', $t->id_target) }}" class="btn btn-action btn-action-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('target.destroy', $t->id_target) }}" method="POST" class="form-delete"
                                    data-title="{{ $t->status == 1 ? 'Nonaktifkan Target?' : 'Aktifkan Target?' }}"
                                    data-text="{{ $t->status == 1 ? 'Target ini tidak akan aktif.' : 'Target ini akan aktif kembali.' }}"
                                    data-color="{{ $t->status == 1 ? '#dc3545' : '#28A745' }}"
                                    data-confirm="{{ $t->status == 1 ? 'Ya, nonaktifkan' : 'Ya, aktifkan' }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-action {{ $t->status == 1 ? 'btn-action-delete' : 'btn-action-restore' }}">
                                        <i class="fas {{ $t->status == 1 ? 'fa-ban' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $data->links() }}
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btnToggle = document.getElementById('toggleColumns');
    if (btnToggle) {
        const icon = document.getElementById('toggleIcon');
        const relationCols = document.querySelectorAll('.relation-col');

        btnToggle.addEventListener('click', function() {
            let isHidden = false;
            relationCols.forEach(el => {
                if(el.classList.contains('d-none')) {
                    el.classList.remove('d-none');
                } else {
                    el.classList.add('d-none');
                    isHidden = true;
                }
            });

            if(isHidden) {
                icon.classList.remove('fa-chevron-left');
                icon.classList.add('fa-chevron-right');
                icon.classList.remove('text-primary');
                icon.classList.add('text-danger');
            } else {
                icon.classList.remove('fa-chevron-right');
                icon.classList.add('fa-chevron-left');
                icon.classList.remove('text-danger');
                icon.classList.add('text-primary');
            }
        });
    }
});
</script>
@endsection
