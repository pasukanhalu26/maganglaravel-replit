<?php $__env->startSection('header', 'Dashboard Overview'); ?>
<?php $__env->startSection('content'); ?>
<style>
/* ===== DASHBOARD DESIGN SYSTEM ===== */
.welcome-banner{background:linear-gradient(135deg,#059669 0%,#047857 60%,#065f46 100%);border-radius:20px;padding:28px 32px;color:#fff;position:relative;overflow:hidden;box-shadow:0 12px 32px rgba(5,150,105,.22),0 2px 8px rgba(5,150,105,.12)}
.welcome-banner::before{content:'';position:absolute;top:-60px;right:-60px;width:220px;height:220px;background:rgba(255,255,255,.07);border-radius:50%}
.welcome-banner::after{content:'';position:absolute;bottom:-40px;right:120px;width:120px;height:120px;background:rgba(255,255,255,.05);border-radius:50%}
.welcome-banner h3{font-size:1.25rem;letter-spacing:-.3px;font-weight:800}
.welcome-banner p{font-size:.82rem;opacity:.8}

.clock-chip{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2);border-radius:12px;padding:8px 16px;font-size:.78rem;font-weight:600;letter-spacing:.02em;white-space:nowrap}
.periode-chip{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.15);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2);border-radius:12px;padding:6px 14px}
.periode-chip select{background:transparent;border:none;color:#fff;font-weight:700;font-size:.85rem;outline:none;cursor:pointer;min-width:70px}
.periode-chip select option{color:#333;background:#fff}

/* KPI Card */
.kpi-card{background:#fff;border-radius:18px;border:1px solid #eef2f7;box-shadow:0 2px 12px rgba(0,0,0,.04);transition:box-shadow .25s,transform .25s;overflow:hidden;height:100%}
.kpi-card:hover{box-shadow:0 10px 30px rgba(0,0,0,.09);transform:translateY(-3px)}
.kpi-card-body{padding:22px 24px}
.kpi-icon{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0}
.kpi-label{font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:#94a3b8;margin-bottom:6px}
.kpi-value{font-size:1.9rem;font-weight:900;line-height:1;letter-spacing:-1px}
.kpi-sub{font-size:.72rem;color:#64748b;margin-top:4px;line-height:1.5}
.kpi-bar{height:5px;background:#f1f5f9;border-radius:4px;overflow:hidden;margin-top:14px}
.kpi-bar-fill{height:100%;border-radius:4px;transition:width 1.2s cubic-bezier(.4,0,.2,1)}
.status-row-item{display:flex;align-items:center;justify-content:space-between;padding:7px 10px;border-radius:10px;font-size:.73rem;font-weight:600;margin-bottom:5px}

/* Chart card */
.chart-card{background:#fff;border-radius:18px;padding:24px 26px;box-shadow:0 2px 12px rgba(0,0,0,.04);border:1px solid #eef2f7}

/* Tabs */
#dashTabs.nav-tabs{border-bottom:2px solid #f0f4f8;gap:2px}
#dashTabs .nav-link{border:none;border-radius:10px 10px 0 0;padding:11px 18px;font-weight:600;font-size:.83rem;color:#94a3b8;transition:color .2s,background .2s}
#dashTabs .nav-link:hover{color:#475569;background:#f8fafc}
#dashTabs .nav-link.active{color:#059669;background:transparent;border-bottom:3px solid #059669}

/* Klaster */
.klaster-card{background:#fff;border-radius:14px;padding:16px 18px;border:1px solid #eef2f7;transition:box-shadow .22s,transform .22s}
.klaster-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);transform:translateY(-2px)}
.progress-bar-custom{height:5px;border-radius:4px;background:#f1f5f9;overflow:hidden;margin-top:10px}
.progress-bar-fill{height:100%;border-radius:4px;transition:width .9s cubic-bezier(.4,0,.2,1)}

/* Badges */
.badge-status{padding:4px 10px;border-radius:20px;font-size:.67rem;font-weight:700;letter-spacing:.4px;display:inline-block}
.badge-tercapai{background:#d1fae5;color:#059669}
.badge-on-track{background:#dbeafe;color:#2563eb}
.badge-behind{background:#fee2e2;color:#dc2626}
.badge-belum{background:#f3f4f6;color:#6b7280}

/* Desa table */
.desa-table thead th{font-size:.66rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;background:#f8fafc;color:#64748b;padding:9px 10px;white-space:nowrap;position:sticky;top:0;z-index:2}
.desa-table td{padding:7px 10px;vertical-align:middle;font-size:.75rem;border-bottom:1px solid #f8fafc}
.desa-table tbody tr:hover{background:#f0fdf4}

/* Forecast table */
.forecast-table thead th{font-size:.67rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#7c3aed;background:#faf5ff;padding:10px 12px;white-space:nowrap;position:sticky;top:0;z-index:2}
.forecast-table td{padding:10px 12px;vertical-align:middle;font-size:.8rem;border-bottom:1px solid #f8f6ff}
.forecast-table tbody tr:hover{background:#faf5ff}

/* Filter select */
.filter-select{border:1px solid #e2e8f0;border-radius:10px;padding:8px 14px;font-weight:600;color:var(--text-main);background:#f8fafc;min-width:120px;font-size:.82rem}
.filter-select:focus{border-color:#059669;box-shadow:0 0 0 3px rgba(5,150,105,.1);outline:none}

/* Scrollbar */
::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-track{background:#f8fafc}
::-webkit-scrollbar-thumb{background:#d1d5db;border-radius:4px}
::-webkit-scrollbar-thumb:hover{background:#9ca3af}

/* Dashboard Dark Mode */
body.dark-mode .kpi-card{background:var(--bg-sidebar);border-color:var(--border-color)}
body.dark-mode .chart-card{background:var(--bg-sidebar);border-color:var(--border-color)}
body.dark-mode .klaster-card{background:var(--bg-sidebar);border-color:var(--border-color)}
body.dark-mode .kpi-value{color:var(--text-main) !important}
body.dark-mode .kpi-sub{color:var(--text-muted)}
body.dark-mode .kpi-bar{background:#334155}
body.dark-mode .desa-table thead th{background:#334155;color:var(--text-muted)}
body.dark-mode .desa-table td{border-color:#334155}
body.dark-mode .forecast-table thead th{background:#1e1b4b;color:#a78bfa}
body.dark-mode .forecast-table td{border-color:#334155}
body.dark-mode .filter-select{background:#334155;border-color:#475569;color:var(--text-main)}
</style>

<!-- Header + Filter -->
<div class="row mb-4">
<div class="col-12">
<div class="welcome-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span style="background:rgba(255,255,255,.2);border-radius:8px;padding:4px 10px;font-size:.7rem;font-weight:700;letter-spacing:.06em">PUSKESMAS DRIYOREJO</span>
        </div>
        <h3 class="fw-bold mb-1">Selamat datang, <?php echo e(str_replace('_', ' ', ucwords(Auth::user()->role))); ?>! 👋</h3>
        <p class="mb-0">Monitoring capaian kinerja program kesehatan — pantau, analisis, dan ambil tindakan.</p>
    </div>
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <div class="periode-chip">
            <i class="fas fa-calendar-alt" style="font-size:.85rem"></i>
            <select id="periodeFilter" class="form-select border-0 bg-transparent text-white fw-bold" style="min-width:80px;cursor:pointer" onchange="window.location='?periode='+this.value">
                <?php $__currentLoopData = $availableYears; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $yr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($yr); ?>" <?php echo e($yr == $selectedYear ? 'selected' : ''); ?> style="color:#333"><?php echo e($yr); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="clock-chip">
            <i class="far fa-clock" style="font-size:.85rem"></i>
            <span id="clock-text">...</span>
        </div>
    </div>
</div>
</div>
</div>



<?php
    // 1. Basic Stats
    $expected_now     = round($sum_target_tahunan * ($current_month / 12));
    $deficit          = max(0, $expected_now - $sum_capaian_kumulatif);
    $surplus          = max(0, $sum_capaian_kumulatif - $expected_now);
    $on_schedule      = $sum_capaian_kumulatif >= $expected_now;
    $remaining_target = max(0, $sum_target_tahunan - $sum_capaian_kumulatif);
    $months_left      = max(1, 12 - $current_month);
    $needed_per_month = ceil($remaining_target / $months_left);
    $avg_per_month    = $current_month > 0 ? round($sum_capaian_kumulatif / $current_month) : 0;
    $need_extra       = $needed_per_month > $avg_per_month;
    $total_ind        = count($indikator_detail);
    $cnt_tercapai     = collect($indikator_detail)->where('status','tercapai')->count();
    $cnt_ontrack      = collect($indikator_detail)->where('status','on-track')->count();
    $cnt_behind       = collect($indikator_detail)->where('status','behind')->count();
    $cnt_belum        = collect($indikator_detail)->where('status','belum')->count();

    // 2. Breakdown Desa (Leaderboard)
    $desa_collection = collect($desa_indikator_data)->map(function($d) {
        $d['pct'] = $d['total'] > 0 ? round(($d['terpenuhi'] / $d['total']) * 100) : 0;
        return $d;
    });
    $top_desas = $desa_collection->sortByDesc('pct')->take(3);
    $bottom_desas = $desa_collection->sortBy('pct')->take(3);

    // 3. Forecast / Proyeksi (Moved up to be accessible everywhere)
    $forecast_items = [];
    foreach ($indikator_detail as $row) {
        $tgt = $row['target_tahunan'];
        if ($tgt <= 0) continue;
        $cap = $row['capaian_kumulatif'];
        $avg_m = $current_month > 0 ? ($cap / $current_month) : 0;
        $proj = $avg_m * 12;
        $proj_pct = round(($proj / $tgt) * 100, 1);
        $gap = $tgt - $cap;
        $needed = $months_left > 0 ? ceil($gap / $months_left) : 0;
        $ratio = ($avg_m > 0 && $needed > 0) ? ($needed / $avg_m) : ($avg_m > 0 ? 0 : 99);
        $verdict = $proj_pct >= 100 ? 'aman' : ($proj_pct >= 80 ? 'waspada' : 'kritis');
        $forecast_items[] = [
            'indikator' => $row['indikator'],
            'klaster'   => $row['klaster'],
            'target'    => $tgt,
            'capaian'   => $cap,
            'proj_pct'  => $proj_pct,
            'needed_pm' => $needed,
            'avg_pm'    => round($avg_m),
            'ratio'     => $ratio,
            'verdict'   => $verdict,
            'gap'       => max(0, $gap),
        ];
    }
    $indikator_darurat = collect($forecast_items)->filter(fn($x) => $x['verdict'] === 'kritis')->sortBy('proj_pct')->take(5);
?>

<div class="row g-3 mb-4">
    
    <div class="col-6 col-lg-3">
        <div class="kpi-card">
            <div class="kpi-card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="kpi-icon" style="background:#dbeafe"><i class="fas fa-bullseye" style="color:#3b82f6"></i></div>
                    <div class="kpi-label">Capaian s.d. Bulan Ini</div>
                </div>
                <div class="kpi-value" style="color:#0f172a"><?php echo e(number_format($sum_capaian_kumulatif)); ?></div>
                <div class="kpi-sub">dari target tahunan <strong style="color:#0f172a"><?php echo e(number_format($sum_target_tahunan)); ?></strong></div>
                <div class="kpi-bar">
                    <div class="kpi-bar-fill" style="width:<?php echo e(min($overall_progress,100)); ?>%;background:#3b82f6"></div>
                </div>
                <div class="d-flex justify-content-between mt-1" style="font-size:.63rem;color:#94a3b8">
                    <span>0%</span>
                    <span class="fw-bold" style="color:#3b82f6"><?php echo e($overall_progress); ?>% tercapai</span>
                    <span>100%</span>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-6 col-lg-3">
        <div class="kpi-card" style="border-top: 3px solid <?php echo e($on_schedule ? '#059669' : '#dc2626'); ?>">
            <div class="kpi-card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="kpi-icon" style="background:<?php echo e($on_schedule ? '#d1fae5' : '#fee2e2'); ?>">
                        <i class="fas fa-<?php echo e($on_schedule ? 'check' : 'exclamation'); ?>" style="color:<?php echo e($on_schedule ? '#059669' : '#dc2626'); ?>"></i>
                    </div>
                    <div class="kpi-label">Posisi vs Jadwal</div>
                </div>
                <div class="kpi-sub mb-1">Bln ke-<?php echo e($current_month); ?>/12 — seharusnya sudah:</div>
                <div class="kpi-value" style="color:#0f172a;font-size:1.5rem"><?php echo e(number_format($expected_now)); ?></div>
                <?php if($on_schedule): ?>
                    <div class="mt-2 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1" style="background:#d1fae5;font-size:.7rem;color:#065f46;font-weight:700">
                        <i class="fas fa-arrow-up" style="font-size:.6rem"></i> Surplus <?php echo e(number_format($surplus)); ?> ✓
                    </div>
                <?php else: ?>
                    <div class="mt-2 px-2 py-1 rounded-2 d-inline-flex align-items-center gap-1" style="background:#fee2e2;font-size:.7rem;color:#991b1b;font-weight:700">
                        <i class="fas fa-arrow-down" style="font-size:.6rem"></i> Ketinggalan <?php echo e(number_format($deficit)); ?>

                    </div>
                <?php endif; ?>
                <div class="mt-2" style="font-size:.63rem;color:#94a3b8">
                    (<?php echo e($current_month); ?>/12) × <?php echo e(number_format($sum_target_tahunan)); ?>

                </div>
            </div>
        </div>
    </div>

    
    <div class="col-6 col-lg-3">
        <div class="kpi-card" style="border-top: 3px solid <?php echo e($need_extra ? '#d97706' : '#059669'); ?>">
            <div class="kpi-card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="kpi-icon" style="background:<?php echo e($need_extra ? '#fef3c7' : '#d1fae5'); ?>">
                        <i class="fas fa-calculator" style="color:<?php echo e($need_extra ? '#d97706' : '#059669'); ?>"></i>
                    </div>
                    <div class="kpi-label">Target Wajib / Bulan</div>
                </div>
                <div class="kpi-sub mb-1">Agar target terpenuhi di Desember:</div>
                <div class="kpi-value" style="color:<?php echo e($need_extra ? '#d97706' : '#059669'); ?>"><?php echo e(number_format($needed_per_month)); ?></div>
                <div class="kpi-sub">/bulan × <?php echo e($months_left); ?> bln sisa</div>
                <?php if($need_extra): ?>
                    <div class="mt-2" style="font-size:.69rem;color:#d97706;font-weight:600">
                        <i class="fas fa-exclamation-triangle me-1"></i>Tren saat ini <?php echo e(number_format($avg_per_month)); ?>/bln — butuh +<?php echo e(number_format($needed_per_month - $avg_per_month)); ?>

                    </div>
                <?php else: ?>
                    <div class="mt-2" style="font-size:.69rem;color:#059669;font-weight:600">
                        <i class="fas fa-check-circle me-1"></i>Tren <?php echo e(number_format($avg_per_month)); ?>/bln — sudah aman ✓
                    </div>
                <?php endif; ?>
                <div class="mt-1" style="font-size:.63rem;color:#94a3b8"><?php echo e(number_format($remaining_target)); ?> ÷ <?php echo e($months_left); ?> bln</div>
            </div>
        </div>
    </div>

    
    <div class="col-6 col-lg-3">
        <div class="kpi-card">
            <div class="kpi-card-body">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <div class="kpi-icon" style="background:#ede9fe"><i class="fas fa-list-check" style="color:#7c3aed"></i></div>
                    <div class="kpi-label">Status <?php echo e($total_ind); ?> Indikator</div>
                </div>
                <div class="status-row-item" style="background:#d1fae5">
                    <span style="color:#065f46"><i class="fas fa-check-circle me-1"></i>Tercapai</span>
                    <span style="font-size:1.1rem;font-weight:900;color:#059669"><?php echo e($cnt_tercapai); ?></span>
                </div>
                <div class="status-row-item" style="background:#dbeafe">
                    <span style="color:#1e40af"><i class="fas fa-equals me-1"></i>On Track</span>
                    <span style="font-size:1.1rem;font-weight:900;color:#3b82f6"><?php echo e($cnt_ontrack); ?></span>
                </div>
                <div class="status-row-item" style="background:#fee2e2">
                    <span style="color:#991b1b"><i class="fas fa-exclamation-triangle me-1"></i>Perlu Tindakan</span>
                    <span style="font-size:1.1rem;font-weight:900;color:#dc2626"><?php echo e($cnt_behind + $cnt_belum); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    
    <div class="col-lg-5">
        <div class="kpi-card h-100" style="border-top:3px solid #3b82f6">
            <div class="kpi-card-body p-0">
                <div class="p-4 border-bottom border-light">
                    <h6 class="fw-bold mb-1 text-dark"><i class="fas fa-trophy me-2" style="color:#f59e0b"></i>Leaderboard Kinerja Desa</h6>
                    <div class="text-muted" style="font-size:0.75rem">Desa dengan persentase indikator terpenuhi tertinggi & terendah.</div>
                </div>
                
                <div class="p-3">
                    <div class="mb-2 fw-bold text-success" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px"><i class="fas fa-arrow-up me-1"></i> Top 3 Desa (Apresiasi)</div>
                    <div class="d-flex flex-column gap-2 mb-4">
                        <?php $__empty_1 = true; $__currentLoopData = $top_desas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex align-items-center justify-content-between p-2 rounded-3" style="background:#f0fdf4;border:1px solid #dcfce7">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:24px;height:24px;background:#d1fae5;color:#059669;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:0.75rem"><?php echo e($loop->iteration); ?></div>
                                <span class="fw-bold text-dark small"><?php echo e($d['nama']); ?></span>
                            </div>
                            <span class="badge bg-success border-0"><?php echo e($d['pct']); ?>%</span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-muted small">Data belum tersedia</div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-2 fw-bold text-danger" style="font-size:0.7rem;text-transform:uppercase;letter-spacing:1px"><i class="fas fa-arrow-down me-1"></i> Bottom 3 Desa (Perlu Bimbingan)</div>
                    <div class="d-flex flex-column gap-2">
                        <?php $__empty_1 = true; $__currentLoopData = $bottom_desas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="d-flex align-items-center justify-content-between p-2 rounded-3" style="background:#fef2f2;border:1px solid #fee2e2">
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:24px;height:24px;background:#fee2e2;color:#dc2626;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:bold;font-size:0.75rem"><i class="fas fa-exclamation"></i></div>
                                <span class="fw-bold text-dark small"><?php echo e($d['nama']); ?></span>
                            </div>
                            <span class="badge bg-danger border-0"><?php echo e($d['pct']); ?>%</span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-muted small">Data belum tersedia</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="col-lg-7">
        <div class="kpi-card h-100" style="border-top:3px solid #dc2626">
            <div class="kpi-card-body p-0">
                <div class="p-4 border-bottom border-light d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fw-bold mb-1" style="color:#b91c1c"><i class="fas fa-siren-on me-2"></i>Prioritas Intervensi Darurat</h6>
                        <div class="text-muted" style="font-size:0.75rem">5 Indikator paling kritis yang berisiko gagal capai target akhir tahun.</div>
                    </div>
                    <a href="#pane-forecast" onclick="document.getElementById('tab-forecast').click();" class="btn btn-sm btn-outline-danger" style="font-size:0.75rem;border-radius:8px">Lihat Semua</a>
                </div>
                
                <div class="p-3">
                    <?php $__empty_1 = true; $__currentLoopData = $indikator_darurat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $darurat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between p-3 rounded-3 mb-2" style="background:#fff;border:1px solid #e2e8f0;border-left:4px solid #dc2626">
                        <div class="mb-2 mb-md-0" style="max-width:350px">
                            <div class="fw-bold text-dark" style="font-size:0.8rem;line-height:1.3"><?php echo e(Str::limit($darurat['indikator'], 65)); ?></div>
                            <div class="text-muted mt-1" style="font-size:0.65rem"><i class="fas fa-layer-group me-1"></i><?php echo e($darurat['klaster']); ?></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="text-end">
                                <div class="text-muted" style="font-size:0.65rem;text-transform:uppercase">Defisit Saat Ini</div>
                                <div class="fw-bold" style="color:#dc2626;font-size:0.95rem">-<?php echo e(number_format($darurat['gap'])); ?></div>
                            </div>
                            <div style="width:1px;height:30px;background:#e2e8f0"></div>
                            <div class="text-end" style="min-width:65px">
                                <div class="text-muted" style="font-size:0.65rem;text-transform:uppercase">Proyeksi</div>
                                <div class="fw-bold text-dark" style="font-size:0.95rem"><?php echo e($darurat['proj_pct']); ?>%</div>
                            </div>
                            <a href="<?php echo e(route('capaian.index', ['katakunci' => substr($darurat['indikator'], 0, 15)])); ?>" class="btn btn-sm btn-light border" title="Input Capaian" style="border-radius:8px"><i class="fas fa-arrow-right text-primary"></i></a>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5">
                        <div style="width:60px;height:60px;background:#d1fae5;color:#059669;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 10px;font-size:1.5rem"><i class="fas fa-check"></i></div>
                        <h6 class="fw-bold text-success mb-0">Semua Indikator Aman!</h6>
                        <p class="text-muted small mt-1">Tidak ada indikator dalam status kritis.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail lainnya dalam tab: lebih sedikit blok sekaligus di layar -->
<div class="chart-card mb-5 p-0 overflow-hidden">
<ul class="nav nav-tabs px-3 pt-3 flex-nowrap overflow-auto" id="dashTabs" role="tablist">
<li class="nav-item" role="presentation">
<button class="nav-link active" id="tab-wilayah" data-bs-toggle="tab" data-bs-target="#pane-wilayah" type="button" role="tab" aria-controls="pane-wilayah" aria-selected="true">Klaster & desa</button>
</li>
<li class="nav-item" role="presentation">
<button class="nav-link fw-bold" id="tab-forecast" data-bs-toggle="tab" data-bs-target="#pane-forecast" type="button" role="tab" style="color:#7c3aed"><i class="fas fa-robot me-1"></i> Proyeksi Akhir Tahun</button>
</li>
</ul>
<div class="tab-content p-3 p-md-4">

<div class="tab-pane fade show active" id="pane-wilayah" role="tabpanel" aria-labelledby="tab-wilayah">
<h6 class="fw-bold text-dark mb-3"><i class="fas fa-layer-group me-2 text-success"></i>Progress per klaster</h6>
<div class="row g-3 mb-4">
<?php $__currentLoopData = $klaster_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="col-md-4 col-xl-3">
<div class="klaster-card">
<div class="d-flex justify-content-between align-items-start mb-2">
<div>
<div class="fw-bold small"><?php echo e($kd['nama']); ?></div>
<div class="text-muted" style="font-size:.72rem"><?php echo e($kd['jumlah_indikator']); ?> indikator</div>
</div>
<span class="badge <?php echo e($kd['progress'] >= 100 ? 'badge-tercapai' : ($kd['progress'] >= ($current_month/12*100) ? 'badge-on-track' : 'badge-behind')); ?> badge-status"><?php echo e($kd['progress']); ?>%</span>
</div>
<div class="d-flex justify-content-between small text-muted mb-1">
<span>Capaian <strong class="text-dark"><?php echo e(number_format($kd['capaian'])); ?></strong></span>
<span>Target <strong class="text-dark"><?php echo e(number_format($kd['target'])); ?></strong></span>
</div>
<div class="progress-bar-custom">
<div class="progress-bar-fill" style="width:<?php echo e(min($kd['progress'],100)); ?>%;background:<?php echo e($kd['progress'] >= 100 ? '#10b981' : ($kd['progress'] >= ($current_month/12*100) ? '#3498db' : '#e74c3c')); ?>"></div>
</div>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(empty($klaster_data)): ?>
<div class="col-12 text-center py-4 text-muted"><i class="fas fa-inbox fa-2x mb-2"></i><p class="mb-0">Belum ada data klaster</p></div>
<?php endif; ?>
</div>

<h6 class="fw-bold text-dark mb-3 mt-4"><i class="fas fa-map-marker-alt me-2 text-success"></i>Pencapaian per desa — <?php echo e($selectedYear); ?></h6>
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2 small text-muted">
<span>Target dibagi <?php echo e($total_desa_count); ?> desa</span>
<span><span class="badge-status badge-tercapai me-1">Terpenuhi</span><span class="badge-status badge-behind">Belum</span></span>
</div>

<div class="accordion" id="desaAccordion">
<?php $__currentLoopData = $desa_indikator_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $desa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
    $pctTerpenuhi = $desa['total'] > 0 ? round(($desa['terpenuhi'] / $desa['total']) * 100) : 0;
    $headerColor = $desa['terpenuhi'] == $desa['total'] && $desa['total'] > 0 ? '#d1fae5' : ($desa['terpenuhi'] > 0 ? '#dbeafe' : '#fee2e2');
    $headerBorder = $desa['terpenuhi'] == $desa['total'] && $desa['total'] > 0 ? '#a7f3d0' : ($desa['terpenuhi'] > 0 ? '#bfdbfe' : '#fecaca');
?>
<div class="mb-2">
<div class="d-flex align-items-center flex-wrap gap-2 p-3 rounded-3" style="background:<?php echo e($headerColor); ?>;border:1px solid <?php echo e($headerBorder); ?>;cursor:pointer" data-bs-toggle="collapse" data-bs-target="#desaCollapse<?php echo e($idx); ?>">
    <div class="flex-grow-1 d-flex align-items-center gap-2 flex-wrap" style="min-width:180px">
        <div class="fw-bold small" style="min-width:110px"><?php echo e($desa['nama']); ?></div>
        <div class="d-flex align-items-center gap-2 flex-grow-1" style="min-width:140px">
            <div style="height:8px;flex:1;background:rgba(0,0,0,.06);border-radius:4px;overflow:hidden;max-width:220px">
                <div style="height:100%;width:<?php echo e($pctTerpenuhi); ?>%;background:<?php echo e($desa['terpenuhi'] == $desa['total'] && $desa['total'] > 0 ? '#10b981' : '#3498db'); ?>;border-radius:4px"></div>
            </div>
            <span class="fw-bold small" style="color:<?php echo e($desa['terpenuhi'] == $desa['total'] && $desa['total'] > 0 ? '#059669' : '#3498db'); ?>"><?php echo e($pctTerpenuhi); ?>%</span>
        </div>
    </div>
    <div class="d-flex align-items-center gap-3 ms-auto flex-wrap">
        <div class="text-center"><div class="text-uppercase" style="font-size:.62rem;color:#666">Terpenuhi</div><div class="fw-bold" style="color:#059669;font-size:.95rem"><?php echo e($desa['terpenuhi']); ?></div></div>
        <div class="text-center"><div class="text-uppercase" style="font-size:.62rem;color:#666">Belum</div><div class="fw-bold" style="color:#e74c3c;font-size:.95rem"><?php echo e($desa['belum']); ?></div></div>
        <div class="text-center"><div class="text-uppercase" style="font-size:.62rem;color:#666">Total</div><div class="fw-bold text-dark" style="font-size:.95rem"><?php echo e($desa['total']); ?></div></div>
        <i class="fas fa-chevron-down text-muted" style="font-size:.75rem"></i>
    </div>
</div>
<div class="collapse" id="desaCollapse<?php echo e($idx); ?>">
<div class="p-0 mt-1">
<div class="table-responsive">
<table class="table table-sm table-hover mb-0 small" style="min-width: 1000px;">
<thead><tr style="background:#fafafa">
<th class="ps-3 py-2 text-uppercase" style="font-size:.68rem;font-weight:700;position:sticky;left:0;background:#fafafa;z-index:2;box-shadow: 2px 0 5px rgba(0,0,0,0.02);">Indikator & Klaster</th>
<th class="text-center py-2 text-uppercase" style="font-size:.68rem;font-weight:700">Target<br>Desa</th>
<th class="text-center py-2 text-uppercase" style="font-size:.68rem;font-weight:700">Tgt<br>Bulan</th>
<?php $__currentLoopData = $bulan_names; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<th class="text-center py-2 text-uppercase" style="font-size:.68rem;font-weight:700;color:#6b7280;"><?php echo e($bn); ?></th>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<th class="text-center py-2 text-uppercase" style="font-size:.68rem;font-weight:700">Total<br>Capaian</th>
<th class="text-center py-2 text-uppercase" style="font-size:.68rem;font-weight:700">Kurang</th>
<th class="text-center py-2 text-uppercase" style="font-size:.68rem;font-weight:700">Status</th>
</tr></thead>
<tbody>
<?php $__currentLoopData = $desa['indikators']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ind): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr style="<?php echo e($ind['tercapai'] ? 'background:rgba(16,185,129,.04)' : ''); ?>">
<td class="ps-3" style="max-width:220px;position:sticky;left:0;background:<?php echo e($ind['tercapai'] ? '#f4fdf8' : '#fff'); ?>;z-index:1;box-shadow: 2px 0 5px rgba(0,0,0,0.02);">
    <div class="fw-bold" style="font-size:0.75rem;line-height:1.2;"><?php echo e(Str::limit($ind['indikator'], 60)); ?></div>
    <div class="text-muted mt-1" style="font-size:0.65rem"><i class="fas fa-tag me-1"></i><?php echo e(Str::limit($ind['klaster'], 30)); ?></div>
</td>
<td class="text-center align-middle fw-bold" style="font-size:0.8rem;"><?php echo e(number_format($ind['target_desa'])); ?></td>
<td class="text-center align-middle text-muted" style="font-size:0.7rem;">±<?php echo e(number_format($ind['target_bulan'])); ?></td>
<?php for($m = 1; $m <= 12; $m++): ?>
    <?php 
        $cap_b = $ind['monthly'][$m] ?? 0;
        $is_fulfilled = $cap_b >= $ind['target_bulan'] && $ind['target_bulan'] > 0;
        $bg_color = $cap_b > 0 ? ($is_fulfilled ? 'rgba(16,185,129,0.1)' : 'rgba(52,152,219,0.05)') : 'transparent';
        $text_color = $cap_b > 0 ? ($is_fulfilled ? '#059669' : '#3498db') : '#d1d5db';
    ?>
    <td class="text-center align-middle" style="background:<?php echo e($bg_color); ?>; color:<?php echo e($text_color); ?>; font-weight:<?php echo e($cap_b > 0 ? '700' : '400'); ?>; font-size:0.7rem;">
        <?php echo e($cap_b > 0 ? number_format($cap_b) : '-'); ?>

    </td>
<?php endfor; ?>
<td class="text-center align-middle fw-bold" style="color:#0f172a;font-size:0.8rem;"><?php echo e(number_format($ind['capaian'])); ?></td>
<td class="text-center align-middle fw-bold" style="font-size:0.75rem; color:<?php echo e($ind['sisa'] <= 0 ? '#059669' : '#e74c3c'); ?>">
    <?php if($ind['sisa'] <= 0): ?>
        <?php echo e($ind['sisa'] == 0 ? '0 ✓' : 'Over +'.number_format(abs($ind['sisa']))); ?>

    <?php else: ?>
        <?php echo e(number_format($ind['sisa'])); ?>

    <?php endif; ?>
</td>
<td class="text-center align-middle">
    <?php if($ind['tercapai']): ?>
        <span class="badge-status badge-tercapai"><i class="fas fa-check-circle me-1"></i>Terpenuhi</span>
    <?php else: ?>
        <span class="badge-status badge-behind" style="font-size:0.65rem">Kurang <?php echo e(number_format($ind['sisa'])); ?></span>
    <?php endif; ?>
</td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php if(empty($desa_indikator_data)): ?>
<div class="text-center py-4 text-muted"><i class="fas fa-inbox fa-2x mb-2 d-block"></i>Belum ada data</div>
<?php endif; ?>
</div>
</div>

<div class="tab-pane fade" id="pane-forecast" role="tabpanel" aria-labelledby="tab-forecast">
<?php
    $bulan_indo = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $months_left = 12 - $current_month;
    $avg_per_month = $current_month > 0 ? $sum_capaian_kumulatif / $current_month : 0;
    $projected_total = $avg_per_month * 12;
    $projected_pct = $sum_target_tahunan > 0 ? round(($projected_total / $sum_target_tahunan) * 100, 1) : 0;
    $gap_to_target = $sum_target_tahunan - $sum_capaian_kumulatif;
    $needed_per_month = $months_left > 0 ? ceil($gap_to_target / $months_left) : 0;
    $pace_ratio = $current_month > 0 && $avg_per_month > 0 ? ($needed_per_month / $avg_per_month) : null;
    $overall_verdict = $projected_pct >= 100 ? 'aman' : ($projected_pct >= 80 ? 'waspada' : 'kritis');

    // Per-indikator forecast
    $forecast_items = [];
    foreach ($indikator_detail as $row) {
        $tgt = $row['target_tahunan'];
        if ($tgt <= 0) continue;
        $cap = $row['capaian_kumulatif'];
        $avg_m = $current_month > 0 ? ($cap / $current_month) : 0;
        $proj = $avg_m * 12;
        $proj_pct = round(($proj / $tgt) * 100, 1);
        $gap = $tgt - $cap;
        $needed = $months_left > 0 ? ceil($gap / $months_left) : 0;
        $ratio = ($avg_m > 0 && $needed > 0) ? ($needed / $avg_m) : ($avg_m > 0 ? 0 : 99);
        $verdict = $proj_pct >= 100 ? 'aman' : ($proj_pct >= 80 ? 'waspada' : 'kritis');
        $forecast_items[] = [
            'indikator' => $row['indikator'],
            'klaster'   => $row['klaster'],
            'target'    => $tgt,
            'capaian'   => $cap,
            'proj_pct'  => $proj_pct,
            'needed_pm' => $needed,
            'avg_pm'    => round($avg_m),
            'ratio'     => $ratio,
            'verdict'   => $verdict,
            'gap'       => max(0, $gap),
        ];
    }
    usort($forecast_items, fn($a, $b) => $a['proj_pct'] <=> $b['proj_pct']);
    $kritis_count = count(array_filter($forecast_items, fn($x) => $x['verdict'] === 'kritis'));
    $waspada_count = count(array_filter($forecast_items, fn($x) => $x['verdict'] === 'waspada'));
    $aman_count = count(array_filter($forecast_items, fn($x) => $x['verdict'] === 'aman'));
?>


<div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
    <div>
        <h6 class="fw-bold mb-1 text-dark" style="font-size:1rem">
            <i class="fas fa-robot me-2" style="color:#7c3aed"></i>
            Proyeksi Cerdas Akhir Tahun <?php echo e($selectedYear); ?>

        </h6>
        <div class="small text-muted">Berdasarkan rata-rata kecepatan capaian <?php echo e($current_month); ?> bulan terakhir &mdash; dihitung otomatis tiap hari.</div>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <span class="px-3 py-1 rounded-pill fw-bold small" style="background:#fee2e2;color:#b91c1c"><i class="fas fa-times-circle me-1"></i><?php echo e($kritis_count); ?> Kritis</span>
        <span class="px-3 py-1 rounded-pill fw-bold small" style="background:#fef3c7;color:#92400e"><i class="fas fa-exclamation-triangle me-1"></i><?php echo e($waspada_count); ?> Waspada</span>
        <span class="px-3 py-1 rounded-pill fw-bold small" style="background:#d1fae5;color:#065f46"><i class="fas fa-check-circle me-1"></i><?php echo e($aman_count); ?> Aman</span>
    </div>
</div>


<div class="p-4 rounded-3 mb-4" style="background: linear-gradient(135deg, #7c3aed, #4f46e5); color: #fff; box-shadow: 0 8px 24px rgba(124,58,237,0.2);">
    <div class="row g-4 align-items-center">
        <div class="col-md-5">
            <div class="mb-2" style="font-size:0.75rem;opacity:0.8;text-transform:uppercase;letter-spacing:.06em">Proyeksi Capaian Global Akhir <?php echo e($selectedYear); ?></div>
            <div style="font-size:3rem;font-weight:900;line-height:1"><?php echo e($projected_pct); ?>%</div>
            <div class="mt-1" style="font-size:0.8rem;opacity:0.85">
                Dengan tren saat ini, estimasi capaian tahunan: <strong><?php echo e(number_format($projected_total)); ?></strong> dari <strong><?php echo e(number_format($sum_target_tahunan)); ?></strong>
            </div>
            <div class="mt-2">
                <?php if($overall_verdict === 'aman'): ?>
                    <span class="px-3 py-1 rounded-pill fw-bold" style="background:rgba(255,255,255,0.2);font-size:0.8rem"><i class="fas fa-check-circle me-1"></i> Target kemungkinan TERCAPAI</span>
                <?php elseif($overall_verdict === 'waspada'): ?>
                    <span class="px-3 py-1 rounded-pill fw-bold" style="background:rgba(255,200,0,0.25);font-size:0.8rem"><i class="fas fa-exclamation-triangle me-1"></i> Perlu Percepatan Upaya</span>
                <?php else: ?>
                    <span class="px-3 py-1 rounded-pill fw-bold" style="background:rgba(255,100,100,0.25);font-size:0.8rem"><i class="fas fa-times-circle me-1"></i> TARGET BERISIKO GAGAL</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-7">
            <div class="row g-3">
                <div class="col-6">
                    <div class="p-3 rounded-2" style="background:rgba(255,255,255,0.12)">
                        <div style="font-size:0.7rem;opacity:0.75;text-transform:uppercase;letter-spacing:.05em">Rata-rata Capaian/Bulan</div>
                        <div class="fw-bold mt-1" style="font-size:1.4rem"><?php echo e(number_format($avg_per_month)); ?></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded-2" style="background:rgba(255,255,255,0.12)">
                        <div style="font-size:0.7rem;opacity:0.75;text-transform:uppercase;letter-spacing:.05em">Yang Harus Dicapai/Bulan</div>
                        <div class="fw-bold mt-1" style="font-size:1.4rem;color:<?php echo e($needed_per_month > $avg_per_month ? '#fca5a5' : '#6ee7b7'); ?>"><?php echo e(number_format($needed_per_month)); ?></div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded-2" style="background:rgba(255,255,255,0.12)">
                        <div style="font-size:0.7rem;opacity:0.75;text-transform:uppercase;letter-spacing:.05em">Sisa Bulan</div>
                        <div class="fw-bold mt-1" style="font-size:1.4rem"><?php echo e($months_left); ?> bln</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded-2" style="background:rgba(255,255,255,0.12)">
                        <div style="font-size:0.7rem;opacity:0.75;text-transform:uppercase;letter-spacing:.05em">Total Defisit Saat Ini</div>
                        <div class="fw-bold mt-1" style="font-size:1.4rem;color:#fca5a5"><?php echo e(number_format(max(0, $gap_to_target))); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
    <span class="fw-bold text-dark small">Detail Proyeksi Per Indikator</span>
    <span class="text-muted small">(diurutkan dari yang paling berisiko)</span>
    <span class="ms-auto small text-muted"><i class="fas fa-calendar me-1"></i>Bulan sekarang: <strong><?php echo e($bulan_indo[$current_month]); ?></strong></span>
</div>
<div class="table-responsive rounded-3 border" style="max-height: 420px; overflow: auto;">
<table class="table table-sm table-hover mb-0" style="font-size:0.8rem">
<thead style="position:sticky;top:0;z-index:2">
<tr style="background:#f8f6ff">
    <th class="py-2 ps-3" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Indikator</th>
    <th class="text-center py-2" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Target</th>
    <th class="text-center py-2" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Capaian Saat Ini</th>
    <th class="text-center py-2" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Rata²/Bln</th>
    <th class="text-center py-2" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Harus/Bln Sisa</th>
    <th class="text-center py-2" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Proyeksi Akhir Tahun</th>
    <th class="text-center py-2 pe-3" style="font-size:0.68rem;font-weight:700;text-transform:uppercase;color:#6b7280">Verdict</th>
</tr>
</thead>
<tbody>
<?php $__empty_1 = true; $__currentLoopData = $forecast_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<?php
    $verdict_color = $fi['verdict'] === 'aman' ? '#059669' : ($fi['verdict'] === 'waspada' ? '#d97706' : '#dc2626');
    $verdict_bg = $fi['verdict'] === 'aman' ? '#d1fae5' : ($fi['verdict'] === 'waspada' ? '#fef3c7' : '#fee2e2');
    $verdict_text = $fi['verdict'] === 'aman' ? '✓ Aman' : ($fi['verdict'] === 'waspada' ? '⚠ Waspada' : '✕ Kritis');
    $need_extra = $fi['ratio'] > 1;
?>
<tr style="<?php echo e($fi['verdict'] === 'kritis' ? 'background: rgba(220,38,38,0.02)' : ''); ?>">
    <td class="ps-3 align-middle" style="max-width:220px">
        <div class="fw-bold text-dark" style="font-size:0.78rem;line-height:1.3"><?php echo e(Str::limit($fi['indikator'], 60)); ?></div>
        <div class="text-muted mt-1" style="font-size:0.65rem"><i class="fas fa-layer-group me-1"></i><?php echo e(Str::limit($fi['klaster'], 28)); ?></div>
    </td>
    <td class="text-center align-middle fw-bold"><?php echo e(number_format($fi['target'])); ?></td>
    <td class="text-center align-middle">
        <div class="fw-bold" style="color:#3498db"><?php echo e(number_format($fi['capaian'])); ?></div>
        <div style="font-size:0.65rem;color:#94a3b8"><?php echo e($fi['capaian'] > 0 ? round(($fi['capaian']/$fi['target'])*100, 1).'%' : '0%'); ?></div>
    </td>
    <td class="text-center align-middle text-muted"><?php echo e(number_format($fi['avg_pm'])); ?></td>
    <td class="text-center align-middle">
        <span class="fw-bold" style="color: <?php echo e($need_extra ? '#dc2626' : '#059669'); ?>"><?php echo e(number_format($fi['needed_pm'])); ?></span>
        <?php if($need_extra && $fi['avg_pm'] > 0): ?>
        <div style="font-size:0.62rem;color:#dc2626">+<?php echo e(round((($fi['ratio']-1)*100))); ?>% dari tren</div>
        <?php endif; ?>
    </td>
    <td class="text-center align-middle">
        <div class="fw-bold" style="color: <?php echo e($verdict_color); ?>"><?php echo e($fi['proj_pct']); ?>%</div>
        <div class="mx-auto mt-1" style="width:80px;height:4px;background:#f1f5f9;border-radius:4px;overflow:hidden">
            <div style="height:100%;width:<?php echo e(min($fi['proj_pct'], 100)); ?>%;background:<?php echo e($verdict_color); ?>;border-radius:4px"></div>
        </div>
    </td>
    <td class="text-center align-middle pe-3">
        <span class="px-2 py-1 rounded-pill fw-bold" style="background:<?php echo e($verdict_bg); ?>;color:<?php echo e($verdict_color); ?>;font-size:0.68rem;white-space:nowrap"><?php echo e($verdict_text); ?></span>
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data target</td></tr>
<?php endif; ?>
</tbody>
</table>
</div>

</div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){

function initProgressBars(){
const observer=new IntersectionObserver(entries=>{
entries.forEach(e=>{
if(!e.isIntersecting)return;
const el=e.target;
if(el.dataset.animated)return;
el.dataset.animated='1';
const w=el.dataset.targetWidth||parseInt(el.style.width,10);
el.style.width=(w||0)+'%';
});
});
document.querySelectorAll('.progress-bar-fill').forEach(el=>{
const m=String(el.style.width||'').match(/([\d.]+)%/);
el.dataset.targetWidth=m?m[1]:'0';
el.style.width='0%';
observer.observe(el);
});
}
initProgressBars();

// Smart Insights Tab tidak memerlukan script chart khusus
});
</script>

<script>
// === REAL-TIME CLOCK WIB (UTC+7) ===
(function() {
    const BULAN = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
    const HARI  = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

    function updateClock() {
        // Gunakan timezone Asia/Jakarta (WIB = UTC+7)
        const now = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Jakarta' }));
        const hari   = HARI[now.getDay()];
        const tgl    = String(now.getDate()).padStart(2, '0');
        const bulan  = BULAN[now.getMonth()];
        const tahun  = now.getFullYear();
        const jam    = String(now.getHours()).padStart(2, '0');
        const menit  = String(now.getMinutes()).padStart(2, '0');
        const detik  = String(now.getSeconds()).padStart(2, '0');

        const el = document.getElementById('clock-text');
        if (el) {
            el.innerHTML = `${hari}, ${tgl} ${bulan} ${tahun} &nbsp;|&nbsp; ${jam}:${menit}:<span style="opacity:0.7">${detik}</span> WIB`;
        }
    }

    updateClock(); // tampilkan langsung
    setInterval(updateClock, 1000); // update tiap detik
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\maganglaravel\resources\views/dashboard.blade.php ENDPATH**/ ?>