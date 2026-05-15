@extends('layouts.admin')
@section('header', 'Master Data Desa')
@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0">Manajemen Desa</h5>
        <a href="{{ route('desa.create') }}" class="btn btn-green px-4"><i class="fas fa-plus-circle me-2"></i> Tambah Desa</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle">
                <thead class="text-center">
<tr>
                    <th>No</th>
                    <th>ID Desa</th>
                    <th>Nama Desa</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Updated By</th>
                    <th>Updated Date</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $d)
                <tr>
<td class="text-center">{{ $data->firstItem() + $key }}</td>
                    <td class="text-center">
                        <div class="position-relative d-inline-block">
                            <span class="badge copy-id" data-id="{{ str_pad($d->id_desa, 3, '0', STR_PAD_LEFT) }}" title="Klik untuk Copy ID" style="cursor: pointer; background: #6f42c1; font-family: monospace; font-size: 0.85rem; padding: 7px 12px; letter-spacing: 1px; transition: 0.3s;">
                                #{{ str_pad($d->id_desa, 3, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </td>
                    <td class="fw-semibold">{{ $d->nama_desa }}</td>
                    <td class="text-center">
                        <span class="badge {{ $d->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $d->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td class="text-center small">{{ $d->create_by ?? '-' }}</td>
                    <td class="text-center small">{{ $d->created_at ? $d->created_at->format('d-m-Y H:i') : '-' }}</td>
                    <td class="text-center small">{{ $d->update_by ?? '-' }}</td>
                    <td class="text-center small">{{ $d->updated_at ? $d->updated_at->format('d-m-Y H:i') : '-' }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="{{ route('desa.edit', $d->id_desa) }}" class="btn btn-action btn-action-edit" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('desa.destroy', $d->id_desa) }}" method="POST" class="form-delete" 
                                data-title="{{ $d->status == 1 ? 'Nonaktifkan Desa?' : 'Aktifkan Desa?' }}" 
                                data-text="{{ $d->status == 1 ? 'Desa ini tidak akan bisa dipilih lagi.' : 'Desa ini akan aktif kembali.' }}"
                                data-color="{{ $d->status == 1 ? '#dc3545' : '#28A745' }}"
                                data-confirm="{{ $d->status == 1 ? 'Ya, nonaktifkan' : 'Ya, aktifkan' }}">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-action {{ $d->status == 1 ? 'btn-action-delete' : 'btn-action-restore' }}" title="{{ $d->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas {{ $d->status == 1 ? 'fa-ban' : 'fa-check' }}"></i>
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
    const copyBadges = document.querySelectorAll('.copy-id');
    
    copyBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            navigator.clipboard.writeText(id).then(() => {
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
                this.style.background = 'linear-gradient(135deg, #28A745, #20c997)';
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.background = 'linear-gradient(135deg, #703799, #5D2E80)';
                }, 1500);
            });
        });
    });
});
</script>
@endsection