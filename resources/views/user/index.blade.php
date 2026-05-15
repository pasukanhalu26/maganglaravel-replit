@extends('layouts.admin')
@section('header', 'Master User')
@section('content')
<div class="card border-0 shadow-sm mb-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold text-dark mb-0">Manajemen Pengguna</h5>
        <button class="btn btn-green px-4" data-bs-toggle="modal" data-bs-target="#modalUser">
            <i class="fas fa-plus-circle me-2"></i> Tambah User
        </button>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover table-borderless align-middle">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Kode ID Login</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Desa</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th>Created Date</th>
                    <th>Updated By</th>
                    <th>Updated Date</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $u)
                <tr>
                    <td class="text-center">{{ $data->firstItem() + $key }}</td>
                    <td class="text-center">
                        @if($u->username && str_starts_with($u->username, 'SIP-'))
                            <div class="position-relative d-inline-block">
                                <span class="badge copy-id" data-id="{{ $u->username }}" title="Klik untuk Copy ID" style="cursor: pointer; background: linear-gradient(135deg, #1a1035, #4B0082); font-size: 0.9rem; letter-spacing: 2px; font-family: monospace; padding: 9px 16px; box-shadow: 0 0 10px rgba(75,0,130,0.4); transition: 0.3s;">
                                    <i class="fas fa-fingerprint me-1"></i>{{ $u->username }}
                                </span>
                            </div>
                        @else
                            <span class="badge bg-secondary" style="font-family: monospace;"><i class="fas fa-hourglass me-1"></i>Auto</span>
                        @endif
                    </td>
                    <td class="fw-bold">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge bg-info text-dark">{{ strtoupper($u->role) }}</span></td>
                    <td><span class="badge bg-light text-dark border">{{ $u->desa->nama_desa ?? '-' }}</span></td>
                    <td>
                        <span class="badge {{ $u->status == 1 ? 'bg-success' : 'bg-danger' }}">
                            {{ $u->status == 1 ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </td>
                    <td><small>{{ $u->create_by ?? '-' }}</small></td>
                    <td><small>{{ $u->created_at ? $u->created_at->format('d-m-Y H:i') : '-' }}</small></td>
                    <td><small>{{ $u->update_by ?? '-' }}</small></td>
                    <td><small>{{ $u->updated_at ? $u->updated_at->format('d-m-Y H:i') : '-' }}</small></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <button class="btn btn-action btn-action-edit" data-bs-toggle="modal" data-bs-target="#editModalUser{{ $u->id }}" title="Edit"><i class="fas fa-edit"></i></button>
                            <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="form-delete" 
                                data-title="{{ $u->status == 1 ? 'Nonaktifkan User?' : 'Aktifkan User?' }}" 
                                data-text="{{ $u->status == 1 ? 'User ini tidak akan bisa login lagi.' : 'User ini akan bisa login kembali.' }}"
                                data-color="{{ $u->status == 1 ? '#dc3545' : '#28A745' }}"
                                data-confirm="{{ $u->status == 1 ? 'Ya, nonaktifkan' : 'Ya, aktifkan' }}">
                                @csrf @method('DELETE')
                                <button class="btn btn-action {{ $u->status == 1 ? 'btn-action-delete' : 'btn-action-restore' }}" title="{{ $u->status == 1 ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <i class="fas {{ $u->status == 1 ? 'fa-ban' : 'fa-check' }}"></i>
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

<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.store') }}" method="POST" class="modal-content modern-form-card">
            @csrf
            <div class="modal-header modern-form-header">
                <h6 class="modal-title">Tambah User Baru</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modern-form-body">
                <div class="alert" style="background: linear-gradient(135deg, #1a1035, #2D0B5A); border: 1px solid #6B21A8; border-radius: 12px; color: #E9D5FF;">
                    <i class="fas fa-info-circle me-2" style="color: #A855F7;"></i>
                    <strong>Kode ID Login</strong> digenerate otomatis oleh sistem.
                </div>
                
                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control form-control-modern" id="name" placeholder="Nama Lengkap" required>
                    <label for="name">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control form-control-modern" id="email" placeholder="Email (untuk login)" required>
                    <label for="email">Email (Bisa untuk login)</label>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="role" class="form-select form-select-modern" id="role" required>
                                <option value="admin">Admin</option>
                                <option value="pj_program">PJ Program</option>
                                <option value="staff_desa">Staff Desa</option>
                            </select>
                            <label for="role">Hak Akses (Role)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="id_desa" class="form-select form-select-modern" id="id_desa">
                                <option value="">Pilih Desa</option>
                                @foreach($desas as $d)
                                    <option value="{{ $d->id_desa }}">{{ $d->nama_desa }}</option>
                                @endforeach
                            </select>
                            <label for="id_desa">Wilayah Desa</label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password" class="form-control form-control-modern" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                
                <div class="row g-2">
                    <div class="col-6"><button type="button" class="btn-modern-cancel" data-bs-dismiss="modal">Batal</button></div>
                    <div class="col-6"><button type="submit" class="btn-modern-save">Simpan Data</button></div>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($data as $u)
<!-- Modal Edit User -->
<div class="modal fade" id="editModalUser{{ $u->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.update', $u->id) }}" method="POST" class="modal-content modern-form-card">
            @csrf @method('PUT')
            <div class="modal-header modern-form-header">
                <h6 class="modal-title">Edit User</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modern-form-body">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control form-control-modern bg-light" value="{{ $u->username }}" readonly>
                    <label>Kode ID Login (Terkunci)</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control form-control-modern" id="name{{ $u->id }}" value="{{ $u->name }}" placeholder="Nama Lengkap" required>
                    <label for="name{{ $u->id }}">Nama Lengkap</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control form-control-modern" id="email{{ $u->id }}" value="{{ $u->email }}" placeholder="Email" required>
                    <label for="email{{ $u->id }}">Email (Bisa untuk login)</label>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="role" class="form-select form-select-modern" id="role{{ $u->id }}" required>
                                <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="pj_program" {{ $u->role == 'pj_program' ? 'selected' : '' }}>PJ Program</option>
                                <option value="staff_desa" {{ $u->role == 'staff_desa' ? 'selected' : '' }}>Staff Desa</option>
                            </select>
                            <label for="role{{ $u->id }}">Hak Akses (Role)</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating">
                            <select name="id_desa" class="form-select form-select-modern" id="id_desa{{ $u->id }}">
                                <option value="">Pilih Desa</option>
                                @foreach($desas as $d)
                                    <option value="{{ $d->id_desa }}" {{ $u->id_desa == $d->id_desa ? 'selected' : '' }}>{{ $d->nama_desa }}</option>
                                @endforeach
                            </select>
                            <label for="id_desa{{ $u->id }}">Wilayah Desa</label>
                        </div>
                    </div>
                </div>

                <div class="form-floating mb-4">
                    <input type="password" name="password" class="form-control form-control-modern" id="pass{{ $u->id }}" placeholder="Kosongkan jika tidak ganti">
                    <label for="pass{{ $u->id }}">Password Baru (Kosongkan bila sama)</label>
                </div>
                
                <div class="row g-2">
                    <div class="col-6"><button type="button" class="btn-modern-cancel" data-bs-dismiss="modal">Batal</button></div>
                    <div class="col-6"><button type="submit" class="btn-modern-save">Update User</button></div>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function() {
    const copyBadges = document.querySelectorAll('.copy-id');
    
    copyBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            
            // Copy to clipboard
            navigator.clipboard.writeText(id).then(() => {
                // Show feedback
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
                this.style.background = 'linear-gradient(135deg, #28A745, #20c997)';
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.style.background = 'linear-gradient(135deg, #1a1035, #4B0082)';
                }, 1500);
            });
        });
    });
});
</script>
@endsection