@extends('layouts.admin')

@section('header', 'Master Data Klaster')

@section('content')
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0">Manajemen Klaster</h5>
        <a href="{{ route('klaster.create') }}" class="btn btn-green px-4"><i class="fas fa-plus-circle me-2"></i> Tambah Klaster</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-borderless align-middle">
                <thead class="text-center">
<tr>
                        <th>No</th>
                        <th>ID Klaster</th>
                        <th>Nama Klaster</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Updated By</th>
                        <th>Updated Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $k)
                    <tr>
                        <td class="text-center">{{ $data->firstItem() + $key }}</td>
                        <td class="text-center">
                            <div class="position-relative d-inline-block">
                                <span class="badge copy-id" data-id="{{ str_pad($k->id_klaster, 3, '0', STR_PAD_LEFT) }}" title="Klik untuk Copy ID" style="cursor: pointer; background: linear-gradient(135deg, #703799, #5D2E80); font-family: monospace; font-size: 0.85rem; padding: 7px 12px; letter-spacing: 1px; transition: 0.3s;">
                                    #{{ str_pad($k->id_klaster, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </div>
                        </td>
                        <td class="fw-semibold">{{ $k->nama_klaster }}</td>
                        <td class="text-center">
                            <span class="badge {{ $k->status == 1 ? 'bg-success' : 'bg-danger' }}">
                                {{ $k->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="text-center small">{{ $k->create_by ?? '-' }}</td>
                        <td class="text-center small">{{ $k->created_at ? $k->created_at->format('d-m-Y H:i') : '-' }}</td>
                        <td class="text-center small">{{ $k->update_by ?? '-' }}</td>
                        <td class="text-center small">{{ $k->updated_at ? $k->updated_at->format('d-m-Y H:i') : '-' }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('klaster.edit', $k->id_klaster) }}" class="btn btn-action btn-action-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('klaster.destroy', $k->id_klaster) }}" method="POST" class="form-delete" 
                                    data-title="{{ $k->status == 1 ? 'Nonaktifkan Klaster?' : 'Aktifkan Klaster?' }}" 
                                    data-text="{{ $k->status == 1 ? 'Klaster ini tidak akan bisa digunakan lagi.' : 'Klaster ini akan aktif kembali.' }}"
                                    data-color="{{ $k->status == 1 ? '#dc3545' : '#28A745' }}"
                                    data-confirm="{{ $k->status == 1 ? 'Ya, nonaktifkan' : 'Ya, aktifkan' }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-action {{ $k->status == 1 ? 'btn-action-delete' : 'btn-action-restore' }}" title="{{ $k->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <i class="fas {{ $k->status == 1 ? 'fa-ban' : 'fa-check' }}"></i>
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