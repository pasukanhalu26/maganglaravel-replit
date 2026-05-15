<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIP Puskesmas Driyorejo - Internal</title>
    <!-- Preconnect untuk mempercepat loading CDN -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    
    <!-- Documentasi Resmi: Bootstrap 5.3 & Font Awesome 6.4 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    <style>
        :root {
            --bg-main: #F7F8FC;
            --bg-sidebar: #FFFFFF;
            --text-main: #1e293b;
            --text-muted: #94a3b8;
            --accent-green: #059669;
            --accent-teal: #78C9CF;
            --accent-orange: #FF7B54;
            --border-color: #e8ecf2;
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 78px;
            --card-shadow: 0 1px 3px rgba(0,0,0,.04), 0 1px 2px rgba(0,0,0,.02);
        }

        /* --- DARK MODE VARIABLES --- */
        body.dark-mode {
            --bg-main: #0f172a;
            --bg-sidebar: #1e293b;
            --text-main: #e2e8f0;
            --text-muted: #94a3b8;
            --accent-green: #10B981;
            --border-color: #334155;
            --card-shadow: 0 1px 3px rgba(0,0,0,.2);
            --bs-table-bg: transparent;
            --bs-table-color: var(--text-main);
            --bs-table-striped-bg: #1e293b;
            --bs-table-striped-color: var(--text-main);
            --bs-table-active-bg: #334155;
            --bs-table-hover-bg: #334155;
            --bs-table-hover-color: var(--text-main);
        }
        /* Override hardcoded Bootstrap utilities */
        body.dark-mode .bg-white {
            background-color: var(--bg-sidebar) !important;
        }
        body.dark-mode .text-dark {
            color: var(--text-main) !important;
        }
        body.dark-mode .card,
        body.dark-mode .modern-form-card,
        body.dark-mode .table-responsive,
        body.dark-mode .card-header,
        body.dark-mode .stat-card-modern,
        body.dark-mode .chart-card {
            background: var(--bg-sidebar) !important;
            border-color: var(--border-color) !important;
        }
        
        /* Tom Select Dark Mode */
        body.dark-mode .ts-control, 
        body.dark-mode .ts-wrapper.single .ts-control {
            background-color: #334155;
            color: var(--text-main);
            border-color: var(--border-color);
        }
        body.dark-mode .ts-dropdown, 
        body.dark-mode .ts-dropdown .option {
            background-color: #334155;
            color: var(--text-main);
            border-color: var(--border-color);
        }
        body.dark-mode .ts-dropdown .option.active, 
        body.dark-mode .ts-dropdown .option:hover {
            background-color: #1e293b;
            color: var(--accent-green);
        }
        body.dark-mode .ts-control input {
            color: var(--text-main);
        }
        body.dark-mode .table thead th {
            background-color: #334155;
            color: var(--text-main);
            border-color: var(--border-color);
        }
        body.dark-mode .table tbody td {
            background-color: var(--bg-sidebar) !important;
            color: var(--text-main) !important;
            border-color: var(--border-color);
        }
        body.dark-mode .table-hover tbody tr:hover td {
            background-color: #334155 !important;
            color: var(--accent-green) !important;
        }
        body.dark-mode .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: #1e293b !important;
        }
        body.dark-mode .form-control-modern,
        body.dark-mode .form-select-modern,
        body.dark-mode .form-control-clean {
            background-color: #334155;
            color: var(--text-main);
            border-color: var(--border-color);
        }
        body.dark-mode .form-control-modern:focus,
        body.dark-mode .form-select-modern:focus,
        body.dark-mode .form-control-clean:focus {
            background-color: #1e293b;
        }
        body.dark-mode #sidebar ul li a:hover {
            background: #334155;
        }
        body.dark-mode #sidebar ul li.active > a {
            background: #064e3b;
            color: #6ee7b7;
        }
        body.dark-mode .btn-light {
            background-color: #334155;
            color: var(--text-main);
            border-color: var(--border-color);
        }
        body.dark-mode .bg-light {
            background-color: #334155 !important;
            color: var(--text-main) !important;
        }
        body.dark-mode .modern-form-header {
            background: linear-gradient(135deg, #065f46, #064e3b);
        }
        body.dark-mode .btn-modern-cancel {
            background: #1e293b;
            color: var(--text-main);
        }

        /* NProgress (Loading Bar) Custom Color */
        #nprogress .bar {
            background: var(--accent-green) !important;
            height: 4px !important;
        }
        #nprogress .peg {
            box-shadow: 0 0 10px var(--accent-green), 0 0 5px var(--accent-green) !important;
        }
        #nprogress .spinner-icon {
            border-top-color: var(--accent-green) !important;
            border-left-color: var(--accent-green) !important;
        }

        body { background-color: var(--bg-main); font-family: 'Inter', sans-serif; color: var(--text-main); overflow-x: hidden; font-size: .925rem; -webkit-font-smoothing: antialiased; }
        .wrapper { display: flex; align-items: stretch; width: 100%; }
        
        /* --- SIDEBAR MODERN WHITE --- */
        #sidebar { 
            min-width: var(--sidebar-width); 
            max-width: var(--sidebar-width); 
            background: var(--bg-sidebar); 
            color: var(--text-main); 
            transition: all 0.3s ease-in-out; 
            min-height: 100vh; 
            border-right: 1px solid var(--border-color);
            z-index: 1000;
        }
        
        .sidebar-header { padding: 24px 20px; text-align: center; border-bottom: 1px solid var(--border-color); white-space: nowrap; overflow: hidden; transition: all 0.3s; }
        .brand-logo { font-size: 1.2rem; font-weight: 800; color: var(--accent-green); letter-spacing: -0.5px; transition: all 0.3s; }
        .brand-logo span { color: var(--text-main); font-weight: 700; }
        
        .sidebar-heading { padding: 22px 24px 8px; font-size: 0.65rem; text-transform: uppercase; letter-spacing: 0.12rem; color: var(--text-muted); font-weight: 700; white-space: nowrap; transition: all 0.3s; }
        
        #sidebar ul li a { padding: 10px 24px; font-size: 0.88rem; display: flex; align-items: center; color: #475569; text-decoration: none; transition: all 0.2s; font-weight: 500; white-space: nowrap; border-radius: 0 12px 12px 0; margin-right: 12px; }
        #sidebar ul li a:hover { color: var(--accent-green); background: #ecfdf5; }
        #sidebar ul li.active > a { color: #065f46; background: #d1fae5; font-weight: 600; }
        #sidebar ul li a i { width: 28px; font-size: 1rem; color: #94a3b8; text-align: center; margin-right: 10px; transition: color 0.2s; }
        #sidebar ul li.active > a i { color: #059669; }

        /* --- SIDEBAR COLLAPSED STATE (MINIMIZE) --- */
        #sidebar.collapsed {
            min-width: var(--sidebar-collapsed-width);
            max-width: var(--sidebar-collapsed-width);
        }
        #sidebar.collapsed .sidebar-header { padding: 30px 0; }
        #sidebar.collapsed .brand-logo { font-size: 1rem; }
        #sidebar.collapsed .brand-logo span { display: none; } /* Sembunyikan teks 'DRIYOREJO' */
        #sidebar.collapsed .sidebar-heading { display: none; } /* Sembunyikan heading */
        #sidebar.collapsed ul li a span { display: none; } /* Sembunyikan teks menu */
        #sidebar.collapsed ul li a { padding: 15px 0; justify-content: center; }
        #sidebar.collapsed ul li a i { margin-right: 0; font-size: 1.3rem; }
        #sidebar.collapsed ul li a:hover, #sidebar.collapsed ul li.active > a { border-radius: 15px; margin: 0 10px; }

        /* --- CONTENT AREA --- */
        #content { width: 100%; padding: 32px 36px; transition: all 0.3s ease-in-out; overflow-y: auto; height: 100vh; }
        
        /* TOP NAV */
        .navbar-custom { background: transparent; padding: 0 0 20px 0; margin-bottom: 24px; border-bottom: 1px solid var(--border-color); }
        .toggle-btn { background: var(--bg-sidebar); border: 1px solid var(--border-color); color: var(--text-main); border-radius: 10px; padding: 8px 14px; cursor: pointer; transition: 0.2s; box-shadow: var(--card-shadow); }
        .toggle-btn:hover { background: #ecfdf5; color: var(--accent-green); }
        
        .user-profile-nav { display: flex; align-items: center; }
        .user-profile-nav img { border-radius: 50%; width: 45px; height: 45px; object-fit: cover; border: 2px solid #fff; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
        .user-info-text { margin-left: 15px; }
        .user-info-text .greeting { font-size: 1.1rem; font-weight: 600; color: var(--text-main); }
        .user-info-text .email { font-size: 0.85rem; color: var(--text-muted); }

        /* UNIVERSAL CARD UX */
        .card { border: none; border-radius: 16px; background: var(--bg-sidebar); border: 1px solid var(--border-color); box-shadow: var(--card-shadow); transition: box-shadow 0.25s, transform 0.25s; }
        .card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.06); transform: translateY(-2px); }
        .card-header { background: var(--bg-sidebar); border-bottom: 1px solid var(--border-color); border-radius: 16px 16px 0 0 !important; padding: 18px 24px; }

        /* UNIVERSAL TABLE UX */
        .table-responsive { border-radius: 12px; border: 1px solid var(--border-color); overflow: hidden; margin-bottom: 1.5rem; background: var(--bg-sidebar); }
        .table { margin-bottom: 0; }
        .table thead th { background-color: #f8fafc; border-bottom: 1px solid var(--border-color); color: #475569; font-weight: 600; font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.06em; vertical-align: middle; padding: 12px 16px; border-top: none; }
        .table tbody td { vertical-align: middle; padding: 12px 16px; color: var(--text-main); border-bottom: 1px solid #f1f5f9; font-size: 0.875rem; }
        .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: #fafbfd; }
        .table-hover tbody tr:hover td { background-color: #ecfdf5 !important; transition: background 0.15s; }
        .table-borderless tbody td { border-bottom: none; }

        /* BADGES IN TABLES */
        .badge { padding: 5px 10px; font-weight: 600; letter-spacing: 0.02em; border-radius: 6px; font-size: 0.75rem; }
        .bg-success { background-color: #ecfdf5 !important; color: #059669 !important; border: 1px solid #a7f3d0; }
        .bg-secondary { background-color: #f1f5f9 !important; color: #64748b !important; border: 1px solid #e2e8f0; }
        .bg-danger { background-color: #fef2f2 !important; color: #dc2626 !important; border: 1px solid #fecaca; }
        .bg-warning { background-color: #fffbeb !important; color: #d97706 !important; border: 1px solid #fde68a; }
        .bg-info { background-color: #ecfeff !important; color: #0891b2 !important; border: 1px solid #a5f3fc; }
        .bg-primary { background-color: #eff6ff !important; color: #2563eb !important; border: 1px solid #bfdbfe; }

        /* BUTTONS IN TABLES */
        .btn-action { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: all 0.3s; border: none; margin: 0 2px; }
        .btn-action-edit { background-color: #FFF9E6; color: #FFC107; }
        .btn-action-edit:hover { background-color: #FFC107; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(255, 193, 7, 0.2); }
        .btn-action-delete { background-color: #FEF0F0; color: #DC3545; }
        .btn-action-delete:hover { background-color: #DC3545; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2); }
        .btn-action-restore { background-color: #EBF8EE; color: #28A745; }
        .btn-action-restore:hover { background-color: #28A745; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2); }
        .btn-action-info { background-color: #E6F7F8; color: #17A2B8; }
        .btn-action-info:hover { background-color: #17A2B8; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(23, 162, 184, 0.2); }

        /* PAGINATION UX */
        .pagination { justify-content: center; margin-top: 1rem; }
        .pagination .page-link { border-radius: 8px; margin: 0 4px; color: var(--text-main); border-color: var(--border-color); font-weight: 500; transition: all 0.2s; }
        .pagination .page-item.active .page-link { background: var(--accent-green); border-color: var(--accent-green); color: #fff; box-shadow: 0 4px 8px rgba(5,150,105,0.2); }
        .pagination .page-link:hover:not(.active) { background: #F0FDF4; color: var(--accent-green); border-color: #F0FDF4; }
        
        /* SEARCH & BUTTONS */
        .form-control-clean { border-radius: 12px; border: 1px solid var(--border-color); padding: 10px 15px; background: #FAF9FB; transition: 0.3s; }
        .form-control-clean:focus { box-shadow: 0 0 0 3px rgba(5,150,105,0.1); border-color: var(--accent-green); background: #fff; }
        .btn-green { background: linear-gradient(135deg, #059669, #047857); color: #fff; border-radius: 10px; padding: 9px 20px; font-weight: 600; border: none; transition: all 0.2s; font-size: 0.85rem; box-shadow: 0 2px 8px rgba(5,150,105,.2); }
        .btn-green:hover { background: linear-gradient(135deg, #047857, #065f46); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(5,150,105,.3); }

        /* MODERN FORMS UI/UX */
        .modern-form-card { background: #fff; border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(5,150,105,0.05); overflow: hidden; }
        .modern-form-header { background: linear-gradient(135deg, var(--accent-green), #047857); color: #fff; padding: 25px 30px; border: none; }
        .modern-form-header h6 { margin: 0; font-weight: 600; letter-spacing: 0.5px; }
        .modern-form-body { padding: 30px; }
        
        .form-floating > .form-control-modern { border: 1px solid var(--border-color); border-radius: 12px; background: #FAF9FB; padding-top: 1.625rem; padding-bottom: 0.625rem; height: calc(3.5rem + 2px); transition: all 0.3s; }
        .form-floating > .form-control-modern:focus { border-color: var(--accent-green); box-shadow: 0 0 0 4px rgba(5,150,105,0.1); background: #fff; }
        .form-floating > label { padding: 1rem 1rem; color: var(--text-muted); transition: all 0.2s; }
        .form-floating > .form-control-modern:focus ~ label, .form-floating > .form-control-modern:not(:placeholder-shown) ~ label { color: var(--accent-green); transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem); }
        
        .form-floating > .form-select-modern { border: 1px solid var(--border-color); border-radius: 12px; background-color: #FAF9FB; padding-top: 1.625rem; padding-bottom: 0.625rem; height: calc(3.5rem + 2px); transition: all 0.3s; }
        .form-floating > .form-select-modern:focus { border-color: var(--accent-green); box-shadow: 0 0 0 4px rgba(5,150,105,0.1); background-color: #fff; }
        
        .btn-modern-save { background: linear-gradient(135deg, var(--accent-green), #047857); color: #fff; border-radius: 12px; padding: 12px 25px; font-weight: 600; border: none; transition: 0.3s; width: 100%; letter-spacing: 0.5px; }
        .btn-modern-save:hover { box-shadow: 0 5px 15px rgba(5,150,105,0.3); transform: translateY(-2px); color: #fff; }
        
        .btn-modern-cancel { background: #fff; color: var(--text-muted); border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 25px; font-weight: 600; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); width: 100%; text-align: center; display: block; text-decoration: none; position: relative; }
        .btn-modern-cancel:hover { background: #FEF0F0; color: #DC3545; border-color: #FCD2D2; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15); }
        /* Efek tooltip modern untuk Batal */
        .btn-modern-cancel::after { content: "Batalkan aksi ini"; position: absolute; bottom: 110%; left: 50%; transform: translateX(-50%) translateY(10px); background: #DC3545; color: #fff; font-size: 0.75rem; padding: 6px 12px; border-radius: 6px; opacity: 0; visibility: hidden; transition: all 0.3s; white-space: nowrap; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-weight: 500; z-index: 10; pointer-events: none; }
        .btn-modern-cancel::before { content: ""; position: absolute; bottom: 100%; left: 50%; transform: translateX(-50%) translateY(10px); border-width: 6px; border-style: solid; border-color: #DC3545 transparent transparent transparent; opacity: 0; visibility: hidden; transition: all 0.3s; z-index: 10; pointer-events: none; }
        .btn-modern-cancel:hover::after, .btn-modern-cancel:hover::before { opacity: 1; visibility: visible; transform: translateX(-50%) translateY(0); }
        
        .text-green { color: var(--accent-green) !important; }

        /* Responsive */
        @media (max-width: 768px) {
            #sidebar { margin-left: calc(-1 * var(--sidebar-width)); position: absolute; height: 100%; z-index: 999; }
            #sidebar.active-mobile { margin-left: 0; box-shadow: 5px 0 15px rgba(0,0,0,0.1); }
            #content { padding: 20px; }
            .toggle-btn { display: block !important; }
        }
    </style>
</head>
<body>
    <script>
        // Cek Dark Mode segera untuk menghindari flash putih (FOUC)
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
        }
    </script>
    <div class="wrapper">
        <!-- SIDEBAR -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="brand-logo">SIP<span>DRIYOREJO</span></div>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" title="Dashboard"><i class="fas fa-chart-pie"></i> <span>Dashboard</span></a>
                </li>

                @can('kelola_master')
                <div class="sidebar-heading">Master Data</div>
                
                @can('kelola_user')
                <li class="{{ Request::is('user*') ? 'active' : '' }}">
                    <a href="{{ route('user.index') }}" title="User"><i class="fas fa-user-gear"></i> <span>User</span></a>
                </li>
                @endcan
                
                <li class="{{ Request::is('desa*') ? 'active' : '' }}">
                    <a href="{{ route('desa.index') }}" title="Desa"><i class="fas fa-house-medical"></i> <span>Desa</span></a>
                </li>
                <li class="{{ Request::is('klaster*') ? 'active' : '' }}">
                    <a href="{{ route('klaster.index') }}" title="Klaster"><i class="fas fa-boxes-stacked"></i> <span>Klaster</span></a>
                </li>
                <li class="{{ Request::is('program*') ? 'active' : '' }}">
                    <a href="{{ route('program.index') }}" title="Program"><i class="fas fa-list-check"></i> <span>Program</span></a>
                </li>
                <li class="{{ Request::is('indikator*') ? 'active' : '' }}">
                    <a href="{{ route('indikator.index') }}" title="Indikator"><i class="fas fa-file-waveform"></i> <span>Indikator</span></a>
                </li>
                <li class="{{ Request::is('target*') ? 'active' : '' }}">
                    <a href="{{ route('target.index') }}" title="Penetapan Target"><i class="fas fa-bullseye"></i> <span>Penetapan Target</span></a>
                </li>
                @endcan

                @can('kelola_capaian')
                <div class="sidebar-heading">Data Capaian</div>
                <li class="{{ Request::is('capaian') || Request::is('capaian/*') && !Request::is('capaian/laporan*') ? 'active' : '' }}">
                    <a href="{{ route('capaian.index') }}" title="Input Capaian"><i class="fas fa-file-signature"></i> <span>Input Capaian</span></a>
                </li>
                <li class="{{ Request::is('laporan/capaian*') ? 'active' : '' }}">
                    <a href="{{ route('capaian.laporan') }}" title="Laporan Master"><i class="fas fa-file-contract"></i> <span>Laporan Master</span></a>
                </li>
                @endcan

                <li class="mt-5">
                    <a href="{{ route('logout') }}" class="text-danger" title="Keluar">
                        <i class="fas fa-sign-out-alt text-danger"></i> <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- CONTENT -->
        <div id="content">
            <div class="navbar-custom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button type="button" id="sidebarCollapse" class="toggle-btn me-4 shadow-sm">
                        <i class="fas fa-bars-staggered"></i>
                    </button>
                    
                    <div class="user-profile-nav d-none d-md-flex">
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=D1FAE5&color=059669&bold=true" alt="Avatar">
                        <div class="user-info-text">
                                <i class="fas fa-fingerprint me-1"></i>{{ Auth::user()->username }}
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <!-- Tombol Dark Mode -->
                    <button type="button" id="darkModeToggle" class="btn btn-sm btn-light rounded-circle shadow-sm" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; transition: 0.3s;" aria-label="Toggle Dark Mode">
                        <i class="fas fa-moon"></i>
                    </button>
                    <span class="badge bg-light text-dark text-uppercase p-2 px-3 rounded-pill border shadow-sm">{{ Auth::user()->role }}</span>
                </div>
            </div>

            <!-- SweetAlert akan menggantikan alert default ini -->
            <!-- @if(session('success')) ... @endif dihapus untuk memakai SweetAlert -->

            @yield('content')
        </div>
    </div>

    <!-- Script Utama (Aman & Native JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>    
    <!-- Tom Select & Flatpickr Global Config -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi Tom Select
            document.querySelectorAll('.select-searchable').forEach(function(el) {
                new TomSelect(el, {
                    create: false,
                    sortField: { field: "text", direction: "asc" },
                    placeholder: "Ketik untuk mencari...",
                    allowEmptyOption: true
                });
            });

            // Inisialisasi Flatpickr
            flatpickr(".datepicker-modern", {
                locale: "id", // Bahasa Indonesia
                dateFormat: "Y-m-d",
                altInput: true,
                altFormat: "d F Y", // Contoh: 24 April 2026
                disableMobile: "true"
            });
            
            // Inisialisasi Flatpickr khusus untuk Tahun
            flatpickr(".yearpicker-modern", {
                locale: "id",
                dateFormat: "Y",
                altInput: true,
                altFormat: "Y",
                disableMobile: "true",
                plugins: [
                    // Hanya menampilkan tahun (secara default native tidak bisa sempurna tanpa plugin,
                    // tapi dengan setting ini user dipaksa pilih tanggal dan akan diambil tahunnya.
                    // Jika butuh plugin MonthSelect, pastikan di-load terpisah)
                ]
            });
        });
    </script>

    <!-- SweetAlert Global Config -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek Session Success dari Laravel
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    html: '{!! addslashes(session("success")) !!}',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg'
                    }
                });
            @endif

            // Cek Session Error dari Laravel
            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session("error") }}',
                    customClass: {
                        popup: 'rounded-4 shadow-lg'
                    }
                });
            @endif

            // Intercept form hapus (pastikan tombol delete atau form-nya punya class .form-delete)
            const deleteForms = document.querySelectorAll('.form-delete');
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Ambil pesan dinamis dari atribut form jika ada, kalau tidak pakai default
                    const title = form.getAttribute('data-title') || 'Apakah Anda yakin?';
                    const text = form.getAttribute('data-text') || 'Data ini akan diubah statusnya!';
                    const confirmColor = form.getAttribute('data-color') || '#dc3545';
                    const confirmText = form.getAttribute('data-confirm') || 'Ya, lanjutkan!';

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: confirmColor,
                        cancelButtonColor: '#8E8A9A',
                        confirmButtonText: confirmText,
                        cancelButtonText: 'Batal',
                        customClass: {
                            popup: 'rounded-4 shadow-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        /**
         * Dokumentasi & Keamanan:
         * 1. Vanilla JavaScript (Tidak bergantung pada jQuery, menghindari celah keamanan library pihak ketiga).
         * 2. Strict Mode diterapkan otomatis dalam module/script modern, menjaga keamanan eksekusi.
         * 3. LocalStorage digunakan untuk menyimpan state sidebar (minimize/maximize) agar tetap persisten 
         *    saat user berpindah halaman. Data hanya disimpan di sisi klien (Client-side) dan tidak berisiko XSS.
         */
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarCollapse');
            
            // Cek state dari LocalStorage saat halaman dimuat
            const isCollapsed = localStorage.getItem('sidebar-collapsed');
            
            if (isCollapsed === 'true' && window.innerWidth > 768) {
                sidebar.classList.add('collapsed');
            }

            // Fungsi Toggle
            toggleBtn.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    // Logika untuk Mobile: Tampilkan / Sembunyikan penuh
                    sidebar.classList.toggle('active-mobile');
                } else {
                    // Logika untuk Desktop: Minimize / Maximize
                    sidebar.classList.toggle('collapsed');
                    
                    // Simpan state ke LocalStorage agar saat pindah halaman tetap minimize
                    if (sidebar.classList.contains('collapsed')) {
                        localStorage.setItem('sidebar-collapsed', 'true');
                    } else {
                        localStorage.setItem('sidebar-collapsed', 'false');
                    }
                }
            });

            // Handle Resize Window
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('collapsed');
                } else {
                    sidebar.classList.remove('active-mobile');
                    if (localStorage.getItem('sidebar-collapsed') === 'true') {
                        sidebar.classList.add('collapsed');
                    }
                }
            });

            // Handle Dark Mode Toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            if (darkModeToggle) {
                const icon = darkModeToggle.querySelector('i');
                
                // Set initial icon based on theme
                if (document.body.classList.contains('dark-mode')) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                    icon.style.color = '#FFD43B'; // Warna kuning matahari
                }

                darkModeToggle.addEventListener('click', function() {
                    document.body.classList.toggle('dark-mode');
                    
                    if (document.body.classList.contains('dark-mode')) {
                        localStorage.setItem('theme', 'dark');
                        icon.classList.remove('fa-moon');
                        icon.classList.add('fa-sun');
                        icon.style.color = '#FFD43B';
                    } else {
                        localStorage.setItem('theme', 'light');
                        icon.classList.remove('fa-sun');
                        icon.classList.add('fa-moon');
                        icon.style.color = ''; // Reset warna
                    }
                });
            }
        });
    </script>
    
    <!-- NProgress Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        // Memulai animasi loading bar di atas layar
        NProgress.configure({ showSpinner: true, speed: 400, minimum: 0.2 });
        NProgress.start();
        
        window.addEventListener('load', function() {
            NProgress.done();
        });

        // Memicu loading bar setiap kali user klik link
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');
            if (link && link.href && !link.href.startsWith('javascript') && !link.href.startsWith('#') && link.target !== '_blank') {
                NProgress.start();
            }
        });
    </script>
</body>
</html>