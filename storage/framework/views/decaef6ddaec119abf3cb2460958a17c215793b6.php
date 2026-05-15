<?php $__env->startSection('header', 'Tambah Capaian'); ?>
<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-header bg-white py-4 border-0 d-flex justify-content-between align-items-center" style="border-bottom: 2px solid #f1f5f9 !important;">
                <div>
                    <h5 class="fw-bold text-dark mb-1"><i class="fas fa-plus-circle text-success me-2"></i>Tambah Data Capaian</h5>
                    <p class="text-muted small mb-0">Lengkapi form di bawah ini untuk menambahkan data capaian bulanan secara berurutan.</p>
                </div>
                <a href="<?php echo e(route('capaian.index')); ?>" class="btn btn-light text-secondary rounded-pill px-4 shadow-sm fw-bold">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
            
            <div class="card-body p-5 bg-light">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger border-0 rounded-3 mb-4 shadow-sm">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <h6 class="mb-0 fw-bold">Terjadi Kesalahan</h6>
                        </div>
                        <ul class="mb-0 small"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('capaian.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    
                    <div class="row g-4">
                        <!-- Left Column: Master Data Selection -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-success mb-4 border-bottom pb-2">
                                        <span class="bg-success text-white rounded-circle d-inline-flex justify-content-center align-items-center me-2" style="width:24px;height:24px;font-size:0.8rem">1</span> 
                                        Pilih Indikator & Target
                                    </h6>
                                    
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Klaster</label>
                                        <select id="filter_klaster" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem">
                                            <option value="">-- Pilih Klaster --</option>
                                            <?php $__currentLoopData = $klasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($k->id_klaster); ?>"><?php echo e($k->nama_klaster); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Program</label>
                                        <select id="filter_program" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem" disabled>
                                            <option value="">-- Pilih Program --</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Indikator</label>
                                        <select id="filter_indikator" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem" disabled>
                                            <option value="">-- Pilih Indikator --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark small">Periode Tahun (Target)</label>
                                        <select name="id_target" id="id_target" class="form-select form-select-lg rounded-3 shadow-sm border-success bg-white" style="font-size:0.9rem; border-width: 2px;" required disabled>
                                            <option value="">-- Pilih Target Tahun --</option>
                                        </select>
                                        <div class="form-text small text-success mt-1"><i class="fas fa-check-circle me-1"></i> Wajib Dipilih</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column: Input Data -->
                        <div class="col-lg-6">
                            <div class="card border-0 shadow-sm rounded-4 h-100">
                                <div class="card-body p-4">
                                    <h6 class="fw-bold text-primary mb-4 border-bottom pb-2">
                                        <span class="bg-primary text-white rounded-circle d-inline-flex justify-content-center align-items-center me-2" style="width:24px;height:24px;font-size:0.8rem">2</span> 
                                        Input Nilai Capaian
                                    </h6>
                                    
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark small">Desa</label>
                                            <?php if($userDesaId): ?>
                                                <input type="hidden" name="id_desa" id="id_desa" value="<?php echo e($userDesaId); ?>">
                                                <input type="text" class="form-control rounded-3 border-0 shadow-sm bg-light" value="<?php echo e(Auth::user()->desa->nama_desa ?? '-'); ?>" readonly>
                                            <?php else: ?>
                                                <select name="id_desa" id="id_desa" class="form-select rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem" required>
                                                    <option value="">-- Pilih Desa --</option>
                                                    <?php $__currentLoopData = $desas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($d->id_desa); ?>"><?php echo e($d->nama_desa); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold text-dark small">Bulan Pelaporan</label>
                                            <select name="bulan" class="form-select rounded-3 shadow-sm border-0 bg-light" style="font-size:0.9rem" required>
                                                <option value="">-- Pilih Bulan --</option>
                                                <?php
                                                    $bulans = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                                              7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                                                ?>
                                                <?php $__currentLoopData = $bulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($num); ?>" <?php echo e(old('bulan') == $num ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="infoPanel" class="mb-4 p-3 rounded-4 shadow-sm" style="background:linear-gradient(135deg,#f0fdf4,#dcfce7); border:1px solid #bbf7d0; display:none; transition: all 0.3s ease;">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="fw-bold small text-success"><i class="fas fa-bullseye me-2"></i>Info Target Puskesmas</span>
                                        </div>
                                        <div class="row g-2 text-center">
                                            <div class="col-6">
                                                <div class="p-2 bg-white rounded-3 shadow-sm">
                                                    <div class="text-muted" style="font-size:0.65rem;text-transform:uppercase;">Target Tahunan</div>
                                                    <div id="info_target" class="fw-bold text-dark" style="font-size:1.1rem">-</div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="p-2 bg-white rounded-3 shadow-sm border border-success">
                                                    <div class="text-success fw-bold" style="font-size:0.65rem;text-transform:uppercase;">Estimasi Target/Bulan</div>
                                                    <div id="info_per_bulan" class="fw-bold text-success" style="font-size:1.1rem">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Pencapaian Bulanan (Angka)</label>
                                        <div class="input-group shadow-sm rounded-3">
                                            <button type="button" class="btn btn-light border-end" onclick="stepValue('capaian_bulan', -1)">
                                                <i class="fas fa-minus text-danger"></i>
                                            </button>
                                            <input type="number" name="capaian_bulan" id="capaian_bulan" class="form-control border-0 text-center fw-bold text-primary"
                                                value="<?php echo e(old('capaian_bulan', 0)); ?>" placeholder="0" min="0" required style="font-size: 1.5rem; height: 60px;">
                                            <button type="button" class="btn btn-light border-start" onclick="stepValue('capaian_bulan', 1)">
                                                <i class="fas fa-plus text-success"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-dark small">Analisa Masalah <span class="text-muted fw-normal">(Opsional)</span></label>
                                        <textarea name="analisa_masalah" class="form-control rounded-3 border-0 shadow-sm bg-light" rows="2" placeholder="Ketikan kendala jika belum tercapai..."><?php echo e(old('analisa_masalah')); ?></textarea>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small">Rencana Tindak Lanjut (RTL) <span class="text-muted fw-normal">(Opsional)</span></label>
                                        <textarea name="rtl" class="form-control rounded-3 border-0 shadow-sm bg-light" rows="2" placeholder="Ketikan solusi bulan depan..."><?php echo e(old('rtl')); ?></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 mt-4 text-end">
                            <hr class="mb-4 opacity-25">
                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow fw-bold">
                                <i class="fas fa-save me-2"></i> Simpan Capaian
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function stepValue(id, delta) {
    const el = document.getElementById(id);
    let val = parseInt(el.value) || 0;
    val += delta;
    if (val < 0) val = 0;
    el.value = val;
}

document.addEventListener('DOMContentLoaded', function() {
    const filterKlaster = document.getElementById('filter_klaster');
    const filterProgram = document.getElementById('filter_program');
    const filterIndikator = document.getElementById('filter_indikator');
    const selectTarget = document.getElementById('id_target');
    const infoPanel = document.getElementById('infoPanel');
    const fmt = v => new Intl.NumberFormat('id-ID').format(v);

    let targetMap = {};

    function updateInfoTarget() {
        const idTarget = selectTarget.value;

        if (idTarget && targetMap[idTarget]) {
            const t = targetMap[idTarget];
            const targetBulan = Math.round(t.target_tahunan / 12);
            document.getElementById('info_target').textContent = fmt(t.target_tahunan);
            document.getElementById('info_per_bulan').textContent = '± ' + fmt(targetBulan);
            infoPanel.style.display = 'block';
        } else {
            infoPanel.style.display = 'none';
        }
    }

    // 1. Klaster -> Program
    filterKlaster.addEventListener('change', function() {
        const idKlaster = this.value;
        
        // Reset children
        filterProgram.innerHTML = '<option value="">-- Pilih Program --</option>';
        filterProgram.disabled = true;
        filterIndikator.innerHTML = '<option value="">-- Pilih Indikator --</option>';
        filterIndikator.disabled = true;
        selectTarget.innerHTML = '<option value="">-- Pilih Target Tahun --</option>';
        selectTarget.disabled = true;
        infoPanel.style.display = 'none';

        if(idKlaster) {
            filterProgram.innerHTML = '<option value="">Loading...</option>';
            fetch(`/api/programs/${idKlaster}`)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Program --</option>';
                    data.forEach(p => html += `<option value="${p.id_program}">${p.nama_program}</option>`);
                    filterProgram.innerHTML = html;
                    filterProgram.disabled = false;
                });
        }
    });

    // 2. Program -> Indikator
    filterProgram.addEventListener('change', function() {
        const idProgram = this.value;
        
        filterIndikator.innerHTML = '<option value="">-- Pilih Indikator --</option>';
        filterIndikator.disabled = true;
        selectTarget.innerHTML = '<option value="">-- Pilih Target Tahun --</option>';
        selectTarget.disabled = true;
        infoPanel.style.display = 'none';

        if(idProgram) {
            filterIndikator.innerHTML = '<option value="">Loading...</option>';
            fetch(`/api/indikators/${idProgram}`)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Indikator --</option>';
                    data.forEach(i => html += `<option value="${i.id_indikator}">${i.nama_indikator}</option>`);
                    filterIndikator.innerHTML = html;
                    filterIndikator.disabled = false;
                });
        }
    });

    // 3. Indikator -> Target (Tahun)
    filterIndikator.addEventListener('change', function() {
        const idIndikator = this.value;
        
        selectTarget.innerHTML = '<option value="">-- Pilih Target Tahun --</option>';
        selectTarget.disabled = true;
        infoPanel.style.display = 'none';
        targetMap = {};

        if(idIndikator) {
            selectTarget.innerHTML = '<option value="">Loading...</option>';
            fetch(`/api/targets/${idIndikator}`)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Target Tahun --</option>';
                    data.forEach(t => {
                        targetMap[t.id_target] = t;
                        html += `<option value="${t.id_target}">${t.periode} (Target: ${fmt(t.target_tahunan)})</option>`;
                    });
                    selectTarget.innerHTML = html;
                    selectTarget.disabled = false;
                });
        }
    });

    selectTarget.addEventListener('change', updateInfoTarget);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/capaian/create.blade.php ENDPATH**/ ?>