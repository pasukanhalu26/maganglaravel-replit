<?php $__env->startSection('header', 'Master Data Klaster'); ?>

<?php $__env->startSection('content'); ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold text-dark mb-0">Manajemen Klaster</h5>
        <a href="<?php echo e(route('klaster.create')); ?>" class="btn btn-green px-4"><i class="fas fa-plus-circle me-2"></i> Tambah Klaster</a>
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
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="text-center"><?php echo e($data->firstItem() + $key); ?></td>
                        <td class="text-center">
                            <div class="position-relative d-inline-block">
                                <span class="badge copy-id" data-id="<?php echo e(str_pad($k->id_klaster, 3, '0', STR_PAD_LEFT)); ?>" title="Klik untuk Copy ID" style="cursor: pointer; background: linear-gradient(135deg, #703799, #5D2E80); font-family: monospace; font-size: 0.85rem; padding: 7px 12px; letter-spacing: 1px; transition: 0.3s;">
                                    #<?php echo e(str_pad($k->id_klaster, 3, '0', STR_PAD_LEFT)); ?>

                                </span>
                            </div>
                        </td>
                        <td class="fw-semibold"><?php echo e($k->nama_klaster); ?></td>
                        <td class="text-center">
                            <span class="badge <?php echo e($k->status == 1 ? 'bg-success' : 'bg-danger'); ?>">
                                <?php echo e($k->status == 1 ? 'Aktif' : 'Non-Aktif'); ?>

                            </span>
                        </td>
                        <td class="text-center small"><?php echo e($k->create_by ?? '-'); ?></td>
                        <td class="text-center small"><?php echo e($k->created_at ? $k->created_at->format('d-m-Y H:i') : '-'); ?></td>
                        <td class="text-center small"><?php echo e($k->update_by ?? '-'); ?></td>
                        <td class="text-center small"><?php echo e($k->updated_at ? $k->updated_at->format('d-m-Y H:i') : '-'); ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="<?php echo e(route('klaster.edit', $k->id_klaster)); ?>" class="btn btn-action btn-action-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <form action="<?php echo e(route('klaster.destroy', $k->id_klaster)); ?>" method="POST" class="form-delete" 
                                    data-title="<?php echo e($k->status == 1 ? 'Nonaktifkan Klaster?' : 'Aktifkan Klaster?'); ?>" 
                                    data-text="<?php echo e($k->status == 1 ? 'Klaster ini tidak akan bisa digunakan lagi.' : 'Klaster ini akan aktif kembali.'); ?>"
                                    data-color="<?php echo e($k->status == 1 ? '#dc3545' : '#28A745'); ?>"
                                    data-confirm="<?php echo e($k->status == 1 ? 'Ya, nonaktifkan' : 'Ya, aktifkan'); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-action <?php echo e($k->status == 1 ? 'btn-action-delete' : 'btn-action-restore'); ?>" title="<?php echo e($k->status == 1 ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                        <i class="fas <?php echo e($k->status == 1 ? 'fa-ban' : 'fa-check'); ?>"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php echo e($data->links()); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/klaster/index.blade.php ENDPATH**/ ?>