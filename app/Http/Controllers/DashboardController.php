<?php

namespace App\Http\Controllers;

use App\Models\ClimateBulletin;
use App\Models\ClimateEarlyWarning;
use App\Models\ClimateSuitability;
use App\Models\DasarianClimateImage;
use App\Models\HthObservation;
use App\Models\Incident;
use App\Models\MalariaObservation;
use App\Models\SystemSetting;
use App\Models\WhatsappRecipient;
use App\Services\BmkgNtpService;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const DISTRICTS = ['Asmat', 'Boven Digoel', 'Mappi', 'Merauke'];
    private const DEFAULT_WHATSAPP_TEMPLATE = "Peringatan Dini Malaria\nYth. {{recipient}}\nPeriode : {{period}}\nKabupaten : {{district}}\nStatus : {{status}} (AI {{incidence}}/100.000 penduduk)\nRekomendasi : {{recommendation}}\nDikirim dari Dashboard SILING MALARIA - BMKG x Dinkes Papua Selatan";

    public function index(): View
    {
        return $this->sitePage('dashboard');
    }

    public function profile(): View
    {
        return $this->sitePage('profile');
    }

    public function services(): View
    {
        return $this->sitePage('services');
    }

    public function products(): View
    {
        $sub = request()->query('sub');
        if ($sub === 'siling-malaria' || $sub === 'malaria') {
            return $this->silingMalaria();
        }

        return $this->sitePage('products', 'katalog');
    }

    public function silingMalaria(): View
    {
        return $this->sitePage('products', 'siling-malaria');
    }

    public function contact(): View
    {
        return $this->sitePage('contact');
    }

    public function ntpTime(BmkgNtpService $ntpService): JsonResponse
    {
        return response()->json([
            'timestamp' => $ntpService->getTimestampMs(),
            'offset' => $ntpService->getOffset(),
            'source' => BmkgNtpService::NTP_HOST,
            'timezone' => 'Asia/Jayapura',
        ]);
    }

    private function sitePage(string $page, string $subPage = 'katalog'): View
    {
        $data = [
            'page' => $page,
            'subPage' => $subPage,
            'initialNtpTime' => app(BmkgNtpService::class)->getTimestampMs(),
        ];
        if ($page === 'dashboard') {
            $data['earlyWarnings'] = ClimateEarlyWarning::all();
            $data['hthObservations'] = HthObservation::orderBy('days', 'desc')->orderBy('district')->orderBy('station_name')->get();
            $data['districts'] = self::DISTRICTS;
            $data['dasarianImages'] = DasarianClimateImage::where('is_active', true)->orderBy('order')->orderBy('id', 'desc')->get();
            $data['climateBulletins'] = ClimateBulletin::where('is_published', true)->orderBy('order')->orderBy('release_date', 'desc')->get();
            $data['latestBulletin'] = $data['climateBulletins']->first();
            return view('welcome', $data);
        }
        if ($page !== 'products' && $page !== 'services') return view('welcome', $data);

        $periodOptions = $this->forecastPeriods();
        $period = request()->query('period', array_key_first($periodOptions));
        if (! array_key_exists($period, $periodOptions)) $period = array_key_first($periodOptions);

        return view('welcome', array_merge($data, [
            'period' => $period,
            'periodLabel' => $this->periodLabel($period),
            'periodOptions' => $periodOptions,
            'records' => Incident::where('period', $period)->orderBy('district')->get(),
            'climateSuitabilities' => ClimateSuitability::where('period', $period)->orderBy('district')->get(),
            'malariaHistory' => MalariaObservation::orderBy('period')->orderBy('district')->get(),
        ]));
    }

    public function admin(): View
    {
        $period = $this->adminPeriod();
        $whatsappRecipients = WhatsappRecipient::orderBy('district')->orderBy('name')->get()->groupBy('district');
        $records = Incident::where('period', $period)->orderBy('district')->get();
        $editingDistrict = request()->query('edit');
        $editingObservation = is_string($editingDistrict) && in_array($editingDistrict, self::DISTRICTS, true)
            ? MalariaObservation::where('period', $period)->where('district', $editingDistrict)->first()
            : null;

        $editingHthId = request()->query('edit_hth');
        $editingHth = $editingHthId ? HthObservation::find($editingHthId) : null;
        $editingEwId = request()->query('edit_ew');
        $editingEw = $editingEwId ? ClimateEarlyWarning::find($editingEwId) : null;
        $editingBulletinId = request()->query('edit_bulletin');
        $editingBulletin = $editingBulletinId ? ClimateBulletin::find($editingBulletinId) : null;

        return view('admin', [
            'period' => $period,
            'periodLabel' => $this->periodLabel($period),
            'selectedMonth' => (int) substr($period, 5, 2),
            'selectedYear' => (int) substr($period, 0, 4),
            'districts' => self::DISTRICTS,
            'records' => $records,
            'climateSuitabilities' => ClimateSuitability::where('period', $period)->orderBy('district')->get(),
            'malariaObservations' => MalariaObservation::where('period', $period)->orderBy('district')->get(),
            'editingObservation' => $editingObservation,
            'whatsappTemplate' => SystemSetting::where('key', 'malaria_whatsapp_template')->value('value') ?: self::DEFAULT_WHATSAPP_TEMPLATE,
            'whatsappRecipients' => $whatsappRecipients,
            'earlyWarnings' => ClimateEarlyWarning::orderBy('category')->orderBy('district')->get(),
            'hthObservations' => HthObservation::orderBy('district')->orderBy('station_name')->get(),
            'hthClassifications' => HthObservation::CLASSIFICATIONS,
            'editingHth' => $editingHth,
            'editingEw' => $editingEw,
            'dasarianImages' => DasarianClimateImage::orderBy('order')->orderBy('id', 'desc')->get(),
            'climateBulletins' => ClimateBulletin::orderBy('order')->orderBy('release_date', 'desc')->get(),
            'editingBulletin' => $editingBulletin,
        ]);
    }

    public function storeEarlyWarning(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:kekeringan,hujan_lebat'],
            'district' => ['required', 'string', 'in:'.implode(',', self::DISTRICTS)],
            'status' => ['required', 'string', 'in:tidak_ada,waspada,siaga,awas'],
            'waspada_areas' => ['nullable', 'string', 'max:500'],
            'siaga_areas' => ['nullable', 'string', 'max:500'],
            'awas_areas' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:1000'],
            'period' => ['nullable', 'string', 'max:64'],
        ]);

        $period = !empty($validated['period']) ? trim($validated['period']) : 'Dasarian II November 2026';
        $validated['period'] = $period;

        ClimateEarlyWarning::updateOrCreate(
            [
                'category' => $validated['category'],
                'district' => $validated['district'],
                'period' => $period,
            ],
            $validated
        );

        return back()->with('success', "Data peringatan dini {$validated['category']} untuk Kab. {$validated['district']} berhasil disimpan.");
    }

    public function destroyEarlyWarning(ClimateEarlyWarning $earlyWarning): RedirectResponse
    {
        $earlyWarning->delete();
        return back()->with('success', 'Data peringatan dini berhasil dihapus.');
    }

    public function storeHthObservation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => ['nullable', 'integer', 'exists:hth_observations,id'],
            'station_name' => ['required', 'string', 'max:128'],
            'district' => ['required', 'string', 'in:'.implode(',', self::DISTRICTS)],
            'subdistrict' => ['nullable', 'string', 'max:64'],
            'latitude' => ['required', 'numeric', 'between:-12,-3'],
            'longitude' => ['required', 'numeric', 'between:135,143'],
            'days' => ['required', 'integer', 'min:0', 'max:365'],
            'updated_date' => ['nullable', 'date'],
        ]);

        $days = (int) $validated['days'];
        $validated['classification'] = HthObservation::computeClassification($days);
        $validated['updated_date'] = $validated['updated_date'] ?? now()->toDateString();

        if (!empty($validated['id'])) {
            $station = HthObservation::findOrFail($validated['id']);
            $station->update($validated);
            $msg = "Pos {$validated['station_name']} berhasil diperbarui.";
        } else {
            HthObservation::create($validated);
            $msg = "Pos {$validated['station_name']} berhasil ditambahkan.";
        }

        return back()->with('success', $msg);
    }

    public function destroyHthObservation(HthObservation $hthObservation): RedirectResponse
    {
        $name = $hthObservation->station_name;
        $hthObservation->delete();
        return back()->with('success', "Pos {$name} berhasil dihapus.");
    }

    public function storeDasarianImage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'in:analisis,prediksi,peluang,lainnya'],
            'title' => ['required', 'string', 'max:255'],
            'period_label' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
        ]);

        $imageFile = $request->file('image');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $imageFile->getClientOriginalName());
        $imageFile->move(public_path('uploads/dasarian'), $fileName);

        DasarianClimateImage::create([
            'category' => $validated['category'],
            'title' => trim($validated['title']),
            'period_label' => $validated['period_label'] ? trim($validated['period_label']) : null,
            'description' => $validated['description'] ? trim($validated['description']) : null,
            'order' => $validated['order'] ?? 0,
            'image_path' => 'uploads/dasarian/' . $fileName,
            'is_active' => true,
        ]);

        return back()->with('success', 'Gambar informasi iklim dasarian berhasil diunggah.');
    }

    public function destroyDasarianImage(DasarianClimateImage $dasarianImage): RedirectResponse
    {
        $title = $dasarianImage->title;
        $fullPath = public_path($dasarianImage->image_path);
        if (file_exists($fullPath) && !str_contains($dasarianImage->image_path, 'analisis-curah-hujan-dasarian.svg') && !str_contains($dasarianImage->image_path, 'prediksi-curah-hujan-dasarian.svg') && !str_contains($dasarianImage->image_path, 'peluang-curah-hujan-dasarian.svg')) {
            @unlink($fullPath);
        }

        $dasarianImage->delete();

        return back()->with('success', "Gambar {$title} berhasil dihapus.");
    }

    public function storeWhatsappRecipient(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'district' => ['required', 'string', 'in:'.implode(',', self::DISTRICTS)],
            'name' => ['required', 'string', 'max:120'],
            'phone' => [
                'required',
                'string',
                'max:30',
                'regex:/^\\+?[0-9\\s().-]{8,30}$/',
            ],
            'period' => ['required', 'date_format:Y-m'],
        ]);

        $phone = preg_replace('/\\D+/', '', $validated['phone']);
        if (str_starts_with($phone, '0')) $phone = '62'.substr($phone, 1);
        elseif (! str_starts_with($phone, '62')) $phone = '62'.$phone;

        if (strlen($phone) < 10 || strlen($phone) > 15) {
            return back()->withErrors(['phone' => 'Nomor harus berisi 10–15 digit setelah disesuaikan ke kode negara.'])->withInput();
        }
        if (WhatsappRecipient::where('district', $validated['district'])->where('phone', $phone)->exists()) {
            return back()->withErrors(['phone' => 'Nomor ini sudah tersimpan untuk kabupaten tersebut.'])->withInput();
        }

        WhatsappRecipient::create([
            'district' => $validated['district'],
            'name' => trim($validated['name']),
            'phone' => $phone,
        ]);

        [$year, $month] = explode('-', $validated['period']);

        return redirect()->to($request->getBaseUrl().'/admin?'.http_build_query(['month' => $month, 'year' => $year]))
            ->with('success', 'Kontak WhatsApp berhasil disimpan untuk '.$validated['district'].'.');
    }

    public function destroyWhatsappRecipient(Request $request, WhatsappRecipient $recipient): RedirectResponse
    {
        $period = $request->validate(['period' => ['required', 'date_format:Y-m']])['period'];
        $recipient->delete();
        [$year, $month] = explode('-', $period);

        return redirect()->to($request->getBaseUrl().'/admin?'.http_build_query(['month' => $month, 'year' => $year]))
            ->with('success', 'Kontak '.$recipient->name.' berhasil dihapus.');
    }

    public function saveWhatsappTemplate(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'whatsapp_template' => ['required', 'string', 'min:20', 'max:5000'],
            'period' => ['required', 'date_format:Y-m'],
        ]);

        SystemSetting::updateOrCreate(
            ['key' => 'malaria_whatsapp_template'],
            ['value' => trim($validated['whatsapp_template'])],
        );

        [$year, $month] = explode('-', $validated['period']);

        return redirect()->route('admin', ['month' => $month, 'year' => $year])
            ->with('success', 'Template pesan WhatsApp berhasil disimpan.');
    }

    public function storeMalariaObservation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'malaria_district' => ['required', 'string', 'in:'.implode(',', self::DISTRICTS)],
            'period' => ['required', 'date_format:Y-m'],
            'cases' => ['required', 'integer', 'min:0', 'max:100000000'],
            'humidity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'temperature' => ['nullable', 'numeric', 'min:-20', 'max:60'],
            'rainfall' => ['nullable', 'numeric', 'min:0', 'max:100000'],
        ]);

        MalariaObservation::updateOrCreate(
            ['district' => $validated['malaria_district'], 'period' => $validated['period']],
            [
                'cases' => $validated['cases'],
                'humidity' => $validated['humidity'] ?? null,
                'temperature' => $validated['temperature'] ?? null,
                'rainfall' => $validated['rainfall'] ?? null,
            ],
        );

        [$year, $month] = explode('-', $validated['period']);

        return redirect()->route('admin', ['month' => $month, 'year' => $year])
            ->with('success', 'Data tren malaria berhasil disimpan untuk '.$this->periodLabel($validated['period']).'.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'district' => ['required', 'string', 'in:'.implode(',', self::DISTRICTS)],
            'incidence' => ['required', 'numeric', 'min:0', 'max:100000'],
            'period' => ['required', 'date_format:Y-m'],
        ]);

        Incident::updateOrCreate(
            ['district' => $validated['district'], 'period' => $validated['period']],
            ['incidence' => $validated['incidence']],
        );

        [$year, $month] = explode('-', $validated['period']);

        return redirect()->route('admin', [
            'month' => $month,
            'year' => $year,
        ])->with('success', 'Angka insiden berhasil disimpan untuk '.$this->periodLabel($validated['period']).'.');
    }

    public function storeClimateSuitability(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'district' => ['required', 'string', 'in:'.implode(',', self::DISTRICTS)],
            'probability' => ['required', 'numeric', 'min:0', 'max:100'],
            'humidity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'confidence' => ['required', 'string', 'in:Rendah,Sedang,Tinggi'],
            'period' => ['required', 'date_format:Y-m'],
        ]);

        ClimateSuitability::updateOrCreate(
            ['district' => $validated['district'], 'period' => $validated['period']],
            [
                'probability' => $validated['probability'],
                'humidity' => $validated['humidity'] ?? null,
                'confidence' => $validated['confidence'],
            ],
        );

        [$year, $month] = explode('-', $validated['period']);

        return redirect()->route('admin', ['month' => $month, 'year' => $year])
            ->with('success', 'Data kesesuaian iklim malaria berhasil disimpan untuk '.$validated['district'].'.');
    }

    public function destroy(Incident $incident): RedirectResponse
    {
        $incident->delete();

        [$year, $month] = explode('-', $incident->period);

        return redirect()->route('admin', [
            'month' => $month,
            'year' => $year,
        ])->with('success', 'Data kabupaten berhasil dihapus.');
    }

    public function storeBulletin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => ['nullable', 'integer', 'exists:climate_bulletins,id'],
            'title' => ['required', 'string', 'max:255'],
            'edition' => ['required', 'string', 'max:100'],
            'release_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:2500'],
            'page_count' => ['nullable', 'integer', 'min:1', 'max:999'],
            'file_size' => ['nullable', 'string', 'max:50'],
            'external_link' => ['nullable', 'url', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['nullable'],
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
            'pdf_file' => ['nullable', 'file', 'mimes:pdf', 'max:35840'], // max 35MB
        ]);

        $bulletin = !empty($validated['id']) ? ClimateBulletin::find($validated['id']) : new ClimateBulletin();

        $bulletin->title = trim($validated['title']);
        $bulletin->edition = trim($validated['edition']);
        $bulletin->release_date = $validated['release_date'] ?? null;
        $bulletin->description = $validated['description'] ? trim($validated['description']) : null;
        $bulletin->page_count = $validated['page_count'] ?? 24;
        $bulletin->file_size = $validated['file_size'] ? trim($validated['file_size']) : null;
        $bulletin->external_link = $validated['external_link'] ? trim($validated['external_link']) : null;
        $bulletin->order = $validated['order'] ?? 0;
        $bulletin->is_published = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverName = 'cover_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $coverFile->getClientOriginalName());
            $coverFile->move(public_path('uploads/bulletins/covers'), $coverName);

            if ($bulletin->cover_image && file_exists(public_path($bulletin->cover_image)) && !str_contains($bulletin->cover_image, 'default-bulletin-cover')) {
                @unlink(public_path($bulletin->cover_image));
            }
            $bulletin->cover_image = 'uploads/bulletins/covers/' . $coverName;
        } elseif (!$bulletin->cover_image) {
            $bulletin->cover_image = 'images/default-bulletin-cover.svg';
        }

        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfName = 'buletin_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $pdfFile->getClientOriginalName());
            $pdfFile->move(public_path('uploads/bulletins/files'), $pdfName);

            if (empty($bulletin->file_size)) {
                $bytes = filesize(public_path('uploads/bulletins/files/' . $pdfName));
                $bulletin->file_size = round($bytes / (1024 * 1024), 1) . ' MB';
            }

            if ($bulletin->file_path && file_exists(public_path($bulletin->file_path))) {
                @unlink(public_path($bulletin->file_path));
            }
            $bulletin->file_path = 'uploads/bulletins/files/' . $pdfName;
        }

        $bulletin->save();

        return redirect()->to(route('admin') . '?tab=buletin#buletin')->with('success', 'Data Buletin Iklim (' . $bulletin->edition . ') berhasil disimpan.');
    }

    public function destroyBulletin(ClimateBulletin $bulletin): RedirectResponse
    {
        $edition = $bulletin->edition;

        if ($bulletin->cover_image && file_exists(public_path($bulletin->cover_image)) && !str_contains($bulletin->cover_image, 'default-bulletin-cover')) {
            @unlink(public_path($bulletin->cover_image));
        }

        if ($bulletin->file_path && file_exists(public_path($bulletin->file_path))) {
            @unlink(public_path($bulletin->file_path));
        }

        $bulletin->delete();

        return redirect()->to(route('admin') . '?tab=buletin#buletin')->with('success', 'Buletin ' . $edition . ' berhasil dihapus.');
    }

    private function adminPeriod(): string
    {
        $period = request()->query('period');
        if ($period && preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $period)) return $period;

        $year = request()->query('year');
        $month = request()->query('month');
        if (is_string($year) && preg_match('/^\d{4}$/', $year) && is_string($month) && preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
            return $year.'-'.$month;
        }

        return now()->format('Y-m');
    }

    private function forecastPeriods(): array
    {
        $periods = [];
        $monthNames = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        $start = CarbonImmutable::now()->startOfMonth();
        for ($offset = 0; $offset < 3; $offset++) {
            $date = $start->addMonths($offset);
            $periods[$date->format('Y-m')] = $monthNames[$date->month].' '.$date->year;
        }
        return $periods;
    }

    private function periodLabel(string $period): string
    {
        $monthNames = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
        [$year, $month] = explode('-', $period);

        return $monthNames[(int) $month].' '.$year;
    }
}
