<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SILING MALARIA | Papua Selatan</title>
    <style>
        :root{--ink:#172d3d;--muted:#6e8190;--line:#e3eaf0;--paper:#f4f7f8;--green:#16845c;--amber:#e3a51a;--red:#cf5141;--blue:#147e85}*{box-sizing:border-box}body{margin:0;background:var(--paper);font:14px/1.5 Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;color:var(--ink)}button,input,select{font:inherit}.topbar{height:76px;background:#fff;border-bottom:1px solid var(--line);display:flex;align-items:center;padding:0 clamp(18px,5vw,72px);gap:14px}.brandmark{width:54px;height:54px;object-fit:contain;flex:none}.brand h1{font-size:15px;line-height:1.2;margin:0;font-weight:800;letter-spacing:.01em}.brand p{font-size:11px;color:var(--muted);margin:4px 0 0}.topright{margin-left:auto;display:flex;align-items:center;gap:10px}.live{display:inline-flex;gap:7px;align-items:center;color:#267353;font-size:12px;font-weight:700}.dot{width:8px;height:8px;border-radius:50%;background:#30a66f;box-shadow:0 0 0 4px #e5f5eb}.wrap{width:min(1260px,calc(100% - 36px));margin:27px auto 50px}.hero{display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-bottom:20px}.eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:.14em;color:var(--blue);font-weight:800}.hero h2{font-size:clamp(30px,4vw,40px);line-height:1.12;margin:5px 0 7px;letter-spacing:-.035em}.hero p{font-size:clamp(13px,1.25vw,15px);line-height:1.5;color:var(--muted);margin:0}.period{background:#fff;border:1px solid var(--line);padding:10px 13px;border-radius:12px;color:#506575;font-size:12px;white-space:nowrap}.stats{display:grid;grid-template-columns:repeat(4,1fr);gap:13px;margin-bottom:15px}.card,.panel{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 4px 16px #17334708}.stat{padding:17px 18px;position:relative;overflow:hidden}.stat:after{content:"";position:absolute;width:54px;height:54px;border-radius:50%;right:12px;top:12px;background:#edf6f4}.stat.warn:after{background:#fff5dc}.stat.alert:after{background:#fff0ed}.stat-label{font-size:12px;color:var(--muted);font-weight:600}.stat-value{font-size:27px;line-height:1.2;font-weight:800;letter-spacing:-.04em;margin-top:5px}.stat-note{font-size:11px;color:var(--muted);margin-top:4px}.stat-icon{position:absolute;right:29px;top:23px;color:#267d69;font-weight:900;font-size:18px;z-index:1}.warn .stat-icon{color:#b57b00}.alert .stat-icon{color:#c64b3d}.content-grid{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(300px,.8fr);gap:15px}.panel{padding:19px}.panel-heading{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:14px}.panel-heading h3{font-size:15px;margin:0;font-weight:800}.panel-heading p{font-size:11px;color:var(--muted);margin:4px 0 0}.map-shell{background:#f5f8f6;border:1px solid #e6ece9;border-radius:13px;min-height:390px;overflow:hidden;position:relative}.map-shell svg{width:100%;height:390px;display:block}.map-bg{fill:#edf3f0}.province{fill:#e4e9e8;stroke:#aebdba;stroke-width:2}.district{stroke:#fff;stroke-width:3;stroke-linejoin:round;cursor:pointer;transition:filter .2s,fill .2s}.district:hover{filter:brightness(.94)}.district-label{fill:#183342;font-size:13px;font-weight:700;text-anchor:middle;pointer-events:none}.district-value{fill:#375464;font-size:11px;font-weight:600;text-anchor:middle;pointer-events:none}.map-legend{position:absolute;left:13px;bottom:13px;background:#ffffffed;border:1px solid var(--line);border-radius:10px;padding:10px 12px;box-shadow:0 3px 12px #193a3210}.map-legend strong{display:block;font-size:10px;margin-bottom:7px}.legend-row{display:flex;align-items:center;gap:7px;font-size:10px;color:#526775;margin:4px 0}.swatch{width:11px;height:11px;border-radius:3px}.map-note{position:absolute;right:12px;bottom:12px;color:#7a8992;font-size:9px;background:#ffffffd9;padding:5px 7px;border-radius:7px}.side-list{display:grid;gap:8px}.district-row{display:grid;grid-template-columns:9px minmax(0,1fr) auto;align-items:center;gap:10px;padding:10px 11px;border:1px solid #edf0f2;border-radius:10px}.row-dot{width:9px;height:9px;border-radius:50%}.district-name{font-weight:700;font-size:12px}.district-sub{font-size:10px;color:var(--muted);margin-top:2px}.district-ai{font-weight:800;font-size:13px}.badge{display:inline-flex;align-items:center;gap:5px;font-size:9px;font-weight:800;padding:3px 7px;border-radius:20px;margin-top:4px}.safe{color:#16734e;background:#e5f6eb}.caution{color:#956400;background:#fff3ce}.danger{color:#a83b30;background:#ffe8e3}.bottom-grid{display:grid;grid-template-columns:1fr 1fr;gap:15px;margin-top:15px}.rec-card{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}.rec{border-radius:12px;padding:13px 14px;border:1px solid transparent}.rec h4{font-size:12px;letter-spacing:.12em;margin:0 0 5px}.rec p{font-size:10px;margin:0 0 8px;opacity:.82}.rec ul{margin:0;padding-left:15px;font-size:10px;line-height:1.6}.rec.green{background:#e8f6ed;border-color:#d6eddc}.rec.yellow{background:#fff5d8;border-color:#f5e8b8}.rec.red{background:#ffebe7;border-color:#f6d6d0}.admin-head{display:flex;justify-content:space-between;align-items:center;margin-bottom:14px}.admin-head h3{font-size:15px;margin:0}.admin-head span{font-size:10px;color:var(--muted)}.form-row{display:grid;grid-template-columns:1.1fr 1fr auto;gap:9px;align-items:end}.field label{display:block;font-size:10px;font-weight:700;color:#627581;margin:0 0 5px}.field input,.field select{width:100%;height:39px;border:1px solid #dce5e8;border-radius:9px;background:white;padding:0 10px;color:var(--ink);outline:none}.field input:focus,.field select:focus{border-color:#168a83;box-shadow:0 0 0 3px #168a831a}.btn{border:0;border-radius:9px;background:#087e79;color:white;font-weight:700;padding:0 14px;height:39px;cursor:pointer;white-space:nowrap}.btn:hover{background:#086e68}.data-table{width:100%;border-collapse:collapse;margin-top:13px}.data-table th{text-align:left;font-size:9px;color:#82919a;text-transform:uppercase;letter-spacing:.07em;padding:8px 7px;border-bottom:1px solid var(--line)}.data-table td{font-size:11px;padding:9px 7px;border-bottom:1px solid #f0f3f4}.data-table tr:last-child td{border-bottom:0}.number-cell{font-weight:800}.delete-btn{border:0;background:#fff0ed;color:#b1483b;border-radius:6px;padding:4px 7px;font-size:10px;cursor:pointer}.flash{padding:9px 12px;border-radius:9px;background:#e8f6ed;color:#216d4b;font-size:11px;margin-bottom:12px}.error{color:#b33d32;font-size:10px;margin-top:4px}.footer{display:flex;justify-content:space-between;gap:12px;color:#82919a;font-size:10px;padding:15px 3px}.empty{padding:18px;text-align:center;color:var(--muted);font-size:11px}.mobile-note{display:none}
        @media(max-width:900px){.stats{grid-template-columns:repeat(2,1fr)}.content-grid,.bottom-grid{grid-template-columns:1fr}.map-shell,.map-shell svg{min-height:340px;height:340px}.rec-card{grid-template-columns:1fr 1fr 1fr}}
        @media(max-width:560px){.topbar{height:65px;padding:0 17px}.brand h1{font-size:12px}.brand p{font-size:9px}.wrap{width:calc(100% - 24px);margin-top:19px}.hero{display:block}.hero h2{font-size:26px;line-height:1.12}.hero p{font-size:13px}.period{display:inline-block;margin-top:12px}.stats{gap:8px}.stat{padding:13px}.stat-value{font-size:23px}.stat-icon{right:22px;top:18px}.panel{padding:14px}.map-shell,.map-shell svg{min-height:290px;height:290px}.map-shell svg{min-width:620px;transform:translateX(-56px)}.map-shell{overflow:hidden}.form-row{grid-template-columns:1fr 1fr}.form-row .btn{grid-column:1/-1}.rec-card{grid-template-columns:1fr}.footer{display:block;line-height:1.7}.mobile-note{display:block;color:#82919a;font-size:9px;margin-top:4px}}
    </style>
    <style>@media(max-width:560px){.map-shell svg{min-width:0;transform:none}}.map-popup{display:none;position:absolute;z-index:5;width:min(230px,calc(100% - 24px));padding:13px 15px;border-radius:11px;background:#fff;border:1px solid #dce5e8;box-shadow:0 12px 30px #17334724;color:#172d3d}.map-popup.is-visible{display:block}.map-popup-title{font-size:13px;font-weight:800;margin:0 25px 7px 0}.map-popup-detail{font-size:11px;color:#586d79;margin:4px 0}.map-popup-status{font-weight:800}.map-popup-close{position:absolute;right:8px;top:7px;border:0;background:#eef3f3;color:#526775;border-radius:50%;width:23px;height:23px;cursor:pointer;font-size:15px;line-height:1}.district:focus{outline:none;filter:brightness(.94);stroke:#172d3d;stroke-width:2}</style>
    <style>
        .stat-icon{display:flex;width:24px;height:24px;align-items:center;justify-content:center;right:27px;top:27px}.stat-icon svg{display:block;width:20px;height:20px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
        @media(max-width:560px){
            .topbar{height:auto;min-height:68px;padding:9px 14px;gap:8px 11px;flex-wrap:nowrap}
            .brandmark{width:46px;height:46px}
            .brand{min-width:0;flex:1}
            .brand h1{font-size:11px;line-height:1.25}
            .brand p{font-size:9px;line-height:1.3}
            .topright{width:auto;flex:none;margin:0 0 0 auto;justify-content:flex-end;gap:8px}
            .topright .live{display:none}
            .topright .period{font-size:10px;padding:8px 9px;margin:0}
            .wrap{width:calc(100% - 24px);margin:17px auto 28px}
            .hero{display:flex;flex-direction:column;align-items:stretch;gap:12px;margin-bottom:14px}
            .hero h2{font-size:24px;max-width:18ch}
            .hero p{font-size:12px}
            .hero .period{width:100%;display:flex;align-items:center;justify-content:space-between;margin:0;padding:9px 11px}
            .hero .period select{max-width:70%;font-size:12px}
            .stats{gap:8px;margin-bottom:10px}
            .stat{min-width:0;padding:12px 11px;border-radius:12px}
            .stat-label{font-size:10px;max-width:calc(100% - 30px)}
            .stat-value{font-size:22px}
            .stat-note{font-size:9px;line-height:1.3}
            .stat-icon{right:27px;top:27px;font-size:15px}
            .content-grid{gap:10px}
            .panel{padding:13px;border-radius:13px}
            .panel-heading{gap:7px;margin-bottom:10px}
            .panel-heading h3{font-size:14px}
            .panel-heading p{font-size:10px}
            .map-shell{min-height:270px;height:270px;border-radius:11px}
            .map-shell svg{width:100%;height:270px;min-width:0;transform:none}
            .map-legend{left:8px;bottom:8px;padding:7px 9px;border-radius:8px}
            .map-legend strong,.legend-row{font-size:9px}
            .map-note{display:none}
            .map-popup{width:min(215px,calc(100% - 16px));padding:11px 12px}
            .district-row{padding:9px;gap:8px}
            .district-name{font-size:11px}
            .district-ai{font-size:12px}
            .rec-card{grid-template-columns:1fr;gap:8px}
            .rec{padding:12px}
            .rec h4{font-size:11px}
            .rec p,.rec ul{font-size:10px}
            .footer{font-size:9px;padding:12px 2px}
        }
        @media(max-width:360px){
            .wrap{width:calc(100% - 18px)}
            .brand h1{font-size:10px}
            .topright{width:auto;margin-left:auto}
            .stats{grid-template-columns:1fr 1fr}
            .map-shell,.map-shell svg{height:245px;min-height:245px}
            .map-legend{transform:scale(.92);transform-origin:bottom left}
        }
        @media(max-width:560px){
            .map-shell{height:auto;min-height:0;display:flex;flex-direction:column;align-items:stretch;overflow:visible}
            .map-shell svg{flex:none}
            .map-legend{position:static;transform:none;width:max-content;max-width:100%;margin:0 8px 8px}
            .map-note,.mobile-note{display:none}
            .footer span{display:block;margin-bottom:4px}
        }
        .trend-panel{margin-top:15px}.trend-scroll{overflow-x:auto}.trend-chart{display:block;width:100%;min-width:680px;height:auto}.trend-select{border:1px solid var(--line);border-radius:9px;background:#fff;color:var(--ink);font-size:11px;padding:8px 10px;max-width:190px}.trend-grid{stroke:#e8eef0;stroke-width:1}.trend-axis{fill:#758893;font-size:11px}.trend-line{fill:none;stroke-width:2.5;stroke-linecap:round;stroke-linejoin:round}.trend-dot{stroke:#fff;stroke-width:1.5}.trend-legend{display:flex;flex-wrap:wrap;gap:10px 18px;margin:9px 2px 0}.trend-key{display:inline-flex;align-items:center;gap:7px;font-size:11px;color:#526775}.trend-key i{width:9px;height:9px;border-radius:50%}.trend-note{font-size:10px;color:#82919a;margin:8px 2px 0}@media(max-width:560px){.trend-panel{padding:13px}.trend-chart{min-width:620px}.trend-key{font-size:10px}.trend-select{max-width:150px}}
        .hero-tools{display:flex;flex-direction:row;align-items:center;justify-content:flex-end;gap:14px}.hero-partners{display:flex;align-items:center;gap:12px}.hero-partners>span{font-size:10px;color:var(--muted);white-space:nowrap}.partner-logos{display:flex;align-items:center;gap:12px}.partner-logos img{display:block;width:auto;height:43px;max-width:108px;object-fit:contain;background:transparent}.partner-logos .partner-bmkg{height:47px;max-width:56px}.partner-logos .partner-province{height:52px;max-width:45px}.partner-logos .partner-kemenkes{height:43px;max-width:43px}.hero-tools>.period{margin:0}@media(max-width:900px){.hero{align-items:stretch;flex-direction:column;gap:10px}.hero-tools{gap:8px}.partner-logos{gap:8px}.partner-logos img{height:36px;max-width:92px}.partner-logos .partner-bmkg{height:40px;max-width:48px}.partner-logos .partner-province{height:43px;max-width:38px}.partner-logos .partner-kemenkes{height:38px;max-width:38px}}@media(max-width:560px){.hero{align-items:stretch}.hero-tools{align-items:center;justify-content:space-between;margin-top:0;gap:8px}.hero-partners{justify-content:space-between;gap:8px}.hero-partners>span{font-size:9px}.partner-logos{gap:12px}.partner-logos img{height:34px;max-width:90px}.partner-logos .partner-bmkg{height:38px;max-width:43px}.partner-logos .partner-province{height:40px;max-width:33px}.partner-logos .partner-kemenkes{height:34px;max-width:34px}.hero-tools>.period{width:auto;display:flex;align-items:center;justify-content:space-between;padding:7px 9px}}@media(max-width:390px){.hero-tools{flex-wrap:wrap}.hero-partners{width:100%;justify-content:flex-end}.hero-tools>.period{width:100%;padding:9px 11px}}
        .content-grid.maps-grid{grid-template-columns:repeat(2,minmax(0,1fr))}.climate-legend{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:2px 8px}.climate-legend .legend-row{font-size:9px}.map-shell .map-popup{position:absolute}.climate-map-note{font-size:10px;color:var(--muted);margin:8px 2px 0}.climate-empty{font-size:10px;color:var(--muted)}@media(max-width:900px){.content-grid.maps-grid{grid-template-columns:1fr}}
    </style>
</head>
<body>
<header class="topbar">
    <img class="brandmark" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG"><div class="brand"><h1>STASIUN KLIMATOLOGI PAPUA SELATAN</h1><p>SILING MALARIA · PERINGATAN DINI BERBASIS DATA IKLIM</p></div>
    <div class="topright"><span class="live"><i class="dot"></i> Data tersimpan</span><a href="{{ route('admin') }}" class="period" style="text-decoration:none;color:var(--ink);font-weight:700">Panel admin ↗</a></div>
</header>
<main class="wrap">
    <section class="hero"><div><div class="eyebrow">Informasi iklim untuk kesehatan</div><h2>SILING MALARIA</h2><p>Peringatan Dini Malaria Berbasis Data Iklim</p></div><div class="hero-tools"><div class="hero-partners"><span>Hasil kolaborasi dari:</span><div class="partner-logos" aria-label="BMKG, Dinas Kesehatan Papua Selatan, dan Pemerintah Provinsi Papua Selatan"><img class="partner-bmkg" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG"><img class="partner-kemenkes" src="https://upload.wikimedia.org/wikipedia/commons/8/89/Logo_Kementerian_Kesehatan_Republik_Indonesia_%282024_rev%29.svg" alt="Logo Kementerian Kesehatan"><img class="partner-province" src="https://papuaselatan.go.id/static/profile/img/LOGO_PPS_NEW.png" alt="Logo Provinsi Papua Selatan"></div></div><form method="get" class="period">Bulan <select name="period" onchange="this.form.submit()" aria-label="Pilih bulan dan tahun" style="border:0;background:transparent;color:var(--ink);font-weight:800;cursor:pointer;max-width:190px">@foreach($periodOptions as $key => $label)<option value="{{ $key }}" @selected($period === $key)>{{ $label }}</option>@endforeach</select></form></div></section>
    @php
        $total = $records->count(); $mean = $total ? $records->avg('incidence') : 0;
        $safeCount = $records->filter(fn($r) => $r->incidence < 3)->count();
        $cautionCount = $records->filter(fn($r) => $r->incidence >= 3 && $r->incidence < 10)->count();
        $alertCount = $records->filter(fn($r) => $r->incidence >= 10)->count();
        $statusText = fn($value) => $value < 3 ? 'Aman' : ($value < 10 ? 'Waspada' : 'Awas');
        $statusClass = fn($value) => $value < 3 ? 'safe' : ($value < 10 ? 'caution' : 'danger');
        $statusColor = fn($value) => $value < 3 ? '#269467' : ($value < 10 ? '#e5ad24' : '#ce5142');
        $districts = ['Asmat','Boven Digoel','Mappi','Merauke'];
        $byName = $records->keyBy('district');
        $climateByName = $climateSuitabilities->keyBy('district');
    @endphp
    <section class="stats">
        <article class="card stat"><div class="stat-label">Kabupaten terpantau</div><div class="stat-value">{{ $total }}<span style="font-size:14px;color:#7a8b95;font-weight:600"> / 4</span></div><div class="stat-note">Data untuk periode terpilih</div><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/></svg></span></article>
        <article class="card stat"><div class="stat-label">Rerata angka insiden</div><div class="stat-value">{{ number_format($mean, 2, ',', '.') }}</div><div class="stat-note">Per 100.000 penduduk</div><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 17 9 11l4 4 8-9"/><path d="M15 6h6v6"/></svg></span></article>
        <article class="card stat warn"><div class="stat-label">Kabupaten waspada</div><div class="stat-value">{{ $cautionCount }}</div><div class="stat-note">AI 3 hingga kurang dari 10</div><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="m12 3 10 18H2L12 3Z"/><path d="M12 9v5m0 3h.01"/></svg></span></article>
        <article class="card stat alert"><div class="stat-label">Kabupaten status awas</div><div class="stat-value">{{ $alertCount }}</div><div class="stat-note">AI 10 atau lebih</div><span class="stat-icon" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M7 17 17 7m-9 0h9v9"/></svg></span></article>
    </section>
    <section class="content-grid maps-grid">
        <article class="panel">
            <div class="panel-heading"><div><h3>Prediksi Angka Insiden Malaria</h3><p>Angka insiden malaria per kabupaten · {{ $periodLabel }}</p></div><span class="badge safe">{{ $safeCount }} aman</span></div>
            <div class="map-shell">
                <svg id="incidence-map" viewBox="0 0 520 500" role="img" aria-label="Peta batas administrasi kabupaten Papua Selatan"></svg>
                <div id="map-popup" class="map-popup" role="status" aria-live="polite"><button type="button" class="map-popup-close" aria-label="Tutup informasi">×</button><div class="map-popup-title"></div><div class="map-popup-detail popup-period"></div><div class="map-popup-detail popup-incidence"></div><div class="map-popup-detail popup-status"></div></div>
                <div class="map-legend"><strong>Status peringatan dini</strong><div class="legend-row"><i class="swatch" style="background:#269467"></i>Aman · AI &lt; 3</div><div class="legend-row"><i class="swatch" style="background:#e5ad24"></i>Waspada · 3 ≤ AI &lt; 10</div><div class="legend-row"><i class="swatch" style="background:#ce5142"></i>Awas · AI ≥ 10</div></div>
                <div class="map-note">Batas kabupaten · BIG 2026</div>
            </div>
            <div class="mobile-note">Geser peta ke samping untuk melihat seluruh wilayah.</div>
        </article>
        <article class="panel">
            <div class="panel-heading"><div><h3>Prediksi Kesesuaian Iklim untuk Malaria</h3><p>Probabilitas kecocokan · {{ $periodLabel }}</p></div></div>
            <div class="map-shell climate-map-shell">
                <svg id="climate-map" viewBox="0 0 520 500" role="img" aria-label="Peta probabilitas kesesuaian iklim untuk malaria di Papua Selatan"></svg>
                <div id="climate-map-popup" class="map-popup" role="status" aria-live="polite"><button type="button" class="map-popup-close" aria-label="Tutup informasi">×</button><div class="map-popup-title"></div><div class="map-popup-detail popup-period"></div><div class="map-popup-detail popup-probability"></div><div class="map-popup-detail popup-humidity"></div><div class="map-popup-detail popup-status"></div></div>
                <div class="map-legend climate-legend"><strong style="grid-column:1/-1">Probabilitas kesesuaian</strong><div class="legend-row"><i class="swatch" style="background:#b52320"></i>&gt;90%</div><div class="legend-row"><i class="swatch" style="background:#e1441c"></i>80–90%</div><div class="legend-row"><i class="swatch" style="background:#f27a18"></i>70–80%</div><div class="legend-row"><i class="swatch" style="background:#f5bd00"></i>60–70%</div><div class="legend-row"><i class="swatch" style="background:#f4e500"></i>50–60%</div><div class="legend-row"><i class="swatch" style="background:#8fe45e"></i>40–50%</div><div class="legend-row"><i class="swatch" style="background:#12d7d2"></i>30–40%</div><div class="legend-row"><i class="swatch" style="background:#2a9af0"></i>20–30%</div><div class="legend-row"><i class="swatch" style="background:#2935df"></i>10–20%</div><div class="legend-row"><i class="swatch" style="background:#fff;border:1px solid #dce5e8"></i>&lt;10%</div></div>
                <div class="map-note">Batas kabupaten · BIG 2026</div>
            </div>
            <p class="climate-map-note">Nilai kesesuaian diinput dari produk prediksi iklim melalui panel admin. Peta tidak menghitung prediksi secara otomatis.</p>
        </article>
    </section>
    <section class="panel" style="margin-top:15px">
        <article class="panel"><div class="panel-heading"><div><h3>Rekomendasi tindak lanjut</h3><p>Sesuaikan dengan pedoman dan kondisi setempat</p></div></div><div class="rec-card">
            <div class="rec green"><h4>AMAN</h4><p>Angka insiden &lt; 3</p><ul><li>Penyelidikan epidemiologi</li><li>Penyuluhan dan PSN</li><li>Larvasidasi selektif</li></ul></div>
            <div class="rec yellow"><h4>WASPADA</h4><p>Angka insiden 3–&lt;10</p><ul><li>Penyelidikan epidemiologi</li><li>Intensifikasi PSN</li><li>Larvasidasi selektif</li></ul></div>
            <div class="rec red"><h4>AWAS</h4><p>Angka insiden ≥ 10</p><ul><li>Penyelidikan epidemiologi</li><li>Koordinasi respons cepat</li><li>Pengendalian vektor terarah</li></ul></div>
        </div></article>
    </section>
    <section class="panel trend-panel">
        <div class="panel-heading"><div><h3>Tren malaria dan iklim bulanan</h3><p>Data per kabupaten · 2021–2026</p></div><select id="trend-metric" class="trend-select" aria-label="Pilih indikator grafik"><option value="cases">Jumlah kasus</option><option value="humidity">Kelembapan (%)</option><option value="temperature">Suhu (°C)</option><option value="rainfall">Curah hujan (mm)</option></select></div>
        <div class="trend-scroll"><svg id="malaria-trend-chart" class="trend-chart" viewBox="0 0 960 360" role="img" aria-label="Grafik tren malaria dan iklim bulanan per kabupaten"></svg></div>
        <div class="trend-legend" aria-label="Legenda kabupaten"><span class="trend-key"><i style="background:#087e79"></i>Asmat</span><span class="trend-key"><i style="background:#3974c6"></i>Boven Digoel</span><span class="trend-key"><i style="background:#e2a21b"></i>Mappi</span><span class="trend-key"><i style="background:#c94f48"></i>Merauke</span></div>
        <p class="trend-note">Pilih indikator untuk melihat tren. Data dapat diperbarui melalui panel admin.</p>
    </section>
    <footer class="footer"><span>SILING MALARIA · Stasiun Klimatologi Papua Selatan</span><span>Batas administrasi: BIG 2026. Ambang AI mengikuti contoh referensi.</span></footer>
</main>
<script>
(() => {
    const svg = document.getElementById('incidence-map');
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
    const statusColor = value => value === null ? '#dce8e3' : value < 3 ? '#269467' : value < 10 ? '#e5ad24' : '#ce5142';
    const statusText = value => value === null ? 'Belum ada data' : value < 3 ? 'Aman' : value < 10 ? 'Waspada' : 'Awas';
    const showPopup = (district, value, event) => {
        popup.querySelector('.map-popup-title').textContent = district;
        popup.querySelector('.popup-period').textContent = 'Prediksi: {{ $periodLabel }}';
        popup.querySelector('.popup-incidence').textContent = value === null ? 'Angka insiden: Belum ada data' : `Angka insiden: ${value.toFixed(2)} per 100.000 penduduk`;
        const status = popup.querySelector('.popup-status');
        status.textContent = `Keterangan: ${statusText(value)}`;
        status.style.color = value === null ? '#71828d' : value < 3 ? '#16734e' : value < 10 ? '#956400' : '#a83b30';
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
    const shell = svg.closest('.map-shell');
    const popup = document.getElementById('climate-map-popup');
    const values = @json($climateByName->mapWithKeys(fn ($record) => [$record->district => ['probability' => (float) $record->probability, 'humidity' => $record->humidity === null ? null : (float) $record->humidity, 'confidence' => $record->confidence]]));
    const features = @json(json_decode(file_get_contents(public_path('data/papua-selatan-kabupaten.geojson')), true)['features']);
    const ns = 'http://www.w3.org/2000/svg';
    const make = (tag, attrs = {}) => { const node = document.createElementNS(ns, tag); Object.entries(attrs).forEach(([key, value]) => node.setAttribute(key, value)); return node; };
    const color = value => value === null ? '#dce8e3' : value > 90 ? '#b52320' : value >= 80 ? '#e1441c' : value >= 70 ? '#f27a18' : value >= 60 ? '#f5bd00' : value >= 50 ? '#f4e500' : value >= 40 ? '#8fe45e' : value >= 30 ? '#12d7d2' : value >= 20 ? '#2a9af0' : value >= 10 ? '#2935df' : '#fff';
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
</body>
</html>



