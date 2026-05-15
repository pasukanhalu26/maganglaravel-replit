<?php $__env->startSection('header', 'Import Capaian'); ?>
<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0">Bulk Input Capaian Bulanan</h5>
        <div class="d-flex gap-2">
            <a href="<?php echo e(route('capaian.index')); ?>" class="btn btn-secondary px-4"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
        </div>
    </div>
    <div class="card-body p-4">
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tutorial / Panduan Penggunaan -->
        <div class="alert alert-light border shadow-sm mb-4 p-4">
            <h6 class="fw-bold text-dark mb-3"><i class="fas fa-chalkboard-teacher text-success me-2"></i> Panduan Penggunaan Fitur Import Excel</h6>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.8rem; font-weight: bold;">1</div>
                        <div>
                            <p class="fw-bold mb-1 small">Download Template</p>
                            <p class="text-secondary small mb-0">Klik tombol "Download Template Excel" untuk mendapatkan format yang benar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.8rem; font-weight: bold;">2</div>
                        <div>
                            <p class="fw-bold mb-1 small">Isi Data Capaian</p>
                            <p class="text-secondary small mb-0">Isi data pada kolom yang berwarna <strong>Hijau</strong>. Jangan mengubah kolom lain terutama <strong>ID TARGET</strong>.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-start">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px; flex-shrink: 0; font-size: 0.8rem; font-weight: bold;">3</div>
                        <div>
                            <p class="fw-bold mb-1 small">Upload & Selesai</p>
                            <p class="text-secondary small mb-0">Pilih Desa dan Bulan, lalu upload file Excel Anda. Sistem akan menghitung Kumulatif secara otomatis.</p>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-3 opacity-25">
            <div class="d-flex align-items-center text-danger small">
                <i class="fas fa-info-circle me-2"></i>
                <span><strong>Penting:</strong> Pastikan kolom "Pencapaian Bulanan" hanya berisi angka. Jika diisi huruf, import akan gagal.</span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-5 mb-4">
                <div class="p-4 bg-light rounded border h-100 shadow-sm">
                    <h6 class="fw-bold text-primary mb-3"><i class="fas fa-download me-2"></i> Download Template Alat Bantu</h6>
                    <p class="text-secondary small mb-4">Gunakan template ini agar struktur data terbaca dengan benar oleh sistem. Template sudah berisi daftar indikator aktif.</p>
                    <a href="<?php echo e(route('capaian.template')); ?>" class="btn btn-outline-success w-100 py-2 fw-bold">
                        <i class="fas fa-file-excel me-2"></i> Download Template Excel
                    </a>
                </div>
            </div>

            <div class="col-md-7">
                <div class="p-4 bg-white rounded border border-success border-opacity-25 shadow-sm h-100">
                    <h6 class="fw-bold text-success mb-3"><i class="fas fa-upload me-2"></i> Form Upload Data Capaian</h6>
                    
                    <form action="<?php echo e(route('capaian.import.process')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <?php if(Auth::user()->id_desa): ?>
                            <input type="hidden" name="id_desa" value="<?php echo e(Auth::user()->id_desa); ?>">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Desa</label>
                                <input type="text" class="form-control bg-light" value="<?php echo e(Auth::user()->desa->nama_desa ?? '-'); ?>" readonly>
                            </div>
                        <?php else: ?>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary small">Pilih Desa <span class="text-danger">*</span></label>
                                <select name="id_desa" class="form-select <?php $__errorArgs = ['id_desa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Pilih Desa --</option>
                                    <?php $__currentLoopData = $desas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($desa->id_desa); ?>"><?php echo e($desa->nama_desa); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['id_desa'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-secondary small">Bulan Pelaporan <span class="text-danger">*</span></label>
                            <select name="bulan" class="form-select <?php $__errorArgs = ['bulan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">-- Pilih Bulan --</option>
                                <?php
                                    $bulans = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                               7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                                ?>
                                <?php $__currentLoopData = $bulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($key); ?>"><?php echo e($val); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['bulan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">File Excel (.xlsx / .xls) <span class="text-danger">*</span></label>
                            <input type="file" name="file_excel" class="form-control <?php $__errorArgs = ['file_excel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept=".xlsx, .xls" required>
                            <?php $__errorArgs = ['file_excel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <button type="submit" class="btn btn-success w-100 py-2 fw-bold shadow-sm">
                            <i class="fas fa-cloud-upload-alt me-2"></i> Mulai Proses Import Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/capaian/import.blade.php ENDPATH**/ ?>