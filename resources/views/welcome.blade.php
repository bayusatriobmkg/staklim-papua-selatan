<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ['dashboard' => 'Dashboard Iklim', 'profile' => 'Profil Stasiun', 'services' => 'Layanan Publik & PTSP', 'products' => (($subPage ?? 'katalog') === 'siling-malaria' ? 'SILING Malaria - Peringatan Dini Berbasis Iklim' : 'Katalog Produk Informasi Iklim'), 'contact' => 'Kontak Kami'][$page] ?? 'Stasiun Klimatologi Papua Selatan' }} | Staklim Papua Selatan - BMKG</title>
    
    <!-- Google Fonts: Plus Jakarta Sans (Gaya Khas Publik & Instansi Modern BMKG) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
        <!-- Leaflet Map CSS & JS with Multi-Tier Fallback -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="">
    <link rel="stylesheet" href="{{ request()->getBasePath() }}/vendor/leaflet/leaflet.css">
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        if (typeof L === 'undefined') {
            document.write('<script src="{{ request()->getBasePath() }}/vendor/leaflet/leaflet.js"><\/script>');
        }
    </script>
    <script>
        if (typeof L === 'undefined') {
            document.write('<script src="{{ asset('vendor/leaflet/leaflet.js') }}"><\/script>');
        }
    </script>

    <style>
        :root {
            /* BMKG Core Palette */
            --bmkg-navy: #002b49;
            --bmkg-navy-dark: #00192b;
            --bmkg-navy-light: #063d66;
            --bmkg-blue: #0284c7;
            --bmkg-blue-dark: #0369a1;
            --bmkg-blue-light: #e0f2fe;
            --bmkg-cyan: #0ea5e9;
            --bmkg-cyan-soft: #f0f9ff;
            --bmkg-gold: #f59e0b;
            --bmkg-gold-soft: #fef3c7;
            
            /* Neutral System */
            --ink: #0f172a;
            --ink-secondary: #334155;
            --muted: #64748b;
            --muted-light: #94a3b8;
            --line: #e2e8f0;
            --line-strong: #cbd5e1;
            --line-light: #f1f5f9;
            --paper: #f8fafc;
            --card-bg: #ffffff;
            
            /* Status Peringatan BMKG */
            --status-awas: #dc2626;
            --status-awas-bg: #fee2e2;
            --status-siaga: #ea580c;
            --status-siaga-bg: #ffedd5;
            --status-waspada: #d97706;
            --status-waspada-bg: #fef9c3;
            --status-aman: #059669;
            --status-aman-bg: #ecfdf5;
            
            /* Radius & Shadows */
            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 16px;
            --r-xl: 20px;
            --shadow-sm: 0 1px 3px rgba(0, 43, 73, 0.05);
            --shadow-md: 0 4px 14px -2px rgba(0, 43, 73, 0.08);
            --shadow-lg: 0 10px 25px -4px rgba(0, 43, 73, 0.10);
            --shadow-xl: 0 20px 35px -5px rgba(0, 43, 73, 0.12);
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--paper);
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--ink);
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        button, input, select, textarea { font-family: inherit; }
        a { color: inherit; text-decoration: none; }

        /* Utility Bar (Standar Waktu Nasional) */
        .utility-bar {
            height: 38px;
            background: var(--bmkg-navy-dark);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .02em;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .utility-inner {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 clamp(16px, 4vw, 56px);
            gap: 12px;
        }
        .utility-left {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #f1f5f9;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .03em;
        }
        .utility-brand {
            color: #38bdf8;
            font-weight: 800;
            letter-spacing: .04em;
        }
        .utility-sep { color: #475569; }
        .utility-right {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #f1f5f9;
        }
        .utility-label {
            color: #94a3b8;
            font-weight: 600;
        }
        .utility-right b {
            color: #ffffff;
            font-weight: 800;
            letter-spacing: .04em;
            background: rgba(2, 132, 199, 0.25);
            border: 1px solid rgba(56, 189, 248, 0.35);
            padding: 2px 8px;
            border-radius: 6px;
        }
        .live-pulse {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
            animation: pulse-dot 2s infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: .6; transform: scale(1.15); }
        }

        /* Topbar Header */
        .topbar {
            background: #ffffff;
            border-bottom: 1px solid var(--line);
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 1200;
        }
        .topbar-inner {
            height: 76px;
            padding: 0 clamp(16px, 4vw, 56px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .brand-link {
            display: flex;
            align-items: center;
            gap: 13px;
            text-decoration: none;
            min-width: 0;
        }
        .brandmark {
            width: 48px;
            height: 48px;
            object-fit: contain;
            flex: none;
            filter: drop-shadow(0 2px 4px rgba(0, 43, 73, 0.08));
        }
        .brand {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-width: 0;
        }
        .brand-sub {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--bmkg-blue);
            line-height: 1.25;
            margin-bottom: 2px;
        }
        .brand h1 {
            font-size: 18px;
            line-height: 1.25;
            margin: 0;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.015em;
            white-space: nowrap;
        }
        .brand p {
            font-size: 11px;
            color: var(--muted);
            margin: 2px 0 0;
            line-height: 1.3;
            font-weight: 500;
        }

        /* Main Navigation */
        .main-nav {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .main-nav a {
            padding: 9px 15px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-secondary);
            border-radius: var(--r-md);
            transition: all .18s ease;
            white-space: nowrap;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .main-nav a:hover {
            color: var(--bmkg-blue);
            background: var(--bmkg-cyan-soft);
        }
        .main-nav a.is-current {
            background: var(--bmkg-navy);
            color: #ffffff;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 43, 73, 0.18);
        }
        .nav-admin-btn {
            margin-left: 6px;
            border: 1.5px solid var(--line);
            color: var(--bmkg-navy) !important;
            font-weight: 700 !important;
            background: #ffffff;
        }
        .nav-admin-btn:hover {
            border-color: var(--bmkg-navy) !important;
            background: var(--bmkg-navy) !important;
            color: #ffffff !important;
        }
        .nav-icon {
            display: none;
        }

        /* Dropdown Navigasi Bar Produk */
        .nav-item-dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .nav-link-dropdown-toggle {
            padding: 9px 15px;
            font-size: 13px;
            font-weight: 600;
            color: var(--ink-secondary);
            border-radius: var(--r-md);
            transition: all .18s ease;
            white-space: nowrap;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .nav-link-dropdown-toggle:hover {
            color: var(--bmkg-blue);
            background: var(--bmkg-cyan-soft);
        }
        .nav-link-dropdown-toggle.is-current {
            background: var(--bmkg-navy) !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 43, 73, 0.18);
        }
        .nav-link-dropdown-toggle.is-current .dropdown-chevron {
            color: #ffffff;
            opacity: 0.95;
        }
        .nav-link-dropdown-toggle .dropdown-chevron {
            display: inline-block;
            transition: transform .22s cubic-bezier(0.16, 1, 0.3, 1);
            opacity: 0.65;
            margin-left: 1px;
            flex-shrink: 0;
        }
        .nav-item-dropdown:hover .nav-link-dropdown-toggle .dropdown-chevron,
        .nav-item-dropdown:focus-within .nav-link-dropdown-toggle .dropdown-chevron {
            transform: rotate(180deg);
            opacity: 1;
        }

        /* Floating Dropdown Menu Card */
        .nav-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            left: auto;
            width: 375px;
            max-width: calc(100vw - 32px);
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid rgba(0, 43, 73, 0.10);
            box-shadow: 0 16px 36px -4px rgba(0, 43, 73, 0.18), 0 4px 12px rgba(0, 0, 0, 0.04);
            padding: 8px;
            box-sizing: border-box;
            visibility: hidden;
            opacity: 0;
            transform: translateY(8px);
            transition: opacity .18s ease, transform .18s ease, visibility .18s;
            z-index: 1300;
            pointer-events: none;
        }
        /* Jembatan hover tak terlihat agar kursor tidak kehilangan fokus hover saat bergeser ke bawah */
        .nav-dropdown-menu::before {
            content: '';
            position: absolute;
            top: -12px;
            left: 0;
            right: 0;
            height: 12px;
        }
        .nav-item-dropdown:hover .nav-dropdown-menu,
        .nav-item-dropdown:focus-within .nav-dropdown-menu {
            visibility: visible;
            opacity: 1;
            transform: translateY(2px);
            pointer-events: auto;
        }

        /* Item tautan di dalam Dropdown Menu */
        .nav-dropdown-menu .dropdown-menu-item {
            display: flex !important;
            align-items: flex-start !important;
            gap: 12px !important;
            padding: 10px 12px !important;
            border-radius: 8px !important;
            text-decoration: none !important;
            background: #ffffff !important;
            box-shadow: none !important;
            transition: all .16s ease !important;
            white-space: normal !important;
            width: 100% !important;
            box-sizing: border-box !important;
            border: 1px solid transparent !important;
            text-align: left;
        }
        .nav-dropdown-menu .dropdown-menu-item:hover {
            background: #f0f9ff !important;
            border-color: #e0f2fe !important;
            transform: translateX(2px);
        }
        .nav-dropdown-menu .dropdown-menu-item.is-active {
            background: #f0fdf4 !important;
            border-color: #bbf7d0 !important;
        }
        .nav-dropdown-menu .dropdown-menu-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #e0f2fe;
            color: #0284c7;
            display: flex !important;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
            transition: all .16s ease;
        }
        .nav-dropdown-menu .dropdown-menu-icon.malaria-icon {
            background: #fee2e2;
            color: #dc2626;
        }
        .nav-dropdown-menu .dropdown-menu-item:hover .dropdown-menu-icon {
            transform: scale(1.06);
        }
        .nav-dropdown-menu .dropdown-menu-text {
            display: flex;
            flex-direction: column;
            gap: 3px;
            flex: 1;
            min-width: 0;
        }
        .nav-dropdown-menu .dropdown-menu-title {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--bmkg-navy);
            line-height: 1.3;
            white-space: nowrap;
        }
        .nav-dropdown-menu .dropdown-menu-item:hover .dropdown-menu-title {
            color: var(--bmkg-blue);
        }
        .nav-dropdown-menu .dropdown-menu-desc {
            font-size: 11px;
            color: #64748b;
            font-weight: 500;
            line-height: 1.4;
            white-space: normal;
        }
        .nav-dropdown-menu .dropdown-menu-badge {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .04em;
            padding: 2px 7px;
            border-radius: 999px;
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            white-space: nowrap;
            flex-shrink: 0;
            display: inline-block;
        }
        .nav-dropdown-menu .dropdown-menu-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 6px 4px;
        }

        /* Mobile Hamburger Menu Toggle Button (Sejajar dengan Brand di Mobile) */
        .mobile-menu-toggle {
            display: none;
            width: 42px;
            height: 42px;
            border-radius: var(--r-md);
            border: 1.5px solid var(--line);
            background: #ffffff;
            cursor: pointer;
            padding: 0;
            color: var(--bmkg-navy);
            transition: all .2s ease;
            position: relative;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            box-shadow: var(--shadow-sm);
            flex: none;
        }
        .mobile-menu-toggle:hover {
            border-color: var(--bmkg-blue);
            background: var(--bmkg-cyan-soft);
            color: var(--bmkg-blue);
        }
        .hamburger-bar {
            display: block;
            width: 20px;
            height: 2.2px;
            background: currentColor;
            border-radius: 2px;
            transition: all .25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .mobile-menu-toggle.is-open {
            background: var(--bmkg-navy);
            color: #ffffff;
            border-color: var(--bmkg-navy);
        }
        .mobile-menu-toggle.is-open .bar-1 {
            transform: translateY(7.2px) rotate(45deg);
        }
        .mobile-menu-toggle.is-open .bar-2 {
            opacity: 0;
            transform: scaleX(0);
        }
        .mobile-menu-toggle.is-open .bar-3 {
            transform: translateY(-7.2px) rotate(-45deg);
        }

        /* Wrap & Layout */
        .wrap {
            width: min(1260px, calc(100% - 36px));
            margin: 26px auto 50px;
        }

        /* Hero Banner */
        .hero {
            background: linear-gradient(135deg, #ffffff 0%, #f0f7fc 100%);
            border: 1px solid #d8e8f5;
            border-radius: var(--r-xl);
            padding: 30px 34px;
            box-shadow: var(--shadow-sm);
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 24px;
            margin-bottom: 24px;
        }
        .hero-text { max-width: 740px; }
        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--bmkg-blue);
            font-weight: 800;
            background: var(--bmkg-blue-light);
            padding: 4px 10px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .eyebrow-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--bmkg-blue);
        }
        .hero h2 {
            font-size: clamp(24px, 3.2vw, 36px);
            line-height: 1.18;
            margin: 0 0 10px;
            letter-spacing: -.03em;
            color: var(--bmkg-navy);
            font-weight: 800;
        }
        .hero p {
            font-size: 13.5px;
            line-height: 1.65;
            color: var(--muted);
            margin: 0;
        }
        .hero-tools {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 12px;
            flex: none;
        }
        .hero-partners {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }
        .hero-partners > span {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: var(--muted);
        }
        .partner-logos {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid var(--line);
            padding: 6px 12px;
            border-radius: var(--r-md);
            box-shadow: var(--shadow-sm);
        }
        .partner-logos img {
            display: block;
            object-fit: contain;
        }
        .partner-logos .partner-bmkg { height: 40px; max-width: 48px; }
        .partner-logos .partner-province { height: 44px; max-width: 38px; }
        .partner-logos .partner-kemenkes { height: 38px; max-width: 38px; }
        .hero-period-select {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            padding: 8px 12px;
            color: var(--ink);
            font-size: 12px;
            font-weight: 700;
        }

        /* Product Cards Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .product-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 22px 24px;
            background: var(--card-bg);
            border: 1px solid var(--line);
            border-top: 4px solid var(--bmkg-blue);
            border-radius: var(--r-lg);
            text-decoration: none;
            color: var(--ink);
            box-shadow: var(--shadow-sm);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-lg);
            border-color: #bae6fd;
            border-top-color: var(--bmkg-navy);
        }
        .product-card .product-no {
            font-size: 10.5px;
            color: var(--bmkg-blue);
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }
        .product-card h3 {
            margin: 8px 0 6px;
            font-size: 17px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.02em;
        }
        .product-card p {
            margin: 0 0 14px;
            color: var(--muted);
            font-size: 12.5px;
            line-height: 1.55;
        }
        .product-card .arrow {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--bmkg-blue);
            font-size: 12px;
            font-weight: 800;
            transition: transform .18s ease;
        }
        .product-card:hover .arrow {
            transform: translateX(3px);
            color: var(--bmkg-navy);
        }

        /* Climate Monitoring (Peringatan Dini & HTH Leaflet - Top Tabs & Floating Subnav) */
        .climate-monitor-section {
            margin: 28px 0 38px;
        }
        .monitor-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
        }
        .monitor-header-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 2px;
        }
        .monitor-top-tabs {
            display: inline-flex;
            align-items: center;
            background: #f1f5f9;
            padding: 5px;
            border-radius: var(--r-lg);
            border: 1.5px solid var(--line);
            gap: 6px;
        }
        .monitor-top-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 22px;
            border-radius: var(--r-md);
            border: none;
            background: transparent;
            color: var(--ink-secondary);
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
            white-space: nowrap;
        }
        .monitor-top-tab-btn:hover {
            color: var(--bmkg-blue);
            background: rgba(255, 255, 255, 0.7);
        }
        .monitor-top-tab-btn.is-active {
            background: var(--bmkg-navy);
            color: #ffffff;
            font-weight: 800;
            box-shadow: 0 4px 14px rgba(0, 43, 73, 0.2);
        }
        .monitor-auto-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid var(--line);
            padding: 6px 14px;
            border-radius: var(--r-full);
            font-size: 11.5px;
            font-weight: 700;
            color: var(--muted);
            box-shadow: var(--shadow-sm);
        }
        .monitor-auto-status .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            box-shadow: 0 0 8px #22c55e;
            animation: pulse-ring 1.8s infinite;
        }
        .monitor-content {
            width: 100%;
            min-width: 0;
        }
        .monitor-pane { display: none; }
        .monitor-pane.is-active { display: block; }

        /* Floating Subnav Inside Map (Kekeringan vs Hujan Lebat) */
        .map-card-wrapper {
            position: relative;
            z-index: 1;
            isolation: isolate;
            border-radius: var(--r-lg);
            overflow: hidden;
            border: 1.5px solid var(--line);
            box-shadow: var(--shadow-sm);
            background: #ffffff;
        }
        .map-floating-subnav {
            position: absolute;
            top: 12px;
            left: 54px;
            z-index: 500;
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            padding: 4px;
            border-radius: var(--r-md);
            border: 1.5px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 4px 16px rgba(0, 43, 73, 0.14);
            gap: 4px;
        }
        .subnav-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 15px;
            border-radius: var(--r-sm);
            border: none;
            background: transparent;
            color: var(--muted);
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            transition: all .18s ease;
        }
        .subnav-btn:hover {
            color: var(--bmkg-blue);
            background: var(--bmkg-cyan-soft);
        }
        .subnav-btn.is-active {
            background: var(--bmkg-blue);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.35);
        }
        .subnav-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            display: inline-block;
        }
        .monitor-leaflet-map {
            width: 100%;
            height: 490px;
            background: #eef2f6;
        }
        .monitor-legend-box {
            position: absolute;
            top: 14px;
            right: 14px;
            z-index: 500;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(226, 232, 240, 0.95);
            border-radius: var(--r-md);
            padding: 12px 14px;
            box-shadow: var(--shadow-md);
            min-width: 170px;
        }
        .monitor-legend-box h4 {
            margin: 0 0 8px;
            font-size: 11px;
            font-weight: 800;
            color: var(--bmkg-navy);
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 11.5px;
            color: var(--ink-secondary);
            font-weight: 600;
            margin-bottom: 4px;
        }
        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            flex: none;
        }
        .legend-box-sq {
            width: 10px;
            height: 10px;
            border-radius: 2px;
            flex: none;
        }

        .table-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 20px 24px;
            margin-top: 16px;
            box-shadow: var(--shadow-sm);
        }
        .table-card h4 {
            margin: 0 0 14px;
            font-size: 15px;
            font-weight: 800;
            color: var(--bmkg-navy);
        }
        .table-scroll { overflow-x: auto; }
        .monitor-table {
            width: 100%;
            border-collapse: collapse;
        }
        .monitor-table th {
            text-align: left;
            font-size: 10.5px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 12px 14px;
            border-bottom: 1.5px solid var(--line);
            background: #f8fafc;
            font-weight: 700;
        }
        .monitor-table td {
            font-size: 12.5px;
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: var(--ink);
        }
        .monitor-table tr:last-child td { border-bottom: 0; }
        .monitor-table tbody tr:hover { background: #f8fafc; }
        .btn-expand-hth {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #ffffff;
            color: var(--bmkg-navy);
            border: 1.5px solid var(--line-strong);
            padding: 9px 20px;
            border-radius: var(--r-md);
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all .2s ease;
            box-shadow: 0 1px 3px rgba(0, 43, 73, 0.05);
            font-family: inherit;
        }
        .btn-expand-hth:hover {
            background: var(--bmkg-blue-light);
            border-color: var(--bmkg-blue);
            color: var(--bmkg-blue-dark);
            box-shadow: 0 2px 6px rgba(2, 132, 199, 0.15);
            transform: translateY(-1px);
        }

        /* Other Pages: Profile, Services, Contact */
        /* Modern BMKG Contact Page Styles */
        .contact-grid-4 {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .contact-feature-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-xl);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all .2s ease;
        }
        .contact-feature-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: #cbd5e1;
        }
        .contact-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            margin-bottom: 14px;
            flex: none;
        }
        .contact-icon-box svg {
            width: 22px;
            height: 22px;
            stroke-width: 2;
        }
        .contact-icon-blue { background: #e0f2fe; color: #0284c7; }
        .contact-icon-green { background: #dcfce7; color: #16a34a; }
        .contact-icon-indigo { background: #e0e7ff; color: #4338ca; }
        .contact-icon-amber { background: #fef3c7; color: #d97706; }

        .contact-feature-card h3 {
            margin: 0 0 6px;
            font-size: 15px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.01em;
        }
        .contact-feature-card p {
            margin: 0 0 16px;
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.55;
            flex: 1;
        }
        .contact-card-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        .pill-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11.5px;
            font-weight: 700;
            padding: 7px 14px;
            border-radius: 20px;
            text-decoration: none;
            transition: all .18s ease;
            background: #f1f5f9;
            color: var(--ink);
            border: 1px solid var(--line);
        }
        .pill-action-btn:hover {
            transform: translateY(-1px);
        }
        .pill-action-btn.btn-direct {
            background: #e0f2fe;
            color: #0284c7;
            border-color: #bae6fd;
        }
        .pill-action-btn.btn-direct:hover {
            background: #bae6fd;
            color: #0369a1;
        }
        .pill-action-btn.btn-call {
            background: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }
        .pill-action-btn.btn-call:hover {
            background: #dcfce7;
        }
        .pill-action-btn.btn-wa {
            background: #f0fdf4;
            color: #16a34a;
            border-color: #bbf7d0;
        }
        .pill-action-btn.btn-wa:hover {
            background: #dcfce7;
            color: #15803d;
        }
        .pill-action-btn.btn-email {
            background: #eef2ff;
            color: #4338ca;
            border-color: #c7d2fe;
        }
        .pill-action-btn.btn-email:hover {
            background: #e0e7ff;
        }
        .pill-status-open {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #86efac;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .02em;
        }
        .pill-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #16a34a;
            box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2);
            animation: pulse-dot 2s infinite;
        }
        .pill-status-closed {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fca5a5;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .02em;
        }
        .pill-status-closed .pill-status-dot {
            background: #dc2626;
            box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
            animation: none;
        }

        /* 2-Column Contact & Map Layout */
        .contact-twocol-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 36px;
        }
        .contact-box-panel {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-xl);
            padding: 28px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
        }
        .contact-box-panel h3 {
            margin: 0 0 4px;
            font-size: 18px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.02em;
        }
        .contact-box-panel .panel-sub {
            margin: 0 0 20px;
            font-size: 12.5px;
            color: var(--muted);
            line-height: 1.5;
        }
        .contact-form-grid {
            display: grid;
            gap: 14px;
        }
        .contact-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--ink-secondary);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .03em;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            border: 1.5px solid var(--line-strong);
            border-radius: var(--r-md);
            padding: 10px 14px;
            font-size: 13px;
            color: var(--ink);
            background: #ffffff;
            outline: none;
            transition: all .2s ease;
        }
        .form-group input::placeholder,
        .form-group textarea::placeholder {
            color: var(--muted-light);
        }
        .form-group input:hover,
        .form-group select:hover,
        .form-group textarea:hover {
            border-color: var(--muted-light);
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--bmkg-blue);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.18);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 95px;
        }
        .btn-submit-message {
            margin-top: 4px;
            width: 100%;
            height: 44px;
            border: 0;
            border-radius: var(--r-md);
            background: var(--bmkg-navy);
            color: #ffffff;
            font-size: 13px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s ease;
            box-shadow: 0 2px 8px rgba(0, 43, 73, 0.18);
        }
        .btn-submit-message:hover {
            background: var(--bmkg-blue-dark);
            transform: translateY(-1px);
        }

        /* Map Embed Container */
        .station-map-wrapper {
            position: relative;
            z-index: 1;
            isolation: isolate;
            flex: 1;
            min-height: 310px;
            border-radius: var(--r-lg);
            overflow: hidden;
            border: 1px solid var(--line);
        }
        .station-map-canvas {
            width: 100%;
            height: 100%;
            min-height: 310px;
        }
        .station-map-overlay-card {
            position: absolute;
            top: 14px;
            left: 14px;
            z-index: 10;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: var(--r-md);
            padding: 12px 14px;
            box-shadow: var(--shadow-md);
            max-width: 250px;
        }
        .station-map-overlay-card h5 {
            margin: 0 0 2px;
            font-size: 12px;
            font-weight: 800;
            color: var(--bmkg-navy);
        }
        .station-map-overlay-card p {
            margin: 0 0 6px;
            font-size: 10.5px;
            color: var(--muted);
            line-height: 1.35;
        }
        .station-map-rating {
            font-size: 10px;
            font-weight: 800;
            color: #d97706;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .station-map-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 10.5px;
            font-weight: 800;
            color: #ffffff;
            background: var(--bmkg-blue);
            padding: 5px 10px;
            border-radius: var(--r-sm);
            text-decoration: none;
            transition: background .15s;
        }
        .station-map-btn:hover { background: var(--bmkg-blue-dark); }


        /* PTSP Services Styles */
        .ptsp-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }
        .ptsp-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .ptsp-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--bmkg-blue);
        }
        .ptsp-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--r-md);
            background: var(--bmkg-blue-light);
            color: var(--bmkg-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }
        .ptsp-card h4 {
            margin: 0 0 8px;
            font-size: 15px;
            font-weight: 800;
            color: var(--bmkg-navy);
        }
        .ptsp-card p {
            margin: 0 0 16px;
            font-size: 12.5px;
            line-height: 1.6;
            color: var(--muted);
            flex: 1;
        }
        .ptsp-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            font-weight: 800;
            color: var(--bmkg-blue);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: var(--r-sm);
            background: var(--bmkg-cyan-soft);
            border: 1px solid #bae6fd;
            transition: all .15s;
            width: fit-content;
        }
        .ptsp-action-btn:hover {
            background: var(--bmkg-blue);
            color: #ffffff;
        }

        /* PTSP Flow Steps */
        .ptsp-steps-panel {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: var(--shadow-sm);
        }
        .ptsp-steps-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 16px;
            margin-top: 18px;
        }
        .ptsp-step-item {
            position: relative;
            padding: 16px;
            background: #f8fafc;
            border: 1px solid var(--line-light);
            border-radius: var(--r-md);
        }
        .ptsp-step-num {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: var(--bmkg-blue);
            color: #ffffff;
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .ptsp-step-item h5 {
            margin: 0 0 6px;
            font-size: 13px;
            font-weight: 800;
            color: var(--bmkg-navy);
        }
        .ptsp-step-item p {
            margin: 0;
            font-size: 11.5px;
            line-height: 1.5;
            color: var(--muted);
        }

        /* Callout Box Tarif Rp 0 & Maklumat */
        .ptsp-callout-grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        @media (max-width: 768px) {
            .ptsp-callout-grid { grid-template-columns: 1fr; }
        }
        .ptsp-free-card {
            background: linear-gradient(135deg, #063d66 0%, #002b49 100%);
            color: #ffffff;
            border-radius: var(--r-lg);
            padding: 24px;
            box-shadow: var(--shadow-md);
        }
        .ptsp-free-card .badge-free {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            background: #f59e0b;
            color: #000000;
            font-weight: 800;
            font-size: 11px;
            margin-bottom: 10px;
            letter-spacing: .05em;
        }
        .ptsp-free-card h4 {
            margin: 0 0 8px;
            font-size: 17px;
            font-weight: 800;
            color: #ffffff;
        }
        .ptsp-free-card p {
            margin: 0 0 14px;
            font-size: 12.5px;
            line-height: 1.6;
            color: #cbd5e1;
        }
        .ptsp-maklumat-card {
            background: #fefce8;
            border: 1px solid #fef08a;
            border-radius: var(--r-lg);
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .ptsp-maklumat-card h4 {
            margin: 0 0 8px;
            font-size: 15px;
            font-weight: 800;
            color: #854d0e;
        }
        .ptsp-maklumat-card p {
            margin: 0 0 12px;
            font-size: 12px;
            line-height: 1.6;
            color: #713f12;
        }

        /* Product Showcase Banner */
        .product-showcase-banner {
            background: linear-gradient(135deg, #00192b 0%, #002b49 60%, #063d66 100%);
            border-radius: var(--r-xl);
            padding: 28px 32px;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
            margin-top: 10px;
        }
        .product-showcase-banner::after {
            content: "";
            position: absolute;
            right: -60px;
            bottom: -60px;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(2, 132, 199, 0.25) 0%, transparent 70%);
            pointer-events: none;
        }
        .showcase-content h3 {
            margin: 0 0 8px;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -.02em;
            color: #ffffff;
        }
        .showcase-content p {
            margin: 0 0 14px;
            font-size: 13px;
            color: #cbd5e1;
            line-height: 1.55;
            max-width: 680px;
        }
        .showcase-features {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 11.5px;
            font-weight: 700;
            color: #38bdf8;
        }
        .btn-showcase {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: var(--bmkg-navy);
            font-weight: 800;
            font-size: 13px;
            padding: 12px 22px;
            border-radius: var(--r-md);
            text-decoration: none;
            white-space: nowrap;
            transition: all .2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            flex-shrink: 0;
            z-index: 1;
        }
        .btn-showcase:hover {
            background: var(--bmkg-blue-light);
            color: var(--bmkg-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.28);
        }

        /* Product Catalog Grid */
        .product-catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 16px;
            margin-bottom: 30px;
        }
        .product-catalog-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .product-catalog-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--bmkg-blue);
        }
        .product-catalog-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 6px;
            background: var(--bmkg-blue-light);
            color: var(--bmkg-blue-dark);
            font-size: 10.5px;
            font-weight: 800;
            margin-bottom: 10px;
            width: fit-content;
        }
        .product-catalog-card h4 {
            margin: 0 0 6px;
            font-size: 15px;
            font-weight: 800;
            color: var(--bmkg-navy);
        }
        .product-catalog-card p {
            margin: 0 0 14px;
            font-size: 12.5px;
            line-height: 1.55;
            color: var(--muted);
            flex: 1;
        }

                /* Dasarian Image Carousel Styles (A4 Landscape 1024x724 - Zero Empty Space) */
        .dasarian-slider-section {
            margin: 36px 0 44px;
        }
        .dasarian-carousel-container {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-xl);
            padding: 24px;
            box-shadow: var(--shadow-sm);
            position: relative;
        }
        .dasarian-pills {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 4px;
        }
        .dasarian-pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            font-size: 13px;
            font-weight: 700;
            color: var(--ink-secondary);
            background: #f8fafc;
            border: 1.5px solid var(--line);
            border-radius: var(--r-full);
            cursor: pointer;
            transition: all .2s ease;
            white-space: nowrap;
        }
        .dasarian-pill-btn:hover {
            border-color: var(--bmkg-blue);
            color: var(--bmkg-blue);
            background: var(--bmkg-cyan-soft);
        }
        .dasarian-pill-btn.is-active {
            background: var(--bmkg-navy);
            color: #ffffff;
            border-color: var(--bmkg-navy);
            box-shadow: 0 4px 14px rgba(0, 43, 73, 0.2);
        }
        .dasarian-pill-btn .pill-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .dasarian-slider-viewport {
            position: relative;
            overflow: hidden;
            border-radius: var(--r-lg);
            background: #ffffff;
            border: 1.5px solid var(--line);
            width: 100%;
            max-width: 980px;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 43, 73, 0.08);
        }
        .dasarian-slider-track {
            display: flex;
            transition: transform .45s cubic-bezier(0.25, 1, 0.5, 1);
            width: 100%;
        }
        .dasarian-slide {
            flex: 0 0 100%;
            max-width: 100%;
            position: relative;
        }
        .dasarian-slide-card {
            position: relative;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            width: 100%;
        }
        .dasarian-img-wrapper {
            position: relative;
            cursor: pointer;
            width: 100%;
            aspect-ratio: 1024 / 724; /* Exact A4 Landscape ratio - zero empty space */
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
            overflow: hidden;
        }
        .dasarian-slide-img {
            width: 100%;
            height: 100%;
            object-fit: contain; /* Exact aspect-ratio match = 100% full bleed without distortion */
            display: block;
            background: #ffffff;
            transition: transform .3s ease;
        }
        .dasarian-img-wrapper:hover .dasarian-slide-img {
            transform: scale(1.015);
        }
        .dasarian-hover-hint {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0, 43, 73, 0.85);
            backdrop-filter: blur(6px);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--r-md);
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0;
            transition: opacity .2s ease;
            pointer-events: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .dasarian-img-wrapper:hover .dasarian-hover-hint {
            opacity: 1;
        }
        .dasarian-slide-footer {
            background: #f8fafc;
            border-top: 1.5px solid var(--line);
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }
        .dasarian-slide-meta {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            flex-wrap: wrap;
        }
        .dasarian-badge-cat {
            color: #ffffff;
            font-size: 10.5px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 6px;
            letter-spacing: .02em;
        }
        .dasarian-badge-period {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 11px;
            font-weight: 700;
            padding: 3px 10px;
            border-radius: 6px;
            border: 1px solid #bae6fd;
        }
        .dasarian-slide-title {
            margin: 0;
            font-size: 15.5px;
            font-weight: 800;
            color: var(--bmkg-navy);
        }
        .dasarian-slide-desc {
            margin: 4px 0 0;
            font-size: 12px;
            color: var(--muted);
            line-height: 1.45;
        }
        .dasarian-slide-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }
        .btn-dasarian-action {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 700;
            border-radius: var(--r-md);
            border: 1px solid var(--line);
            background: #ffffff;
            color: var(--bmkg-navy);
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }
        .btn-dasarian-action:hover {
            border-color: var(--bmkg-blue);
            color: var(--bmkg-blue);
            background: var(--bmkg-cyan-soft);
        }
        .btn-dasarian-download {
            background: var(--bmkg-blue);
            color: #ffffff !important;
            border-color: var(--bmkg-blue);
        }
        .btn-dasarian-download:hover {
            background: var(--bmkg-blue-dark);
        }
        .dasarian-nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.95);
            border: 1.5px solid var(--line);
            color: var(--bmkg-navy);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 20;
            box-shadow: 0 4px 14px rgba(0, 43, 73, 0.16);
            transition: all .2s;
        }
        .dasarian-nav-arrow:hover {
            background: #ffffff;
            color: var(--bmkg-blue);
            transform: translateY(-50%) scale(1.08);
            border-color: var(--bmkg-blue);
        }
        .dasarian-arrow-prev { left: 16px; }
        .dasarian-arrow-next { right: 16px; }
        .dasarian-controls-bottom {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            margin-top: 14px;
        }
        .dasarian-dots {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .dasarian-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #cbd5e1;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: all .25s ease;
        }
        .dasarian-dot.is-active {
            width: 28px;
            border-radius: 10px;
            background: var(--bmkg-blue);
        }
        .dasarian-progress-wrapper {
            width: 180px;
            height: 3px;
            background: #f1f5f9;
            border-radius: 2px;
            overflow: hidden;
        }
        .dasarian-progress-bar {
            height: 100%;
            width: 0%;
            background: var(--bmkg-blue);
            transition: width .1s linear;
        }

        /* Fullscreen Lightbox Modal */
        .dasarian-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.88);
            backdrop-filter: blur(8px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .dasarian-modal-dialog {
            background: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: var(--r-xl);
            max-width: 1060px;
            width: 100%;
            max-height: 94vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .dasarian-modal-header {
            padding: 14px 20px;
            background: #002b49;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .dasarian-modal-btn {
            font-size: 11.5px;
            font-weight: 700;
            color: #ffffff;
            background: var(--bmkg-blue);
            padding: 6px 14px;
            border-radius: var(--r-sm);
            text-decoration: none;
        }
        .dasarian-modal-close {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 26px;
            cursor: pointer;
            line-height: 1;
            padding: 0 6px;
        }
        .dasarian-modal-body {
            padding: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: auto;
            background: #f8fafc;
        }
        .dasarian-modal-img {
            max-width: 100%;
            max-height: 80vh;
            aspect-ratio: 1024 / 724;
            object-fit: contain;
            border-radius: var(--r-md);
            box-shadow: 0 4px 16px rgba(0,0,0,0.15);
        }

        /* Climate Bulletin Showcase Section */
        .bulletin-section {
            margin: 40px 0 48px;
        }
        .bulletin-card-main {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid var(--line);
            border-radius: var(--r-xl);
            box-shadow: 0 10px 30px -10px rgba(0, 43, 73, 0.08);
            overflow: hidden;
            position: relative;
        }
        .bulletin-card-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--bmkg-blue) 0%, #38bdf8 50%, #059669 100%);
        }
        .bulletin-hero-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 36px;
            padding: 36px 36px 32px;
            align-items: center;
        }
        .bulletin-cover-col {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        .bulletin-3d-book {
            position: relative;
            max-width: 250px;
            width: 100%;
            border-radius: 8px 14px 14px 8px;
            box-shadow: -8px 12px 28px rgba(0, 43, 73, 0.22), 0 2px 6px rgba(0,0,0,0.1);
            transition: transform .35s cubic-bezier(0.16, 1, 0.3, 1), box-shadow .35s ease;
            cursor: pointer;
            overflow: hidden;
            background: #002b49;
            aspect-ratio: 1 / 1.414;
            display: block;
            text-decoration: none;
        }
        .bulletin-3d-book:hover {
            transform: translateY(-6px) rotate(-1deg) scale(1.02);
            box-shadow: -12px 20px 36px rgba(0, 43, 73, 0.28), 0 4px 12px rgba(0,0,0,0.15);
        }
        .bulletin-3d-book img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .bulletin-book-spine {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 14px;
            background: linear-gradient(90deg, rgba(0,0,0,0.4) 0%, rgba(255,255,255,0.2) 30%, rgba(0,0,0,0.2) 100%);
            pointer-events: none;
        }
        .bulletin-badge-floating {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(2, 132, 199, 0.95);
            backdrop-filter: blur(4px);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 999px;
            letter-spacing: .04em;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }
        .bulletin-info-col {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .bulletin-tags-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }
        .bulletin-tag-edition {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
            border: 1px solid #bae6fd;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .bulletin-tag-meta {
            font-size: 12px;
            color: var(--muted);
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #ffffff;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--line);
        }
        .bulletin-headline {
            margin: 0;
            font-size: 26px;
            font-weight: 800;
            color: var(--bmkg-navy);
            line-height: 1.25;
            letter-spacing: -.02em;
        }
        .bulletin-summary {
            font-size: 14px;
            line-height: 1.65;
            color: var(--body);
            margin: 0;
            max-width: 720px;
        }
        .bulletin-highlights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 10px;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            padding: 14px 18px;
        }
        .bulletin-highlight-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--bmkg-navy);
        }
        .bulletin-highlight-item svg {
            flex-shrink: 0;
            color: var(--bmkg-blue);
            margin-top: 2px;
        }
        .bulletin-actions-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
            margin-top: 6px;
        }
        .btn-bulletin-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, var(--bmkg-blue) 0%, var(--bmkg-navy) 100%);
            color: #ffffff !important;
            font-size: 13.5px;
            font-weight: 700;
            padding: 12px 24px;
            border-radius: var(--r-sm);
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.28);
            transition: all .2s ease;
        }
        .btn-bulletin-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(2, 132, 199, 0.38);
        }
        .btn-bulletin-secondary {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #ffffff;
            color: var(--bmkg-navy) !important;
            font-size: 13.5px;
            font-weight: 700;
            padding: 11px 20px;
            border-radius: var(--r-sm);
            border: 1px solid var(--line);
            text-decoration: none;
            transition: all .2s ease;
        }
        .btn-bulletin-secondary:hover {
            background: #f8fafc;
            border-color: var(--bmkg-blue);
            color: var(--bmkg-blue) !important;
            transform: translateY(-1px);
        }

        /* Previous Bulletins Archive Strip */
        .bulletin-archive-box {
            border-top: 1px solid var(--line);
            background: #ffffff;
            padding: 20px 36px 24px;
        }
        .bulletin-archive-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }
        .bulletin-archive-title {
            font-size: 13.5px;
            font-weight: 800;
            color: var(--bmkg-navy);
            display: flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        .bulletin-archive-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 14px;
        }
        .bulletin-archive-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            background: #f8fafc;
            border: 1px solid var(--line);
            border-radius: var(--r-md);
            text-decoration: none;
            color: inherit;
            transition: all .2s ease;
        }
        .bulletin-archive-card:hover {
            background: #ffffff;
            border-color: #bae6fd;
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.1);
            transform: translateY(-2px);
        }
        .bulletin-archive-thumb {
            width: 44px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #cbd5e1;
            flex-shrink: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .bulletin-archive-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
            min-width: 0;
        }
        .bulletin-archive-badge {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--bmkg-blue);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .bulletin-archive-name {
            font-size: 12px;
            font-weight: 700;
            color: var(--bmkg-navy);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .bulletin-archive-date {
            font-size: 11px;
            color: var(--muted);
        }

        /* FAQ Section */
        .faq-section {
            margin-top: 10px;
        }
        .faq-title {
            text-align: center;
            font-size: 20px;
            font-weight: 800;
            color: var(--bmkg-navy);
            letter-spacing: -.02em;
            margin: 0 0 20px;
        }
        .faq-accordion-list {
            display: grid;
            gap: 12px;
            max-width: 860px;
            margin: 0 auto;
        }
        .faq-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all .2s;
        }
        .faq-question {
            width: 100%;
            background: none;
            border: none;
            padding: 16px 20px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--bmkg-navy);
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }
        .faq-question:hover {
            color: var(--bmkg-blue);
        }
        .faq-icon {
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #f1f5f9;
            color: var(--bmkg-blue);
            display: grid;
            place-items: center;
            font-size: 15px;
            font-weight: 800;
            flex: none;
            transition: transform .2s ease;
        }
        .faq-card.is-open .faq-icon {
            transform: rotate(45deg);
            background: var(--bmkg-blue-light);
        }
        .faq-answer {
            display: none;
            padding: 0 20px 18px;
            font-size: 13px;
            line-height: 1.65;
            color: var(--ink-secondary);
            border-top: 1px solid #f1f5f9;
            padding-top: 12px;
        }
        .faq-card.is-open .faq-answer {
            display: block;
        }
        .page-section {
            margin: 24px 0 36px;
        }
        .section-intro { margin-bottom: 20px; }
        .section-intro h2 {
            font-size: clamp(24px, 2.8vw, 32px);
            margin: 4px 0 6px;
            color: var(--bmkg-navy);
            letter-spacing: -.03em;
            font-weight: 800;
        }
        .section-intro p {
            color: var(--muted);
            max-width: 760px;
            margin: 0;
            font-size: 13.5px;
        }
        /* Profil: Foto Pegawai & Team Card */
        .profile-team-card {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-xl);
            padding: 24px;
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }
        .profile-team-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 28px;
            align-items: center;
        }
        .profile-photo-container {
            position: relative;
            border-radius: var(--r-lg);
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(0, 43, 73, 0.12);
            background: #00192b;
            border: 1px solid rgba(0, 43, 73, 0.08);
        }
        .profile-photo-img {
            width: 100%;
            height: auto;
            display: block;
            object-fit: cover;
            transition: transform .35s ease;
        }
        .profile-photo-container:hover .profile-photo-img {
            transform: scale(1.025);
        }
        .profile-photo-tag {
            position: absolute;
            bottom: 12px;
            left: 12px;
            background: rgba(0, 43, 73, 0.85);
            backdrop-filter: blur(8px);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 5px 12px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            letter-spacing: .02em;
        }
        .profile-team-content {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .profile-badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--bmkg-cyan-soft);
            color: var(--bmkg-blue-dark);
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .05em;
            padding: 5px 12px;
            border-radius: 999px;
            width: fit-content;
        }
        .profile-team-content h3 {
            margin: 0;
            font-size: 21px;
            font-weight: 800;
            color: var(--bmkg-navy);
            line-height: 1.3;
        }
        .profile-team-content p {
            margin: 0;
            font-size: 13.5px;
            line-height: 1.7;
            color: #475569;
        }
        .profile-team-highlights {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin-top: 4px;
            padding-top: 14px;
            border-top: 1px solid var(--line);
        }
        .team-highlight-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        .team-highlight-item svg {
            color: var(--bmkg-blue);
            flex-shrink: 0;
            margin-top: 2px;
        }
        .team-highlight-item strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--bmkg-navy);
        }
        .team-highlight-item span {
            display: block;
            font-size: 11.5px;
            color: #64748b;
            margin-top: 2px;
        }

        .profile-grid, .service-grid {
            display: grid;
            grid-template-columns: 1.2fr .8fr;
            gap: 16px;
        }
        .info-panel {
            padding: 24px;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            box-shadow: var(--shadow-sm);
        }
        .info-panel h3 {
            font-size: 17px;
            margin: 0 0 10px;
            color: var(--bmkg-navy);
            font-weight: 800;
        }
        .info-panel p {
            font-size: 13.5px;
            line-height: 1.7;
            color: var(--ink-secondary);
            margin: 0;
        }
        .info-panel ul {
            padding-left: 19px;
            color: var(--ink-secondary);
            font-size: 13.5px;
            line-height: 1.8;
            margin: 8px 0 0;
        }
        .org-placeholder {
            display: grid;
            place-items: center;
            min-height: 130px;
            border: 1.5px dashed #cbd5e1;
            border-radius: var(--r-md);
            background: #f8fafc;
            color: var(--muted);
            text-align: center;
            padding: 20px;
            font-size: 12.5px;
        }
        .service-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .service-callout {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin: 16px 0;
            padding: 18px 22px;
            background: var(--bmkg-blue-light);
            border: 1px solid #bae6fd;
            border-radius: var(--r-md);
            color: var(--bmkg-navy);
            font-size: 13.5px;
            font-weight: 600;
        }
        .service-callout a, .contact-link {
            color: var(--bmkg-blue);
            font-weight: 800;
            text-decoration: none;
        }
        .service-callout a:hover, .contact-link:hover {
            color: var(--bmkg-blue-dark);
            text-decoration: underline;
        }
        .contact-panel {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }
        .contact-item {
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            background: #ffffff;
            box-shadow: var(--shadow-sm);
        }
        .contact-item strong {
            display: block;
            font-size: 11px;
            color: var(--muted);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }
        .contact-item span {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--bmkg-navy);
            line-height: 1.5;
        }

        /* Stats & SILING Malaria Styles */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 18px;
        }
        .card, .panel {
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: var(--r-lg);
            box-shadow: var(--shadow-sm);
        }
        .stat {
            padding: 18px 20px;
            position: relative;
            overflow: hidden;
        }
        .stat:after {
            content: "";
            position: absolute;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            right: 12px;
            top: 12px;
            background: var(--bmkg-blue-light);
        }
        .stat.warn:after { background: var(--bmkg-gold-soft); }
        .stat.alert:after { background: var(--status-awas-bg); }
        .stat-label { font-size: 12px; color: var(--muted); font-weight: 600; }
        .stat-value { font-size: 28px; line-height: 1.2; font-weight: 800; letter-spacing: -.03em; margin-top: 5px; color: var(--bmkg-navy); }
        .stat-note { font-size: 11px; color: var(--muted); margin-top: 4px; }
        .stat-icon {
            position: absolute;
            right: 28px;
            top: 24px;
            display: flex;
            width: 24px;
            height: 24px;
            align-items: center;
            justify-content: center;
            color: var(--bmkg-blue);
            z-index: 1;
        }
        .stat-icon svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 1.8; }
        .warn .stat-icon { color: var(--status-waspada); }
        .alert .stat-icon { color: var(--status-awas); }
        .content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.55fr) minmax(300px, .8fr);
            gap: 16px;
        }
        .content-grid.maps-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .panel { padding: 20px; }
        .panel-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }
        .panel-heading h3 { font-size: 15px; margin: 0; font-weight: 800; color: var(--bmkg-navy); }
        .panel-heading p { font-size: 11px; color: var(--muted); margin: 3px 0 0; }
        .map-shell {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: var(--r-md);
            min-height: 390px;
            overflow: hidden;
            position: relative;
        }
        .map-shell svg { width: 100%; height: 390px; display: block; }
        .map-legend {
            position: absolute;
            left: 13px;
            bottom: 13px;
            background: #ffffffed;
            border: 1px solid var(--line);
            border-radius: var(--r-sm);
            padding: 10px 12px;
            box-shadow: var(--shadow-sm);
        }
        .map-legend strong { display: block; font-size: 10px; margin-bottom: 7px; color: var(--bmkg-navy); }
        .climate-legend .legend-group { margin-top: 6px; }
        .climate-legend .legend-group-title { display: block; font-size: 10px; line-height: 1.2; font-weight: 800; color: var(--bmkg-navy); margin-bottom: 2px; }
        .climate-legend .legend-row { margin: 3px 0; }
        .legend-row { display: flex; align-items: center; gap: 7px; font-size: 10px; color: var(--ink-secondary); margin: 4px 0; }
        .swatch { width: 11px; height: 11px; border-radius: 3px; }
        .map-note { position: absolute; right: 12px; bottom: 12px; color: var(--muted); font-size: 9px; background: #ffffffd9; padding: 4px 7px; border-radius: 6px; }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 9.5px;
            font-weight: 800;
            padding: 3px 8px;
            border-radius: 20px;
        }
        .safe { color: #047857; background: #d1fae5; }
        .caution { color: #b45309; background: #fef3c7; }
        .danger { color: #b91c1c; background: #fee2e2; }
        .rec-card { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
        .rec { border-radius: var(--r-md); padding: 14px 16px; border: 1px solid transparent; }
        .rec h4 { font-size: 12px; letter-spacing: .1em; margin: 0 0 5px; font-weight: 800; }
        .rec p { font-size: 10.5px; margin: 0 0 8px; opacity: .88; }
        .rec ul { margin: 0; padding-left: 15px; font-size: 10.5px; line-height: 1.6; }
        .rec.green { background: #ecfdf5; border-color: #a7f3d0; color: #065f46; }
        .rec.yellow { background: #fffbeb; border-color: #fde68a; color: #92400e; }
        .rec.red { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .trend-panel { margin-top: 16px; }
        .trend-scroll { overflow-x: auto; }
        .trend-chart { display: block; width: 100%; min-width: 680px; height: auto; }
        .trend-select { border: 1px solid var(--line); border-radius: var(--r-sm); background: #ffffff; color: var(--ink); font-size: 11.5px; font-weight: 600; padding: 8px 10px; max-width: 190px; }
        .trend-grid { stroke: #e2e8f0; stroke-width: 1; }
        .trend-axis { fill: var(--muted); font-size: 11px; font-family: inherit; }
        .trend-line { fill: none; stroke-width: 2.5; stroke-linecap: round; stroke-linejoin: round; }
        .trend-dot { stroke: #ffffff; stroke-width: 1.5; }
        .trend-legend { display: flex; flex-wrap: wrap; gap: 10px 18px; margin: 10px 2px 0; }
        .trend-key { display: inline-flex; align-items: center; gap: 7px; font-size: 11px; color: var(--ink-secondary); font-weight: 600; }
        .trend-key i { width: 9px; height: 9px; border-radius: 50%; }
        .trend-note { font-size: 10px; color: var(--muted); margin: 8px 2px 0; }
        .district { stroke: #ffffff; stroke-width: 2.5; stroke-linejoin: round; cursor: pointer; transition: filter .2s, fill .2s; }
        .district:hover, .district:focus { filter: brightness(.92); outline: none; }
        .district-label { fill: var(--bmkg-navy); font-size: 13px; font-weight: 700; text-anchor: middle; pointer-events: none; }
        .district-value { fill: var(--ink-secondary); font-size: 11px; font-weight: 600; text-anchor: middle; pointer-events: none; }
        .map-popup { display: none; position: absolute; z-index: 5; width: min(240px, calc(100% - 24px)); padding: 14px 16px; border-radius: var(--r-md); background: #ffffff; border: 1px solid var(--line); box-shadow: var(--shadow-lg); color: var(--ink); }
        .map-popup.is-visible { display: block; }
        .map-popup-title { font-size: 13.5px; font-weight: 800; color: var(--bmkg-navy); margin: 0 25px 7px 0; }
        .map-popup-detail { font-size: 11px; color: var(--ink-secondary); margin: 4px 0; }
        .map-popup-status { font-weight: 800; }
        .map-popup-close { position: absolute; right: 8px; top: 7px; border: 0; background: #f1f5f9; color: var(--muted); border-radius: 50%; width: 24px; height: 24px; cursor: pointer; font-size: 15px; line-height: 1; display: grid; place-items: center; }

        /* Site Footer */
        .site-footer {
            margin-top: 50px;
            background: var(--bmkg-navy-dark);
            color: #ffffff;
            border-top: 3px solid var(--bmkg-blue);
        }
        .footer-inner {
            width: min(1260px, calc(100% - 36px));
            margin: auto;
            padding: 40px 0 30px;
            display: grid;
            grid-template-columns: 1.35fr .8fr 1.05fr;
            gap: 36px;
        }
        .footer-brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
        .footer-logo {
            width: 48px;
            height: 48px;
            object-fit: contain;
            background: #ffffff;
            border-radius: 50%;
            padding: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
            flex-shrink: 0;
        }
        .footer-brand-sub {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: .08em;
            color: #38bdf8;
            text-transform: uppercase;
        }
        .footer-brand {
            font-size: 15px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -.01em;
        }
        .footer-copy {
            max-width: 410px;
            margin: 0;
            color: #94a3b8;
            font-size: 12.5px;
            line-height: 1.65;
        }
        .footer-heading {
            margin: 0 0 14px;
            font-size: 12px;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #38bdf8;
            font-weight: 800;
        }
        .footer-links {
            display: grid;
            gap: 9px;
        }
        .footer-links a {
            color: #cbd5e1;
            font-size: 12.5px;
            font-weight: 500;
            transition: color .18s ease;
        }
        .footer-links a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .footer-contact {
            display: grid;
            align-content: start;
            gap: 10px;
            color: #cbd5e1;
            font-size: 12.5px;
            line-height: 1.6;
        }
        .footer-contact a {
            color: #cbd5e1;
        }
        .footer-contact a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
        .footer-contact strong { color: #ffffff; }
        .footer-badge {
            display: inline-block;
            background: rgba(56, 189, 248, 0.15);
            border: 1px solid rgba(56, 189, 248, 0.35);
            color: #38bdf8;
            font-weight: 800;
            font-size: 11px;
            padding: 4px 10px;
            border-radius: 6px;
            width: fit-content;
        }
        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: #001220;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 500;
        }
        .footer-bottom strong { color: #f1f5f9; }

        /* ========================================================
           COMPREHENSIVE ADAPTIVE MOBILE & TABLET STYLES
           ======================================================== */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }

        /* 1. TABLET LANDSCAPE / MEDIUM SCREENS (<= 1024px) */
        @media (max-width: 1024px) {
            .contact-grid-4 {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .content-grid {
                grid-template-columns: 1fr;
            }
            .content-grid.maps-grid {
                grid-template-columns: 1fr;
            }
        }

        /* 2. TABLET PORTRAIT / SMALL LAPTOPS (<= 980px) */
        @media (max-width: 980px) {
            .topbar-inner {
                height: 64px;
                min-height: 64px;
                flex-wrap: nowrap;
                padding: 0 clamp(14px, 3.5vw, 24px);
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                position: relative;
            }
            .brand-link {
                flex: 1;
                min-width: 0;
                gap: 10px;
            }
            .brandmark {
                width: 40px;
                height: 40px;
            }
            .brand {
                min-width: 0;
            }
            .brand-sub {
                font-size: 9.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .brand h1 {
                font-size: 14.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            /* Hamburger Button sejajar dengan Brand di Mobile */
            .mobile-menu-toggle {
                display: flex;
            }
            /* Bar navigasi disembunyikan dan diubah menjadi slide-down drawer saat dibuka */
            .main-nav {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                width: 100%;
                background: #ffffff;
                border-top: 1px solid var(--line);
                border-bottom: 2.5px solid var(--bmkg-blue);
                box-shadow: 0 14px 28px rgba(0, 43, 73, 0.16);
                padding: 12px clamp(14px, 3.5vw, 24px) 16px;
                flex-direction: column;
                gap: 6px;
                z-index: 1250;
            }
            .main-nav.is-open {
                display: flex;
                animation: menuSlideDown .2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            @keyframes menuSlideDown {
                from { opacity: 0; transform: translateY(-8px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .main-nav a {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 0 14px;
                height: 44px;
                font-size: 13.5px;
                font-weight: 700;
                color: var(--ink-secondary);
                border-radius: var(--r-md);
                background: #f8fafc;
                border: 1px solid #f1f5f9;
                white-space: nowrap;
                width: 100%;
                text-decoration: none;
            }
            .main-nav a:hover {
                background: var(--bmkg-blue-light);
                color: var(--bmkg-blue-dark);
                border-color: #bae6fd;
            }
            .main-nav a.is-current {
                background: var(--bmkg-navy);
                color: #ffffff;
                border-color: var(--bmkg-navy);
                box-shadow: 0 2px 8px rgba(0, 43, 73, 0.18);
            }
            .nav-admin-btn {
                margin-left: 0 !important;
                background: #e0f2fe !important;
                color: #0369a1 !important;
                border: 1px solid #bae6fd !important;
            }
            .nav-admin-btn:hover {
                background: var(--bmkg-blue-dark) !important;
                color: #ffffff !important;
            }
            .nav-icon {
                display: inline-block;
                width: 18px;
                height: 18px;
                flex: none;
                opacity: 0.85;
            }
            /* Dropdown Navigasi Bar Produk di Mobile */
            .nav-item-dropdown {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 4px;
            }
            .nav-link-dropdown-toggle {
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 0 14px;
                height: 44px;
                font-size: 13.5px;
                font-weight: 700;
                color: var(--ink-secondary);
                border-radius: var(--r-md);
                background: #f8fafc;
                border: 1px solid #f1f5f9;
                width: 100%;
                text-decoration: none;
                box-sizing: border-box;
            }
            .nav-link-dropdown-toggle .nav-icon {
                display: inline-block;
            }
            .nav-link-dropdown-toggle .dropdown-chevron {
                margin-left: auto;
                opacity: 0.8;
            }
            .nav-link-dropdown-toggle.is-current {
                background: var(--bmkg-navy) !important;
                color: #ffffff !important;
                border-color: var(--bmkg-navy) !important;
                box-shadow: 0 2px 8px rgba(0, 43, 73, 0.18);
            }
            .nav-dropdown-menu {
                position: static;
                visibility: visible;
                opacity: 1;
                transform: none;
                pointer-events: auto;
                min-width: 0;
                width: 100%;
                box-shadow: none;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: var(--r-md);
                padding: 6px;
                display: flex;
                flex-direction: column;
                gap: 4px;
                margin-top: 2px;
                box-sizing: border-box;
            }
            .nav-dropdown-menu::before {
                display: none;
            }
            .nav-dropdown-menu .dropdown-menu-item {
                padding: 8px 10px !important;
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 6px !important;
                height: auto !important;
            }
            .nav-dropdown-menu .dropdown-menu-item:hover,
            .nav-dropdown-menu .dropdown-menu-item:active {
                background: var(--bmkg-blue-light) !important;
                border-color: #bae6fd !important;
            }
            .nav-dropdown-menu .dropdown-menu-item.is-active {
                background: #e0f2fe !important;
                border-color: #7dd3fc !important;
            }
            .hero {
                flex-direction: column;
                align-items: stretch;
                padding: 24px 20px;
                gap: 16px;
            }
            .hero-tools {
                width: 100%;
                align-items: stretch;
            }
            .hero-period {
                width: 100%;
                flex-wrap: wrap;
            }
            .hero-partners {
                align-items: flex-start;
                flex-wrap: wrap;
            }
            .stats {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            .contact-twocol-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            .profile-team-grid {
                grid-template-columns: 1fr;
                gap: 18px;
            }
            .profile-team-card {
                padding: 16px;
            }
            .profile-team-content h3 {
                font-size: 18px;
            }
            .profile-grid, .service-grid {
                grid-template-columns: 1fr;
            }
            .ptsp-callout-grid {
                grid-template-columns: 1fr;
            }
            .footer-inner {
                grid-template-columns: 1fr 1fr;
                gap: 28px;
            }
            .footer-brand-block {
                grid-column: 1 / -1;
            }
        }

        /* 3. MOBILE LARGE & STANDARD (<= 640px) */
        @media (max-width: 640px) {
            .utility-inner {
                padding: 0 14px;
                font-size: 10px;
                gap: 8px;
            }
            .utility-label {
                display: none; /* Hide long NTP label so date + WIT time fit on one line cleanly */
            }
            .utility-left {
                font-size: 10.5px;
            }
            .utility-right b {
                font-size: 11px;
                padding: 2px 7px;
            }
            .topbar-inner {
                padding: 0 12px;
                height: 60px;
                min-height: 60px;
            }
            .brandmark {
                width: 36px;
                height: 36px;
            }
            .brand h1 {
                font-size: 13.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .brand-sub {
                font-size: 8.5px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .mobile-menu-toggle {
                width: 38px;
                height: 38px;
            }
            .wrap {
                width: calc(100% - 20px);
                margin-top: 14px;
            }
            .hero {
                padding: 18px 14px;
                border-radius: var(--r-md);
            }
            .hero h2 {
                font-size: 19px;
                line-height: 1.3;
            }
            .hero-sub {
                font-size: 12px;
            }
            .hero-period {
                display: grid;
                grid-template-columns: 1fr 1fr auto;
                gap: 6px;
                width: 100%;
                padding: 6px 10px;
            }
            .hero-period select, .hero-period input {
                min-width: 0;
                width: 100%;
                font-size: 11.5px;
                height: 32px;
            }
            .hero-period button {
                height: 32px;
                padding: 0 12px;
                font-size: 11.5px;
            }
            .hero-partners {
                gap: 6px;
            }
            .partner-chip {
                font-size: 10.5px;
                padding: 4px 8px;
            }

            /* Dasarian Carousel on Mobile */
            .dasarian-slider-section {
                margin: 22px 0 32px;
            }
            .dasarian-carousel-container {
                padding: 14px 12px;
                border-radius: var(--r-lg);
            }
            .dasarian-pills {
                justify-content: flex-start;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
                padding-bottom: 6px;
                margin-bottom: 12px;
            }
            .dasarian-pills::-webkit-scrollbar {
                display: none;
            }
            .dasarian-pill-btn {
                padding: 6px 12px;
                font-size: 11.5px;
                flex-shrink: 0;
            }
            .dasarian-nav-arrow {
                width: 34px;
                height: 34px;
            }
            .dasarian-nav-arrow svg {
                width: 18px;
                height: 18px;
            }
            .dasarian-arrow-prev { left: 8px; }
            .dasarian-arrow-next { right: 8px; }
            .dasarian-slide-footer {
                flex-direction: column;
                align-items: stretch;
                padding: 14px;
                gap: 12px;
            }
            .dasarian-slide-title {
                font-size: 14px;
            }
            .dasarian-slide-desc {
                font-size: 11.5px;
            }
            .dasarian-slide-actions {
                width: 100%;
                display: flex;
                gap: 8px;
            }
            .btn-dasarian-action {
                flex: 1;
                justify-content: center;
                padding: 8px;
                font-size: 11.5px;
            }

            /* Climate Bulletin on Mobile */
            .bulletin-hero-grid {
                grid-template-columns: 1fr;
                gap: 24px;
                padding: 24px 18px 20px;
            }
            .bulletin-3d-book {
                max-width: 200px;
            }
            .bulletin-headline {
                font-size: 20px;
            }
            .bulletin-archive-box {
                padding: 16px 18px;
            }
            .bulletin-archive-grid {
                grid-template-columns: 1fr;
            }

            /* Monitoring Section & Leaflet Map on Mobile */
            .monitor-section {
                margin: 24px 0 32px;
            }
            .monitor-tabs-nav {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .monitor-tabs-group {
                width: 100%;
                display: flex;
            }
            .monitor-tab-btn {
                flex: 1;
                justify-content: center;
                padding: 9px 10px;
                font-size: 11.5px;
                white-space: nowrap;
            }
            .monitor-auto-status {
                width: 100%;
                justify-content: center;
                font-size: 11px;
                padding: 5px 10px;
            }
            .monitor-leaflet-map {
                height: 320px;
            }
            .map-floating-subnav {
                top: 8px;
                left: 46px;
                padding: 3px;
                gap: 3px;
                max-width: calc(100% - 54px);
            }
            .subnav-btn {
                padding: 5px 8px;
                font-size: 10.5px;
                gap: 4px;
            }
            .subnav-dot {
                width: 6px;
                height: 6px;
            }
            .monitor-legend-box {
                top: auto;
                bottom: 8px;
                right: 8px;
                left: 8px;
                width: auto;
                min-width: 0;
                padding: 8px 10px;
                display: flex;
                flex-wrap: wrap;
                gap: 4px 10px;
                background: rgba(255, 255, 255, 0.95);
            }
            .monitor-legend-box h4 {
                width: 100%;
                margin: 0 0 3px;
                font-size: 10px;
            }
            .legend-item {
                font-size: 10.5px;
                margin-bottom: 0;
            }
            .table-card {
                padding: 16px 14px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table-card-head {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
            .monitor-table {
                min-width: 500px;
            }

            /* Contact Page on Mobile */
            .contact-grid-4 {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .contact-feature-card {
                padding: 16px;
            }
            .contact-form-row {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            .contact-box-panel {
                padding: 20px 16px;
            }
            .station-map-wrapper {
                min-height: 270px;
                height: 270px;
            }
            .station-map-overlay-card {
                position: relative;
                top: auto;
                left: auto;
                max-width: 100%;
                margin: 10px;
                padding: 10px 14px;
            }

            /* PTSP Services & Product Catalog on Mobile */
            .ptsp-grid, .ptsp-steps-grid, .product-catalog-grid, .product-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            .ptsp-card, .ptsp-step-item, .product-catalog-card, .product-card {
                padding: 16px;
            }
            .ptsp-free-card, .ptsp-maklumat-card {
                padding: 18px 16px;
            }
            .product-showcase-banner { flex-direction: column; align-items: flex-start; padding: 22px 18px; gap: 18px; }
            .btn-showcase { width: 100%; justify-content: center; }
            .tarif-table {
                min-width: 480px;
            }

            /* SILING Malaria & Stats on Mobile */
            .stats {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .stat {
                padding: 14px 16px;
            }
            .stat-value {
                font-size: 24px;
            }
            .rec-card {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .panel {
                padding: 16px 14px;
            }
            .panel-heading {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
            .map-shell {
                min-height: 280px;
            }
            .map-shell svg {
                height: 280px;
            }

            /* Footer on Mobile */
            .footer-inner {
                grid-template-columns: 1fr;
                padding: 28px 0 20px;
                gap: 22px;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 8px;
                text-align: center;
            }

            /* Lightbox Modal on Mobile */
            .dasarian-modal {
                padding: 10px;
            }
            .dasarian-modal-dialog {
                width: 100%;
                border-radius: var(--r-md);
            }
            .dasarian-modal-head {
                padding: 12px 14px;
            }
            .dasarian-modal-head h4 {
                font-size: 13px;
            }
        }

        /* 4. EXTRA SMALL PHONES (<= 380px) */
        @media (max-width: 380px) {
            .utility-inner {
                padding: 0 10px;
                font-size: 9px;
            }
            .topbar-inner {
                padding: 6px 10px 0;
            }
            .brandmark {
                width: 32px;
                height: 32px;
            }
            .brand h1 {
                font-size: 12.5px;
            }
            .brand-sub {
                display: none;
            }
            .hero-period {
                grid-template-columns: 1fr;
            }
            .dasarian-slide-actions {
                flex-direction: column;
            }
            .btn-dasarian-action {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="utility-bar">
    <div class="utility-inner">
        <div class="utility-left">
            <span id="papua-date">{{ strtoupper(\Carbon\Carbon::now('Asia/Jayapura')->locale('id')->isoFormat('dddd, D MMMM Y')) }}</span>
        </div>
        <div class="utility-right" title="Disinkronkan dengan Standar Waktu Nasional NTP BMKG (ntp.bmkg.go.id)">
            <span class="live-pulse" aria-hidden="true"></span>
            <span class="utility-label">STANDAR WAKTU INDONESIA (NTP BMKG)</span>
            <b id="papua-time">--:--:-- WIT</b>
        </div>
    </div>
</div>
<header class="topbar">
    <div class="topbar-inner">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img class="brandmark" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG">
            <div class="brand">
                <span class="brand-sub">BADAN METEOROLOGI, KLIMATOLOGI, DAN GEOFISIKA</span>
                <h1>STASIUN KLIMATOLOGI PAPUA SELATAN</h1>
            </div>
        </a>

        <!-- Tombol Ikon Menu Mobile (Sejajar dengan Brand Staklim Papua Selatan) -->
        <button type="button" class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Buka Menu Navigasi" aria-expanded="false" aria-controls="mainNavMenu">
            <span class="hamburger-bar bar-1"></span>
            <span class="hamburger-bar bar-2"></span>
            <span class="hamburger-bar bar-3"></span>
        </button>

        <nav class="main-nav" id="mainNavMenu" aria-label="Navigasi utama">
            <a href="{{ route('dashboard') }}" @class(['is-current' => $page === 'dashboard'])>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('profile') }}" @class(['is-current' => $page === 'profile'])>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                <span>Profil</span>
            </a>
            <a href="{{ route('services') }}" @class(['is-current' => $page === 'services'])>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <span>Layanan</span>
            </a>
            <div @class(['nav-item-dropdown', 'is-current' => $page === 'products'])>
                <a href="{{ route('products') }}" class="nav-link-dropdown-toggle @if($page === 'products') is-current @endif" aria-haspopup="true" aria-expanded="false">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                    <span>Produk</span>
                    <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </a>
                <div class="nav-dropdown-menu" role="menu" aria-label="Submenu Produk">
                    <a href="{{ route('products') }}" class="dropdown-menu-item @if($page === 'products' && ($subPage ?? 'katalog') === 'katalog') is-active @endif" role="menuitem">
                        <div class="dropdown-menu-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 2 7 12 12 22 7 12 2"/><polyline points="2 17 12 22 22 17"/><polyline points="2 12 12 17 22 12"/></svg>
                        </div>
                        <div class="dropdown-menu-text">
                            <span class="dropdown-menu-title">Katalog Produk Iklim</span>
                            <span class="dropdown-menu-desc">HTH, Prakiraan Hujan, Agroklimat &amp; Buletin</span>
                        </div>
                    </a>
                    <div class="dropdown-menu-divider"></div>
                    <a href="{{ route('products.malaria') }}" class="dropdown-menu-item @if($page === 'products' && ($subPage ?? 'katalog') === 'siling-malaria') is-active @endif" role="menuitem">
                        <div class="dropdown-menu-icon malaria-icon">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <div class="dropdown-menu-text">
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;flex-wrap:nowrap;width:100%;">
                                <span class="dropdown-menu-title">SILING Malaria</span>
                                <span class="dropdown-menu-badge">Peringatan Dini</span>
                            </div>
                            <span class="dropdown-menu-desc">Sistem Peringatan Dini Malaria Berbasis Iklim</span>
                        </div>
                    </a>
                </div>
            </div>
            <a href="{{ route('contact') }}" @class(['is-current' => $page === 'contact'])>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="nav-icon"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                <span>Kontak Kami</span>
            </a>
        </nav>
    </div>
</header>
<script>
(() => {
    let baseServerMs = {{ isset($initialNtpTime) ? (int) $initialNtpTime : 'Date.now()' }};
    let basePerf = performance.now();

    const getPapuaTime = () => {
        const elapsed = performance.now() - basePerf;
        return new Date(baseServerMs + elapsed);
    };

    const updatePapuaClock = () => {
        const now = getPapuaTime();
        const date = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jayapura', weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' }).format(now);
        const time = new Intl.DateTimeFormat('id-ID', { timeZone: 'Asia/Jayapura', hour: '2-digit', minute: '2-digit', second: '2-digit', hourCycle: 'h23' }).format(now);
        const dateEl = document.getElementById('papua-date');
        const timeEl = document.getElementById('papua-time');
        if (dateEl) dateEl.textContent = date.toLocaleUpperCase('id-ID');
        if (timeEl) timeEl.textContent = `${time} WIT`;

        const badge = document.getElementById('operational-status-badge');
        const badgeText = document.getElementById('operational-status-text');
        if (badge && badgeText) {
            const witParts = new Intl.DateTimeFormat('en-US', {
                timeZone: 'Asia/Jayapura',
                weekday: 'short',
                hour: 'numeric',
                minute: 'numeric',
                hour12: false
            }).formatToParts(now);

            let weekday = '', hour = 0, minute = 0;
            for (const p of witParts) {
                if (p.type === 'weekday') weekday = p.value;
                if (p.type === 'hour') hour = parseInt(p.value, 10);
                if (p.type === 'minute') minute = parseInt(p.value, 10);
            }

            const isWorkday = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'].includes(weekday);
            const timeVal = hour * 60 + minute;
            const isOpen = isWorkday && (timeVal >= 480 && timeVal < 960);

            if (isOpen) {
                badge.className = 'pill-status-open';
                badgeText.textContent = 'BUKA SEKARANG (08:00 - 16:00 WIT)';
            } else {
                badge.className = 'pill-status-closed';
                if (!isWorkday) {
                    badgeText.textContent = 'TUTUP (Buka Kembali Senin 08:00 WIT)';
                } else if (timeVal < 480) {
                    badgeText.textContent = 'TUTUP (Buka Pukul 08:00 WIT)';
                } else if (weekday === 'Fri') {
                    badgeText.textContent = 'TUTUP (Buka Kembali Senin 08:00 WIT)';
                } else {
                    badgeText.textContent = 'TUTUP (Buka Esok Hari 08:00 WIT)';
                }
            }
        }
    };

    const syncNtp = async () => {
        try {
            const t0 = performance.now();
            const res = await fetch('{{ route('ntp.time') }}', { cache: 'no-store' });
            if (!res.ok) return;
            const data = await res.json();
            const t1 = performance.now();
            const rtt = t1 - t0;
            baseServerMs = data.timestamp + (rtt / 2);
            basePerf = t1;
            updatePapuaClock();
        } catch (e) {
            // graceful fallback to existing clock
        }
    };

    updatePapuaClock();
    window.setInterval(updatePapuaClock, 1000);
    window.setInterval(syncNtp, 5 * 60 * 1000);

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') {
            syncNtp();
        }
    });

    // Mobile Navigation Drawer Toggle (Sejajar dengan Brand Staklim Papua Selatan)
    const mobileToggle = document.getElementById('mobileMenuToggle');
    const mobileNav = document.getElementById('mainNavMenu');
    if (mobileToggle && mobileNav) {
        mobileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = mobileToggle.classList.toggle('is-open');
            mobileNav.classList.toggle('is-open', isOpen);
            mobileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        document.addEventListener('click', (e) => {
            if (!mobileNav.contains(e.target) && !mobileToggle.contains(e.target)) {
                mobileToggle.classList.remove('is-open');
                mobileNav.classList.remove('is-open');
                mobileToggle.setAttribute('aria-expanded', 'false');
            }
        });

        mobileNav.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                mobileToggle.classList.remove('is-open');
                mobileNav.classList.remove('is-open');
                mobileToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }
})();
</script>
<main class="wrap">
    @if($page === 'dashboard')
<section class="climate-monitor-section" id="monitoring-iklim">
        <div class="monitor-container">
            <!-- Top Header Bar with Tabs and Live Indicator -->
            <div class="monitor-header-bar">
                <div class="monitor-top-tabs">
                    <button type="button" class="monitor-top-tab-btn is-active" data-tab="peringatan-dini">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <span>Peringatan Dini</span>
                    </button>
                    <button type="button" class="monitor-top-tab-btn" data-tab="distribusi-hth">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/></svg>
                        <span>Distribusi HTH</span>
                    </button>
                </div>
                <div class="monitor-auto-status" title="Peta bergeser otomatis antara Peringatan Dini & Distribusi HTH. Arahkan kursor untuk menjeda.">
                    <span class="pulse-dot"></span>
                    <span>Auto-slide aktif: <strong id="monitorAutoStatusText" style="color:var(--bmkg-navy);">Peringatan Dini</strong></span>
                </div>
            </div>

            <!-- Content Area (Full Width) -->
            <div class="monitor-content">
                <!-- Tab 1: Peringatan Dini -->
                <div class="monitor-pane is-active" id="pane-peringatan-dini">
                    <div class="map-card-wrapper">
                        <div id="leaflet-peringatan-map" class="monitor-leaflet-map"></div>

                        <!-- Floating Subnav: Kekeringan vs Hujan Lebat (Di Dalam Peta) -->
                        <div class="map-floating-subnav">
                            <button type="button" class="subnav-btn is-active" data-sub="kekeringan">
                                <span class="subnav-dot" style="background:#eab308"></span>
                                <span>Kekeringan</span>
                            </button>
                            <button type="button" class="subnav-btn" data-sub="hujan_lebat">
                                <span class="subnav-dot" style="background:#0284c7"></span>
                                <span>Hujan Lebat</span>
                            </button>
                        </div>

                        <!-- Legend Box -->
                        <div class="monitor-legend-box">
                            <h4>Status Peringatan</h4>
                            <div class="legend-item"><span class="legend-dot" style="background:#dc2626"></span> Awas</div>
                            <div class="legend-item"><span class="legend-dot" style="background:#f97316"></span> Siaga</div>
                            <div class="legend-item"><span class="legend-dot" style="background:#eab308"></span> Waspada</div>
                            <div class="legend-item"><span class="legend-dot" style="background:#16a34a"></span> Tidak Ada Peringatan</div>
                        </div>
                    </div>

                    <div class="table-card">
                        <h4 id="early-warning-table-title">Tabel Peringatan Dini (Kekeringan)</h4>
                        <div class="table-scroll">
                            <table class="monitor-table" id="early-warning-table">
                                <thead>
                                    <tr>
                                        <th style="width:45px">#</th>
                                        <th>KABUPATEN / KOTA</th>
                                        <th>WASPADA</th>
                                        <th>SIAGA</th>
                                        <th>AWAS</th>
                                    </tr>
                                </thead>
                                <tbody id="early-warning-table-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Distribusi HTH -->
                <div class="monitor-pane" id="pane-distribusi-hth">
                    <div class="map-card-wrapper">
                        <div id="leaflet-hth-map" class="monitor-leaflet-map"></div>
                        <div class="monitor-legend-box">
                            <h4>Klasifikasi HTH</h4>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#0e4429"></span> Hujan / 0 hari</div>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#22c55e"></span> 1–5 hari</div>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#facc15"></span> 6–10 hari</div>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#f97316"></span> 11–20 hari</div>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#b45309"></span> 21–30 hari</div>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#df65b0"></span> 31–60 hari</div>
                            <div class="legend-item"><span class="legend-box-sq" style="background:#991b1b"></span> &gt;60 hari</div>
                        </div>
                    </div>

                    <div class="table-card">
                        <div class="table-card-head" style="margin-bottom:14px;">
                            <h4 style="margin:0;">Daftar Pos Pengamatan Hari Tanpa Hujan (HTH) Papua Selatan</h4>
                        </div>
                        <div class="table-scroll">
                            <table class="monitor-table">
                                <thead>
                                    <tr>
                                        <th style="width:45px">#</th>
                                        <th>NAMA POS / STASIUN</th>
                                        <th>KABUPATEN / DISTRIK</th>
                                        <th>JUMLAH HTH</th>
                                        <th>KLASIFIKASI</th>
                                        <th>TANGGAL UPDATE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($hthObservations ?? [] as $idx => $st)
                                    <tr class="hth-row {{ $idx >= 5 ? 'hth-row-hidden' : '' }}" style="{{ $idx >= 5 ? 'display:none;' : '' }}">
                                        <td>{{ $idx + 1 }}</td>
                                        <td><strong>{{ $st->station_name }}</strong></td>
                                        <td>Kab. {{ $st->district }}{{ $st->subdistrict ? ' · Distrik '.$st->subdistrict : '' }}</td>
                                        <td><span class="hth-days-badge" style="background:{{ $st->color }}1f; color:{{ $st->color }}; font-weight:800; border:1px solid {{ $st->color }}40; padding:3px 9px; border-radius:12px; font-size:11px;">{{ $st->days }} Hari</span></td>
                                        <td><span style="display:inline-flex; align-items:center; gap:6px; font-weight:700; font-size:11px;"><i style="display:inline-block; width:10px; height:10px; border-radius:2px; background:{{ $st->color }};"></i> {{ $st->classification }}</span></td>
                                        <td>{{ $st->updated_date ? \Carbon\Carbon::parse($st->updated_date)->locale('id')->isoFormat('D MMMM Y') : '—' }}</td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="6" style="text-align:center; padding:18px; color:var(--muted);">Belum ada data pos pengamatan HTH.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(count($hthObservations ?? []) > 5)
                        <div style="margin-top:14px; padding-top:14px; border-top:1px solid #f1f5f9; display:flex; justify-content:center;">
                            <button type="button" id="btn-toggle-hth" onclick="toggleHthTable()" class="btn-expand-hth">
                                <span id="toggle-hth-text" data-expanded="false">Lihat Seluruh Pos Pengamatan</span>
                                <svg id="toggle-hth-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="transition:transform .25s ease;"><path d="m6 9 6 6 6-6"/></svg>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Peta & Informasi Iklim Dasarian (Auto Slider Carousel) -->
    <section class="dasarian-slider-section" id="dasarian-iklim">
        <div class="section-intro" style="margin-bottom: 18px;">
            <div class="eyebrow">Publikasi Iklim Dasarian (10 Harian)</div>
            <h2>Peta Analisis &amp; Prakiraan Curah Hujan Dasarian</h2>
            <p>Peta sebaran analisis curah hujan terkini, prakiraan deterministik, dan peluang curah hujan dasarian untuk wilayah Provinsi Papua Selatan.</p>
        </div>

        <div class="dasarian-carousel-container" id="dasarianCarousel">
            <!-- Category Quick-Pills Filter -->
            <div class="dasarian-pills">
                @foreach($dasarianImages ?? [] as $idx => $img)
                <button type="button" class="dasarian-pill-btn {{ $idx === 0 ? 'is-active' : '' }}" data-slide-target="{{ $idx }}">
                    <span class="pill-dot" style="background: {{ $img->category_color }}"></span>
                    <span>{{ $img->category_label }}</span>
                </button>
                @endforeach
            </div>

            <!-- Carousel Viewport & Slider Track -->
            <div class="dasarian-slider-viewport">
                <div class="dasarian-slider-track" id="dasarianTrack">
                                        @forelse($dasarianImages ?? [] as $idx => $img)
                    <div class="dasarian-slide" data-index="{{ $idx }}" data-category="{{ $img->category }}">
                        <div class="dasarian-slide-card">
                            <!-- Main Map Image (1024x724 - Zero Empty Space) -->
                            <div class="dasarian-img-wrapper" onclick="openDasarianLightbox('{{ asset($img->image_path) }}', '{{ addslashes($img->title) }}', '{{ addslashes($img->period_label ?: '') }}')">
                                <img src="{{ asset($img->image_path) }}" alt="{{ $img->title }}" class="dasarian-slide-img" loading="lazy">
                                <div class="dasarian-hover-hint">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                                    <span>Klik untuk memperbesar peta resolusi tinggi</span>
                                </div>
                            </div>

                            <!-- Info Footer Bar -->
                            <div class="dasarian-slide-footer">
                                <div>
                                    <div class="dasarian-slide-meta">
                                        <span class="dasarian-badge-cat" style="background: {{ $img->category_color }};">
                                            {{ $img->category_label }}
                                        </span>
                                        @if($img->period_label)
                                        <span class="dasarian-badge-period">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                            {{ $img->period_label }}
                                        </span>
                                        @endif
                                    </div>
                                    <h4 class="dasarian-slide-title">{{ $img->title }}</h4>
                                    @if($img->description)
                                    <p class="dasarian-slide-desc">{{ $img->description }}</p>
                                    @endif
                                </div>
                                <div class="dasarian-slide-actions">
                                    <button type="button" class="btn-dasarian-action" onclick="openDasarianLightbox('{{ asset($img->image_path) }}', '{{ addslashes($img->title) }}', '{{ addslashes($img->period_label ?: '') }}')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 3 21 3 21 9"/><polyline points="9 21 3 21 3 15"/><line x1="21" y1="3" x2="14" y2="10"/><line x1="3" y1="21" x2="10" y2="14"/></svg>
                                        <span>Perbesar</span>
                                    </button>
                                    <a href="{{ asset($img->image_path) }}" download="{{ Str::slug($img->title) }}" class="btn-dasarian-action btn-dasarian-download" target="_blank">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                        <span>Unduh HD</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="dasarian-slide is-active">
                        <div class="dasarian-slide-card" style="padding: 40px; text-align: center; color: var(--muted);">
                            <p>Belum ada gambar peta dasarian yang diunggah oleh operator.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Navigation Arrows -->
                <button type="button" class="dasarian-nav-arrow dasarian-arrow-prev" id="dasarianPrevBtn" aria-label="Gambar Sebelumnya">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <button type="button" class="dasarian-nav-arrow dasarian-arrow-next" id="dasarianNextBtn" aria-label="Gambar Berikutnya">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>

            <!-- Dots Indicators & Progress Bar -->
            <div class="dasarian-controls-bottom">
                <div class="dasarian-dots" id="dasarianDots">
                    @foreach($dasarianImages ?? [] as $idx => $img)
                    <button type="button" class="dasarian-dot {{ $idx === 0 ? 'is-active' : '' }}" data-slide="{{ $idx }}" aria-label="Slide {{ $idx + 1 }}"></button>
                    @endforeach
                </div>
                <div class="dasarian-progress-wrapper">
                    <div class="dasarian-progress-bar" id="dasarianProgressBar"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Lightbox Modal Fullscreen -->
    <div id="dasarianLightboxModal" class="dasarian-modal" style="display:none;" onclick="closeDasarianLightbox(event)">
        <div class="dasarian-modal-dialog" onclick="event.stopPropagation()">
            <div class="dasarian-modal-header">
                <div>
                    <h4 id="dasarianModalTitle" style="margin:0; font-size:16px; font-weight:800; color:#ffffff;">Peta Dasarian</h4>
                    <span id="dasarianModalPeriod" style="font-size:12px; color:#38bdf8; font-weight:600;"></span>
                </div>
                <div style="display:flex; gap:10px; align-items:center;">
                    <a id="dasarianModalDownload" href="#" download class="dasarian-modal-btn">Unduh Peta HD</a>
                    <button type="button" class="dasarian-modal-close" onclick="closeDasarianLightbox()">&times;</button>
                </div>
            </div>
            <div class="dasarian-modal-body">
                <img id="dasarianModalImg" src="" alt="Peta Dasarian Resolusi Tinggi" class="dasarian-modal-img">
            </div>
        </div>
    </div>

    <!-- Display Publikasi Buletin Iklim Papua Selatan -->
    <section class="bulletin-section" id="buletin-iklim">
        <div class="section-intro" style="margin-bottom: 20px;">
            <div class="eyebrow">Publikasi Resmi Iklim</div>
            <h2>Buletin Informasi Iklim Papua Selatan</h2>
            <p>Akses berkala dokumen analisis dinamika atmosfer, evaluasi curah hujan, prospek iklim, serta potensi cuaca ekstrem di wilayah Provinsi Papua Selatan.</p>
        </div>

        @if(!empty($latestBulletin))
        <div class="bulletin-card-main">
            <div class="bulletin-hero-grid">
                <!-- Cover Column with 3D Effect -->
                <div class="bulletin-cover-col">
                    <a href="{{ $latestBulletin->download_url ?: '#' }}" target="_blank" rel="noopener" class="bulletin-3d-book" title="Buka Dokumen Buletin (PDF)">
                        <img src="{{ $latestBulletin->cover_url }}" alt="Sampul {{ $latestBulletin->title }}" loading="lazy">
                        <div class="bulletin-book-spine"></div>
                        <span class="bulletin-badge-floating">Edisi Baru</span>
                    </a>
                </div>

                <!-- Info and Highlights Column -->
                <div class="bulletin-info-col">
                    <div class="bulletin-tags-row">
                        <span class="bulletin-tag-edition">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            {{ $latestBulletin->edition }}
                        </span>
                        @if($latestBulletin->release_date)
                        <span class="bulletin-tag-meta">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $latestBulletin->formatted_date }}
                        </span>
                        @endif
                        <span class="bulletin-tag-meta">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            {{ $latestBulletin->page_count ?? 24 }} Halaman
                        </span>
                        @if($latestBulletin->file_size)
                        <span class="bulletin-tag-meta">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            {{ $latestBulletin->file_size }}
                        </span>
                        @endif
                    </div>

                    <h3 class="bulletin-headline">{{ $latestBulletin->title }}</h3>

                    <p class="bulletin-summary">
                        {{ $latestBulletin->description ?: 'Buletin informasi iklim resmi menyajikan telaah dinamika atmosfer skala global dan regional, anomali suhu permukaan laut (SST), analisis curah hujan dan hari tanpa hujan (HTH), serta prospek iklim bulanan hingga dasarian untuk seluruh kabupaten di Papua Selatan.' }}
                    </p>

                    <div class="bulletin-highlights-grid">
                        <div class="bulletin-highlight-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Dinamika Atmosfer, ENSO &amp; IOD</span>
                        </div>
                        <div class="bulletin-highlight-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Evaluasi Curah Hujan &amp; HTH</span>
                        </div>
                        <div class="bulletin-highlight-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Prakiraan Curah Hujan &amp; Sifat Hujan</span>
                        </div>
                        <div class="bulletin-highlight-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            <span>Rekomendasi Kebijakan &amp; Sektor Tani</span>
                        </div>
                    </div>

                    <div class="bulletin-actions-row">
                        @if($latestBulletin->download_url)
                        <a href="{{ $latestBulletin->download_url }}" target="_blank" rel="noopener" class="btn-bulletin-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            <span>Unduh E-Book Buletin (PDF)</span>
                        </a>
                        <a href="{{ $latestBulletin->download_url }}" target="_blank" rel="noopener" class="btn-bulletin-secondary">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <span>Baca Buletin Online</span>
                        </a>
                        @else
                        <a href="{{ route('contact') }}" class="btn-bulletin-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            <span>Permohonan Dokumen Buletin</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Arsip Buletin Edisi Sebelumnya -->
            @if(isset($climateBulletins) && $climateBulletins->count() > 1)
            <div class="bulletin-archive-box">
                <div class="bulletin-archive-header">
                    <span class="bulletin-archive-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                        Arsip Buletin Edisi Sebelumnya
                    </span>
                    <span style="font-size:12px; color:var(--muted); font-weight:600;">Total {{ $climateBulletins->count() }} Edisi Tersedia</span>
                </div>
                <div class="bulletin-archive-grid">
                    @foreach($climateBulletins->slice(1) as $archived)
                    <a href="{{ $archived->download_url ?: '#' }}" target="_blank" rel="noopener" class="bulletin-archive-card" title="Buka {{ $archived->title }} - {{ $archived->edition }}">
                        <img src="{{ $archived->cover_url }}" alt="Cover {{ $archived->edition }}" class="bulletin-archive-thumb" loading="lazy">
                        <div class="bulletin-archive-info">
                            <span class="bulletin-archive-badge">{{ $archived->edition }}</span>
                            <span class="bulletin-archive-name">{{ $archived->title }}</span>
                            <span class="bulletin-archive-date">{{ $archived->formatted_date }} &bull; {{ $archived->page_count ?? 24 }} Hlm</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @else
        <div style="background:#ffffff; border:1px solid var(--line); border-radius:var(--r-xl); padding:40px; text-align:center;">
            <p style="color:var(--muted); font-size:14px; margin:0;">Belum ada buletin iklim yang dipublikasikan. Hubungi pengelola stasiun untuk edisi buletin cetak/digital.</p>
        </div>
        @endif
    </section>
@elseif($page === 'profile')
<section class="page-section">
    <div class="section-intro">
        <div class="eyebrow">Profil Stasiun</div>
        <h2>Stasiun Klimatologi Papua Selatan</h2>
        <p>Mengenal tugas, layanan, dan dedikasi insan klimatologi yang melayani pengamatan dan penyediaan informasi iklim di Provinsi Papua Selatan.</p>
    </div>

    <!-- Foto Pegawai & Profil Banner Unggulan -->
    <div class="profile-team-card">
        <div class="profile-team-grid">
            <div class="profile-photo-container">
                <img src="{{ asset('images/foto-pegawai-staklim.jpg') }}" alt="Pegawai dan Staf Stasiun Klimatologi Papua Selatan" class="profile-photo-img" loading="lazy">
                <div class="profile-photo-tag">Stasiun Klimatologi Papua Selatan</div>
            </div>
            <div class="profile-team-content">
                <div class="profile-badge-pill">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Insan Klimatologi</span>
                </div>
                <h3>Keluarga Besar Stasiun Klimatologi Papua Selatan</h3>
                <p>Seluruh pegawai dan staf Stasiun Klimatologi Kelas II Papua Selatan berdedikasi tinggi dalam melaksanakan pengamatan atmosfer, pengelolaan data klimatologi, pemodelan iklim terapan, serta pelayanan informasi iklim yang cepat, tepat, dan akurat di seluruh wilayah Provinsi Papua Selatan.</p>
                <div class="profile-team-highlights">
                    <div class="team-highlight-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <div>
                            <strong>Pengamatan Berkala &amp; Kontinu</strong>
                            <span>Monitoring cuaca dan iklim di 4 kabupaten Papua Selatan</span>
                        </div>
                    </div>
                    <div class="team-highlight-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        <div>
                            <strong>Layanan Publik Terpadu (PTSP)</strong>
                            <span>Penyediaan data iklim, agroklimat, dan peringatan dini</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-grid">
        <article class="info-panel">
            <h3>Tentang Kami</h3>
            <p>Stasiun Klimatologi Kelas II Papua Selatan merupakan unit pelaksana teknis BMKG yang melaksanakan pengamatan, pengelolaan, analisis, dan pelayanan informasi klimatologi untuk wilayah Papua Selatan. Informasi iklim mendukung kebutuhan masyarakat dan berbagai sektor dalam memahami kondisi iklim serta mengantisipasi dampaknya.</p>
        </article>
        <article class="info-panel">
            <h3>Tugas dan Fungsi</h3>
            <ul>
                <li>Melaksanakan pengamatan unsur iklim dan cuaca khusus.</li>
                <li>Mengelola, memvalidasi, dan menganalisis data klimatologi.</li>
                <li>Menyediakan informasi, prakiraan, dan peringatan dini iklim.</li>
                <li>Memberikan layanan data dan konsultasi klimatologi publik serta sektoral.</li>
            </ul>
        </article>
        <article class="info-panel">
            <h3>Sumber Daya Manusia &amp; Organisasi</h3>
            <p>Didukung oleh fungsional pengamat meteorologi dan geofisika (PMG), teknisi, pranata komputer, serta staf tata usaha yang kompeten dan berintegritas dalam melayani Provinsi Papua Selatan.</p>
        </article>
        <article class="info-panel">
            <h3>Wilayah Layanan</h3>
            <p>Provinsi Papua Selatan, meliputi Kabupaten Merauke, Boven Digoel, Mappi, dan Asmat.</p>
        </article>
    </div>
</section>

@elseif($page === 'services')
<section class="page-section">
<div class="section-intro"><div class="eyebrow">Layanan &amp; Produk</div><h2>Informasi iklim sektoral dan layanan publik</h2><p>Produk iklim untuk mendukung pengambilan keputusan, serta layanan data dan konsultasi klimatologi.</p></div>
<div class="service-grid">
<article class="info-panel"><h3>Informasi Iklim Sektoral</h3><p>Informasi klimatologi yang mendukung kebutuhan sektor dan masyarakat, termasuk pemantauan risiko iklim.</p><ul><li>Peringatan Dini Malaria berbasis data iklim</li><li>Informasi iklim untuk sektor terkait</li></ul><a class="contact-link" href="{{ route('products.malaria') }}">Buka SILING Malaria &rarr;</a></article>
<article class="info-panel" id="layanan-pnbp"><h3>Layanan PNBP</h3><p>Jenis layanan ditata mengikuti katalog Staklim Maluku, dengan tarif dan prosedur yang ditetapkan berdasarkan ketentuan PNBP BMKG yang berlaku.</p><ul><li>Informasi iklim untuk agroindustri</li><li>Informasi perubahan iklim</li><li>Jasa konsultasi klimatologi</li></ul><p class="pending-note">Daftar produk, tarif Papua Selatan, dan tautan pemesanan akan dilengkapi setelah dikonfirmasi berdasarkan ketentuan resmi yang berlaku.</p></article>
</div>
<div class="service-callout"><span>Perlu data atau konsultasi iklim? Hubungi layanan Staklim Papua Selatan.</span><a href="{{ route('contact') }}">Informasi kontak →</a></div>
<div class="product-grid">
<article class="product-card" id="produk-peringatan"><span class="product-no">PRODUK IKLIM</span><h3>Peringatan Dini Iklim</h3><p>Informasi potensi curah hujan tinggi dan kekeringan meteorologis. Publikasi peta/buletin dapat ditautkan di sini.</p></article>
<article class="product-card" id="produk-prediksi"><span class="product-no">PRODUK IKLIM</span><h3>Prediksi Curah Hujan</h3><p>Publikasi prakiraan curah hujan Papua Selatan. Tautan produk resmi dapat ditambahkan saat tersedia.</p></article>
<article class="product-card" id="produk-hth"><span class="product-no">PRODUK IKLIM</span><h3>Monitoring Hari Tanpa Hujan</h3><p>Pemantauan hari tanpa hujan. Tautan laporan/peta monitoring dapat ditambahkan di sini.</p></article>
</div>
</section>

    @elseif($page === 'contact')
    <section class="page-section">
        <div class="section-intro">
            <div class="eyebrow">Kontak &amp; Layanan Informasi</div>
            <h2>Hubungi Stasiun Klimatologi Papua Selatan</h2>
            <p>Sampaikan pertanyaan, masukan, konsultasi iklim dan SILING Malaria, atau permohonan data Anda langsung kepada tim kami.</p>
        </div>

        <!-- 1. Top 4 Contact Feature Cards -->
        <div class="contact-grid-4">
            <!-- Card 1: Alamat -->
            <div class="contact-feature-card">
                <div>
                    <div class="contact-icon-box contact-icon-blue">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <h3>Alamat Kantor</h3>
                    <p>Jl. Poros Semangga–Tanah Miring, SP 2, Distrik Tanah Miring, Kabupaten Merauke, Provinsi Papua Selatan 99651</p>
                </div>
                <div class="contact-card-actions">
                    <a href="https://maps.google.com/?q=Stasiun+Klimatologi+Papua+Selatan+Tanah+Miring+Merauke" target="_blank" rel="noopener" class="pill-action-btn btn-direct">
                        Petunjuk Arah &rarr;
                    </a>
                </div>
            </div>

            <!-- Card 2: Telepon & Kontak -->
            <div class="contact-feature-card">
                <div>
                    <div class="contact-icon-box contact-icon-green">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <h3>Telepon &amp; Kontak</h3>
                    <p>0811-4908-182<br><small style="color:var(--muted); font-size:11px;">(0971) 321855</small></p>
                </div>
                <div class="contact-card-actions">
                    <a href="tel:+628114908182" class="pill-action-btn btn-call">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Hubungi
                    </a>
                    <a href="https://wa.me/628114908182?text=Halo%20BMKG%20Stasiun%20Klimatologi%20Papua%20Selatan%2C%20saya%20ingin%20berkonsultasi" target="_blank" rel="noopener" class="pill-action-btn btn-wa">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                        WhatsApp
                    </a>
                </div>
            </div>

            <!-- Card 3: Email Resmi -->
            <div class="contact-feature-card">
                <div>
                    <div class="contact-icon-box contact-icon-indigo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <h3>Email Resmi</h3>
                    <p>staklim.merauke@bmkg.go.id</p>
                </div>
                <div class="contact-card-actions">
                    <a href="mailto:staklim.merauke@bmkg.go.id?subject=Permohonan%20Informasi%20BMKG%20Papua%20Selatan" class="pill-action-btn btn-email">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        Kirim Email
                    </a>
                </div>
            </div>

            <!-- Card 4: Jam Operasional -->
            @php
                $nowWit = \Carbon\Carbon::now('Asia/Jayapura');
                $dayOfWeek = $nowWit->dayOfWeek; // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
                $timeVal = (int) $nowWit->format('H') * 60 + (int) $nowWit->format('i');
                $isWorkday = ($dayOfWeek >= 1 && $dayOfWeek <= 5);
                $isOpen = ($isWorkday && $timeVal >= 480 && $timeVal < 960);
            @endphp
            <div class="contact-feature-card">
                <div>
                    <div class="contact-icon-box contact-icon-amber">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h3>Jam Operasional</h3>
                    <p>08.00 &ndash; 16.00 WIT<br><small style="color:var(--muted); font-size:11px;">Senin s/d Jumat (Hari Kerja)</small></p>
                </div>
                <div class="contact-card-actions">
                    <span class="{{ $isOpen ? 'pill-status-open' : 'pill-status-closed' }}" id="operational-status-badge">
                        <span class="pill-status-dot"></span>
                        <span id="operational-status-text">
                            @if($isOpen)
                                BUKA SEKARANG (08:00 - 16:00 WIT)
                            @elseif(!$isWorkday)
                                TUTUP (Buka Kembali Senin 08:00 WIT)
                            @elseif($timeVal < 480)
                                TUTUP (Buka Pukul 08:00 WIT)
                            @elseif($dayOfWeek === 5)
                                TUTUP (Buka Kembali Senin 08:00 WIT)
                            @else
                                TUTUP (Buka Esok Hari 08:00 WIT)
                            @endif
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Two-Column Layout: Form Message & Interactive Map -->
        <div class="contact-twocol-grid">
            <!-- Left: Message Form -->
            <div class="contact-box-panel">
                <h3>Kirimi Kami Pesan</h3>
                <p class="panel-sub">Sampaikan pertanyaan, masukan, atau permohonan data Anda langsung kepada tim kami.</p>

                <form id="contact-message-form" class="contact-form-grid" onsubmit="event.preventDefault(); handleContactSubmit();">
                    <div class="form-group">
                        <label for="contact_name">Nama Lengkap *</label>
                        <input id="contact_name" type="text" placeholder="Masukkan nama lengkap Anda" required>
                    </div>

                    <div class="contact-form-row">
                        <div class="form-group">
                            <label for="contact_info">Email / WhatsApp *</label>
                            <input id="contact_info" type="text" placeholder="Email atau nomor WhatsApp" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_category">Kategori Layanan *</label>
                            <select id="contact_category" required>
                                <option value="">Pilih Kategori...</option>
                                <option value="Permohonan Data Iklim & Cuaca">Permohonan Data Iklim &amp; Cuaca</option>
                                <option value="Konsultasi SILING Malaria">Konsultasi SILING Malaria</option>
                                <option value="Prakiraan & Analisis Iklim">Prakiraan &amp; Analisis Iklim</option>
                                <option value="Kunjungan & Edukasi Stasiun">Kunjungan &amp; Edukasi Stasiun</option>
                                <option value="Pengaduan & Saran">Pengaduan &amp; Saran</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contact_body">Pesan / Detail Pertanyaan *</label>
                        <textarea id="contact_body" rows="4" placeholder="Tuliskan pesan atau detail data yang Anda butuhkan..." required></textarea>
                    </div>

                    <div id="contact-feedback" style="display:none; padding:10px 14px; border-radius:var(--r-md); font-size:12px; font-weight:700;"></div>

                    <button type="submit" class="btn-submit-message">
                        Kirim Pesan &rarr;
                    </button>
                </form>
            </div>

            <!-- Right: Interactive Station Map -->
            <div class="contact-box-panel">
                <h3>Lokasi Stasiun</h3>
                <p class="panel-sub">Kunjungi kantor Stasiun Klimatologi Papua Selatan di Tanah Miring, Merauke.</p>

                <div class="station-map-wrapper">
                    <div id="contact-station-map" class="station-map-canvas"></div>
                    <div class="station-map-overlay-card">
                        <h5>BMKG Stasiun Klimatologi Papua Selatan</h5>
                        <p>Jl. Poros Semangga–Tanah Miring, Merauke</p>
                        <div class="station-map-rating">
                            <span>4.9</span> &starf;&starf;&starf;&starf;&starf; <span style="color:#64748b; font-weight:600;">(PTSP BMKG)</span>
                        </div>
                        <a href="https://maps.google.com/?q=Stasiun+Klimatologi+Papua+Selatan+Tanah+Miring+Merauke" target="_blank" rel="noopener" class="station-map-btn">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Open in Maps
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Pertanyaan Sering Diajukan (FAQ) -->
        <div class="faq-section">
            <h3 class="faq-title">Pertanyaan Sering Diajukan (FAQ)</h3>
            <div class="faq-accordion-list">
                <div class="faq-card is-open">
                    <button type="button" class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana cara mendapatkan Data Iklim resmi untuk keperluan penelitian / instansi?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Permohonan data iklim resmi dapat diajukan secara langsung di kantor Pelayanan Terpadu Satu Pintu (PTSP) Staklim Papua Selatan atau secara online melalui portal resmi <strong>dataonline.bmkg.go.id</strong>. Untuk mahasiswa atau penelitian akademis, tarif nol rupiah (gratis) berlaku dengan melampirkan surat pengantar resmi dari universitas dan proposal penelitian.
                    </div>
                </div>

                <div class="faq-card">
                    <button type="button" class="faq-question" onclick="toggleFaq(this)">
                        <span>Apakah informasi pemantauan cuaca dan sistem SILING Malaria ini gratis diakses publik?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Ya, seluruh informasi pemantauan iklim, peta peringatan dini kekeringan/hujan lebat, dan peta kesesuaian iklim malaria di portal ini disediakan secara terbuka dan gratis sebagai bentuk keterbukaan informasi publik BMKG untuk mendukung ketahanan kesehatan di wilayah Papua Selatan.
                    </div>
                </div>

                <div class="faq-card">
                    <button type="button" class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana mekanisme peringatan dini malaria diteruskan ke dinas dan tenaga kesehatan?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Data observasi iklim dipadukan dengan angka insiden kasus malaria setiap bulan. Jika suatu wilayah berada pada status Waspada atau Awas, sistem notifikasi terpadu BMKG secara otomatis meneruskan pesan peringatan dini beserta rekomendasi mitigasi langsung ke WhatsApp tenaga kesehatan dan dinas terkait.
                    </div>
                </div>

                <div class="faq-card">
                    <button type="button" class="faq-question" onclick="toggleFaq(this)">
                        <span>Bagaimana prosedur mengajukan kunjungan edukasi sekolah atau kampus ke Stasiun Klimatologi?</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        Sekolah atau instansi dapat mengirimkan surat permohonan kunjungan resmi yang dialamatkan kepada Kepala Stasiun Klimatologi Papua Selatan via email resmi (<strong>staklim.merauke@bmkg.go.id</strong>) minimal 7 hari kerja sebelum tanggal kunjungan yang dikehendaki.
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

@if($page === 'services')
<section class="page-section" id="layanan-ptsp">
    <div class="section-intro">
        <div class="eyebrow">Pelayanan Terpadu Satu Pintu (PTSP) BMKG</div>
        <h2>Standar Layanan Publik &amp; Jasa Klimatologi</h2>
        <p>Stasiun Klimatologi Papua Selatan menyediakan layanan data dan jasa informasi iklim resmi sesuai standar operasional BMKG untuk mendukung masyarakat, perencana pembangunan daerah, akademisi, dan riset ilmiah.</p>
    </div>

    <!-- 4 Layanan Utama PTSP BMKG -->
    <div class="ptsp-grid">
        <div class="ptsp-card">
            <div>
                <div class="ptsp-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"/><path d="M12 12v9"/><path d="m8 17 4 4 4-4"/></svg>
                </div>
                <h4>Layanan Data Iklim Resmi (Data Online)</h4>
                <p>Penyediaan data historis unsur cuaca dan iklim (curah hujan, suhu udara, kelembapan, radiasi matahari, dan angin) harian maupun bulanan dari seluruh pos hujan dan stasiun di Papua Selatan.</p>
            </div>
            <a href="https://dataonline.bmkg.go.id" target="_blank" rel="noopener" class="ptsp-action-btn">
                <span>Akses Data Online</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </a>
        </div>

        <div class="ptsp-card">
            <div>
                <div class="ptsp-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                </div>
                <h4>Layanan Rekomendasi &amp; Konsultasi Iklim</h4>
                <p>Kajian teknis iklim untuk dokumen AMDAL, perencanaan tata ruang wilayah (RTRW), kelayakan iklim pertanian/perkebunan, dan analisis kerentanan perubahan iklim di Papua Selatan.</p>
            </div>
            <a href="{{ route('contact') }}" class="ptsp-action-btn">
                <span>Konsultasi Teknis</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="ptsp-card">
            <div>
                <div class="ptsp-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                </div>
                <h4>Layanan Kalibrasi &amp; Tera Alat Cuaca</h4>
                <p>Uji kalibrasi sensor meteorologi dan penakar hujan (AWS, ARG, AWS Pertanian, Hellmann, OBS) untuk menjamin validitas dan akurasi standar WMO bagi instansi mitra dan swasta.</p>
            </div>
            <a href="{{ route('contact') }}" class="ptsp-action-btn">
                <span>Uji Kalibrasi</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>

        <div class="ptsp-card">
            <div>
                <div class="ptsp-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h4>Edukasi, SLI &amp; Kunjungan Taman Alat</h4>
                <p>Sekolah Lapang Iklim (SLI) untuk petani, studi tiru, bimbingan magang riset (PKL), dan kunjungan edukasi siswa sekolah/mahasiswa ke Taman Alat Staklim Merauke.</p>
            </div>
            <a href="{{ route('contact') }}" class="ptsp-action-btn">
                <span>Ajukan Kunjungan</span>
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    <!-- Alur Pelayanan PTSP BMKG -->
    <div class="ptsp-steps-panel">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
            <div>
                <h3 style="margin:0 0 4px; font-size:17px; font-weight:800; color:var(--bmkg-navy);">Alur &amp; Prosedur Permohonan Layanan</h3>
                <p style="margin:0; font-size:12.5px; color:var(--muted);">Proses permohonan data dan jasa klimatologi sesuai SOP Pelayanan Terpadu BMKG.</p>
            </div>
            <a href="https://ptsp.bmkg.go.id" target="_blank" rel="noopener" class="ptsp-action-btn" style="background:#ffffff; border-color:var(--line);">
                <span>Portal PTSP Pusat &rarr;</span>
            </a>
        </div>

        <div class="ptsp-steps-grid">
            <div class="ptsp-step-item">
                <span class="ptsp-step-num">1</span>
                <h5>Pengajuan Permohonan</h5>
                <p>Pemohon mendaftar di loket PTSP kantor atau secara daring melalui portal PTSP/Data Online dengan mengisi formulir dan melampirkan identitas resmi.</p>
            </div>
            <div class="ptsp-step-item">
                <span class="ptsp-step-num">2</span>
                <h5>Verifikasi &amp; Telaah Teknis</h5>
                <p>Petugas PTSP dan fungsional PMG memeriksa ketersediaan data unsur iklim, kelengkapan berkas, dan peruntukan permohonan.</p>
            </div>
            <div class="ptsp-step-item">
                <span class="ptsp-step-num">3</span>
                <h5>Billing / Penetapan Tarif Rp 0</h5>
                <p>Penerbitan kode billing PNBP Simponi Kemenkeu untuk permohonan komersial, atau Surat Keterangan Tarif Rp 0 untuk keperluan penelitian mahasiswa.</p>
            </div>
            <div class="ptsp-step-item">
                <span class="ptsp-step-num">4</span>
                <h5>Penerbitan &amp; Penyerahan Data</h5>
                <p>Data resmi ber-QR Code legalitas BMKG diserahkan kepada pemohon dalam bentuk salinan digital atau cetak resmi.</p>
            </div>
        </div>
    </div>

    <!-- Maklumat & Tarif Nol Rupiah -->
    <div class="ptsp-callout-grid">
        <div class="ptsp-free-card">
            <span class="badge-free">TARIF KHUSUS RP 0,- (GRATIS)</span>
            <h4>Dukungan Penuh Riset &amp; Pendidikan Mahasiswa</h4>
            <p>Sesuai Peraturan Pemerintah RI No. 47 Tahun 2018 tentang Jenis dan Tarif atas Jenis PNBP yang Berlaku pada BMKG, layanan data iklim dikenakan tarif <strong>Rp 0,00 (Nol Rupiah / Gratis)</strong> untuk kegiatan penelitian tugas akhir/skripsi/tesis/disertasi mahasiswa dan pelajar.</p>
            <div style="background:rgba(255,255,255,0.1); border-radius:var(--r-md); padding:12px 14px; font-size:11.5px; line-height:1.6; margin-bottom:14px;">
                <strong>Persyaratan Tarif Nol Rupiah:</strong>
                <ul style="margin:4px 0 0; padding-left:18px;">
                    <li>Surat pengantar resmi bertandatangan Dekan / Ketua Program Studi.</li>
                    <li>Fotokopi Kartu Tanda Mahasiswa (KTM) yang masih aktif.</li>
                    <li>Ringkasan proposal penelitian yang memuat parameter data dan periode yang dibutuhkan.</li>
                </ul>
            </div>
            <a href="https://dataonline.bmkg.go.id" target="_blank" rel="noopener" style="display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:800; color:#002b49; background:#ffffff; padding:7px 14px; border-radius:var(--r-sm); text-decoration:none;">
                <span>Daftar Akun Mahasiswa di Data Online &rarr;</span>
            </a>
        </div>

        <div class="ptsp-maklumat-card">
            <div>
                <div style="font-size:26px; margin-bottom:10px;">🏛️</div>
                <h4>Maklumat Pelayanan BMKG</h4>
                <p style="font-style:italic;">"Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan informasi meteorologi, klimatologi, dan geofisika sesuai dengan standar pelayanan yang telah ditetapkan, serta siap menerima sanksi apabila tidak sesuai ketentuan."</p>
                <div style="border-top:1px dashed #fef08a; padding-top:10px; margin-top:10px; font-size:11px; color:#854d0e;">
                    <strong>Wilayah Bebas dari Korupsi (WBK):</strong><br>
                    Seluruh petugas BMKG dilarang menerima imbalan, tips, atau gratifikasi dalam bentuk apapun.
                </div>
            </div>
            <div style="margin-top:16px;">
                <a href="{{ route('contact') }}" style="display:inline-flex; align-items:center; gap:6px; font-size:11.5px; font-weight:800; color:#854d0e; text-decoration:none; background:#fef08a; padding:6px 12px; border-radius:var(--r-sm);">
                    <span>Hubungi Loket PTSP Merauke &rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>
@endif

@if($page === 'products')
<section class="page-section" id="produk-iklim">
    @if(($subPage ?? 'katalog') === 'katalog')
    <!-- SUB-PAGE 1: KATALOG INFORMASI IKLIM -->
    <div class="section-intro">
        <div class="eyebrow">Katalog Informasi &amp; Analisis Iklim</div>
        <h2>Produk Informasi Iklim Papua Selatan</h2>
        <p>Ragam produk operasional klimatologi, pemantauan hari tanpa hujan, analisis hujan bulanan, serta publikasi iklim berkala Stasiun Klimatologi Papua Selatan.</p>
    </div>

    <!-- 4 Katalog Produk Iklim Operasional -->
    <div class="product-catalog-grid">
        <div class="product-catalog-card">
            <div>
                <span class="product-catalog-badge">Pemantauan Dasarian</span>
                <h4>Monitoring Hari Tanpa Hujan (HTH)</h4>
                <p>Peta sebaran dan deret hari kering berturut-turut pada jaringan pos hujan di 4 kabupaten Papua Selatan untuk deteksi awal kekeringan meteorologis.</p>
            </div>
            <a href="{{ route('dashboard') }}#monitoring" class="ptsp-action-btn">
                <span>Lihat di Dashboard Peta ↓</span>
            </a>
        </div>

        <div class="product-catalog-card">
            <div>
                <span class="product-catalog-badge">Prakiraan Bulanan</span>
                <h4>Prakiraan Curah Hujan &amp; Sifat Hujan</h4>
                <p>Analisis probabilitas curah hujan bulanan dan prakiraan sifat hujan (Bawah Normal, Normal, Atas Normal) untuk perencanaan sektor pertanian dan perairan.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="ptsp-action-btn">
                <span>Info Peringatan Dini ↓</span>
            </a>
        </div>

        <div class="product-catalog-card">
            <div>
                <span class="product-catalog-badge">Klimatologi Sektoral</span>
                <h4>Informasi Iklim Pertanian (Agroklimat)</h4>
                <p>Analisis ketersediaan air tanah (KAT), neraca air lahan, dan rekomendasi iklim untuk mendukung sentra pertanian dan lumbung pangan Merauke.</p>
            </div>
            <a href="{{ route('services') }}" class="ptsp-action-btn">
                <span>Layanan Konsultasi &rarr;</span>
            </a>
        </div>

        <div class="product-catalog-card">
            <div>
                <span class="product-catalog-badge">Publikasi Berkala</span>
                <h4>Buletin Iklim Papua Selatan</h4>
                <p>Publikasi resmi bulanan yang memuat rekapitulasi dinamika atmosfer (ENSO, IOD, MJO), anomali suhu muka laut, dan iklim ekstrem di Papua Selatan.</p>
            </div>
            <a href="{{ route('dashboard') }}#buletin-iklim" class="ptsp-action-btn">
                <span>Lihat &amp; Unduh Buletin &rarr;</span>
            </a>
        </div>
    </div>

    @else
    <!-- SUB-PAGE 2: SILING MALARIA -->
    <div id="malaria">
        <section class="hero">
            <div>
                <div class="eyebrow">Sistem Informasi Iklim untuk Kesehatan</div>
                <h2>SILING MALARIA</h2>
                <p>Peringatan Dini Malaria Berbasis Data Iklim Terpadu</p>
            </div>
            <div class="hero-tools">
                <div class="hero-partners">
                    <span>Hasil kolaborasi dari:</span>
                    <div class="partner-logos" aria-label="BMKG, Dinas Kesehatan Papua Selatan, dan Pemerintah Provinsi Papua Selatan">
                        <img class="partner-bmkg" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG">
                        <img class="partner-kemenkes" src="https://upload.wikimedia.org/wikipedia/commons/8/89/Logo_Kementerian_Kesehatan_Republik_Indonesia_%282024_rev%29.svg" alt="Logo Kementerian Kesehatan">
                        <img class="partner-province" src="https://papuaselatan.go.id/static/profile/img/LOGO_PPS_NEW.png" alt="Logo Provinsi Papua Selatan">
                    </div>
                </div>
                <form method="get" action="{{ route('products.malaria', [], false) }}" class="period">
                    Bulan 
                    <select name="period" onchange="this.form.submit()" aria-label="Pilih bulan dan tahun" style="border:0;background:transparent;color:var(--ink);font-weight:800;cursor:pointer;max-width:190px">
                        @foreach($periodOptions as $key => $label)
                            <option value="{{ $key }}" @selected($period === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </section>

        @php
        $total = $records->count(); $mean = $total ? $records->avg('incidence') : 0;
        $safeCount = $records->filter(fn($r) => $r->incidence < 3)->count();
        $cautionCount = $records->filter(fn($r) => $r->incidence >= 3 && $r->incidence <= 10)->count();
        $alertCount = $records->filter(fn($r) => $r->incidence > 10)->count();
        $statusText = fn($value) => $value < 3 ? 'Aman' : ($value <= 10 ? 'Waspada' : 'Awas');
        $statusClass = fn($value) => $value < 3 ? 'safe' : ($value <= 10 ? 'caution' : 'danger');
        $statusColor = fn($value) => $value < 3 ? '#269467' : ($value <= 10 ? '#e5ad24' : '#ce5142');
        $districts = ['Asmat','Boven Digoel','Mappi','Merauke'];
        $byName = $records->keyBy('district');
        $climateByName = $climateSuitabilities->keyBy('district');
        @endphp

        <section class="content-grid maps-grid">
            <article class="panel">
                <div class="panel-heading"><div><h3>Prediksi Angka Insiden Malaria</h3><p>Angka insiden per 1.000 penduduk · {{ $periodLabel }}</p></div><span class="badge safe">{{ $safeCount }} aman</span></div>
                <div class="map-shell">
                    <svg id="incidence-map" viewBox="0 0 520 500" role="img" aria-label="Peta batas administrasi kabupaten Papua Selatan"></svg>
                    <div id="map-popup" class="map-popup" role="status" aria-live="polite"><button type="button" class="map-popup-close" aria-label="Tutup informasi">×</button><div class="map-popup-title"></div><div class="map-popup-detail popup-period"></div><div class="map-popup-detail popup-incidence"></div><div class="map-popup-detail popup-status"></div></div>
                    <div class="map-legend"><strong>Status peringatan dini · per 1.000 penduduk</strong><div class="legend-row"><i class="swatch" style="background:#269467"></i>Aman · AI &lt; 3</div><div class="legend-row"><i class="swatch" style="background:#e5ad24"></i>Waspada · 3 ≤ AI ≤ 10</div><div class="legend-row"><i class="swatch" style="background:#ce5142"></i>Awas · AI &gt; 10</div></div>
                    <div class="map-note">Batas kabupaten · BIG 2026</div>
                </div>
            </article>

            <article class="panel">
                <div class="panel-heading"><div><h3>Prediksi Kesesuaian Iklim untuk Malaria</h3><p>Probabilitas kecocokan · {{ $periodLabel }}</p></div></div>
                <div class="map-shell climate-map-shell">
                    <svg id="climate-map" viewBox="0 0 520 500" role="img" aria-label="Peta probabilitas kesesuaian iklim untuk malaria di Papua Selatan"></svg>
                    <div id="climate-map-popup" class="map-popup" role="status" aria-live="polite"><button type="button" class="map-popup-close" aria-label="Tutup informasi">×</button><div class="map-popup-title"></div><div class="map-popup-detail popup-period"></div><div class="map-popup-detail popup-probability"></div><div class="map-popup-detail popup-humidity"></div><div class="map-popup-detail popup-status"></div></div>
                    <div class="map-legend climate-legend" aria-label="Legenda probabilitas kesesuaian iklim">
                        <strong>Probabilitas<br>kecocokan</strong>
                        <div class="legend-group"><span class="legend-group-title">Tinggi</span><div class="legend-row"><i class="swatch" style="background:#d00000"></i>&gt;90%</div><div class="legend-row"><i class="swatch" style="background:#ff3300"></i>80–90%</div><div class="legend-row"><i class="swatch" style="background:#ff9900"></i>70–80%</div></div>
                        <div class="legend-group"><span class="legend-group-title">Sedang</span><div class="legend-row"><i class="swatch" style="background:#ffff00"></i>60–70%</div><div class="legend-row"><i class="swatch" style="background:#bfff00"></i>50–60%</div><div class="legend-row"><i class="swatch" style="background:#33cc33"></i>40–50%</div></div>
                        <div class="legend-group"><span class="legend-group-title">Rendah</span><div class="legend-row"><i class="swatch" style="background:#00cccc"></i>30–40%</div><div class="legend-row"><i class="swatch" style="background:#00a6e6"></i>20–30%</div><div class="legend-row"><i class="swatch" style="background:#0066ff"></i>10–20%</div><div class="legend-row"><i class="swatch" style="background:#0000cc"></i>&lt;10%</div></div>
                    </div>
                    <div class="map-note">Batas kabupaten · BIG 2026</div>
                </div>
            </article>
        </section>

        <section class="panel" style="margin-top:15px">
            <article class="panel"><div class="panel-heading"><div><h3>Rekomendasi tindak lanjut</h3><p>Ambang angka insiden per 1.000 penduduk</p></div></div><div class="rec-card">
            <div class="rec green"><h4>AMAN</h4><p><strong>Angka Insiden &lt; 3 per 1.000 penduduk.</strong> Risiko penularan rendah. Pencegahan rutin tetap dipertahankan.</p><ul><li>Surveilans rutin kasus malaria di fasilitas pelayanan kesehatan (FKTP).</li><li>Surveilans vektor rutin: kelambu, larva, dan nyamuk dewasa.</li><li>Edukasi pencegahan 3M Plus: Menguras, Menutup, Mengubur, memakai kelambu, repelen, dan pakaian tertutup.</li><li>Pantau rutin data kasus, vektor, dan faktor lingkungan.</li></ul></div>
            <div class="rec yellow"><h4>WASPADA</h4><p><strong>Angka Insiden 3–10 per 1.000 penduduk.</strong> Risiko penularan sedang. Tingkatkan kewaspadaan dan pencegahan.</p><ul><li>Tingkatkan surveilans kasus malaria aktif dan pasif.</li><li>Tingkatkan surveilans vektor di lokasi risiko.</li><li>Lakukan larvasidasi selektif di tempat perindukan nyamuk.</li><li>Pastikan ketersediaan kelambu berinsektisida.</li><li>Edukasi dan komunikasi risiko kepada masyarakat.</li></ul></div>
            <div class="rec red"><h4>AWAS</h4><p><strong>Angka Insiden &gt; 10 per 1.000 penduduk.</strong> Risiko penularan tinggi. Perlu respons cepat dan pengendalian intensif lintas sektor.</p><ul><li>Aktifkan respons cepat (RRT) malaria di tingkat kabupaten.</li><li>Lakukan surveilans kasus, vektor, dan lingkungan secara intensif dan harian.</li><li>Lakukan larvasidasi massal berkelanjutan di lokasi berisiko.</li><li>Lakukan IRS massal di seluruh wilayah berisiko tinggi.</li><li>Pastikan ketersediaan obat, RDT, dan logistik tanpa putus.</li><li>Mobilisasi lintas sektor dan komunikasi risiko intensif.</li></ul></div>
            </div></article>
        </section>

        <section class="panel trend-panel">
            <div class="panel-heading"><div><h3>Tren malaria dan iklim bulanan</h3><p>Data per kabupaten · 2021–2026</p></div><select id="trend-metric" class="trend-select" aria-label="Pilih indikator grafik"><option value="cases">Jumlah kasus</option><option value="humidity">Kelembapan (%)</option><option value="temperature">Suhu (°C)</option><option value="rainfall">Curah hujan (mm)</option></select></div>
            <div class="trend-scroll"><svg id="malaria-trend-chart" class="trend-chart" viewBox="0 0 960 360" role="img" aria-label="Grafik tren malaria dan iklim bulanan per kabupaten"></svg></div>
            <div class="trend-legend" aria-label="Legenda kabupaten"><span class="trend-key"><i style="background:#087e79"></i>Asmat</span><span class="trend-key"><i style="background:#3974c6"></i>Boven Digoel</span><span class="trend-key"><i style="background:#e2a21b"></i>Mappi</span><span class="trend-key"><i style="background:#c94f48"></i>Merauke</span></div>
            <p class="trend-note">Pilih indikator untuk melihat grafik tren data malaria dan parameter iklim bulanan.</p>
        </section>

        <!-- Publikasi Buletin Iklim Lingkungan & Peringatan Dini Malaria -->
        @if(!empty($latestMalariaBulletin))
        <section class="bulletin-section" id="buletin-siling-malaria" style="margin-top:36px;">
            <div class="section-intro" style="margin-bottom: 20px;">
                <div class="eyebrow">Publikasi Khusus Iklim &amp; Kesehatan</div>
                <h2>Buletin Iklim Lingkungan &amp; Peringatan Dini Malaria</h2>
                <p>Akses publikasi resmi analisis korelasi faktor dinamika atmosfer dan transmisi malaria, pemodelan spasial kesesuaian iklim perkembangbiakan vektor, serta rekomendasi pencegahan operasional di Provinsi Papua Selatan.</p>
            </div>

            <div class="bulletin-card-main">
                <div class="bulletin-hero-grid">
                    <!-- Cover Column with 3D Effect -->
                    <div class="bulletin-cover-col">
                        <a href="{{ $latestMalariaBulletin->download_url ?: '#' }}" target="_blank" rel="noopener" class="bulletin-3d-book" title="Buka Dokumen Buletin SILING Malaria (PDF)">
                            <img src="{{ $latestMalariaBulletin->cover_url }}" alt="Sampul {{ $latestMalariaBulletin->title }}" loading="lazy">
                            <div class="bulletin-book-spine"></div>
                            <span class="bulletin-badge-floating" style="background:#059669;">Edisi Baru</span>
                        </a>
                    </div>

                    <!-- Info and Highlights Column -->
                    <div class="bulletin-info-col">
                        <div class="bulletin-tags-row">
                            <span class="bulletin-tag-edition" style="background:#ecfdf5; color:#065f46; border-color:#a7f3d0;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                {{ $latestMalariaBulletin->edition }}
                            </span>
                            @if($latestMalariaBulletin->release_date)
                            <span class="bulletin-tag-meta">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $latestMalariaBulletin->formatted_date }}
                            </span>
                            @endif
                            <span class="bulletin-tag-meta">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                {{ $latestMalariaBulletin->page_count ?? 32 }} Halaman
                            </span>
                            @if($latestMalariaBulletin->file_size)
                            <span class="bulletin-tag-meta">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                {{ $latestMalariaBulletin->file_size }}
                            </span>
                            @endif
                        </div>

                        <h3 class="bulletin-headline">{{ $latestMalariaBulletin->title }}</h3>

                        <p class="bulletin-summary">
                            {{ $latestMalariaBulletin->description ?: 'Publikasi resmi hasil integrasi data klimatologi dan kesehatan kerja sama Stasiun Klimatologi Papua Selatan dengan Dinas Kesehatan. Menyajikan analisis korelasi parameter atmosfer dengan tren angka insiden malaria di Kabupaten Asmat, Boven Digoel, Mappi, dan Merauke.' }}
                        </p>

                        <div class="bulletin-highlights-grid">
                            <div class="bulletin-highlight-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>Korelasi Suhu, Kelembapan &amp; Curah Hujan</span>
                            </div>
                            <div class="bulletin-highlight-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>Peta Kesesuaian Iklim Vektor Anopheles</span>
                            </div>
                            <div class="bulletin-highlight-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>Prediksi Angka Insiden (AI) 4 Kabupaten</span>
                            </div>
                            <div class="bulletin-highlight-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                <span>Peringatan Dini &amp; Rekomendasi Tindak Lanjut</span>
                            </div>
                        </div>

                        <div class="bulletin-actions-row">
                            @if($latestMalariaBulletin->download_url)
                            <a href="{{ $latestMalariaBulletin->download_url }}" target="_blank" rel="noopener" class="btn-bulletin-primary" style="background:linear-gradient(135deg, #059669, #0284c7);">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                                <span>Unduh Buletin Malaria (PDF)</span>
                            </a>
                            <a href="{{ $latestMalariaBulletin->download_url }}" target="_blank" rel="noopener" class="btn-bulletin-secondary">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <span>Baca Buletin Online</span>
                            </a>
                            @else
                            <a href="{{ route('contact') }}" class="btn-bulletin-primary" style="background:#059669;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                <span>Permohonan Dokumen Buletin</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if(isset($malariaBulletins) && $malariaBulletins->count() > 1)
                <div class="bulletin-archive-box">
                    <div class="bulletin-archive-header">
                        <span class="bulletin-archive-title">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                            Arsip Buletin SILING Malaria Sebelumnya
                        </span>
                        <span style="font-size:12px; color:var(--muted); font-weight:600;">Total {{ $malariaBulletins->count() }} Edisi</span>
                    </div>
                    <div class="bulletin-archive-grid">
                        @foreach($malariaBulletins->slice(1) as $archived)
                        <a href="{{ $archived->download_url ?: '#' }}" target="_blank" rel="noopener" class="bulletin-archive-card" title="Buka {{ $archived->title }} - {{ $archived->edition }}">
                            <img src="{{ $archived->cover_url }}" alt="Cover {{ $archived->edition }}" class="bulletin-archive-thumb" loading="lazy">
                            <div class="bulletin-archive-info">
                                <span class="bulletin-archive-badge">{{ $archived->edition }}</span>
                                <span class="bulletin-archive-name">{{ $archived->title }}</span>
                                <span class="bulletin-archive-date">{{ $archived->formatted_date }} &bull; {{ $archived->page_count ?? 32 }} Hlm</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </section>
        @endif
    </div>
    @endif
</section>
@endif

</main>

<!-- Site Footer -->
<footer class="site-footer">
    <div class="footer-inner">
        <div>
            <div class="footer-brand-header">
                <img class="footer-logo" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG">
                <div>
                    <div class="footer-brand-sub">Badan Meteorologi, Klimatologi, dan Geofisika</div>
                    <div class="footer-brand">Stasiun Klimatologi Papua Selatan</div>
                </div>
            </div>
            <p class="footer-copy">Menyediakan informasi iklim, kualitas udara, pemantauan kekeringan, hari tanpa hujan, dan peringatan dini berbasis iklim untuk mendukung pembangunan dan kesehatan di Provinsi Papua Selatan.</p>
        </div>
        <div>
            <h4 class="footer-heading">Navigasi Utama</h4>
            <div class="footer-links">
                <a href="{{ route('dashboard') }}">Dashboard Monitoring</a>
                <a href="{{ route('profile') }}">Profil Stasiun</a>
                <a href="{{ route('services') }}">Layanan Publik (PTSP)</a>
                <a href="{{ route('products') }}">Produk Iklim</a>
                <a href="{{ route('contact') }}">Kontak Kami</a>
            </div>
        </div>
        <div>
            <h4 class="footer-heading">Kontak &amp; Layanan PTSP</h4>
            <div class="footer-contact">
                <div><strong>Alamat:</strong> Jl. Poros Semangga–Tanah Miring, SP 2, Merauke</div>
                <div><strong>Telepon:</strong> <a href="tel:+628114908182">0811-4908-182</a></div>
                <div><strong>Email:</strong> <a href="mailto:staklim.merauke@bmkg.go.id">staklim.merauke@bmkg.go.id</a></div>
                <div style="margin-top:4px;">
                    <span class="footer-badge">Call Center BMKG 196</span>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; {{ date('Y') }} Badan Meteorologi, Klimatologi, dan Geofisika &mdash; Stasiun Klimatologi Papua Selatan.</span>
        <span>Standar Waktu Resmi Indonesia disinkronkan dengan NTP BMKG.</span>
    </div>
</footer>

@if($page === 'products' && ($subPage ?? 'katalog') === 'siling-malaria')
<script>
(() => {
    const svg = document.getElementById('incidence-map');
    if (!svg) return;
    const mapShell = svg.closest('.map-shell');
    const popup = document.getElementById('map-popup');
    const closePopup = popup.querySelector('.map-popup-close');
    const incidentValues = @json($byName->mapWithKeys(fn ($record) => [$record->district => (float) $record->incidence]));
    const boundaryData = @json(json_decode(file_get_contents(public_path('data/papua-selatan-kabupaten.geojson')), true));
    const ns = 'http://www.w3.org/2000/svg';
    const make = (tag, attrs = {}) => {
        const element = document.createElementNS(ns, tag);
        Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value));
        return element;
    };
    const statusColor = value => value === null ? '#dce8e3' : value < 3 ? '#269467' : value <= 10 ? '#e5ad24' : '#ce5142';
    const statusText = value => value === null ? 'Belum ada data' : value < 3 ? 'Aman' : value <= 10 ? 'Waspada' : 'Awas';
    const showPopup = (district, value, event) => {
        popup.querySelector('.map-popup-title').textContent = district;
        popup.querySelector('.popup-period').textContent = 'Prediksi: {{ $periodLabel }}';
        popup.querySelector('.popup-incidence').textContent = value === null ? 'Angka insiden: Belum ada data' : `Angka insiden: ${value.toFixed(2)} per 1.000 penduduk`;
        const status = popup.querySelector('.popup-status');
        status.textContent = `Keterangan: ${statusText(value)}`;
        status.style.color = value === null ? '#71828d' : value < 3 ? '#16734e' : value <= 10 ? '#956400' : '#a83b30';
        popup.classList.add('is-visible');
        const bounds = mapShell.getBoundingClientRect();
        const popupWidth = popup.offsetWidth, popupHeight = popup.offsetHeight;
        const localX = event.clientX - bounds.left, localY = event.clientY - bounds.top;
        const left = Math.max(12, Math.min(localX + 12, bounds.width - popupWidth - 12));
        const top = localY < popupHeight + 24
            ? Math.min(localY + 14, bounds.height - popupHeight - 12)
            : localY - popupHeight - 14;
        popup.style.left = `${left}px`;
        popup.style.top = `${Math.max(12, top)}px`;
    };
    closePopup.addEventListener('click', () => popup.classList.remove('is-visible'));
    const coords = geometry => {
        const points = [];
        const visit = item => {
            if (Array.isArray(item) && typeof item[0] === 'number') points.push(item);
            else if (Array.isArray(item)) item.forEach(visit);
        };
        visit(geometry.coordinates);
        return points;
    };
    const pathFor = (geometry, project) => {
        const polygons = geometry.type === 'Polygon' ? [geometry.coordinates] : geometry.coordinates;
        return polygons.flatMap(polygon => polygon.map(ring => ring.map((point, index) => {
            const [x, y] = project(point);
            return `${index ? 'L' : 'M'}${x.toFixed(2)},${y.toFixed(2)}`;
        }).join(' ') + ' Z')).join(' ');
    };
    Promise.resolve(boundaryData)
        .then(({ features }) => {
            const allPoints = features.flatMap(feature => coords(feature.geometry));
            const minLon = Math.min(...allPoints.map(point => point[0]));
            const maxLon = Math.max(...allPoints.map(point => point[0]));
            const minLat = Math.min(...allPoints.map(point => point[1]));
            const maxLat = Math.max(...allPoints.map(point => point[1]));
            const pad = 22, width = 520, height = 500;
            const scale = Math.min((width - pad * 2) / (maxLon - minLon), (height - pad * 2) / (maxLat - minLat));
            const drawnWidth = (maxLon - minLon) * scale, drawnHeight = (maxLat - minLat) * scale;
            const offsetX = (width - drawnWidth) / 2, offsetY = (height - drawnHeight) / 2;
            const project = ([lon, lat]) => [offsetX + (lon - minLon) * scale, offsetY + (maxLat - lat) * scale];
            const shapes = make('g');
            const labels = make('g');
            features.forEach(feature => {
                const district = feature.properties.district;
                const value = Object.hasOwn(incidentValues, district) ? incidentValues[district] : null;
                const shape = make('path', { class: 'district', 'data-district': district, d: pathFor(feature.geometry, project), fill: statusColor(value), 'fill-rule': 'evenodd', tabindex: '0', role: 'button', 'aria-label': `Lihat data malaria ${district}` });
                shape.addEventListener('click', event => showPopup(district, value, event));
                shape.addEventListener('keydown', event => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        showPopup(district, value, { clientX: event.currentTarget.getBoundingClientRect().left + event.currentTarget.getBoundingClientRect().width / 2, clientY: event.currentTarget.getBoundingClientRect().top + event.currentTarget.getBoundingClientRect().height / 2 });
                    }
                });
                shapes.append(shape);
                const points = coords(feature.geometry);
                const bounds = points.reduce((box, point) => ({ minX: Math.min(box.minX, point[0]), maxX: Math.max(box.maxX, point[0]), minY: Math.min(box.minY, point[1]), maxY: Math.max(box.maxY, point[1]) }), { minX: Infinity, maxX: -Infinity, minY: Infinity, maxY: -Infinity });
                const [x, y] = project([(bounds.minX + bounds.maxX) / 2, (bounds.minY + bounds.maxY) / 2]);
                const label = make('g', { class: 'map-label', transform: `translate(${x} ${y})` });
                const title = make('text', { class: 'district-label', 'font-size': district === 'Boven Digoel' ? '11' : '13' });
                title.textContent = district;
                const detail = make('text', { class: 'district-value', y: '17' });
                detail.textContent = value === null ? 'Belum ada data' : `AI ${value.toFixed(2)}`;
                label.append(title, detail);
                labels.append(label);
            });
            svg.replaceChildren(shapes, labels);
        })
        .catch(() => {
            const message = make('text', { x: '260', y: '250', 'text-anchor': 'middle', fill: '#71828d', 'font-size': '13' });
            message.textContent = 'Data batas peta tidak dapat dimuat';
            svg.replaceChildren(message);
        });
})();
</script>
<script>
(() => {
    const svg = document.getElementById('climate-map');
    if (!svg) return;
    const shell = svg.closest('.map-shell');
    const popup = document.getElementById('climate-map-popup');
    const values = @json($climateByName->mapWithKeys(fn ($record) => [$record->district => ['probability' => (float) $record->probability, 'humidity' => $record->humidity === null ? null : (float) $record->humidity, 'confidence' => $record->confidence]]));
    const features = @json(json_decode(file_get_contents(public_path('data/papua-selatan-kabupaten.geojson')), true)['features']);
    const ns = 'http://www.w3.org/2000/svg';
    const make = (tag, attrs = {}) => { const node = document.createElementNS(ns, tag); Object.entries(attrs).forEach(([key, value]) => node.setAttribute(key, value)); return node; };
    const color = value => value === null ? '#dce8e3' : value > 90 ? '#d00000' : value >= 80 ? '#ff3300' : value >= 70 ? '#ff9900' : value >= 60 ? '#ffff00' : value >= 50 ? '#bfff00' : value >= 40 ? '#33cc33' : value >= 30 ? '#00cccc' : value >= 20 ? '#00a6e6' : value >= 10 ? '#0066ff' : '#0000cc';
    const category = value => value === null ? 'Belum ada data' : value > 90 ? 'Sangat tinggi' : value >= 70 ? 'Tinggi' : value >= 40 ? 'Sedang' : 'Rendah';
    const allPoints = [];
    const visit = item => { if (Array.isArray(item) && typeof item[0] === 'number') allPoints.push(item); else if (Array.isArray(item)) item.forEach(visit); };
    features.forEach(feature => visit(feature.geometry.coordinates));
    const minLon = Math.min(...allPoints.map(point => point[0])), maxLon = Math.max(...allPoints.map(point => point[0]));
    const minLat = Math.min(...allPoints.map(point => point[1])), maxLat = Math.max(...allPoints.map(point => point[1]));
    const width = 520, height = 500, pad = 22;
    const scale = Math.min((width - 2 * pad) / (maxLon - minLon), (height - 2 * pad) / (maxLat - minLat));
    const offsetX = (width - (maxLon - minLon) * scale) / 2, offsetY = (height - (maxLat - minLat) * scale) / 2;
    const project = ([lon, lat]) => [offsetX + (lon - minLon) * scale, offsetY + (maxLat - lat) * scale];
    const pathFor = geometry => {
        const polygons = geometry.type === 'Polygon' ? [geometry.coordinates] : geometry.coordinates;
        return polygons.flatMap(polygon => polygon.map(ring => ring.map((point, index) => { const [x, y] = project(point); return `${index ? 'L' : 'M'}${x.toFixed(2)},${y.toFixed(2)}`; }).join(' ') + ' Z')).join(' ');
    };
    const showPopup = (district, value, event) => {
        const probability = value === null ? null : Number(value.probability);
        popup.querySelector('.map-popup-title').textContent = district;
        popup.querySelector('.popup-period').textContent = 'Prediksi: {{ $periodLabel }}';
        popup.querySelector('.popup-probability').textContent = probability === null ? 'Probabilitas kecocokan: Belum ada data' : `Probabilitas Kecocokan: ${probability.toLocaleString('id-ID', { maximumFractionDigits: 2 })}%`;
        popup.querySelector('.popup-humidity').textContent = value?.humidity === null || value === null ? 'RH: Belum ada data' : `RH: ${Number(value.humidity).toLocaleString('id-ID', { maximumFractionDigits: 2 })}%`;
        const status = popup.querySelector('.popup-status'); status.textContent = `Tingkat Keyakinan: ${value?.confidence || 'Belum ada data'}`; status.style.color = value === null ? '#71828d' : '#365365';
        popup.classList.add('is-visible');
        const bounds = shell.getBoundingClientRect(), w = popup.offsetWidth, h = popup.offsetHeight;
        const x = event.clientX - bounds.left, y = event.clientY - bounds.top;
        popup.style.left = `${Math.max(10, Math.min(x + 12, bounds.width - w - 10))}px`;
        popup.style.top = `${Math.max(10, Math.min(y < h + 24 ? y + 14 : y - h - 14, bounds.height - h - 10))}px`;
    };
    popup.querySelector('.map-popup-close').addEventListener('click', () => popup.classList.remove('is-visible'));
    const shapes = make('g'), labels = make('g');
    features.forEach(feature => {
        const district = feature.properties.district;
        const value = Object.hasOwn(values, district) ? values[district] : null;
        const probability = value === null ? null : Number(value.probability);
        const shape = make('path', { class: 'district', d: pathFor(feature.geometry), fill: color(probability), 'fill-rule': 'evenodd', tabindex: '0', role: 'button', 'aria-label': `Lihat kesesuaian iklim malaria ${district}` });
        shape.addEventListener('click', event => showPopup(district, value, event));
        shape.addEventListener('keydown', event => { if (event.key === 'Enter' || event.key === ' ') { event.preventDefault(); const box = event.currentTarget.getBoundingClientRect(); showPopup(district, value, { clientX: box.left + box.width / 2, clientY: box.top + box.height / 2 }); } });
        shapes.append(shape);
        const points = [];
        const collect = item => { if (Array.isArray(item) && typeof item[0] === 'number') points.push(item); else if (Array.isArray(item)) item.forEach(collect); };
        collect(feature.geometry.coordinates);
        const box = points.reduce((b, point) => ({ minX: Math.min(b.minX, point[0]), maxX: Math.max(b.maxX, point[0]), minY: Math.min(b.minY, point[1]), maxY: Math.max(b.maxY, point[1]) }), { minX: Infinity, maxX: -Infinity, minY: Infinity, maxY: -Infinity });
        const [x, y] = project([(box.minX + box.maxX) / 2, (box.minY + box.maxY) / 2]);
        const label = make('g', { transform: `translate(${x} ${y})` });
        const name = make('text', { class: 'district-label', 'font-size': district === 'Boven Digoel' ? '11' : '13' }); name.textContent = district;
        const detail = make('text', { class: 'district-value', y: '17' }); detail.textContent = value === null ? 'Belum ada data' : `${probability.toLocaleString('id-ID', { maximumFractionDigits: 1 })}%`;
        label.append(name, detail); labels.append(label);
    });
    svg.replaceChildren(shapes, labels);
})();
</script>
<script>
(() => {
    const svg = document.getElementById('malaria-trend-chart');
    if (!svg) return;
    const metricSelect = document.getElementById('trend-metric');
    const rows = @json($malariaHistory);
    const series = [
        { name: 'Asmat', color: '#087e79' },
        { name: 'Boven Digoel', color: '#3974c6' },
        { name: 'Mappi', color: '#e2a21b' },
        { name: 'Merauke', color: '#c94f48' },
    ];
    const namespace = 'http://www.w3.org/2000/svg';
    const add = (tag, attrs = {}, parent) => {
        const element = document.createElementNS(namespace, tag);
        Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value));
        (parent || svg).append(element);
        return element;
    };

    if (!rows.length) {
        const message = add('text', { x: 480, y: 180, 'text-anchor': 'middle', class: 'trend-axis' });
        message.textContent = 'Belum ada data historis malaria';
        return;
    }

    const left = 54, right = 930, top = 22, bottom = 306;
    const monthNumber = period => Number(period.slice(0, 4)) * 12 + Number(period.slice(5, 7)) - 1;
    const minMonth = Math.min(...rows.map(row => monthNumber(row.period)));
    const maxMonth = Math.max(...rows.map(row => monthNumber(row.period)));
    const x = period => left + ((monthNumber(period) - minMonth) / Math.max(1, maxMonth - minMonth)) * (right - left);
    const periods = [...new Set(rows.map(row => row.period))].sort();
    const metrics = {
        cases: { label: 'kasus', step: 500, decimals: 0 },
        humidity: { label: '%', step: 20, decimals: 1 },
        temperature: { label: '°C', step: 2, decimals: 1 },
        rainfall: { label: 'mm', step: 100, decimals: 1 },
    };

    const render = () => {
        const key = metricSelect.value;
        const metric = metrics[key];
        const values = rows.map(row => Number(row[key])).filter(Number.isFinite);
        const minValue = Math.min(...values);
        const maxValue = Math.max(...values);
        const yMin = minValue <= 0 ? 0 : Math.floor(minValue / metric.step) * metric.step;
        const yMax = Math.max(yMin + metric.step, Math.ceil(maxValue / metric.step) * metric.step);
        const y = value => bottom - ((Number(value) - yMin) / (yMax - yMin)) * (bottom - top);
        svg.replaceChildren();
        svg.setAttribute('aria-label', `Grafik ${metric.label} bulanan per kabupaten`);

        for (let tick = 0; tick <= 4; tick++) {
            const value = yMin + (yMax - yMin) * tick / 4;
            const yPosition = y(value);
            add('line', { x1: left, y1: yPosition, x2: right, y2: yPosition, class: 'trend-grid' });
            const label = add('text', { x: left - 9, y: yPosition + 4, 'text-anchor': 'end', class: 'trend-axis' });
            label.textContent = value.toLocaleString('id-ID', { maximumFractionDigits: metric.decimals });
        }

        periods.filter(period => period.endsWith('-01')).forEach(period => {
            const xPosition = x(period);
            add('line', { x1: xPosition, y1: top, x2: xPosition, y2: bottom, class: 'trend-grid' });
            const label = add('text', { x: xPosition, y: bottom + 22, 'text-anchor': 'middle', class: 'trend-axis' });
            label.textContent = period.slice(0, 4);
        });

        series.forEach(item => {
            const points = rows.filter(row => row.district === item.name && row[key] !== null && row[key] !== '').sort((a, b) => a.period.localeCompare(b.period));
            if (!points.length) return;
            add('path', {
                d: points.map((point, index) => `${index ? 'L' : 'M'}${x(point.period).toFixed(2)},${y(point[key]).toFixed(2)}`).join(' '),
                class: 'trend-line', stroke: item.color,
            });
            points.forEach(point => {
                const dot = add('circle', { cx: x(point.period), cy: y(point[key]), r: 3.2, fill: item.color, class: 'trend-dot' });
                const title = add('title', {}, dot);
                title.textContent = `${item.name} · ${point.period}: ${Number(point[key]).toLocaleString('id-ID', { maximumFractionDigits: metric.decimals })} ${metric.label}`;
            });
        });
    };

    metricSelect.addEventListener('change', render);
    render();
})();
</script>
@endif

@if($page === 'dashboard')
<script>
(() => {
    const earlyWarnings = @json($earlyWarnings ?? []);
    const hthStations = @json($hthObservations ?? []);
    const districts = ['Asmat', 'Boven Digoel', 'Mappi', 'Merauke'];
    let currentSubCategory = 'kekeringan';
    const geojsonData = @json(json_decode(file_get_contents(public_path('data/papua-selatan-kabupaten.geojson')), true));
    let peringatanGeojsonLayer = null;
    let peringatanMap = null;
    let hthMap = null;

    const statusColors = {
        'awas': '#dc2626',
        'siaga': '#f97316',
        'waspada': '#eab308',
        'tidak_ada': '#16a34a'
    };

    const statusLabels = {
        'awas': 'Awas',
        'siaga': 'Siaga',
        'waspada': 'Waspada',
        'tidak_ada': 'Tidak Ada Peringatan'
    };

    // Tab Switching & Auto-slide (Peringatan Dini <-> Distribusi HTH)
    const topTabButtons = document.querySelectorAll('.monitor-top-tab-btn');
    const monitorPanes = {
        'peringatan-dini': document.getElementById('pane-peringatan-dini'),
        'distribusi-hth': document.getElementById('pane-distribusi-hth'),
    };
    const monitorTabKeys = ['peringatan-dini', 'distribusi-hth'];
    let currentMonitorTabIdx = 0;
    let isMonitorPaused = false;
    const MONITOR_INTERVAL = 8000; // 8 seconds per slide

    window.switchMonitorTab = (targetTab, userInitiated = false) => {
        const idx = monitorTabKeys.indexOf(targetTab);
        if (idx !== -1) currentMonitorTabIdx = idx;

        topTabButtons.forEach(btn => {
            btn.classList.toggle('is-active', btn.dataset.tab === targetTab);
        });
        Object.entries(monitorPanes).forEach(([key, pane]) => {
            if (pane) pane.classList.toggle('is-active', key === targetTab);
        });

        const statusText = document.getElementById('monitorAutoStatusText');
        if (statusText) {
            statusText.textContent = targetTab === 'peringatan-dini' ? 'Peringatan Dini' : 'Distribusi HTH';
        }

        setTimeout(() => {
            if (targetTab === 'peringatan-dini' && peringatanMap) {
                peringatanMap.invalidateSize();
                peringatanMap.setView([-7.0, 139.5], 7);
            }
            if (targetTab === 'distribusi-hth' && hthMap) {
                hthMap.invalidateSize();
                hthMap.setView([-7.0, 139.5], 7);
            }
        }, 120);

        if (userInitiated) {
            isMonitorPaused = true;
            setTimeout(() => { isMonitorPaused = false; }, 14000);
        }
    };

    topTabButtons.forEach(btn => {
        btn.addEventListener('click', () => window.switchMonitorTab(btn.dataset.tab, true));
    });

    // Auto-slide loop for Peringatan Dini <-> HTH
    const monitorSection = document.getElementById('monitoring-iklim');
    if (monitorSection) {
        monitorSection.addEventListener('mouseenter', () => { isMonitorPaused = true; });
        monitorSection.addEventListener('mouseleave', () => { isMonitorPaused = false; });
    }

    setInterval(() => {
        if (!isMonitorPaused) {
            currentMonitorTabIdx = (currentMonitorTabIdx + 1) % monitorTabKeys.length;
            window.switchMonitorTab(monitorTabKeys[currentMonitorTabIdx], false);
        }
    }, MONITOR_INTERVAL);

    // Sub-nav for Peringatan Dini (Kekeringan vs Hujan Lebat)
    const subnavButtons = document.querySelectorAll('.subnav-btn');
    const tableTitle = document.getElementById('early-warning-table-title');
    const tableBody = document.getElementById('early-warning-table-body');

    const updateTable = () => {
        if (!tableBody) return;
        const catLabel = currentSubCategory === 'kekeringan' ? 'Kekeringan' : 'Hujan Lebat';
        if (tableTitle) tableTitle.textContent = `Tabel Peringatan Dini (${catLabel})`;

        tableBody.innerHTML = '';
        districts.forEach((dist, idx) => {
            const item = earlyWarnings.find(ew => ew.category === currentSubCategory && ew.district.toLowerCase() === dist.toLowerCase());
            const status = item ? item.status : 'tidak_ada';
            const waspada = (item && item.waspada_areas && item.waspada_areas !== '-') ? item.waspada_areas : '-';
            const siaga = (item && item.siaga_areas && item.siaga_areas !== '-') ? item.siaga_areas : '-';
            const awas = (item && item.awas_areas && item.awas_areas !== '-') ? item.awas_areas : '-';

            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${idx + 1}</td>
                <td><strong>Kabupaten ${dist}</strong></td>
                <td>${waspada !== '-' ? `<span style="display:inline-block; padding:3px 8px; border-radius:10px; background:#fef9c3; color:#854d0e; font-weight:700; font-size:11px;">${waspada}</span>` : '<span style="color:#9ca3af">—</span>'}</td>
                <td>${siaga !== '-' ? `<span style="display:inline-block; padding:3px 8px; border-radius:10px; background:#ffedd5; color:#9a3412; font-weight:700; font-size:11px;">${siaga}</span>` : '<span style="color:#9ca3af">—</span>'}</td>
                <td>${awas !== '-' ? `<span style="display:inline-block; padding:3px 8px; border-radius:10px; background:#fee2e2; color:#991b1b; font-weight:700; font-size:11px;">${awas}</span>` : '<span style="color:#9ca3af">—</span>'}</td>
            `;
            tableBody.appendChild(tr);
        });
    };

    const getDistrictStyle = (districtName) => {
        if (!districtName) {
            return {
                fillColor: '#16a34a',
                weight: 2,
                opacity: 1,
                color: '#ffffff',
                fillOpacity: 0.78
            };
        }
        const item = earlyWarnings.find(ew => ew.category === currentSubCategory && ew.district.toLowerCase() === districtName.toLowerCase());
        const status = item ? item.status : 'tidak_ada';
        const color = statusColors[status] || '#16a34a';

        return {
            fillColor: color,
            weight: 2,
            opacity: 1,
            color: '#ffffff',
            fillOpacity: 0.78
        };
    };

    const updatePeringatanMapStyles = () => {
        if (!peringatanGeojsonLayer) return;
        peringatanGeojsonLayer.eachLayer(layer => {
            const districtName = layer.feature?.properties?.district;
            if (!districtName) return;

            layer.setStyle(getDistrictStyle(districtName));

            const item = earlyWarnings.find(ew => ew.category === currentSubCategory && ew.district.toLowerCase() === districtName.toLowerCase());
            const status = item ? item.status : 'tidak_ada';
            const color = statusColors[status] || '#16a34a';
            const statusText = statusLabels[status] || 'Tidak Ada Peringatan';
            const waspada = (item && item.waspada_areas && item.waspada_areas !== '-') ? item.waspada_areas : '—';
            const siaga = (item && item.siaga_areas && item.siaga_areas !== '-') ? item.siaga_areas : '—';
            const awas = (item && item.awas_areas && item.awas_areas !== '-') ? item.awas_areas : '—';
            const desc = item && item.description ? item.description : '';

            layer.bindPopup(`
                <div style="font-family:'Plus Jakarta Sans',system-ui,-apple-system,sans-serif; min-width:200px; font-size:12px;">
                    <div style="font-size:13px; font-weight:800; color:#102b4e; margin-bottom:4px;">Kabupaten ${districtName}</div>
                    <div style="margin-bottom:8px;">
                        <span style="display:inline-block; padding:3px 9px; border-radius:12px; background:${color}; color:#fff; font-weight:800; font-size:11px;">
                            ${statusText}
                        </span>
                    </div>
                    <div style="font-size:11px; line-height:1.5; color:#475569;">
                        <div><strong>Waspada:</strong> ${waspada}</div>
                        <div><strong>Siaga:</strong> ${siaga}</div>
                        <div><strong>Awas:</strong> ${awas}</div>
                        ${desc ? `<div style="margin-top:6px; font-style:italic; color:#64748b;">${desc}</div>` : ''}
                    </div>
                </div>
            `);
        });
    };

    subnavButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            subnavButtons.forEach(b => b.classList.remove('is-active'));
            btn.classList.add('is-active');
            currentSubCategory = btn.dataset.sub;
            updateTable();
            updatePeringatanMapStyles();
        });
    });

    // Initialize Leaflet Map 1: Peringatan Dini
    const initPeringatanMap = () => {
        const el = document.getElementById('leaflet-peringatan-map');
        if (!el || typeof L === 'undefined') return;
        if (peringatanMap) return;

        peringatanMap = L.map('leaflet-peringatan-map', {
            center: [-7.0, 139.5],
            zoom: 7,
            minZoom: 6,
            maxZoom: 12,
            scrollWheelZoom: false
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(peringatanMap);

        if (geojsonData) {
            peringatanGeojsonLayer = L.geoJSON(geojsonData, {
                style: (feature) => {
                    return getDistrictStyle(feature?.properties?.district);
                },
                onEachFeature: (feature, layer) => {
                    layer.on({
                        mouseover: (e) => {
                            const l = e.target;
                            l.setStyle({ weight: 3, color: '#002b49', fillOpacity: 0.92 });
                            if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                l.bringToFront();
                            }
                        },
                        mouseout: (e) => {
                            const l = e.target;
                            l.setStyle(getDistrictStyle(l.feature?.properties?.district));
                        }
                    });
                }
            }).addTo(peringatanMap);

            peringatanMap.on('popupclose', () => {
                updatePeringatanMapStyles();
            });

            peringatanMap.setView([-7.0, 139.5], 7);
            updatePeringatanMapStyles();
        }

        setTimeout(() => {
            if (peringatanMap) {
                peringatanMap.invalidateSize();
                peringatanMap.setView([-7.0, 139.5], 7);
            }
        }, 150);
    };

    // Initialize Leaflet Map 2: Distribusi HTH
    const initHthMap = () => {
        const el = document.getElementById('leaflet-hth-map');
        if (!el || typeof L === 'undefined') return;
        if (hthMap) return;

        hthMap = L.map('leaflet-hth-map', {
            center: [-7.0, 139.5],
            zoom: 7,
            minZoom: 6,
            maxZoom: 12,
            scrollWheelZoom: false
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(hthMap);

        if (geojsonData) {
            L.geoJSON(geojsonData, {
                style: {
                    fillColor: '#f1f5f9',
                    fillOpacity: 0.35,
                    color: '#94a3b8',
                    weight: 1.5,
                    dashArray: '3, 3'
                }
            }).addTo(hthMap);
        }

        // Add observation station markers
        hthStations.forEach(st => {
            const lat = Number(st.latitude);
            const lng = Number(st.longitude);
            if (isNaN(lat) || isNaN(lng)) return;

            const color = st.color || '#22c55e';
            const marker = L.circleMarker([lat, lng], {
                radius: 7.5,
                fillColor: color,
                color: '#ffffff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.92
            }).addTo(hthMap);

            marker.bindPopup(`
                <div style="font-family:'Plus Jakarta Sans',system-ui,-apple-system,sans-serif; min-width:180px; font-size:12px;">
                    <div style="font-size:13px; font-weight:800; color:#102b4e; margin-bottom:2px;">${st.station_name}</div>
                    <div style="color:#64748b; font-size:11px; margin-bottom:8px;">Kab. ${st.district}${st.subdistrict ? ' · Distrik ' + st.subdistrict : ''}</div>
                    <div style="margin-bottom:8px;">
                        <span style="display:inline-block; padding:3px 9px; border-radius:12px; background:${color}22; color:${color}; border:1px solid ${color}55; font-weight:800; font-size:11px;">
                            ${st.days} Hari Tanpa Hujan
                        </span>
                    </div>
                    <div style="font-size:11px; color:#334155; margin-bottom:4px;">Klasifikasi: <strong>${st.classification}</strong></div>
                    <div style="font-size:10px; color:#94a3b8;">Koordinat: ${lat.toFixed(4)}, ${lng.toFixed(4)}</div>
                    ${st.updated_date ? `<div style="font-size:10px; color:#94a3b8;">Update: ${st.updated_date.slice(0, 10)}</div>` : ''}
                </div>
            `);
        });

        // Set default provincial overview zoom level 7
        hthMap.setView([-7.0, 139.5], 7);

        setTimeout(() => {
            if (hthMap) {
                hthMap.invalidateSize();
                hthMap.setView([-7.0, 139.5], 7);
            }
        }, 150);
    };

    // Populate table immediately
    updateTable();

    // Initialize maps when Leaflet is available
    const tryInitMaps = () => {
        if (typeof L !== 'undefined') {
            initPeringatanMap();
            initHthMap();
            return true;
        }
        return false;
    };

    if (!tryInitMaps()) {
        let attempts = 0;
        const interval = setInterval(() => {
            attempts++;
            if (tryInitMaps() || attempts > 40) {
                clearInterval(interval);
            }
        }, 100);
    }

    window.addEventListener('load', () => {
        tryInitMaps();
        if (peringatanMap) peringatanMap.invalidateSize();
        if (hthMap) hthMap.invalidateSize();
    });

    // Dasarian Climate Image Carousel (Auto-slide, pause on hover, pills & dots)
    (() => {
        const track = document.getElementById('dasarianTrack');
        if (!track) return;

        const slides = Array.from(track.querySelectorAll('.dasarian-slide'));
        const dots = Array.from(document.querySelectorAll('.dasarian-dot'));
        const pills = Array.from(document.querySelectorAll('.dasarian-pill-btn'));
        const prevBtn = document.getElementById('dasarianPrevBtn');
        const nextBtn = document.getElementById('dasarianNextBtn');
        const progressBar = document.getElementById('dasarianProgressBar');
        const container = document.getElementById('dasarianCarousel');

        if (slides.length <= 1) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }

        let currentIndex = 0;
        const totalSlides = slides.length;
        const INTERVAL = 5000;
        let startTime = performance.now();
        let isPaused = false;

        const updateSlider = (index) => {
            currentIndex = (index + totalSlides) % totalSlides;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            dots.forEach((dot, idx) => {
                dot.classList.toggle('is-active', idx === currentIndex);
            });

            pills.forEach((pill, idx) => {
                pill.classList.toggle('is-active', idx === currentIndex);
            });

            startTime = performance.now();
        };

        if (prevBtn) {
            prevBtn.addEventListener('click', () => updateSlider(currentIndex - 1));
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => updateSlider(currentIndex + 1));
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => updateSlider(idx));
        });

        pills.forEach((pill, idx) => {
            pill.addEventListener('click', () => updateSlider(idx));
        });

        if (container) {
            container.addEventListener('mouseenter', () => { isPaused = true; });
            container.addEventListener('mouseleave', () => { isPaused = false; startTime = performance.now(); });
        }

        const step = (now) => {
            if (!isPaused) {
                const elapsed = now - startTime;
                const pct = Math.min(100, (elapsed / INTERVAL) * 100);
                if (progressBar) progressBar.style.width = `${pct}%`;

                if (elapsed >= INTERVAL) {
                    updateSlider(currentIndex + 1);
                }
            }
            requestAnimationFrame(step);
        };
        requestAnimationFrame(step);

        window.openDasarianLightbox = (src, title, period) => {
            const modal = document.getElementById('dasarianLightboxModal');
            const modalImg = document.getElementById('dasarianModalImg');
            const modalTitle = document.getElementById('dasarianModalTitle');
            const modalPeriod = document.getElementById('dasarianModalPeriod');
            const modalDownload = document.getElementById('dasarianModalDownload');

            if (!modal) return;
            modalImg.src = src;
            modalTitle.textContent = title;
            modalPeriod.textContent = period;
            modalDownload.href = src;
            modalDownload.setAttribute('download', title);
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        };

        window.closeDasarianLightbox = () => {
            const modal = document.getElementById('dasarianLightboxModal');
            if (!modal) return;
            modal.style.display = 'none';
            document.body.style.overflow = '';
        };

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDasarianLightbox();
            if (e.key === 'ArrowLeft' && !document.getElementById('dasarianLightboxModal')?.style.display.includes('flex')) {
                updateSlider(currentIndex - 1);
            }
            if (e.key === 'ArrowRight' && !document.getElementById('dasarianLightboxModal')?.style.display.includes('flex')) {
                updateSlider(currentIndex + 1);
            }
        });
    })();

    // Toggle Expand/Collapse HTH Observation Table
    window.toggleHthTable = () => {
        const btnText = document.getElementById('toggle-hth-text');
        const btnIcon = document.getElementById('toggle-hth-icon');
        
        const isExpanded = btnText.getAttribute('data-expanded') === 'true';

        if (isExpanded) {
            // Collapse back to 5
            document.querySelectorAll('.hth-row').forEach((row, idx) => {
                if (idx >= 5) {
                    row.style.display = 'none';
                    row.classList.add('hth-row-hidden');
                }
            });
            btnText.textContent = 'Lihat Seluruh Pos Pengamatan';
            btnText.setAttribute('data-expanded', 'false');
            if (btnIcon) btnIcon.style.transform = 'rotate(0deg)';
        } else {
            // Expand to show all
            document.querySelectorAll('.hth-row').forEach(row => {
                row.style.display = '';
                row.classList.remove('hth-row-hidden');
            });
            btnText.textContent = 'Tampilkan Lebih Sedikit';
            btnText.setAttribute('data-expanded', 'true');
            if (btnIcon) btnIcon.style.transform = 'rotate(180deg)';
        }
    };
})();
</script>
@endif

@if($page === 'contact')
<script>
(() => {
    // FAQ Accordion Toggle
    window.toggleFaq = (button) => {
        const card = button.closest('.faq-card');
        const isOpen = card.classList.contains('is-open');
        document.querySelectorAll('.faq-card').forEach(c => c.classList.remove('is-open'));
        if (!isOpen) {
            card.classList.add('is-open');
        }
    };

    // Initialize Station Map in Contact Page
    const initContactMap = () => {
        const mapEl = document.getElementById('contact-station-map');
        if (!mapEl || typeof L === 'undefined') return;

        const stationCoords = [-8.3820, 140.4510]; // Distrik Tanah Miring, Merauke (Staklim Papua Selatan)
        const contactMap = L.map('contact-station-map', {
            center: stationCoords,
            zoom: 13,
            scrollWheelZoom: false
        });

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(contactMap);

        // Marker with custom styling
        const marker = L.circleMarker(stationCoords, {
            radius: 9,
            fillColor: '#0284c7',
            color: '#ffffff',
            weight: 3,
            opacity: 1,
            fillOpacity: 1
        }).addTo(contactMap);

        marker.bindPopup(`
            <div style="font-family:'Plus Jakarta Sans',system-ui,sans-serif; min-width:180px; font-size:12px;">
                <div style="font-size:13px; font-weight:800; color:#002b49; margin-bottom:4px;">Stasiun Klimatologi Papua Selatan</div>
                <div style="color:#64748b; font-size:11px; margin-bottom:8px;">Distrik Tanah Miring, Kabupaten Merauke</div>
                <a href="https://maps.google.com/?q=Stasiun+Klimatologi+Papua+Selatan+Tanah+Miring+Merauke" target="_blank" rel="noopener" style="display:inline-block; font-size:10.5px; font-weight:800; color:#fff; background:#0284c7; padding:4px 10px; border-radius:6px; text-decoration:none;">Buka Google Maps &rarr;</a>
            </div>
        `).openPopup();

        setTimeout(() => {
            contactMap.invalidateSize();
        }, 150);
    };

    // Handle Contact Message Form Submit
    window.handleContactSubmit = () => {
        const name = document.getElementById('contact_name').value.trim();
        const info = document.getElementById('contact_info').value.trim();
        const category = document.getElementById('contact_category').value;
        const body = document.getElementById('contact_body').value.trim();
        const feedback = document.getElementById('contact-feedback');

        if (!name || !info || !category || !body) return;

        feedback.style.display = 'block';
        feedback.style.background = '#dcfce7';
        feedback.style.color = '#15803d';
        feedback.style.border = '1px solid #86efac';
        feedback.innerHTML = `<strong>Terima kasih, ${name}!</strong> Pesan Anda perihal "${category}" sedang disiapkan untuk dikirim ke WhatsApp petugas BMKG.`;

        const waText = `Halo BMKG Stasiun Klimatologi Papua Selatan,%0A%0A*Nama:* ${encodeURIComponent(name)}%0A*Kontak:* ${encodeURIComponent(info)}%0A*Kategori:* ${encodeURIComponent(category)}%0A*Pesan:*%0A${encodeURIComponent(body)}`;
        
        setTimeout(() => {
            window.open(`https://wa.me/628114908182?text=${waText}`, '_blank');
        }, 1200);
    };

    if (typeof L !== 'undefined') {
        initContactMap();
    } else {
        window.addEventListener('load', initContactMap);
    }
})();
</script>
@endif
</body>
</html>
