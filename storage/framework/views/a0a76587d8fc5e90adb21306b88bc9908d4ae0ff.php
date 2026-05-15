<?php $__env->startSection('header', 'Input Capaian via Excel'); ?>
<?php $__env->startSection('content'); ?>
<style>
    /* === INPUT CAPAIAN PAGE STYLES === */
    .ic-hero {
        background: linear-gradient(135deg, #059669 0%, #047857 50%, #065F46 100%);
        border-radius: 20px;
        padding: 35px 40px;
        color: #fff;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    .ic-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .ic-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        right: 10%;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
    }
    .ic-hero h2 { font-weight: 700; font-size: 1.6rem; margin-bottom: 8px; position: relative; z-index: 1; }
    .ic-hero p { opacity: 0.85; font-size: 0.95rem; margin-bottom: 0; position: relative; z-index: 1; }

    .ic-card {
        background: var(--bg-sidebar);
        border: 1px solid var(--border-color);
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }
    .ic-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(5,150,105,0.12);
    }
    .ic-card-header {
        padding: 22px 28px;
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 1px solid var(--border-color);
    }
    .ic-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }
    .ic-card-icon.download { background: linear-gradient(135deg, #10B981, #059669); color: #fff; }
    .ic-card-icon.upload { background: linear-gradient(135deg, #3B82F6, #1D4ED8); color: #fff; }
    .ic-card-icon.export { background: linear-gradient(135deg, #8B5CF6, #6D28D9); color: #fff; }

    .ic-card-header h5 { font-weight: 700; font-size: 1.05rem; margin: 0; color: var(--text-main); }
    .ic-card-header small { color: var(--text-muted); font-size: 0.8rem; }

    .ic-card-body { padding: 25px 28px 30px; }

    .ic-form-group { margin-bottom: 18px; }
    .ic-form-group label {
        font-weight: 600;
        font-size: 0.82rem;
        color: var(--text-main);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
        display: block;
    }
    .ic-form-group .form-select,
    .ic-form-group .form-control {
        border: 1.5px solid var(--border-color);
        border-radius: 12px;
        padding: 10px 15px;
        font-size: 0.92rem;
        background: var(--bg-main);
        color: var(--text-main);
        transition: all 0.3s;
    }
    .ic-form-group .form-select:focus,
    .ic-form-group .form-control:focus {
        border-color: var(--accent-green);
        box-shadow: 0 0 0 4px rgba(5,150,105,0.1);
        background: var(--bg-sidebar);
    }

    .btn-ic {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        font-size: 0.9rem;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        justify-content: center;
    }
    .btn-ic-green {
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff;
    }
    .btn-ic-green:hover {
        background: linear-gradient(135deg, #059669, #047857);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5,150,105,0.3);
    }
    .btn-ic-blue {
        background: linear-gradient(135deg, #3B82F6, #1D4ED8);
        color: #fff;
    }
    .btn-ic-blue:hover {
        background: linear-gradient(135deg, #1D4ED8, #1E40AF);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59,130,246,0.3);
    }
    .btn-ic-purple {
        background: linear-gradient(135deg, #8B5CF6, #6D28D9);
        color: #fff;
    }
    .btn-ic-purple:hover {
        background: linear-gradient(135deg, #6D28D9, #5B21B6);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(139,92,246,0.3);
    }

    /* File upload area */
    .ic-upload-zone {
        border: 2px dashed var(--border-color);
        border-radius: 14px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: var(--bg-main);
        position: relative;
    }
    .ic-upload-zone:hover,
    .ic-upload-zone.dragover {
        border-color: var(--accent-green);
        background: #F0FDF4;
    }
    body.dark-mode .ic-upload-zone:hover,
    body.dark-mode .ic-upload-zone.dragover {
        background: #1F1B2A;
    }
    .ic-upload-zone i { font-size: 2rem; color: var(--text-muted); margin-bottom: 10px; }
    .ic-upload-zone p { color: var(--text-muted); margin: 0; font-size: 0.85rem; }
    .ic-upload-zone .file-name {
        color: var(--accent-green);
        font-weight: 600;
        margin-top: 8px;
        display: none;
    }

    /* Step indicators */
    .ic-steps {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }
    .ic-step {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.78rem;
        color: var(--text-muted);
        font-weight: 500;
    }
    .ic-step-num {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--border-color);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
    }
    .ic-step.active .ic-step-num {
        background: var(--accent-green);
        color: #fff;
    }
    .ic-step.active { color: var(--accent-green); }

    /* Warning/Info box */
    .ic-alert {
        border-radius: 12px;
        padding: 14px 18px;
        font-size: 0.85rem;
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 18px;
    }
    .ic-alert-info {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #1E40AF;
    }
    .ic-alert-warning {
        background: #FFFBEB;
        border: 1px solid #FDE68A;
        color: #92400E;
    }
    .ic-alert-danger {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #991B1B;
    }
    body.dark-mode .ic-alert-info { background: #1E1B4B; border-color: #3730A3; color: #93C5FD; }
    body.dark-mode .ic-alert-warning { background: #451A03; border-color: #92400E; color: #FDE68A; }
    body.dark-mode .ic-alert-danger { background: #450A0A; border-color: #991B1B; color: #FCA5A5; }

    .ic-alert i { font-size: 1rem; margin-top: 2px; flex-shrink: 0; }

    /* Workflow arrow connectors */
    .workflow-arrow {
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.5rem;
        padding: 10px 0;
    }
    @media (min-width: 992px) {
        .workflow-arrow { display: none; }
    }
</style>


<div class="ic-hero">
    <h2><i class="fas fa-file-excel me-2"></i>Input Capaian via Excel</h2>
    <p>Download template, isi data capaian di Excel, lalu upload kembali untuk input massal. Pencapaian kumulatif & persentase dihitung otomatis oleh sistem.</p>
</div>


<?php if(session('import_warnings')): ?>
<div class="ic-alert ic-alert-warning mb-4">
    <i class="fas fa-exclamation-triangle"></i>
    <div>
        <strong>Peringatan saat Import:</strong><br>
        <?php echo session('import_warnings'); ?>

    </div>
</div>
<?php endif; ?>


<div class="row g-4">

    
    <div class="col-lg-4">
        <div class="ic-card">
            <div class="ic-card-header">
                <div class="ic-card-icon download">
                    <i class="fas fa-download"></i>
                </div>
                <div>
                    <h5>Download Template</h5>
                    <small>Alat bantu input capaian</small>
                </div>
            </div>
            <div class="ic-card-body">
                <div class="ic-steps">
                    <div class="ic-step active"><span class="ic-step-num">1</span> Pilih Program</div>
                    <div class="ic-step active"><span class="ic-step-num">2</span> Pilih Bulan</div>
                    <div class="ic-step active"><span class="ic-step-num">3</span> Download</div>
                </div>

                <div class="ic-alert ic-alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>File Excel berisi indikator sesuai program. Isi hanya kolom <strong>berwarna hijau</strong>.</span>
                </div>

                <form action="<?php echo e(route('capaian.download-template')); ?>" method="GET">
                    <div class="ic-form-group">
                        <label for="tmpl_klaster">Klaster</label>
                        <select name="id_klaster" id="tmpl_klaster" class="form-select" required>
                            <option value="">-- Pilih Klaster --</option>
                            <?php $__currentLoopData = $klasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $klaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($klaster->id_klaster); ?>"><?php echo e($klaster->nama_klaster); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label for="tmpl_program">Program</label>
                        <select name="id_program" id="tmpl_program" class="form-select" required disabled>
                            <option value="">-- Pilih Klaster dulu --</option>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label for="tmpl_bulan">Bulan Pelaporan</label>
                        <select name="bulan" id="tmpl_bulan" class="form-select" required>
                            <option value="">-- Pilih Bulan --</option>
                            <?php
                                $namaBulan = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',
                                              7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                            ?>
                            <?php $__currentLoopData = $namaBulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($num); ?>"><?php echo e($nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button type="submit" class="btn-ic btn-ic-green">
                        <i class="fas fa-file-download"></i> Download Template Excel
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-4">
        <div class="workflow-arrow d-lg-none">
            <i class="fas fa-arrow-down"></i>
        </div>
        <div class="ic-card">
            <div class="ic-card-header">
                <div class="ic-card-icon upload">
                    <i class="fas fa-upload"></i>
                </div>
                <div>
                    <h5>Import Data Capaian</h5>
                    <small>Upload file template yang sudah diisi</small>
                </div>
            </div>
            <div class="ic-card-body">
                <div class="ic-steps">
                    <div class="ic-step active"><span class="ic-step-num">1</span> Pilih Bulan & Desa</div>
                    <div class="ic-step active"><span class="ic-step-num">2</span> Upload File</div>
                </div>

                <div class="ic-alert ic-alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Jika data bulan ini sudah ada, sistem akan <strong>otomatis mengupdate</strong> (bukan duplikat).</span>
                </div>

                <form action="<?php echo e(route('capaian.import-excel')); ?>" method="POST" enctype="multipart/form-data" id="formImport">
                    <?php echo csrf_field(); ?>
                    <div class="ic-form-group">
                        <label for="imp_bulan">Bulan Pelaporan</label>
                        <select name="bulan" id="imp_bulan" class="form-select" required>
                            <option value="">-- Pilih Bulan --</option>
                            <?php $__currentLoopData = $namaBulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($num); ?>"><?php echo e($nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label for="imp_desa">Desa Pelapor</label>
                        <select name="id_desa" id="imp_desa" class="form-select" required>
                            <option value="">-- Pilih Desa --</option>
                            <?php $__currentLoopData = $desas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($desa->id_desa); ?>" <?php echo e(($user->id_desa == $desa->id_desa) ? 'selected' : ''); ?>>
                                    <?php echo e($desa->nama_desa); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label>File Excel (.xlsx)</label>
                        <div class="ic-upload-zone" id="uploadZone" onclick="document.getElementById('fileExcel').click()">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <p>Klik atau seret file Excel ke sini</p>
                            <p class="file-name" id="fileName"></p>
                            <input type="file" name="file_excel" id="fileExcel" accept=".xlsx,.xls" required style="display:none">
                        </div>
                    </div>

                    <button type="submit" class="btn-ic btn-ic-blue" id="btnImport">
                        <i class="fas fa-file-import"></i> Import & Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="col-lg-4">
        <div class="workflow-arrow d-lg-none">
            <i class="fas fa-arrow-down"></i>
        </div>
        <div class="ic-card">
            <div class="ic-card-header">
                <div class="ic-card-icon export">
                    <i class="fas fa-file-export"></i>
                </div>
                <div>
                    <h5>Export Laporan Capaian</h5>
                    <small>Download laporan lengkap per bulan</small>
                </div>
            </div>
            <div class="ic-card-body">
                <div class="ic-steps">
                    <div class="ic-step active"><span class="ic-step-num">1</span> Filter (opsional)</div>
                    <div class="ic-step active"><span class="ic-step-num">2</span> Export</div>
                </div>

                <div class="ic-alert ic-alert-info">
                    <i class="fas fa-calculator"></i>
                    <span><strong>Kumulatif & persentase</strong> dihitung otomatis oleh sistem. Setiap bulan menjadi sheet terpisah.</span>
                </div>

                <form action="<?php echo e(route('capaian.export-laporan')); ?>" method="GET">
                    <div class="ic-form-group">
                        <label for="exp_bulan">Bulan (Kosongkan = Semua)</label>
                        <select name="bulan_export" id="exp_bulan" class="form-select">
                            <option value="">-- Semua Bulan (Multi-Sheet) --</option>
                            <?php $__currentLoopData = $namaBulan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nama): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($num); ?>"><?php echo e($nama); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label for="exp_klaster">Klaster (Opsional)</label>
                        <select name="id_klaster_export" id="exp_klaster" class="form-select">
                            <option value="">-- Semua Klaster --</option>
                            <?php $__currentLoopData = $klasters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $klaster): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($klaster->id_klaster); ?>"><?php echo e($klaster->nama_klaster); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label for="exp_program">Program (Opsional)</label>
                        <select name="id_program_export" id="exp_program" class="form-select">
                            <option value="">-- Semua Program --</option>
                        </select>
                    </div>

                    <div class="ic-form-group">
                        <label for="exp_desa">Desa (Opsional)</label>
                        <select name="id_desa_export" id="exp_desa" class="form-select">
                            <option value="">-- Semua Desa --</option>
                            <?php $__currentLoopData = $desas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $desa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($desa->id_desa); ?>"><?php echo e($desa->nama_desa); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <button type="submit" class="btn-ic btn-ic-purple">
                        <i class="fas fa-download"></i> Export Laporan Excel
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>


<div class="ic-card mt-4">
    <div class="ic-card-header">
        <div class="ic-card-icon" style="background: linear-gradient(135deg, #F59E0B, #D97706); color: #fff;">
            <i class="fas fa-book-open"></i>
        </div>
        <div>
            <h5>Panduan Penggunaan</h5>
            <small>Langkah-langkah input capaian via Excel</small>
        </div>
    </div>
    <div class="ic-card-body">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="ic-step-num" style="background: #10B981; color: #fff; min-width: 28px; height: 28px; font-size: 0.85rem;">1</span>
                    <div>
                        <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">Download Template</h6>
                        <p class="text-muted mb-0" style="font-size: 0.82rem;">Pilih program & bulan, lalu download. File Excel berisi daftar indikator dan target tahunan yang sudah terisi otomatis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="ic-step-num" style="background: #3B82F6; color: #fff; min-width: 28px; height: 28px; font-size: 0.85rem;">2</span>
                    <div>
                        <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">Isi & Upload</h6>
                        <p class="text-muted mb-0" style="font-size: 0.82rem;">Isi kolom hijau (Pencapaian, Analisa, RTL) di Excel, simpan, lalu upload di bagian Import. Pilih bulan & desa yang sesuai.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="ic-step-num" style="background: #8B5CF6; color: #fff; min-width: 28px; height: 28px; font-size: 0.85rem;">3</span>
                    <div>
                        <h6 class="fw-bold mb-1" style="font-size: 0.9rem;">Export Laporan</h6>
                        <p class="text-muted mb-0" style="font-size: 0.82rem;">Setelah data masuk, export laporan lengkap. Kumulatif & persentase otomatis dihitung. Setiap bulan menjadi sheet terpisah.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // CASCADING DROPDOWN: Klaster -> Program
    // ========================================
    function setupCascade(klasterSelect, programSelect) {
        klasterSelect.addEventListener('change', function() {
            const klasterId = this.value;
            programSelect.innerHTML = '<option value="">-- Memuat... --</option>';
            programSelect.disabled = true;

            if (!klasterId) {
                programSelect.innerHTML = '<option value="">-- Pilih Klaster dulu --</option>';
                return;
            }

            fetch(`/api/programs/${klasterId}`)
                .then(res => res.json())
                .then(data => {
                    let options = '<option value="">-- Pilih Program --</option>';
                    data.forEach(p => {
                        options += `<option value="${p.id_program}">${p.nama_program}</option>`;
                    });
                    programSelect.innerHTML = options;
                    programSelect.disabled = false;
                })
                .catch(() => {
                    programSelect.innerHTML = '<option value="">-- Gagal memuat --</option>';
                });
        });
    }

    // Setup untuk Template section
    const tmplKlaster = document.getElementById('tmpl_klaster');
    const tmplProgram = document.getElementById('tmpl_program');
    if (tmplKlaster && tmplProgram) {
        setupCascade(tmplKlaster, tmplProgram);
    }

    // Setup untuk Export section
    const expKlaster = document.getElementById('exp_klaster');
    const expProgram = document.getElementById('exp_program');
    if (expKlaster && expProgram) {
        setupCascade(expKlaster, expProgram);
    }

    // ========================================
    // FILE UPLOAD ZONE
    // ========================================
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileExcel');
    const fileNameDisplay = document.getElementById('fileName');

    if (uploadZone && fileInput) {
        // Drag & Drop
        ['dragenter', 'dragover'].forEach(evt => {
            uploadZone.addEventListener(evt, e => {
                e.preventDefault();
                uploadZone.classList.add('dragover');
            });
        });
        ['dragleave', 'drop'].forEach(evt => {
            uploadZone.addEventListener(evt, e => {
                e.preventDefault();
                uploadZone.classList.remove('dragover');
            });
        });
        uploadZone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                showFileName(files[0].name);
            }
        });

        // File selected via click
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                showFileName(this.files[0].name);
            }
        });

        function showFileName(name) {
            fileNameDisplay.textContent = '📄 ' + name;
            fileNameDisplay.style.display = 'block';
            uploadZone.querySelector('p:first-of-type').textContent = 'File siap diupload:';
        }
    }

    // ========================================
    // IMPORT LOADING STATE
    // ========================================
    const formImport = document.getElementById('formImport');
    const btnImport = document.getElementById('btnImport');

    if (formImport && btnImport) {
        formImport.addEventListener('submit', function() {
            btnImport.disabled = true;
            btnImport.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang mengimport...';
        });
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/capaian/input-capaian.blade.php ENDPATH**/ ?>