<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Panel Pengelola Data | Stasiun Klimatologi Papua Selatan - BMKG</title>

    <!-- Google Fonts: Plus Jakarta Sans (Standar Tampilan Publik & Institusional BMKG) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bmkg-navy: #002b49;
            --bmkg-navy-dark: #00192b;
            --bmkg-navy-light: #0a3d62;
            --bmkg-blue: #0284c7;
            --bmkg-blue-dark: #0369a1;
            --bmkg-blue-light: #e0f2fe;
            --bmkg-cyan: #0ea5e9;
            --bmkg-gold: #f59e0b;
            --bmkg-gold-soft: #fef3c7;
            
            --ink: #0f172a;
            --ink-secondary: #334155;
            --muted: #64748b;
            --line: #e2e8f0;
            --line-strong: #cbd5e1;
            --paper: #f4f8fb;
            --card-bg: #ffffff;
            
            --status-awas: #dc2626;
            --status-awas-bg: #fee2e2;
            --status-siaga: #ea580c;
            --status-siaga-bg: #ffedd5;
            --status-waspada: #d97706;
            --status-waspada-bg: #fef3c7;
            --status-aman: #16a34a;
            --status-aman-bg: #dcfce7;
            
            --r-sm: 6px;
            --r-md: 10px;
            --r-lg: 14px;
            --r-xl: 18px;
            
            --shadow-sm: 0 1px 3px rgba(0, 43, 73, 0.05);
            --shadow-md: 0 4px 14px rgba(0, 43, 73, 0.07);
            --shadow-lg: 0 10px 25px rgba(0, 43, 73, 0.1);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--paper);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 13.5px;
            line-height: 1.6;
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
        }

        button, input, select, textarea {
            font-family: inherit;
        }

        /* Topbar */
        .admin-topbar {
            height: 74px;
            background: #ffffff;
            border-bottom: 2px solid #e0e9f1;
            box-shadow: var(--shadow-sm);
            display: flex;
            align-items: center;
            padding: 0 clamp(16px, 4vw, 48px);
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar-mark {
            width: 48px;
            height: 48px;
            object-fit: contain;
            flex: none;
        }
        .topbar-brand {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }
        .topbar-institution {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
            color: var(--bmkg-blue);
            text-transform: uppercase;
        }
        .topbar-title {
            font-size: 15px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.01em;
            line-height: 1.2;
            margin: 0;
        }
        .topbar-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-left: 10px;
            background: var(--bmkg-blue-light);
            color: var(--bmkg-blue-dark);
            border: 1px solid #bae6fd;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: .04em;
        }
        .topbar-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--bmkg-blue);
        }
        .topbar-nav {
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--bmkg-navy);
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
            font-size: 12px;
            padding: 9px 16px;
            border-radius: var(--r-md);
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(0, 43, 73, 0.2);
        }
        .topbar-nav:hover {
            background: var(--bmkg-blue-dark);
            transform: translateY(-1px);
        }

        /* Container Layout */
        .wrap {
            width: min(1140px, calc(100% - 32px));
            margin: 28px auto 60px;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 16px;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--line);
        }
        .eyebrow {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--bmkg-blue);
            font-weight: 800;
            margin-bottom: 4px;
            display: inline-block;
        }
        .heading h2 {
            font-size: clamp(22px, 2.5vw, 28px);
            letter-spacing: -.03em;
            color: var(--bmkg-navy);
            font-weight: 800;
            margin: 0;
            line-height: 1.25;
        }
        .heading p {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        /* Period Switcher */
        .admin-period {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid var(--line-strong);
            border-radius: var(--r-md);
            padding: 8px 12px;
            box-shadow: var(--shadow-sm);
        }
        .admin-period label {
            font-size: 11px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
        }
        .admin-period select,
        .admin-period input {
            height: 36px;
            border: 1px solid var(--line);
            border-radius: var(--r-sm);
            padding: 0 10px;
            background: #f8fafc;
            color: var(--ink);
            font-size: 12.5px;
            font-weight: 600;
            outline: none;
        }
        .admin-period select:focus,
        .admin-period input:focus {
            border-color: var(--bmkg-blue);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }
        .admin-period .btn {
            height: 36px;
            padding: 0 14px;
            font-size: 12px;
            white-space: nowrap;
        }

        /* Card Styles */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            box-shadow: var(--shadow-sm);
            padding: 24px 28px;
            margin-bottom: 20px;
            position: relative;
        }
        .card-header-bar {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }
        .card h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.01em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card h3::before {
            content: "";
            display: inline-block;
            width: 4px;
            height: 16px;
            background: var(--bmkg-blue);
            border-radius: 2px;
        }
        .sub {
            font-size: 12.5px;
            color: var(--muted);
            margin: 4px 0 18px;
            line-height: 1.5;
        }

        /* Forms */
        .form {
            display: grid;
            grid-template-columns: 1.1fr 1fr auto;
            gap: 12px;
            align-items: end;
        }
        .field label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--ink-secondary);
            margin: 0 0 6px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .field input,
        .field select,
        .field textarea {
            width: 100%;
            height: 42px;
            border: 1px solid var(--line-strong);
            border-radius: var(--r-sm);
            background: #ffffff;
            padding: 0 12px;
            color: var(--ink);
            font-size: 13px;
            outline: none;
            transition: all .15s ease;
        }
        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            border-color: var(--bmkg-blue);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
            background: #ffffff;
        }

        /* Buttons */
        .btn {
            border: 0;
            border-radius: var(--r-sm);
            background: var(--bmkg-navy);
            color: #ffffff;
            font-weight: 700;
            font-size: 12.5px;
            padding: 0 18px;
            height: 42px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all .2s ease;
            box-shadow: 0 2px 6px rgba(0, 43, 73, 0.15);
        }
        .btn:hover {
            background: var(--bmkg-blue-dark);
            transform: translateY(-1px);
        }
        .btn-blue {
            background: var(--bmkg-blue);
        }
        .btn-blue:hover {
            background: var(--bmkg-blue-dark);
        }
        .delete {
            border: 1px solid #fecaca;
            background: #fff1f2;
            color: #b91c1c;
            border-radius: var(--r-sm);
            padding: 6px 10px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: all .15s;
        }
        .delete:hover {
            background: #fee2e2;
            color: #991b1b;
        }
        .edit-link {
            display: inline-block;
            color: var(--bmkg-blue);
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            padding: 5px 8px;
            border-radius: var(--r-sm);
            background: var(--bmkg-blue-light);
            border: 1px solid #bae6fd;
            transition: all .15s;
        }
        .edit-link:hover {
            background: #bae6fd;
            color: var(--bmkg-blue-dark);
        }

        .admin-quicklink {
            padding: 8px 14px;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            color: var(--bmkg-navy);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all .2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .admin-quicklink:hover {
            background: var(--bmkg-blue-light);
            border-color: #bae6fd;
            color: var(--bmkg-blue-dark);
            transform: translateY(-1px);
        }

        /* Alerts */
        .flash {
            padding: 12px 16px;
            border-radius: var(--r-md);
            background: var(--status-aman-bg);
            border: 1px solid #86efac;
            color: var(--status-aman);
            font-size: 12.5px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .flash.error {
            background: var(--status-awas-bg);
            border-color: #fca5a5;
            color: var(--status-awas);
        }

        /* Tables */
        .table-wrap {
            overflow-x: auto;
            margin-top: 14px;
            border: 1px solid var(--line);
            border-radius: var(--r-md);
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
        }
        .table th {
            text-align: left;
            font-size: 10.5px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 12px 14px;
            background: #f8fafc;
            border-bottom: 1.5px solid var(--line);
            font-weight: 700;
        }
        .table td {
            font-size: 12.5px;
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--ink);
        }
        .table tr:last-child td {
            border-bottom: 0;
        }
        .table tr:hover td {
            background: #f8fafc;
        }
        .value { font-weight: 800; color: var(--bmkg-navy); }
        .empty {
            text-align: center;
            color: var(--muted);
            padding: 26px;
            font-size: 12.5px;
            font-style: italic;
        }
        .hint {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 14px;
            line-height: 1.5;
        }

        /* Badges */
        .badge {
            display: inline-block;
            font-size: 10.5px;
            font-weight: 800;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: .02em;
        }
        .safe { color: var(--status-aman); background: var(--status-aman-bg); }
        .caution { color: var(--status-waspada); background: var(--status-waspada-bg); }
        .danger { color: var(--status-awas); background: var(--status-awas-bg); }

        .badge-status-awas { background: var(--status-awas-bg); color: var(--status-awas); font-weight: 800; border-radius: 12px; padding: 3px 8px; font-size: 10.5px; border: 1px solid #fca5a5; }
        .badge-status-siaga { background: var(--status-siaga-bg); color: var(--status-siaga); font-weight: 800; border-radius: 12px; padding: 3px 8px; font-size: 10.5px; border: 1px solid #fdba74; }
        .badge-status-waspada { background: var(--status-waspada-bg); color: var(--status-waspada); font-weight: 800; border-radius: 12px; padding: 3px 8px; font-size: 10.5px; border: 1px solid #fde047; }
        .badge-status-tidak_ada { background: var(--status-aman-bg); color: var(--status-aman); font-weight: 800; border-radius: 12px; padding: 3px 8px; font-size: 10.5px; border: 1px solid #86efac; }
        .badge-category { display: inline-block; font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; background: var(--bmkg-blue-light); color: var(--bmkg-blue-dark); text-transform: uppercase; }

        /* Specific section layouts */
        .climate-form { grid-template-columns: repeat(4, minmax(120px, 1fr)); gap: 10px; }
        .climate-form .btn { grid-column: 1 / -1; width: 100%; }
        .suitability-form { grid-template-columns: 1.05fr 1fr 1fr 1fr auto; }
        .suitability-form .btn { white-space: nowrap; }
        .malaria-input-nav { display: flex; flex-wrap: wrap; gap: 8px; margin: 14px 0 18px; }
        .malaria-input-nav a { display: inline-flex; align-items: center; min-height: 34px; padding: 6px 11px; border: 1px solid var(--line); border-radius: 20px; background: #f8fafc; color: var(--bmkg-navy); text-decoration: none; font-size: 11px; font-weight: 700; }
        .malaria-input-nav a:hover { border-color: var(--bmkg-blue); color: var(--bmkg-blue-dark); }
        .malaria-period-note { margin: 8px 0 14px; padding: 9px 11px; border-left: 3px solid var(--bmkg-blue); border-radius: 4px; background: var(--bmkg-blue-light); color: var(--bmkg-navy); font-size: 12px; }
        .malaria-form-note { margin: 0 0 12px; color: var(--muted); font-size: 12px; }

        .template-label { display: block; font-size: 11px; font-weight: 700; color: var(--ink-secondary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: .04em; }
        .template-form textarea { display: block; width: 100%; resize: vertical; border: 1px solid var(--line-strong); border-radius: var(--r-sm); padding: 12px; color: var(--ink); font: inherit; font-size: 12.5px; line-height: 1.6; }
        .template-form textarea:focus { outline: none; border-color: var(--bmkg-blue); box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15); }
        .template-form .hint code { background: #e0f2fe; border-radius: 4px; padding: 2px 6px; color: var(--bmkg-navy); font-weight: 700; }

        .recipient-form { display: grid; grid-template-columns: 1fr 1fr 1.2fr auto; align-items: end; gap: 10px; padding: 16px; margin-bottom: 14px; background: #f8fafc; border: 1px solid var(--line); border-radius: var(--r-md); }
        .wa-list { display: grid; gap: 12px; }
        .wa-district { display: grid; gap: 10px; padding: 14px 16px; border: 1px solid var(--line); border-radius: var(--r-md); background: #ffffff; }
        .wa-summary { display: flex; flex-wrap: wrap; align-items: center; gap: 10px; padding-bottom: 6px; border-bottom: 1px solid var(--line); }
        .wa-summary strong { font-size: 13px; color: var(--bmkg-navy); }
        .wa-recipient { display: grid; grid-template-columns: minmax(0, 1fr) auto auto; align-items: center; gap: 10px; padding: 10px 12px; background: #f8fafc; border: 1px solid #edf2f7; border-radius: var(--r-sm); }
        .wa-contact { display: flex; flex-wrap: wrap; align-items: center; gap: 6px 14px; min-width: 0; }
        .wa-contact strong { font-size: 12px; color: var(--ink); }
        .wa-contact span { font-size: 11px; color: var(--muted); font-family: monospace; }
        .wa-send-form .btn { height: 34px; font-size: 11.5px; background: #25d366; }
        .wa-send-form .btn:hover { background: #1eb956; }
        .wa-recipient .delete { height: 34px; }
        .wa-error { grid-column: 1 / -1; margin: 0; color: var(--status-awas); font-size: 11px; min-height: 0; }
        .wa-error:not(:empty) { min-height: 14px; }
        .wa-empty { margin: 0; padding: 10px; text-align: left; font-size: 11.5px; color: var(--muted); }

        /* Footer */
        .admin-footer {
            font-size: 11px;
            color: var(--muted);
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--line);
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .suitability-form { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .suitability-form .btn { grid-column: 1 / -1; width: 100%; }
        }
        @media (max-width: 640px) {
            .admin-topbar { height: auto; padding: 12px 16px; flex-wrap: wrap; }
            .topbar-nav { width: 100%; justify-content: center; }
            .heading { display: block; }
            .admin-period { margin-top: 14px; flex-wrap: wrap; width: 100%; }
            .admin-period input { width: 90px; }
            .form { grid-template-columns: 1fr; }
            .btn { width: 100%; }
            .climate-form { grid-template-columns: 1fr 1fr; }
            .climate-form .btn { grid-column: 1 / -1; }
            .recipient-form { grid-template-columns: 1fr; }
            .wa-recipient { grid-template-columns: 1fr auto; }
            .wa-send-form { grid-column: 2; grid-row: 1; }
            .wa-recipient > form:not(.wa-send-form) { grid-column: 2; grid-row: 2; }
            .card { padding: 18px 16px; }
        }
        @media (max-width: 360px) {
            .climate-form { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<header class="admin-topbar">
    <img class="topbar-mark" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG">
    <div class="topbar-brand">
        <span class="topbar-institution">Badan Meteorologi, Klimatologi, dan Geofisika</span>
        <h1 class="topbar-title">Stasiun Klimatologi Papua Selatan <span class="topbar-badge"><span class="topbar-badge-dot"></span> Panel Pengelola</span></h1>
    </div>
    <div style="display:flex; align-items:center; gap:8px;">
        <a class="topbar-nav" href="{{ route('dashboard') }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            Kembali ke Portal Publik
        </a>
        <form method="post" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="topbar-nav" style="border:1px solid #fecaca; background:#fff1f2; color:#b91c1c; cursor:pointer;" title="Keluar dari sesi admin">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                Keluar
            </button>
        </form>
    </div>
</header>

<main class="wrap">
    <!-- Header Page & Period Selector -->
    <div class="heading">
        <div>
            <span class="eyebrow">Manajemen Data Iklim & Kesehatan</span>
            <h2>Kelola Data Wilayah & Peringatan Dini</h2>
            <p>Atur periode operasional, data angka insiden (AI), parameter iklim, dan titik observasi HTH.</p>
        </div>
        <form method="get" class="admin-period">
            <label for="month">Bulan</label>
            <select id="month" name="month" aria-label="Pilih bulan">
                @foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $number => $monthName)
                    <option value="{{ sprintf('%02d', $number) }}" @selected($selectedMonth === $number)>{{ $monthName }}</option>
                @endforeach
            </select>
            <label for="year">Tahun</label>
            <input id="year" name="year" type="number" min="1900" max="9999" step="1" value="{{ $selectedYear }}" aria-label="Pilih tahun">
            <button class="btn btn-blue" type="submit">Tampilkan</button>
        </form>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="flash">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="flash error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <!-- QUICK NAV ANCHORS -->
    <nav class="admin-quicknav" style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:20px;">
        <a href="#kelola-peringatan-dini" class="admin-quicklink">⚠️ Peringatan Dini Iklim</a>
        <a href="#kelola-pos-hth" class="admin-quicklink">☀️ Pos Observasi HTH</a>
        <a href="#kelola-peta-dasarian" class="admin-quicklink">🗺️ Peta Iklim Dasarian</a>
        <a href="#kelola-buletin-iklim" class="admin-quicklink">📰 Publikasi Buletin Iklim</a>
        <a href="#kelola-siling-malaria" class="admin-quicklink">🦟 SILING Malaria (AI &amp; Prediksi)</a>
        <a href="#kelola-notifikasi-wa" class="admin-quicklink">📱 Notifikasi WhatsApp Nakes</a>
    </nav>

    <!-- 1. KELOLA PERINGATAN DINI IKLIM (BARU) -->
    <section class="card" id="kelola-peringatan-dini">
        <div class="card-header-bar">
            <div>
                <h3>Peringatan Dini Iklim (Kekeringan & Hujan Lebat)</h3>
                <p class="sub">Atur status peringatan dini per kabupaten (Awas, Siaga, Waspada, Tidak Ada Peringatan) beserta daftar kecamatan/distrik terdampak untuk peta dan tabel publik.</p>
            </div>
        </div>
        <form method="post" novalidate action="{{ route('early-warning.store', [], false) }}" class="form" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:12px; align-items:end;">
            @csrf
            <div class="field">
                <label for="ew_category">Jenis Peringatan</label>
                <select id="ew_category" name="category" required>
                    <option value="kekeringan" @selected(old('category', $editingEw?->category) === 'kekeringan')>Kekeringan Meteorologis</option>
                    <option value="hujan_lebat" @selected(old('category', $editingEw?->category) === 'hujan_lebat')>Potensi Hujan Lebat</option>
                </select>
            </div>
            <div class="field">
                <label for="ew_district">Kabupaten</label>
                <select id="ew_district" name="district" required>
                    <option value="">Pilih kabupaten</option>
                    @foreach($districts as $d)
                        <option value="{{ $d }}" @selected(old('district', $editingEw?->district) === $d)>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="ew_status">Status Peringatan</label>
                <select id="ew_status" name="status" required>
                    <option value="tidak_ada" @selected(old('status', $editingEw?->status) === 'tidak_ada')>Tidak Ada Peringatan</option>
                    <option value="waspada" @selected(old('status', $editingEw?->status) === 'waspada')>Waspada</option>
                    <option value="siaga" @selected(old('status', $editingEw?->status) === 'siaga')>Siaga</option>
                    <option value="awas" @selected(old('status', $editingEw?->status) === 'awas')>Awas</option>
                </select>
            </div>
            <div class="field">
                <label for="ew_period">Periode Dasarian</label>
                <input id="ew_period" name="period" type="text" value="{{ old('period', $editingEw?->period ?? 'Dasarian II November 2026') }}" placeholder="Contoh: Dasarian II November 2026">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <label for="ew_waspada">Wilayah Terdampak Waspada (Kecamatan / Distrik)</label>
                <input id="ew_waspada" name="waspada_areas" type="text" value="{{ old('waspada_areas', $editingEw?->waspada_areas) }}" placeholder="Contoh: Distrik Naukenjerai, Animha (atau '-' jika tidak ada)">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <label for="ew_siaga">Wilayah Terdampak Siaga (Kecamatan / Distrik)</label>
                <input id="ew_siaga" name="siaga_areas" type="text" value="{{ old('siaga_areas', $editingEw?->siaga_areas) }}" placeholder="Contoh: Distrik Jair, Tanah Merah (atau '-' jika tidak ada)">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <label for="ew_awas">Wilayah Terdampak Awas (Kecamatan / Distrik)</label>
                <input id="ew_awas" name="awas_areas" type="text" value="{{ old('awas_areas', $editingEw?->awas_areas) }}" placeholder="Contoh: Distrik Kurik (atau '-' jika tidak ada)">
            </div>
            <div class="field" style="grid-column: 1 / -1;">
                <label for="ew_desc">Catatan / Deskripsi Tambahan</label>
                <input id="ew_desc" name="description" type="text" value="{{ old('description', $editingEw?->description) }}" placeholder="Contoh: Potensi curah hujan sangat rendah pada dasarian berjalan.">
            </div>
            <div style="grid-column: 1 / -1; display:flex; gap:10px; align-items:center;">
                <button class="btn btn-blue" type="submit">{{ $editingEw ? 'Perbarui Peringatan Dini' : 'Simpan Peringatan Dini' }}</button>
                @if($editingEw)
                    <a href="{{ route('admin') }}" class="delete" style="text-decoration:none; display:inline-flex; align-items:center; height:42px;">Batal Edit</a>
                @endif
            </div>
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Jenis</th>
                        <th>Kabupaten</th>
                        <th>Status</th>
                        <th>Waspada</th>
                        <th>Siaga</th>
                        <th>Awas</th>
                        <th>Periode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($earlyWarnings as $ew)
                    <tr>
                        <td data-label="Jenis"><span class="badge-category">{{ ucfirst(str_replace('_', ' ', $ew->category)) }}</span></td>
                        <td data-label="Kabupaten"><strong>{{ $ew->district }}</strong></td>
                        <td data-label="Status"><span class="badge-status-{{ $ew->status }}">{{ $ew->status_label }}</span></td>
                        <td data-label="Waspada">{{ $ew->waspada_areas ?: '—' }}</td>
                        <td data-label="Siaga">{{ $ew->siaga_areas ?: '—' }}</td>
                        <td data-label="Awas">{{ $ew->awas_areas ?: '—' }}</td>
                        <td data-label="Periode"><small>{{ $ew->period }}</small></td>
                        <td data-label="Aksi" style="white-space:nowrap;">
                            <a class="edit-link" href="{{ route('admin', ['edit_ew' => $ew->id]) }}#kelola-peringatan-dini">Edit</a>
                            <form method="post" novalidate action="{{ route('early-warning.destroy', $ew, false) }}" style="display:inline;" onsubmit="return confirm('Hapus data peringatan dini {{ $ew->category }} untuk {{ $ew->district }}?')">
                                @csrf @method('delete')
                                <button class="delete" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="empty">Belum ada data peringatan dini. Gunakan formulir di atas untuk menambahkan data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 2. KELOLA POS PENGAMATAN DISTRIBUSI HTH (BARU) -->
    <section class="card" id="kelola-pos-hth">
        <div class="card-header-bar">
            <div>
                <h3>Pos Pengamatan Distribusi HTH (Hari Tanpa Hujan)</h3>
                <p class="sub">Input titik koordinat pos hujan dan jumlah Hari Tanpa Hujan (HTH). Skala warna ditentukan otomatis sesuai standar Klimatologi BMKG.</p>
            </div>
        </div>
        <form method="post" novalidate action="{{ route('hth-observation.store', [], false) }}" class="form" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:12px; align-items:end;">
            @csrf
            @if($editingHth)
                <input type="hidden" name="id" value="{{ $editingHth->id }}">
            @endif
            <div class="field" style="grid-column: span 2;">
                <label for="hth_station_name">Nama Pos / Stasiun</label>
                <input id="hth_station_name" name="station_name" type="text" value="{{ old('station_name', $editingHth?->station_name) }}" placeholder="Contoh: Pos Hujan Kurik" required>
            </div>
            <div class="field">
                <label for="hth_district">Kabupaten</label>
                <select id="hth_district" name="district" required>
                    <option value="">Pilih kabupaten</option>
                    @foreach($hthDistricts as $d)
                        <option value="{{ $d }}" @selected(old('district', $editingHth?->district) === $d)>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="hth_subdistrict">Distrik / Lokasi</label>
                <input id="hth_subdistrict" name="subdistrict" type="text" value="{{ old('subdistrict', $editingHth?->subdistrict) }}" placeholder="Contoh: Kurik">
            </div>
            <div class="field">
                <label for="hth_latitude">Latitude</label>
                <input id="hth_latitude" name="latitude" type="number" step="any" min="-12" max="-3" value="{{ old('latitude', $editingHth?->latitude) }}" placeholder="Contoh: -8.312500" required>
            </div>
            <div class="field">
                <label for="hth_longitude">Longitude</label>
                <input id="hth_longitude" name="longitude" type="number" step="any" min="135" max="143" value="{{ old('longitude', $editingHth?->longitude) }}" placeholder="Contoh: 140.235600" required>
            </div>
            <div class="field">
                <label for="hth_days">Hari Tanpa Hujan (HTH)</label>
                <input id="hth_days" name="days" type="number" min="0" max="365" value="{{ old('days', $editingHth?->days ?? 0) }}" placeholder="0" required>
            </div>
            <div class="field">
                <label for="hth_updated_date">Tanggal Pembaruan</label>
                <input id="hth_updated_date" name="updated_date" type="date" value="{{ old('updated_date', $editingHth?->updated_date?->format('Y-m-d') ?? date('Y-m-d')) }}">
            </div>
            <div style="grid-column: 1 / -1; display:flex; gap:10px; align-items:center;">
                <button class="btn btn-blue" type="submit">{{ $editingHth ? 'Perbarui Pos Hujan' : 'Simpan Pos Hujan' }}</button>
                @if($editingHth)
                    <a href="{{ route('admin') }}" class="delete" style="text-decoration:none; display:inline-flex; align-items:center; height:42px;">Batal Edit</a>
                @endif
            </div>
        </form>

        <p class="hint">Klasifikasi BMKG: <strong>Hujan / 0 hari</strong>, <strong>1–5 hari</strong> (Sangat Pendek), <strong>6–10 hari</strong> (Pendek), <strong>11–20 hari</strong> (Menengah), <strong>21–30 hari</strong> (Panjang), <strong>31–60 hari</strong> (Sangat Panjang), <strong>&gt;60 hari</strong> (Kekeringan Ekstrem).</p>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Pos / Stasiun</th>
                        <th>Kabupaten</th>
                        <th>Distrik</th>
                        <th>Koordinat</th>
                        <th>HTH</th>
                        <th>Klasifikasi Standar</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hthObservations as $st)
                    <tr>
                        <td data-label="Nama Pos"><strong>{{ $st->station_name }}</strong></td>
                        <td data-label="Kabupaten">{{ $st->district }}</td>
                        <td data-label="Distrik">{{ $st->subdistrict ?: '—' }}</td>
                        <td data-label="Koordinat"><small>{{ number_format($st->latitude, 4) }}, {{ number_format($st->longitude, 4) }}</small></td>
                        <td data-label="HTH" class="value">{{ $st->days }} hari</td>
                        <td data-label="Klasifikasi">
                            <span style="display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:800; padding:3px 9px; border-radius:12px; background:{{ $st->color }}22; color:{{ $st->color }}; border:1px solid {{ $st->color }}44;">
                                <i style="display:inline-block; width:8px; height:8px; border-radius:2px; background:{{ $st->color }};"></i>
                                {{ $st->classification }}
                            </span>
                        </td>
                        <td data-label="Tanggal"><small>{{ $st->updated_date ? $st->updated_date->format('d/m/Y') : '—' }}</small></td>
                        <td data-label="Aksi" style="white-space:nowrap;">
                            <a class="edit-link" href="{{ route('admin', ['edit_hth' => $st->id]) }}#kelola-pos-hth">Edit</a>
                            <form method="post" novalidate action="{{ route('hth-observation.destroy', $st, false) }}" style="display:inline;" onsubmit="return confirm('Hapus pos pengamatan {{ $st->station_name }}?')">
                                @csrf @method('delete')
                                <button class="delete" type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="empty">Belum ada titik pos pengamatan HTH. Gunakan formulir di atas untuk menambahkan data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 3. KELOLA PETA & INFORMASI IKLIM DASARIAN (BARU) -->
    <section class="card" id="kelola-peta-dasarian">
        <div class="card-header-bar">
            <div>
                <h3>Publikasi Peta Iklim Dasarian (10 Harian)</h3>
                <p class="sub">Unggah dan kelola peta analisis curah hujan, prakiraan deterministik, dan peluang curah hujan dasarian yang tampil di carousel dashboard utama.</p>
            </div>
            @if($editingDasarian)
                <a href="{{ route('admin') }}#kelola-peta-dasarian" class="btn" style="background:#64748b; font-size:11.5px; height:36px;">
                    + Tambah Peta Baru
                </a>
            @endif
        </div>

        @if($editingDasarian)
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--r-md); padding:10px 14px; margin-bottom:16px; font-size:12px; color:#1e40af; display:flex; justify-content:space-between; align-items:center;">
                <span>Mode Edit: Mengubah peta <strong>{{ $editingDasarian->title }} ({{ $editingDasarian->category_label }})</strong></span>
                <a href="{{ route('admin') }}#kelola-peta-dasarian" style="color:#b91c1c; font-weight:700; text-decoration:none;">Batal Edit &times;</a>
            </div>
        @endif

        <form method="post" novalidate action="{{ route('dasarian-image.store', [], false) }}" enctype="multipart/form-data" class="form" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px; align-items:start;">
            @csrf
            @if($editingDasarian)
                <input type="hidden" name="id" value="{{ $editingDasarian->id }}">
            @endif

            <div class="field">
                <label for="dasarian_category">Kategori Peta *</label>
                <select id="dasarian_category" name="category" required>
                    <option value="analisis" @selected(old('category', $editingDasarian?->category) === 'analisis')>Analisis Curah Hujan</option>
                    <option value="prediksi" @selected(old('category', $editingDasarian?->category) === 'prediksi')>Prediksi Curah Hujan</option>
                    <option value="peluang" @selected(old('category', $editingDasarian?->category) === 'peluang')>Peluang Curah Hujan</option>
                    <option value="lainnya" @selected(old('category', $editingDasarian?->category) === 'lainnya')>Informasi Dasarian Lainnya</option>
                </select>
            </div>

            <div class="field" style="grid-column: span 2;">
                <label for="dasarian_title">Judul Peta *</label>
                <input id="dasarian_title" name="title" type="text" required placeholder="Contoh: Analisis Curah Hujan Dasarian I November 2026" value="{{ old('title', $editingDasarian?->title) }}">
            </div>

            <div class="field">
                <label for="dasarian_period_label">Label Periode Dasarian</label>
                <input id="dasarian_period_label" name="period_label" type="text" placeholder="Contoh: Dasarian I November 2026" value="{{ old('period_label', $editingDasarian?->period_label) }}">
            </div>

            <div class="field">
                <label for="dasarian_order">Urutan Slide (Angka kecil tampil lebih dulu)</label>
                <input id="dasarian_order" name="order" type="number" min="0" max="999" value="{{ old('order', $editingDasarian?->order ?? 0) }}">
            </div>

            <div class="field" style="grid-column: span 2;">
                <label for="dasarian_image">Berkas Gambar Peta (JPG, PNG, WebP, SVG maks 5 MB) {{ $editingDasarian ? '(Kosongkan jika tidak ganti gambar)' : '*' }}</label>
                <input id="dasarian_image" name="image" type="file" accept="image/jpeg,image/png,image/jpg,image/webp,image/svg+xml" {{ $editingDasarian ? '' : 'required' }}>
                <small style="color:var(--muted); font-size:11px; margin-top:3px; display:block;">
                    Disarankan rasio A4 Lanskap (1024 x 724 px) agar pas sempurna di carousel dashboard.
                    @if($editingDasarian && $editingDasarian->image_path)
                        <br>Gambar saat ini: <a href="{{ asset($editingDasarian->image_path) }}" target="_blank" rel="noopener">Lihat gambar</a>
                    @endif
                </small>
            </div>

            <div class="field" style="grid-column: 1 / -1;">
                <label for="dasarian_description">Deskripsi / Keterangan Peta</label>
                <textarea id="dasarian_description" name="description" rows="2" placeholder="Keterangan sebaran curah hujan, intensitas, sifat hujan, atau catatan analisis dasarian...">{{ old('description', $editingDasarian?->description) }}</textarea>
            </div>

            <div class="field" style="grid-column: 1 / -1; display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="dasarian_is_active" name="is_active" value="1" style="width:18px; height:18px;" @checked(old('is_active', $editingDasarian ? $editingDasarian->is_active : true))>
                <label for="dasarian_is_active" style="font-weight:700; margin:0; cursor:pointer;">
                    Tampilkan di Carousel Publik (Centang agar peta aktif dan tampil di halaman depan)
                </label>
            </div>

            <div style="grid-column: 1 / -1; display:flex; gap:10px; margin-top:6px;">
                <button class="btn btn-blue" type="submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $editingDasarian ? 'Perbarui Peta Dasarian' : 'Simpan & Publikasikan Peta' }}
                </button>
                @if($editingDasarian)
                    <a href="{{ route('admin') }}#kelola-peta-dasarian" class="btn" style="background:#e2e8f0; color:#334155; text-decoration:none;">Batal</a>
                @endif
            </div>
        </form>

        <div style="margin-top:24px;">
            <div style="font-size:13px; font-weight:700; color:var(--bmkg-navy); margin-bottom:8px; display:flex; justify-content:space-between; align-items:center;">
                <span>Daftar Peta Informasi Iklim Dasarian ({{ $dasarianImages->count() }} Peta)</span>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:80px;">Pratinjau</th>
                            <th>Kategori</th>
                            <th>Judul &amp; Periode</th>
                            <th>Deskripsi</th>
                            <th style="width:60px; text-align:center;">Urutan</th>
                            <th style="width:70px; text-align:center;">Status</th>
                            <th style="width:130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dasarianImages as $img)
                        <tr>
                            <td>
                                <a href="{{ asset($img->image_path) }}" target="_blank" rel="noopener" title="Lihat Peta Resolusi Penuh">
                                    <img src="{{ asset($img->image_path) }}" alt="{{ $img->title }}" style="width:72px; height:50px; object-fit:cover; border-radius:4px; border:1px solid #cbd5e1; box-shadow:0 1px 3px rgba(0,0,0,0.1); display:block;">
                                </a>
                            </td>
                            <td>
                                <span class="badge" style="background: {{ $img->category_color }}18; color: {{ $img->category_color }}; border: 1px solid {{ $img->category_color }}40; font-size:11px; font-weight:700; white-space:nowrap;">
                                    {{ $img->category_label }}
                                </span>
                            </td>
                            <td>
                                <strong style="color:var(--bmkg-navy); font-size:13px; display:block;">{{ $img->title }}</strong>
                                @if($img->period_label)
                                    <span style="display:inline-block; margin-top:2px; font-size:11.5px; color:#0369a1; background:#e0f2fe; padding:1px 6px; border-radius:4px;">{{ $img->period_label }}</span>
                                @endif
                            </td>
                            <td style="font-size:12px; color:var(--muted); max-width:240px;">
                                {{ $img->description ?: '-' }}
                            </td>
                            <td style="text-align:center; font-weight:700; font-size:12px;">{{ $img->order }}</td>
                            <td style="text-align:center;">
                                @if($img->is_active)
                                    <span class="badge" style="background:#dcfce7; color:#15803d; border:1px solid #86efac; font-size:10px;">Aktif</span>
                                @else
                                    <span class="badge" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; font-size:10px;">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex; gap:6px; align-items:center;">
                                    <a href="{{ route('admin', ['edit_dasarian' => $img->id]) }}#kelola-peta-dasarian" class="edit-link">Edit</a>
                                    <form method="post" novalidate action="{{ route('dasarian-image.destroy', $img->id, false) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peta ini?');" style="margin:0;">
                                        @csrf
                                        @method('delete')
                                        <button class="delete" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty">Belum ada peta dasarian yang diunggah. Silakan gunakan formulir di atas untuk mengunggah peta analisis/prakiraan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 4. KELOLA BULETIN INFORMASI IKLIM (BARU) -->
    <section class="card" id="kelola-buletin-iklim">
        <div class="card-header-bar">
            <div>
                <h3>Publikasi Buletin Iklim Papua Selatan</h3>
                <p class="sub">Kelola edisi buletin informasi iklim bulanan/dasarian, sampul digital, dokumen PDF, ringkasan eksekutif, dan status publikasi di portal utama.</p>
            </div>
            @if($editingBulletin)
                <a href="{{ route('admin') }}#kelola-buletin-iklim" class="btn" style="background:#64748b; font-size:11.5px; height:36px;">
                    + Tambah Buletin Baru
                </a>
            @endif
        </div>

        @if($editingBulletin)
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--r-md); padding:10px 14px; margin-bottom:16px; font-size:12px; color:#1e40af; display:flex; justify-content:space-between; align-items:center;">
                <span>Mode Edit: Mengubah buletin <strong>{{ $editingBulletin->title }} ({{ $editingBulletin->edition }})</strong></span>
                <a href="{{ route('admin') }}#kelola-buletin-iklim" style="color:#b91c1c; font-weight:700; text-decoration:none;">Batal Edit &times;</a>
            </div>
        @endif

        <form method="post" novalidate action="{{ route('bulletin.store', [], false) }}" enctype="multipart/form-data" class="form" style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:14px; align-items:start;">
            @csrf
            @if($editingBulletin)
                <input type="hidden" name="id" value="{{ $editingBulletin->id }}">
            @endif

            <div class="field" style="grid-column: 1 / -1;">
                <label for="bulletin_title">Judul Buletin *</label>
                <input id="bulletin_title" name="title" type="text" required placeholder="Contoh: Buletin Informasi Iklim Papua Selatan" value="{{ old('title', $editingBulletin->title ?? 'Buletin Informasi Iklim Papua Selatan') }}">
            </div>

            <div class="field">
                <label for="bulletin_edition">Edisi &amp; Volume *</label>
                <input id="bulletin_edition" name="edition" type="text" required placeholder="Contoh: Edisi November 2026 - Vol. II" value="{{ old('edition', $editingBulletin->edition ?? '') }}">
            </div>

            <div class="field">
                <label for="bulletin_release_date">Tanggal Rilis / Terbit</label>
                <input id="bulletin_release_date" name="release_date" type="date" value="{{ old('release_date', $editingBulletin && $editingBulletin->release_date ? $editingBulletin->release_date->format('Y-m-d') : date('Y-m-d')) }}">
            </div>

            <div class="field">
                <label for="bulletin_page_count">Jumlah Halaman</label>
                <input id="bulletin_page_count" name="page_count" type="number" min="1" max="999" placeholder="24" value="{{ old('page_count', $editingBulletin->page_count ?? 24) }}">
            </div>

            <div class="field">
                <label for="bulletin_file_size">Estimasi Ukuran File (opsional)</label>
                <input id="bulletin_file_size" name="file_size" type="text" placeholder="Contoh: 4.8 MB (otomatis jika upload PDF)" value="{{ old('file_size', $editingBulletin->file_size ?? '') }}">
            </div>

            <div class="field">
                <label for="bulletin_cover_image">Unggah Gambar Sampul (JPG/PNG/WebP/SVG)</label>
                <input id="bulletin_cover_image" name="cover_image" type="file" accept="image/*">
                @if($editingBulletin && $editingBulletin->cover_image)
                    <small style="color:var(--muted); font-size:11px; margin-top:3px; display:block;">Sampul saat ini: <a href="{{ $editingBulletin->cover_url }}" target="_blank">Lihat file</a></small>
                @endif
            </div>

            <div class="field">
                <label for="bulletin_pdf_file">Unggah Dokumen PDF (Maks 35 MB)</label>
                <input id="bulletin_pdf_file" name="pdf_file" type="file" accept=".pdf,application/pdf">
                @if($editingBulletin && $editingBulletin->file_path)
                    <small style="color:var(--muted); font-size:11px; margin-top:3px; display:block;">File PDF saat ini: <a href="{{ asset($editingBulletin->file_path) }}" target="_blank">Download PDF</a></small>
                @endif
            </div>

            <div class="field">
                <label for="bulletin_external_link">Tautan Eksternal / Google Drive / Repository BMKG</label>
                <input id="bulletin_external_link" name="external_link" type="url" placeholder="https://..." value="{{ old('external_link', $editingBulletin->external_link ?? '') }}">
            </div>

            <div class="field">
                <label for="bulletin_order">Urutan Prioritas (Angka kecil lebih dulu)</label>
                <input id="bulletin_order" name="order" type="number" min="0" max="999" value="{{ old('order', $editingBulletin->order ?? 0) }}">
            </div>

            <div class="field" style="grid-column: 1 / -1;">
                <label for="bulletin_description">Ringkasan Eksekutif &amp; Sorotan Analisis (Tampil di Dashboard)</label>
                <textarea id="bulletin_description" name="description" rows="3" placeholder="Ringkasan analisis dinamika atmosfer, curah hujan dasarian, ENSO, IOD, dan prospek iklim...">{{ old('description', $editingBulletin->description ?? '') }}</textarea>
            </div>

            <div class="field" style="grid-column: 1 / -1; display:flex; align-items:center; gap:8px;">
                <input type="checkbox" id="bulletin_is_published" name="is_published" value="1" style="width:18px; height:18px;" @checked(old('is_published', $editingBulletin ? $editingBulletin->is_published : true))>
                <label for="bulletin_is_published" style="font-weight:700; margin:0; cursor:pointer;">
                    Publikasikan Buletin (Centang agar dapat diakses publik di Dashboard Utama)
                </label>
            </div>

            <div style="grid-column: 1 / -1; display:flex; gap:10px; margin-top:6px;">
                <button class="btn btn-blue" type="submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $editingBulletin ? 'Perbarui Buletin Iklim' : 'Simpan & Publikasikan Buletin' }}
                </button>
                @if($editingBulletin)
                    <a href="{{ route('admin') }}#kelola-buletin-iklim" class="btn" style="background:#e2e8f0; color:#334155; text-decoration:none;">Batal</a>
                @endif
            </div>
        </form>

        <div style="margin-top:24px;">
            <div style="font-size:13px; font-weight:700; color:var(--bmkg-navy); margin-bottom:8px; display:flex; justify-content:space-between; align-items:center;">
                <span>Daftar Buletin Informasi Iklim Tersimpan ({{ $climateBulletins->count() }} Edisi)</span>
            </div>
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:60px;">Sampul</th>
                            <th>Judul &amp; Edisi</th>
                            <th>Tgl Terbit</th>
                            <th>Halaman / Ukuran</th>
                            <th>Status</th>
                            <th>Dokumen</th>
                            <th style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($climateBulletins as $b)
                        <tr>
                            <td>
                                <img src="{{ $b->cover_url }}" alt="Cover" style="width:48px; height:64px; object-fit:cover; border-radius:4px; border:1px solid #cbd5e1; box-shadow:0 1px 3px rgba(0,0,0,0.1);">
                            </td>
                            <td>
                                <strong style="color:var(--bmkg-navy); font-size:13px; display:block;">{{ $b->title }}</strong>
                                <span style="display:inline-block; margin-top:2px; font-size:11.5px; font-weight:600; color:var(--bmkg-blue); background:#eff6ff; padding:2px 8px; border-radius:4px;">{{ $b->edition }}</span>
                                @if($b->description)
                                    <p style="margin:4px 0 0; font-size:11px; color:var(--muted); line-height:1.4; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $b->description }}</p>
                                @endif
                            </td>
                            <td style="font-size:12px; white-space:nowrap;">{{ $b->formatted_date }}</td>
                            <td style="font-size:12px; white-space:nowrap;">
                                <div>{{ $b->page_count ? $b->page_count . ' Hlm' : '-' }}</div>
                                <small style="color:var(--muted);">{{ $b->file_size ?: 'PDF' }}</small>
                            </td>
                            <td>
                                @if($b->is_published)
                                    <span class="badge" style="background:#dcfce7; color:#15803d; border:1px solid #86efac; font-size:10.5px;">Terbit</span>
                                @else
                                    <span class="badge" style="background:#f1f5f9; color:#64748b; border:1px solid #cbd5e1; font-size:10.5px;">Draf</span>
                                @endif
                            </td>
                            <td>
                                @if($b->download_url)
                                    <a href="{{ $b->download_url }}" target="_blank" rel="noopener" class="edit-link" style="background:#ecfdf5; border-color:#a7f3d0; color:#047857; display:inline-flex; align-items:center; gap:4px;">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        Buka PDF
                                    </a>
                                @else
                                    <span style="font-size:11px; color:var(--muted);">-</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex; gap:6px; align-items:center;">
                                    <a href="{{ route('admin', ['edit_bulletin' => $b->id]) }}#kelola-buletin-iklim" class="edit-link">Edit</a>
                                    <form method="post" novalidate action="{{ route('bulletin.destroy', $b->id, false) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buletin ini?');" style="margin:0;">
                                        @csrf
                                        @method('delete')
                                        <button class="delete" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="empty">Belum ada buletin iklim yang diunggah. Silakan gunakan formulir di atas untuk mempublikasikan edisi terbaru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- 4. INPUT ANGKA INSIDEN MALARIA (SILING MALARIA) -->
    <section class="card" id="kelola-siling-malaria">
        <h3>Input Data Malaria</h3>
        <p class="sub">Pilih jenis data yang ingin dimasukkan. Setiap formulir menyimpan data secara terpisah untuk kabupaten dan periode yang dipilih.</p>
        <div class="malaria-period-note">Periode aktif untuk semua input: <strong>{{ $periodLabel }}</strong>. Ubah bulan dan tahun melalui pilihan periode di bagian atas halaman.</div>
        <nav class="malaria-input-nav" aria-label="Pilih formulir data malaria">
            <a href="#malaria-ai-input">1. Angka insiden</a>
            <a href="#malaria-climate-input">2. Kesesuaian iklim</a>
            <a href="#malaria-trend-input">3. Kasus dan parameter iklim</a>
        </nav>
        <div id="malaria-ai-input">
        <h4>1. Angka Insiden Malaria</h4>
        <p class="malaria-form-note">Masukkan angka insiden per 1.000 penduduk. Jika kabupaten dan periode yang sama sudah ada, nilainya akan diperbarui.</p>
        <form method="post" novalidate action="{{ route('incidents.store', [], false) }}" class="form">
            @csrf
            <input type="hidden" name="period" value="{{ $period }}">
            <div class="field">
                <label for="district">Kabupaten</label>
                <select id="district" name="district" required>
                    <option value="">Pilih kabupaten</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="incidence">Angka Insiden (AI) per 1.000 Penduduk</label>
                <input id="incidence" name="incidence" type="number" min="0" max="100000" step="0.01" value="{{ old('incidence') }}" placeholder="Contoh: 4.25" required>
            </div>
            <button class="btn btn-blue" type="submit">Simpan Data AI</button>
        </form>
        <p class="hint">Status dihitung otomatis: Aman &lt;3, Waspada 3–10, dan Awas &gt;10 per 1.000 penduduk.</p>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kabupaten</th>
                        <th>Angka Insiden</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        @php($status = $record->incidence < 3 ? 'Aman' : ($record->incidence <= 10 ? 'Waspada' : 'Awas'))
                        @php($class = $record->incidence < 3 ? 'safe' : ($record->incidence <= 10 ? 'caution' : 'danger'))
                        <tr>
                            <td data-label="Kabupaten"><strong>{{ $record->district }}</strong></td>
                            <td data-label="Angka insiden" class="value">{{ number_format($record->incidence, 2, ',', '.') }}</td>
                            <td data-label="Status"><span class="badge {{ $class }}">{{ $status }}</span></td>
                            <td data-label="Aksi">
                                <form method="post" novalidate action="{{ route('incidents.destroy', $record, false) }}" onsubmit="return confirm('Hapus data {{ $record->district }} periode ini?')">
                                    @csrf @method('delete')
                                    <button class="delete" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="empty" colspan="4">Belum ada data untuk bulan ini. Gunakan formulir di atas untuk menambahkan data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </section>

    <!-- 4. PREDIKSI KESESUAIAN IKLIM UNTUK MALARIA -->
    <section class="card" id="malaria-climate-input">
        <h3>2. Kesesuaian Iklim Malaria</h3>
        <p class="malaria-form-note">Isi probabilitas kecocokan, kelembapan jika tersedia, dan tingkat keyakinan untuk periode {{ $periodLabel }}. Data ini mengatur peta prediksi SILING.</p>
        <form method="post" novalidate action="{{ route('climate-suitability.store', [], false) }}" class="form suitability-form">
            @csrf
            <input type="hidden" name="period" value="{{ $period }}">
            <div class="field">
                <label for="suitability_district">Kabupaten</label>
                <select id="suitability_district" name="district" required>
                    <option value="">Pilih kabupaten</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="suitability_probability">Probabilitas Kecocokan (%)</label>
                <input id="suitability_probability" name="probability" type="number" min="0" max="100" step="0.01" value="{{ old('probability') }}" placeholder="Contoh: 47.00" required>
            </div>
            <div class="field">
                <label for="suitability_humidity">RH / Kelembapan (%)</label>
                <input id="suitability_humidity" name="humidity" type="number" min="0" max="100" step="0.01" value="{{ old('humidity') }}" placeholder="Contoh: 75.30">
            </div>
            <div class="field">
                <label for="suitability_confidence">Tingkat Keyakinan</label>
                <select id="suitability_confidence" name="confidence" required>
                    <option value="">Pilih tingkat</option>
                    @foreach(['Rendah','Sedang','Tinggi'] as $level)
                        <option value="{{ $level }}" @selected(old('confidence') === $level)>{{ $level }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-blue" type="submit">Simpan Prediksi</button>
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kabupaten</th>
                        <th>Probabilitas</th>
                        <th>RH</th>
                        <th>Tingkat Keyakinan</th>
                        <th>Kategori Peta</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($climateSuitabilities as $suitability)
                        @php($probability = (float) $suitability->probability)
                        @php($category = $probability > 90 ? 'Sangat tinggi' : ($probability >= 70 ? 'Tinggi' : ($probability >= 40 ? 'Sedang' : 'Rendah')))
                        <tr>
                            <td data-label="Kabupaten"><strong>{{ $suitability->district }}</strong></td>
                            <td data-label="Probabilitas" class="value">{{ number_format($probability, 2, ',', '.') }}%</td>
                            <td data-label="RH">{{ $suitability->humidity === null ? '—' : number_format((float) $suitability->humidity, 2, ',', '.').'%' }}</td>
                            <td data-label="Tingkat keyakinan">{{ $suitability->confidence ?? '—' }}</td>
                            <td data-label="Kategori peta">{{ $category }}</td>
                        </tr>
                    @empty
                        <tr><td class="empty" colspan="5">Belum ada nilai prediksi untuk periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 5. DATA GRAFIK HISTORIS KASUS & IKLIM -->
    <section class="card" id="malaria-trend-input">
        <h3>3. Kasus Malaria dan Parameter Iklim</h3>
        <p class="malaria-form-note">Masukkan jumlah kasus dan parameter iklim bulanan untuk grafik tren. Kelembapan, suhu, dan curah hujan boleh dikosongkan jika belum tersedia.</p>
        <form method="post" novalidate action="{{ route('malaria-observations.store', [], false) }}" class="form climate-form">
            @csrf
            <input type="hidden" name="period" value="{{ $period }}">
            <div class="field">
                <label for="malaria_district">Kabupaten</label>
                <select id="malaria_district" name="malaria_district" required>
                    <option value="">Pilih kabupaten</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" @selected(old('malaria_district', $editingObservation?->district) === $district)>{{ $district }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="malaria_cases">Jumlah Kasus</label>
                <input id="malaria_cases" name="cases" type="number" min="0" step="1" value="{{ old('cases', $editingObservation?->cases) }}" placeholder="Contoh: 125" required>
            </div>
            <div class="field">
                <label for="malaria_humidity">Kelembapan (%)</label>
                <input id="malaria_humidity" name="humidity" type="number" min="0" max="100" step="any" value="{{ old('humidity', $editingObservation?->humidity) }}" placeholder="Contoh: 85.2">
            </div>
            <div class="field">
                <label for="malaria_temperature">Suhu (°C)</label>
                <input id="malaria_temperature" name="temperature" type="number" min="-20" max="60" step="any" value="{{ old('temperature', $editingObservation?->temperature) }}" placeholder="Contoh: 27.1">
            </div>
            <div class="field" style="grid-column: span 2;">
                <label for="malaria_rainfall">Curah Hujan (mm)</label>
                <input id="malaria_rainfall" name="rainfall" type="number" min="0" step="any" value="{{ old('rainfall', $editingObservation?->rainfall) }}" placeholder="Contoh: 344.5">
            </div>
            <div style="grid-column: 1 / -1;">
                <button class="btn btn-blue" type="submit">{{ $editingObservation ? 'Perbarui Data Grafik' : 'Simpan Data Grafik' }}</button>
            </div>
        </form>

        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Kabupaten</th>
                        <th>Kasus</th>
                        <th>Kelembapan</th>
                        <th>Suhu</th>
                        <th>Curah Hujan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($malariaObservations as $observation)
                        <tr>
                            <td data-label="Kabupaten">
                                <strong>{{ $observation->district }}</strong>
                                <a class="edit-link" href="{{ route('admin', ['month' => $selectedMonth, 'year' => $selectedYear, 'edit' => $observation->district], false) }}">Edit</a>
                            </td>
                            <td data-label="Kasus" class="value">{{ number_format($observation->cases, 0, ',', '.') }}</td>
                            <td data-label="Kelembapan">{{ $observation->humidity === null ? '—' : number_format((float) $observation->humidity, 2, ',', '.').'%' }}</td>
                            <td data-label="Suhu">{{ $observation->temperature === null ? '—' : number_format((float) $observation->temperature, 2, ',', '.').' °C' }}</td>
                            <td data-label="Curah hujan">{{ $observation->rainfall === null ? '—' : number_format((float) $observation->rainfall, 2, ',', '.').' mm' }}</td>
                        </tr>
                    @empty
                        <tr><td class="empty" colspan="5">Belum ada data grafik untuk bulan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <!-- 6. TEMPLATE & BROADCAST WHATSAPP NAKES -->
    <section class="card" id="kelola-notifikasi-wa">
        <h3>Template Pesan &amp; Notifikasi WhatsApp Nakes</h3>
        <p class="sub">Konfigurasi pesan otomatis peringatan dini yang dikirim ke tenaga kesehatan (nakes) di tiap kabupaten.</p>
        <form method="post" novalidate action="{{ route('whatsapp-template.save', [], false) }}" class="template-form">
            @csrf
            <input type="hidden" name="period" value="{{ $period }}">
            <label class="template-label" for="whatsapp_template">Format Template Pesan</label>
            <textarea id="whatsapp_template" name="whatsapp_template" rows="6" required>{{ old('whatsapp_template', $whatsappTemplate) }}</textarea>
            <p class="hint">Variabel otomatis: <code>@{{ recipient }}</code>, <code>@{{ period }}</code>, <code>@{{ district }}</code>, <code>@{{ status }}</code>, <code>@{{ incidence }}</code>, <code>@{{ recommendation }}</code>.</p>
            <button class="btn btn-blue" type="submit">Simpan Template WhatsApp</button>
        </form>

        <h4 style="margin: 28px 0 10px; font-size: 14px; color: var(--bmkg-navy); font-weight: 800;">Daftar Kontak Nakes per Kabupaten</h4>
        <form method="post" novalidate action="{{ request()->getBaseUrl() }}/penerima-whatsapp" class="recipient-form">
            @csrf
            <input type="hidden" name="period" value="{{ $period }}">
            <div class="field">
                <label for="recipient_district">Kabupaten</label>
                <select id="recipient_district" name="district" required>
                    <option value="">Pilih kabupaten</option>
                    @foreach($districts as $district)
                        <option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="recipient_name">Nama Nakes</label>
                <input id="recipient_name" name="name" type="text" maxlength="120" value="{{ old('name') }}" placeholder="Nama petugas / nakes" required>
            </div>
            <div class="field">
                <label for="recipient_phone">Nomor WhatsApp</label>
                <input id="recipient_phone" name="phone" type="tel" inputmode="tel" value="{{ old('phone') }}" placeholder="08… atau 628…" required>
            </div>
            <button class="btn" type="submit">Simpan Kontak</button>
        </form>

        <div class="wa-list">
            @forelse($records as $record)
                <div class="wa-district" data-incidence="{{ number_format((float) $record->incidence, 2, '.', '') }}" data-status="{{ $record->incidence < 3 ? 'Aman' : ($record->incidence <= 10 ? 'Waspada' : 'Awas') }}" data-recommendation="{{ $record->incidence < 3 ? 'Surveilans rutin kasus di FKTP dan vektor; edukasi 3M Plus; pantau kasus, vektor, dan lingkungan.' : ($record->incidence <= 10 ? 'Tingkatkan surveilans kasus dan vektor; larvasidasi selektif; pastikan kelambu berinsektisida; edukasi risiko.' : 'Aktifkan RRT kabupaten; surveilans harian; larvasidasi dan IRS di wilayah berisiko; pastikan obat, RDT, dan logistik; mobilisasi lintas sektor.') }}">
                    <div class="wa-summary">
                        <strong>Kabupaten {{ $record->district }}</strong>
                        <span class="badge {{ $record->incidence < 3 ? 'safe' : ($record->incidence <= 10 ? 'caution' : 'danger') }}">
                            {{ $record->incidence < 3 ? 'Aman' : ($record->incidence <= 10 ? 'Waspada' : 'Awas') }} · AI {{ number_format((float) $record->incidence, 2, ',', '.') }} / 1.000
                        </span>
                    </div>
                    @forelse($whatsappRecipients->get($record->district, collect()) as $recipient)
                        <div class="wa-recipient" data-district="{{ $record->district }}" data-recipient="{{ $recipient->name }}" data-phone="{{ $recipient->phone }}">
                            <div class="wa-contact">
                                <strong>{{ $recipient->name }}</strong>
                                <span>{{ $recipient->phone }}</span>
                            </div>
                            <form class="wa-send-form">
                                <button class="btn" type="submit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 2L11 13"/><path d="M22 2L15 22L11 13L2 9L22 2Z"/></svg>
                                    Kirim WA
                                </button>
                            </form>
                            <form method="post" novalidate action="{{ request()->getBaseUrl() }}/penerima-whatsapp/{{ $recipient->id }}" onsubmit="return confirm('Hapus kontak {{ $recipient->name }}?')">
                                @csrf @method('delete')
                                <input type="hidden" name="period" value="{{ $period }}">
                                <button class="delete" type="submit">Hapus</button>
                            </form>
                            <p class="wa-error" role="status" aria-live="polite"></p>
                        </div>
                    @empty
                        <p class="empty wa-empty">Belum ada kontak nakes tersimpan untuk {{ $record->district }}.</p>
                    @endforelse
                </div>
            @empty
                <div class="empty">Belum ada data AI untuk periode ini. Simpan data kabupaten terlebih dahulu agar pesan dapat disiapkan.</div>
            @endforelse
        </div>
    </section>

    <footer class="admin-footer">
        &copy; 2026 Badan Meteorologi, Klimatologi, dan Geofisika (BMKG) &mdash; Stasiun Klimatologi Papua Selatan. Hak Cipta Dilindungi.
    </footer>
</main>

<script>
(() => {
    const template = @json($whatsappTemplate);
    document.querySelectorAll('.wa-send-form').forEach(form => form.addEventListener('submit', event => {
        event.preventDefault();
        const recipient = form.closest('.wa-recipient');
        const district = recipient.closest('.wa-district');
        const error = recipient.querySelector('.wa-error');
        let phone = recipient.dataset.phone.replace(/\D/g, '');
        if (phone.startsWith('0')) phone = `62${phone.slice(1)}`;
        else if (!phone.startsWith('62')) phone = `62${phone}`;
        if (phone.length < 10 || phone.length > 15) {
            error.textContent = 'Nomor kontak tidak valid. Perbarui data penerima.';
            return;
        }
        const values = {
            period: @json($periodLabel),
            recipient: recipient.dataset.recipient,
            district: district.dataset.district,
            status: district.dataset.status,
            incidence: district.dataset.incidence,
            recommendation: district.dataset.recommendation,
        };
        const message = template.replace(/\{\{\s*(period|recipient|district|status|incidence|recommendation)\s*\}\}/g, (_, key) => values[key]);
        error.textContent = '';
        window.open(`https://wa.me/${phone}?text=${encodeURIComponent(message)}`, '_blank', 'noopener');
    }));
})();
</script>
</body>
</html>
