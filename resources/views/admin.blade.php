<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin SILING MALARIA | Papua Selatan</title>
    <style>
        :root{--ink:#172d3d;--muted:#71828d;--line:#e3eaf0;--paper:#f3f7f7;--teal:#087e79}*{box-sizing:border-box}body{margin:0;background:var(--paper);font:14px/1.5 Inter,system-ui,-apple-system,"Segoe UI",sans-serif;color:var(--ink)}button,input,select{font:inherit}.topbar{height:76px;background:white;border-bottom:1px solid var(--line);display:flex;align-items:center;padding:0 clamp(18px,5vw,72px);gap:14px}.mark{width:42px;height:42px;border-radius:14px;background:#e4f2ef;color:#117657;display:grid;place-items:center;font-weight:900}.brand h1{font-size:15px;margin:0;line-height:1.2}.brand p{font-size:11px;color:var(--muted);margin:4px 0 0}.nav{margin-left:auto;color:var(--teal);font-weight:700;text-decoration:none;font-size:12px}.wrap{width:min(1000px,calc(100% - 32px));margin:32px auto}.eyebrow{font-size:11px;text-transform:uppercase;letter-spacing:.14em;color:var(--teal);font-weight:800}.heading{display:flex;justify-content:space-between;align-items:flex-end;gap:15px;margin-bottom:20px}.heading h2{font-size:30px;letter-spacing:-.04em;margin:4px 0}.heading p{margin:0;color:var(--muted)}.period{background:#fff;border:1px solid var(--line);border-radius:10px;padding:9px 12px;color:#506575;font-size:12px;white-space:nowrap}.card{background:#fff;border:1px solid var(--line);border-radius:16px;box-shadow:0 4px 16px #17334708;padding:22px;margin-bottom:15px}.card h3{margin:0;font-size:16px}.sub{font-size:12px;color:var(--muted);margin:4px 0 18px}.form{display:grid;grid-template-columns:1.1fr 1fr auto;gap:12px;align-items:end}.field label{display:block;font-size:11px;font-weight:700;color:#627581;margin:0 0 6px}.field input,.field select{width:100%;height:43px;border:1px solid #dce5e8;border-radius:10px;background:white;padding:0 12px;color:var(--ink);outline:none}.field input:focus,.field select:focus{border-color:#168a83;box-shadow:0 0 0 3px #168a831a}.btn{border:0;border-radius:10px;background:var(--teal);color:white;font-weight:700;padding:0 17px;height:43px;cursor:pointer}.btn:hover{background:#086e68}.flash{padding:11px 13px;border-radius:10px;background:#e8f6ed;color:#216d4b;font-size:12px;margin-bottom:14px}.flash.error{background:#fff0ed;color:#a83b30}.table-wrap{overflow:auto}.table{width:100%;border-collapse:collapse;margin-top:8px}.table th{text-align:left;font-size:10px;color:#82919a;text-transform:uppercase;letter-spacing:.07em;padding:10px;border-bottom:1px solid var(--line)}.table td{font-size:12px;padding:13px 10px;border-bottom:1px solid #f0f3f4}.table tr:last-child td{border-bottom:0}.value{font-weight:800}.badge{display:inline-block;font-size:10px;font-weight:800;padding:4px 8px;border-radius:20px}.safe{color:#16734e;background:#e5f6eb}.caution{color:#956400;background:#fff3ce}.danger{color:#a83b30;background:#ffe8e3}.delete{border:0;background:#fff0ed;color:#b1483b;border-radius:7px;padding:6px 9px;font-size:10px;cursor:pointer}.empty{text-align:center;color:var(--muted);padding:22px}.hint{font-size:11px;color:var(--muted);margin-top:14px}.footer{font-size:10px;color:#82919a;margin:22px 2px}@media(max-width:640px){.heading{display:block}.period{display:inline-block;margin-top:13px}.heading h2{font-size:25px}.form{grid-template-columns:1fr}.btn{width:100%}.card{padding:17px}.topbar{padding:0 16px}.brand h1{font-size:12px}.brand p{font-size:9px}}
        .mark{width:54px;height:54px;object-fit:contain;flex:none;background:transparent;border-radius:0}.admin-period{display:flex;align-items:center;gap:8px}.admin-period select,.admin-period input{height:36px;border:1px solid #dce5e8;border-radius:8px;padding:0 8px;background:#fff;color:#172d3d}.admin-period .btn{height:36px;padding:0 12px;white-space:nowrap}@media(max-width:640px){.admin-period{display:flex;flex-wrap:wrap;white-space:normal}.admin-period input{width:95px}}
        @media(max-width:640px){.topbar{height:auto;min-height:68px;padding:9px 14px;gap:8px 11px;flex-wrap:wrap}.mark{width:46px;height:46px}.brand{min-width:0;flex:1}.brand h1{font-size:11px;line-height:1.25}.brand p{font-size:9px;line-height:1.3}.nav{width:calc(100% - 57px);margin:0 0 0 57px;font-size:11px}.wrap{width:calc(100% - 24px);margin:19px auto 28px}.heading{display:block;margin-bottom:14px}.heading h2{font-size:25px}.heading p{font-size:12px}.admin-period{width:100%;margin-top:12px;padding:10px;display:grid;grid-template-columns:44px minmax(0,1fr) 38px 92px;align-items:center;gap:8px;font-size:11px}.admin-period select,.admin-period input{width:100%;min-width:0;height:39px}.admin-period .btn{grid-column:1/-1;width:100%;height:40px}.card{padding:15px;border-radius:13px}.card h3{font-size:15px}.sub{font-size:11px;line-height:1.45;margin-bottom:14px}.form{grid-template-columns:1fr;gap:11px}.field label{font-size:11px}.field input,.field select{height:43px}.form .btn{width:100%;height:43px}.table-wrap{margin:0 -4px}.table{min-width:540px}.table th{font-size:9px;padding:9px 8px}.table td{font-size:11px;padding:11px 8px}.hint{font-size:10px;line-height:1.45}.footer{font-size:9px;line-height:1.5}}@media(max-width:360px){.wrap{width:calc(100% - 18px)}.admin-period{grid-template-columns:42px minmax(0,1fr) 38px 82px;gap:6px;padding:8px}.brand h1{font-size:10px}}
    </style>
    <style>
        @media(max-width:640px){
            .table-wrap{margin:0;overflow:visible}
            .table{display:block;min-width:0;border-collapse:separate;border-spacing:0;margin-top:4px}
            .table thead{display:none}
            .table tbody{display:grid;gap:8px}
            .table tr{display:grid;grid-template-columns:1fr 1fr;gap:2px 12px;padding:9px 11px;border:1px solid #e7edef;border-radius:10px;background:#fff}
            .table td{display:flex;align-items:center;justify-content:space-between;gap:8px;padding:5px 0;border:0;font-size:11px}
            .table td:before{content:attr(data-label);font-size:9px;color:#82919a;text-transform:uppercase;letter-spacing:.04em;font-weight:700}
            .table td:first-child{grid-column:1/-1;border-bottom:1px solid #edf1f2;padding-bottom:7px;margin-bottom:2px}
            .table td:first-child strong{font-size:13px}
            .table td:nth-child(4){grid-column:1/-1;justify-content:flex-end;border-top:1px solid #edf1f2;padding-top:7px;margin-top:2px}
            .table .empty{grid-column:1/-1;justify-content:center;text-align:center;padding:14px 4px}
        }
    </style>
    <style>
        .climate-form{grid-template-columns:repeat(4,minmax(120px,1fr));gap:10px}.climate-form .btn{grid-column:1/-1;width:100%}.edit-link{display:block;width:max-content;margin-top:4px;color:#087e79;font-size:10px;font-weight:700;text-decoration:none}.edit-link:hover{text-decoration:underline}
        @media(max-width:640px){.climate-form{grid-template-columns:1fr 1fr}.climate-form .btn{grid-column:1/-1}}
        @media(max-width:360px){.climate-form{grid-template-columns:1fr}}
    </style>
    <style>
        .template-label{display:block;font-size:11px;font-weight:700;color:#627581;margin-bottom:6px}.template-form textarea{display:block;width:100%;resize:vertical;border:1px solid #dce5e8;border-radius:10px;padding:11px 12px;color:var(--ink);font:inherit;font-size:12px;line-height:1.6}.template-form textarea:focus,.recipient-form input:focus{outline:none;border-color:#168a83;box-shadow:0 0 0 3px #168a831a}.template-form .hint code{background:#f2f6f6;border-radius:4px;padding:2px 4px;color:#087e79}.recipient-form{display:grid;grid-template-columns:1fr 1fr 1.2fr auto;align-items:end;gap:10px;padding:13px;margin-bottom:13px;background:#f8fafa;border:1px solid #e7edef;border-radius:11px}.recipient-form .btn{height:43px;white-space:nowrap}.wa-list{display:grid;gap:9px}.wa-district{display:grid;gap:8px;padding:12px;border:1px solid #e7edef;border-radius:11px}.wa-summary{display:flex;flex-wrap:wrap;align-items:center;gap:8px;padding-bottom:5px}.wa-summary strong{font-size:12px}.wa-recipient{display:grid;grid-template-columns:minmax(0,1fr) auto auto;align-items:center;gap:8px;padding:8px 9px;background:#f8fafa;border-radius:9px}.wa-contact{display:flex;flex-wrap:wrap;align-items:center;gap:6px 12px;min-width:0}.wa-contact strong{font-size:11px}.wa-contact span{font-size:10px;color:#71828d}.wa-send-form .btn{height:36px}.wa-recipient .delete{height:32px}.wa-error{grid-column:1/-1;margin:0;color:#b33d32;font-size:10px;min-height:0}.wa-error:not(:empty){min-height:14px}.wa-empty{margin:0;padding:8px;text-align:left;font-size:10px}.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        @media(max-width:640px){.recipient-form{grid-template-columns:1fr;gap:10px}.recipient-form .btn{width:100%}.wa-recipient{grid-template-columns:minmax(0,1fr) auto}.wa-send-form{grid-column:2;grid-row:1}.wa-recipient>form:not(.wa-send-form){grid-column:2;grid-row:2}.wa-error{grid-column:1/-1}}
    </style>
    <style>.suitability-form{grid-template-columns:1.05fr 1fr 1fr 1fr auto}.suitability-form .btn{white-space:nowrap}@media(max-width:900px){.suitability-form{grid-template-columns:repeat(2,minmax(0,1fr))}.suitability-form .btn{grid-column:1/-1;width:100%}}</style>
</head>
<body>
<header class="topbar"><img class="mark" src="{{ asset('images/logo-bmkg-transparent.png') }}" alt="Logo BMKG"><div class="brand"><h1>STASIUN KLIMATOLOGI PAPUA SELATAN</h1><p>ADMIN SILING MALARIA · PERINGATAN DINI BERBASIS DATA IKLIM</p></div><a class="nav" href="{{ route('dashboard') }}">← Kembali ke dashboard</a></header>
<main class="wrap">
    <div class="heading"><div><div class="eyebrow">Panel pengelola</div><h2>Input angka insiden</h2><p>Atur bulan dan tahun data yang akan dikelola.</p></div><form method="get" class="period admin-period"><label for="month">Bulan</label><select id="month" name="month" aria-label="Pilih bulan">@foreach([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $number => $monthName)<option value="{{ sprintf('%02d', $number) }}" @selected($selectedMonth === $number)>{{ $monthName }}</option>@endforeach</select><label for="year">Tahun</label><input id="year" name="year" type="number" min="1900" max="9999" step="1" value="{{ $selectedYear }}" aria-label="Pilih tahun"><button class="btn" type="submit">Tampilkan</button></form></div>
    <section class="card">
        <h3>Tambah atau perbarui data kabupaten</h3><p class="sub">Periode input: <strong>{{ $periodLabel }}</strong>. Jika kabupaten dan periode yang sama sudah ada, nilai sebelumnya akan diperbarui.</p>
        @if(session('success'))<div class="flash">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="flash error">{{ $errors->first() }}</div>@endif
        <form method="post" action="{{ route('incidents.store', [], false) }}" class="form">@csrf<input type="hidden" name="period" value="{{ $period }}">
            <div class="field"><label for="district">Kabupaten</label><select id="district" name="district" required><option value="">Pilih kabupaten</option>@foreach($districts as $district)<option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>@endforeach</select></div>
            <div class="field"><label for="incidence">Angka insiden (AI) per 100.000 penduduk</label><input id="incidence" name="incidence" type="number" min="0" max="100000" step="0.01" value="{{ old('incidence') }}" placeholder="Contoh: 4.25" required></div>
            <button class="btn" type="submit">Simpan data</button>
        </form>
        <p class="hint">Status aman, waspada, dan awas ditentukan otomatis dari nilai angka insiden.</p>
    </section>
    <section class="card"><h3>Data tersimpan</h3><p class="sub">Data untuk periode {{ $periodLabel }}</p><div class="table-wrap"><table class="table"><thead><tr><th>Kabupaten</th><th>Angka insiden</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        @forelse($records as $record)
            @php($status = $record->incidence < 3 ? 'Aman' : ($record->incidence < 10 ? 'Waspada' : 'Awas'))
            @php($class = $record->incidence < 3 ? 'safe' : ($record->incidence < 10 ? 'caution' : 'danger'))
            <tr><td data-label="Kabupaten"><strong>{{ $record->district }}</strong></td><td data-label="Angka insiden" class="value">{{ number_format($record->incidence, 2, ',', '.') }}</td><td data-label="Status"><span class="badge {{ $class }}">{{ $status }}</span></td><td data-label="Aksi"><form method="post" action="{{ route('incidents.destroy', $record, false) }}" onsubmit="return confirm('Hapus data {{ $record->district }} periode ini?')">@csrf @method('delete')<button class="delete" type="submit">Hapus</button></form></td></tr>
        @empty<tr><td class="empty" colspan="4">Belum ada data untuk bulan ini. Gunakan formulir di atas untuk menambahkan data.</td></tr>@endforelse
    </tbody></table></div></section>
    <section class="card">
        <h3>Prediksi kesesuaian iklim untuk malaria</h3>
        <p class="sub">Masukkan nilai prediksi resmi untuk {{ $periodLabel }}. Nilai ditampilkan pada peta pengguna dan tidak dihitung otomatis oleh dashboard.</p>
        <form method="post" action="{{ route('climate-suitability.store', [], false) }}" class="form suitability-form">@csrf<input type="hidden" name="period" value="{{ $period }}">
            <div class="field"><label for="suitability_district">Kabupaten</label><select id="suitability_district" name="district" required><option value="">Pilih kabupaten</option>@foreach($districts as $district)<option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>@endforeach</select></div>
            <div class="field"><label for="suitability_probability">Probabilitas kecocokan (%)</label><input id="suitability_probability" name="probability" type="number" min="0" max="100" step="0.01" value="{{ old('probability') }}" placeholder="Contoh: 47.00" required></div>
            <div class="field"><label for="suitability_humidity">RH / kelembapan (%)</label><input id="suitability_humidity" name="humidity" type="number" min="0" max="100" step="0.01" value="{{ old('humidity') }}" placeholder="Contoh: 75.30"></div>
            <div class="field"><label for="suitability_confidence">Tingkat keyakinan</label><select id="suitability_confidence" name="confidence" required><option value="">Pilih tingkat</option>@foreach(['Rendah','Sedang','Tinggi'] as $level)<option value="{{ $level }}" @selected(old('confidence') === $level)>{{ $level }}</option>@endforeach</select></div>
            <button class="btn" type="submit">Simpan prediksi</button>
        </form>
        <p class="hint">Jika kabupaten dan periode yang sama sudah ada, nilai sebelumnya akan diperbarui.</p>
        <div class="table-wrap"><table class="table"><thead><tr><th>Kabupaten</th><th>Probabilitas</th><th>RH</th><th>Tingkat keyakinan</th><th>Kategori peta</th></tr></thead><tbody>
            @forelse($climateSuitabilities as $suitability)
                @php($probability = (float) $suitability->probability)
                @php($category = $probability > 90 ? 'Sangat tinggi' : ($probability >= 70 ? 'Tinggi' : ($probability >= 40 ? 'Sedang' : 'Rendah')))
                <tr><td data-label="Kabupaten"><strong>{{ $suitability->district }}</strong></td><td data-label="Probabilitas" class="value">{{ number_format($probability, 2, ',', '.') }}%</td><td data-label="RH">{{ $suitability->humidity === null ? '—' : number_format((float) $suitability->humidity, 2, ',', '.').'%' }}</td><td data-label="Tingkat keyakinan">{{ $suitability->confidence ?? '—' }}</td><td data-label="Kategori peta">{{ $category }}</td></tr>
            @empty<tr><td class="empty" colspan="5">Belum ada nilai prediksi untuk periode ini.</td></tr>@endforelse
        </tbody></table></div>
    </section>
    <section class="card">
        <h3>Data grafik kasus dan iklim</h3>
        <p class="sub">Tambah atau perbarui data grafik untuk {{ $periodLabel }}. Pilih kabupaten untuk mengedit nilai yang sudah ada.</p>
        <form method="post" action="{{ route('malaria-observations.store', [], false) }}" class="form climate-form">@csrf<input type="hidden" name="period" value="{{ $period }}">
            <div class="field"><label for="malaria_district">Kabupaten</label><select id="malaria_district" name="malaria_district" required><option value="">Pilih kabupaten</option>@foreach($districts as $district)<option value="{{ $district }}" @selected(old('malaria_district', $editingObservation?->district) === $district)>{{ $district }}</option>@endforeach</select></div>
            <div class="field"><label for="malaria_cases">Jumlah kasus</label><input id="malaria_cases" name="cases" type="number" min="0" step="1" value="{{ old('cases', $editingObservation?->cases) }}" placeholder="Contoh: 125" required></div>
            <div class="field"><label for="malaria_humidity">Kelembapan (%)</label><input id="malaria_humidity" name="humidity" type="number" min="0" max="100" step="any" value="{{ old('humidity', $editingObservation?->humidity) }}" placeholder="Contoh: 85.2"></div>
            <div class="field"><label for="malaria_temperature">Suhu (°C)</label><input id="malaria_temperature" name="temperature" type="number" min="-20" max="60" step="any" value="{{ old('temperature', $editingObservation?->temperature) }}" placeholder="Contoh: 27.1"></div>
            <div class="field"><label for="malaria_rainfall">Curah hujan (mm)</label><input id="malaria_rainfall" name="rainfall" type="number" min="0" step="any" value="{{ old('rainfall', $editingObservation?->rainfall) }}" placeholder="Contoh: 344.5"></div>
            <button class="btn" type="submit">{{ $editingObservation ? 'Perbarui data grafik' : 'Simpan data grafik' }}</button>
        </form>
        <p class="hint">Data ini mengisi grafik tren kasus di halaman pengguna. Data angka insiden untuk peta tetap diinput pada formulir di atas.</p>
        <div class="table-wrap"><table class="table"><thead><tr><th>Kabupaten</th><th>Kasus</th><th>Kelembapan</th><th>Suhu</th><th>Curah hujan</th></tr></thead><tbody>
            @forelse($malariaObservations as $observation)
                <tr><td data-label="Kabupaten"><strong>{{ $observation->district }}</strong><a class="edit-link" href="{{ route('admin', ['month' => $selectedMonth, 'year' => $selectedYear, 'edit' => $observation->district], false) }}">Edit data</a></td><td data-label="Kasus" class="value">{{ number_format($observation->cases, 0, ',', '.') }}</td><td data-label="Kelembapan">{{ $observation->humidity === null ? '—' : number_format((float) $observation->humidity, 2, ',', '.').'%' }}</td><td data-label="Suhu">{{ $observation->temperature === null ? '—' : number_format((float) $observation->temperature, 2, ',', '.').' °C' }}</td><td data-label="Curah hujan">{{ $observation->rainfall === null ? '—' : number_format((float) $observation->rainfall, 2, ',', '.').' mm' }}</td></tr>
            @empty<tr><td class="empty" colspan="5">Belum ada data grafik untuk bulan ini.</td></tr>@endforelse
        </tbody></table></div>
    </section>
    <section class="card">
        <h3>Template pesan WhatsApp</h3>
        <p class="sub">Atur isi pesan yang disiapkan otomatis dari periode, kabupaten, AI, status, dan rekomendasi.</p>
        <form method="post" action="{{ route('whatsapp-template.save', [], false) }}" class="template-form">@csrf<input type="hidden" name="period" value="{{ $period }}">
            <label class="template-label" for="whatsapp_template">Isi pesan</label>
            <textarea id="whatsapp_template" name="whatsapp_template" rows="7" required>{{ old('whatsapp_template', $whatsappTemplate) }}</textarea>
            <p class="hint">Variabel template: recipient, period, district, status, incidence, recommendation. Tulis nama variabel dalam kurung kurawal ganda.</p>
            <button class="btn" type="submit">Simpan template</button>
        </form>
    </section>
    <section class="card">
        <h3>Kirim peringatan ke nakes</h3>
        <p class="sub">Simpan beberapa penerima untuk setiap kabupaten. Pesan disiapkan sesuai periode dan nilai AI kabupaten.</p>
        <form method="post" action="{{ request()->getBaseUrl() }}/penerima-whatsapp" class="recipient-form">@csrf<input type="hidden" name="period" value="{{ $period }}">
            <div class="field"><label for="recipient_district">Kabupaten</label><select id="recipient_district" name="district" required><option value="">Pilih kabupaten</option>@foreach($districts as $district)<option value="{{ $district }}" @selected(old('district') === $district)>{{ $district }}</option>@endforeach</select></div>
            <div class="field"><label for="recipient_name">Nama nakes</label><input id="recipient_name" name="name" type="text" maxlength="120" value="{{ old('name') }}" placeholder="Nama penerima" required></div>
            <div class="field"><label for="recipient_phone">Nomor WhatsApp</label><input id="recipient_phone" name="phone" type="tel" inputmode="tel" value="{{ old('phone') }}" placeholder="08… atau 628…" required></div>
            <button class="btn" type="submit">Simpan penerima</button>
        </form>
        <div class="wa-list">
            @forelse($records as $record)
                <div class="wa-district" data-incidence="{{ number_format((float) $record->incidence, 2, '.', '') }}" data-status="{{ $record->incidence < 3 ? 'Aman' : ($record->incidence < 10 ? 'Waspada' : 'Awas') }}" data-recommendation="{{ $record->incidence < 3 ? 'Lanjutkan surveilans rutin, edukasi pencegahan, dan pemantauan faktor iklim.' : ($record->incidence < 10 ? 'Tingkatkan surveilans, validasi laporan, dan kesiapsiagaan logistik.' : 'Aktifkan respon cepat (RRT), surveilans harian, penyelidikan epidemiologi, dan koordinasi lintas sektor.') }}">
                    <div class="wa-summary"><strong>{{ $record->district }}</strong><span class="badge {{ $record->incidence < 3 ? 'safe' : ($record->incidence < 10 ? 'caution' : 'danger') }}">{{ $record->incidence < 3 ? 'Aman' : ($record->incidence < 10 ? 'Waspada' : 'Awas') }} · AI {{ number_format((float) $record->incidence, 2, ',', '.') }}</span></div>
                    @forelse($whatsappRecipients->get($record->district, collect()) as $recipient)
                        <div class="wa-recipient" data-district="{{ $record->district }}" data-recipient="{{ $recipient->name }}" data-phone="{{ $recipient->phone }}">
                            <div class="wa-contact"><strong>{{ $recipient->name }}</strong><span>{{ $recipient->phone }}</span></div>
                            <form class="wa-send-form"><button class="btn" type="submit">Buka WhatsApp</button></form>
                            <form method="post" action="{{ request()->getBaseUrl() }}/penerima-whatsapp/{{ $recipient->id }}" onsubmit="return confirm('Hapus kontak {{ $recipient->name }} dari daftar penerima?')">@csrf @method('delete')<input type="hidden" name="period" value="{{ $period }}"><button class="delete" type="submit">Hapus</button></form>
                            <p class="wa-error" role="status" aria-live="polite"></p>
                        </div>
                    @empty
                        <p class="empty wa-empty">Belum ada penerima tersimpan untuk {{ $record->district }}.</p>
                    @endforelse
                </div>
            @empty
                <div class="empty">Belum ada data AI untuk periode ini. Simpan data kabupaten terlebih dahulu agar pesan dapat disiapkan.</div>
            @endforelse
        </div>
        <p class="hint">Tombol membuka chat WhatsApp dengan pesan terisi. Periksa pesan dan tekan Kirim di WhatsApp untuk setiap penerima.</p>
    </section>
    <footer class="footer">Panel pengelolaan angka insiden malaria · Papua Selatan</footer>
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

