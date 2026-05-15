<?php $__env->startSection('header', 'Tambah Target'); ?>
<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="modern-form-card">
            <div class="modern-form-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Data Target</h6>
                <a href="<?php echo e(route('target.index')); ?>" class="btn btn-sm btn-light text-green rounded-pill px-3 shadow-sm"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
            </div>
            <div class="modern-form-body">

                <?php if($errors->any()): ?>
                    <div class="alert alert-danger border-0 rounded-3 mb-4">
                        <ul class="mb-0 small"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('target.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    
                    <div class="mb-4 p-3 d-flex align-items-center gap-3" style="background: linear-gradient(135deg, #F9F5FF, #F2EAF9); border-radius: 12px; border: 1px dashed #C4A0E8;">
                        <div>
                            <div class="text-muted" style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.8px; font-weight: 600;">ID Target</div>
                            <div style="font-family: monospace; font-size: 1.1rem; font-weight: 700; color: #A39DB0; letter-spacing: 2px;">#AUTO</div>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: #F2EAF9; color: #703799; border: 1px solid #C4A0E8; font-size: 0.7rem;">
                                <i class="fas fa-magic me-1"></i>Auto Generate
                            </span>
                        </div>
                    </div>

                    
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="text-muted small fw-bold mb-1">Pilih Klaster</label>
                            <select name="id_klaster" id="id_klaster" class="form-select form-select-modern select-searchable" required>
                                <option value="">Pilih Klaster</option>
                                <?php $__currentLoopData = $klasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($k->id_klaster); ?>" <?php echo e(old('id_klaster') == $k->id_klaster ? 'selected' : ''); ?>>
                                        <?php echo e($k->nama_klaster); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small fw-bold mb-1">Pilih Program</label>
                            <select name="id_program" id="id_program" class="form-select form-select-modern select-searchable" required>
                                <option value="">Pilih Program</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="text-muted small fw-bold mb-1">Pilih Indikator</label>
                            <select name="id_indikator" id="id_indikator" class="form-select form-select-modern select-searchable" required>
                                <option value="">Pilih Indikator</option>
                            </select>
                        </div>
                    </div>

                    
                    <div class="row g-3 mb-5">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="periode" id="periode" class="form-control form-control-modern"
                                    value="<?php echo e(old('periode', date('Y'))); ?>" placeholder="2025" min="2000" max="2100" required>
                                <label for="periode">Periode (Tahun)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="number" name="target_tahunan" id="target_tahunan" class="form-control form-control-modern"
                                    value="<?php echo e(old('target_tahunan')); ?>" placeholder="940" min="0" required>
                                <label for="target_tahunan">Target Tahunan</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6"><a href="<?php echo e(route('target.index')); ?>" class="btn-modern-cancel">Batal</a></div>
                        <div class="col-md-6"><button type="submit" class="btn-modern-save"><i class="fas fa-save me-2"></i>Simpan Target</button></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const klasterSelect = document.getElementById('id_klaster');
    const programSelect = document.getElementById('id_program');
    const indikatorSelect = document.getElementById('id_indikator');
    
    let programTomSelect = null;
    let indikatorTomSelect = null;
    
    setTimeout(() => {
        if(programSelect.tomselect) programTomSelect = programSelect.tomselect;
        if(indikatorSelect.tomselect) indikatorTomSelect = indikatorSelect.tomselect;
    }, 100);

    klasterSelect.addEventListener('change', function() {
        const idKlaster = this.value;
        
        if(programTomSelect) { programTomSelect.clearOptions(); programTomSelect.clear(); }
        if(indikatorTomSelect) { indikatorTomSelect.clearOptions(); indikatorTomSelect.clear(); }

        if(idKlaster) {
            fetch(`/api/programs/${idKlaster}`)
                .then(res => res.json())
                .then(data => {
                    if(programTomSelect) {
                        data.forEach(p => programTomSelect.addOption({value: p.id_program, text: `${p.nama_program}`}));
                        programTomSelect.refreshOptions(false);
                    }
                });
        }
    });

    programSelect.addEventListener('change', function() {
        const idProgram = this.value;
        
        if(indikatorTomSelect) { indikatorTomSelect.clearOptions(); indikatorTomSelect.clear(); }

        if(idProgram) {
            fetch(`/api/indikators/${idProgram}`)
                .then(res => res.json())
                .then(data => {
                    if(indikatorTomSelect) {
                        data.forEach(i => indikatorTomSelect.addOption({value: i.id_indikator, text: `${i.nama_indikator.substring(0,60)}`}));
                        indikatorTomSelect.refreshOptions(false);
                    }
                });
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/target/create.blade.php ENDPATH**/ ?>