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
    private const HTH_DISTRICTS = ['Asmat', 'Boven Digoel', 'Mappi', 'Merauke', 'Timika'];
    private const DEFAULT_WHATSAPP_TEMPLATE = "Peringatan Dini Malaria\nYth. {{recipient}}\nPeriode : {{period}}\nKabupaten : {{district}}\nStatus : {{status}} (AI {{incidence}}/1.000 penduduk)\nRekomendasi : {{recommendation}}\nDikirim dari Dashboard SILING MALARIA - BMKG x Dinkes Papua Selatan";

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
            $data['climateBulletins'] = ClimateBulletin::where('is_published', true)->where(function($q) { $q->where('category', 'iklim')->orWhereNull('category'); })->orderBy('order')->orderBy('release_date', 'desc')->get();
            $data['latestBulletin'] = $data['climateBulletins']->first();
            return view('welcome', $data);
        }
        if ($page !== 'products' && $page !== 'services') return view('welcome', $data);

        $periodOptions = $this->forecastPeriods();
        $period = request()->query('period', array_key_first($periodOptions));
        if (! array_key_exists($period, $periodOptions)) $period = array_key_first($periodOptions);

        $malariaBulletins = ClimateBulletin::where('is_published', true)->where('category', 'malaria')->orderBy('order')->orderBy('release_date', 'desc')->get();
        $latestMalariaBulletin = $malariaBulletins->first();

        return view('welcome', array_merge($data, [
            'period' => $period,
            'periodLabel' => $this->periodLabel($period),
            'periodOptions' => $periodOptions,
            'records' => Incident::where('period', $period)->orderBy('district')->get(),
            'climateSuitabilities' => ClimateSuitability::where('period', $period)->orderBy('district')->get(),
            'malariaHistory' => MalariaObservation::orderBy('period')->orderBy('district')->get(),
            'malariaBulletins' => $malariaBulletins,
            'latestMalariaBulletin' => $latestMalariaBulletin,
        ]));
    }

    public function admin(): View
    {
        $period = $this->adminPeriod();
        $whatsappRecipients = WhatsappRecipient::orderBy('district')->orderBy('name')->get()->groupBy('district');
        $records = Incident::where('period', $period)->orderBy('district')->get();
        $whatsappTemplate = SystemSetting::where('key', 'malaria_whatsapp_template')->value('value') ?: self::DEFAULT_WHATSAPP_TEMPLATE;
        $whatsappTemplate = str_replace('100.000 penduduk', '1.000 penduduk', $whatsappTemplate);
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
        $editingDasarianId = request()->query('edit_dasarian');
        $editingDasarian = $editingDasarianId ? DasarianClimateImage::find($editingDasarianId) : null;

        $activeTab = request()->query('tab');
        if (! $activeTab) {
            if ($editingEwId) $activeTab = 'peringatan-dini';
            elseif ($editingHthId) $activeTab = 'pos-hth';
            elseif ($editingDasarianId) $activeTab = 'peta-dasarian';
            elseif ($editingBulletinId) $activeTab = 'buletin-iklim';
            elseif ($editingObservation || request()->has('edit')) $activeTab = 'siling-malaria';
            else $activeTab = 'peringatan-dini';
        }
        if ($activeTab === 'buletin') {
            $activeTab = 'buletin-iklim';
        }

        return view('admin', [
            'activeTab' => $activeTab,
            'period' => $period,
            'periodLabel' => $this->periodLabel($period),
            'selectedMonth' => (int) substr($period, 5, 2),
            'selectedYear' => (int) substr($period, 0, 4),
            'districts' => self::DISTRICTS,
            'records' => $records,
            'climateSuitabilities' => ClimateSuitability::where('period', $period)->orderBy('district')->get(),
            'malariaObservations' => MalariaObservation::where('period', $period)->orderBy('district')->get(),
            'editingObservation' => $editingObservation,
            'whatsappTemplate' => $whatsappTemplate,
            'whatsappRecipients' => $whatsappRecipients,
            'earlyWarnings' => ClimateEarlyWarning::orderBy('category')->orderBy('district')->get(),
            'hthObservations' => HthObservation::orderBy('district')->orderBy('station_name')->get(),
            'hthClassifications' => HthObservation::CLASSIFICATIONS,
            'hthDistricts' => self::HTH_DISTRICTS,
            'editingHth' => $editingHth,
            'editingEw' => $editingEw,
            'dasarianImages' => DasarianClimateImage::orderBy('order')->orderBy('id', 'desc')->get(),
            'editingDasarian' => $editingDasarian,
            'climateBulletins' => ClimateBulletin::orderBy('order')->orderBy('release_date', 'desc')->get(),
            'malariaBulletins' => ClimateBulletin::where('category', 'malaria')->orderBy('order')->orderBy('release_date', 'desc')->get(),
            'latestMalariaBulletin' => ClimateBulletin::where('category', 'malaria')->orderBy('order')->orderBy('release_date', 'desc')->first(),
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
            'district' => ['required', 'string', 'in:'.implode(',', self::HTH_DISTRICTS)],
            'subdistrict' => ['nullable', 'string', 'max:64'],
            'latitude' => ['required', 'numeric', 'between:-12,-3'],
            'longitude' => ['required', 'numeric', 'between:135,143'],
            'days' => ['required', 'integer', 'min:0', 'max:365'],
            'updated_date' => ['nullable', 'date'],
        ]);

        $days = (int) $validated['days'];
        $validated['classification'] = HthObservation::computeClassification($days);
        $validated['updated_date'] = $validated['updated_date'] ?? now()->toDateString();
        $validated['latitude'] = round((float) $validated['latitude'], 6);
        $validated['longitude'] = round((float) $validated['longitude'], 6);

        if (!empty($validated['id'])) {
            $station = HthObservation::findOrFail($validated['id']);
            $samePoint = HthObservation::where('latitude', $validated['latitude'])
                ->where('longitude', $validated['longitude'])
                ->where('id', '!=', $station->id)
                ->first();

            if ($samePoint) {
                $samePoint->update($validated);
                $station->delete();
                $msg = "Pembacaan titik {$validated['station_name']} diperbarui dan duplikat titik disatukan.";
            } else {
                $station->update($validated);
                $msg = "Pos {$validated['station_name']} berhasil diperbarui.";
            }
        } else {
            $station = HthObservation::updateOrCreate(
                ['latitude' => $validated['latitude'], 'longitude' => $validated['longitude']],
                $validated,
            );
            $msg = $station->wasRecentlyCreated
                ? "Pos {$validated['station_name']} berhasil ditambahkan."
                : "Pembacaan titik {$validated['station_name']} berhasil diperbarui.";
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
        $isEdit = $request->filled('id');
        $validated = $request->validate([
            'id' => ['nullable', 'integer', 'exists:dasarian_climate_images,id'],
            'category' => ['required', 'string', 'in:analisis,prediksi,peluang,lainnya'],
            'title' => ['required', 'string', 'max:255'],
            'period_label' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable'],
            'image' => [$isEdit ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:5120'],
        ]);

        $dasarian = $isEdit ? DasarianClimateImage::findOrFail($validated['id']) : new DasarianClimateImage();

        $dasarian->category = $validated['category'];
        $dasarian->title = trim($validated['title']);
        $dasarian->period_label = $validated['period_label'] ? trim($validated['period_label']) : null;
        $dasarian->description = $validated['description'] ? trim($validated['description']) : null;
        $dasarian->order = $validated['order'] ?? 0;
        $dasarian->is_active = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $imageFile->getClientOriginalName());
            $this->saveUploadedFile($imageFile, public_path('uploads/dasarian'), $fileName);

            if ($isEdit && $dasarian->image_path) {
                $oldPath = public_path($dasarian->image_path);
                if (file_exists($oldPath) && !str_contains($dasarian->image_path, 'analisis-curah-hujan-dasarian.svg') && !str_contains($dasarian->image_path, 'prediksi-curah-hujan-dasarian.svg') && !str_contains($dasarian->image_path, 'peluang-curah-hujan-dasarian.svg')) {
                    @unlink($oldPath);
                }
            }

            $dasarian->image_path = 'uploads/dasarian/' . $fileName;
        }

        $dasarian->save();

        return redirect()->route('admin', ['tab' => 'peta-dasarian'])
            ->with('success', $isEdit ? 'Peta dasarian berhasil diperbarui.' : 'Gambar informasi iklim dasarian berhasil diunggah.');
    }

    public function destroyDasarianImage(DasarianClimateImage $dasarianImage): RedirectResponse
    {
        $title = $dasarianImage->title;
        $fullPath = public_path($dasarianImage->image_path);
        if (file_exists($fullPath) && !str_contains($dasarianImage->image_path, 'analisis-curah-hujan-dasarian.svg') && !str_contains($dasarianImage->image_path, 'prediksi-curah-hujan-dasarian.svg') && !str_contains($dasarianImage->image_path, 'peluang-curah-hujan-dasarian.svg')) {
            @unlink($fullPath);
        }

        $dasarianImage->delete();

        return redirect()->route('admin', ['tab' => 'peta-dasarian'])->with('success', "Gambar {$title} berhasil dihapus.");
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

        return redirect()->route('admin', ['tab' => 'notifikasi-wa', 'month' => $month, 'year' => $year])
            ->with('success', 'Kontak WhatsApp berhasil disimpan untuk '.$validated['district'].'.');
    }

    public function destroyWhatsappRecipient(Request $request, WhatsappRecipient $recipient): RedirectResponse
    {
        $period = $request->validate(['period' => ['required', 'date_format:Y-m']])['period'];
        $recipient->delete();
        [$year, $month] = explode('-', $period);

        return redirect()->route('admin', ['tab' => 'notifikasi-wa', 'month' => $month, 'year' => $year])
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

        return redirect()->route('admin', ['tab' => 'notifikasi-wa', 'month' => $month, 'year' => $year])
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

        return redirect()->route('admin', ['tab' => 'siling-malaria', 'month' => $month, 'year' => $year])
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
            'tab' => 'siling-malaria',
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

        return redirect()->route('admin', ['tab' => 'siling-malaria', 'month' => $month, 'year' => $year])
            ->with('success', 'Data kesesuaian iklim malaria berhasil disimpan untuk '.$validated['district'].'.');
    }

    public function destroy(Incident $incident): RedirectResponse
    {
        $incident->delete();

        [$year, $month] = explode('-', $incident->period);

        return redirect()->route('admin', [
            'tab' => 'siling-malaria',
            'month' => $month,
            'year' => $year,
        ])->with('success', 'Data kabupaten berhasil dihapus.');
    }

    public function storeBulletin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id' => ['nullable', 'integer', 'exists:climate_bulletins,id'],
            'category' => ['nullable', 'string', 'in:iklim,malaria'],
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
            'redirect_tab' => ['nullable', 'string'],
        ]);

        $bulletin = !empty($validated['id']) ? ClimateBulletin::find($validated['id']) : new ClimateBulletin();

        $bulletin->category = $validated['category'] ?? ($bulletin->category ?: 'iklim');
        $bulletin->title = trim($validated['title']);
        $bulletin->edition = trim($validated['edition']);
        $bulletin->release_date = $validated['release_date'] ?? null;
        $bulletin->description = !empty($validated['description']) ? trim($validated['description']) : null;
        $bulletin->page_count = $validated['page_count'] ?? 24;
        $bulletin->file_size = !empty($validated['file_size']) ? trim($validated['file_size']) : null;
        $bulletin->external_link = !empty($validated['external_link']) ? trim($validated['external_link']) : null;
        $bulletin->order = $validated['order'] ?? 0;
        $bulletin->is_published = $request->boolean('is_published');

        if ($request->hasFile('cover_image')) {
            $coverFile = $request->file('cover_image');
            $coverName = 'cover_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $coverFile->getClientOriginalName());
            $this->saveUploadedFile($coverFile, public_path('uploads/bulletins/covers'), $coverName);

            if ($bulletin->cover_image && file_exists(public_path($bulletin->cover_image)) && !str_contains($bulletin->cover_image, 'default-')) {
                @unlink(public_path($bulletin->cover_image));
            }
            $bulletin->cover_image = 'uploads/bulletins/covers/' . $coverName;
        }

        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $pdfName = 'buletin_' . time() . '_' . preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $pdfFile->getClientOriginalName());
            $this->saveUploadedFile($pdfFile, public_path('uploads/bulletins/files'), $pdfName);

            $uploadedPdfFullPath = public_path('uploads/bulletins/files/' . $pdfName);

            if (empty($bulletin->file_size) && file_exists($uploadedPdfFullPath)) {
                $bytes = filesize($uploadedPdfFullPath);
                $bulletin->file_size = round($bytes / (1024 * 1024), 1) . ' MB';
            }

            // Jika user tidak mengunggah sampul gambar secara manual, ekstrak otomatis sampul halaman dari file PDF
            if (!$request->hasFile('cover_image')) {
                $extractedCoverName = 'cover_' . time() . '_' . pathinfo($pdfName, PATHINFO_FILENAME) . '.jpg';
                $extractedCoverPath = public_path('uploads/bulletins/covers/' . $extractedCoverName);
                if ($this->extractPdfCoverImage($uploadedPdfFullPath, $extractedCoverPath)) {
                    if ($bulletin->cover_image && file_exists(public_path($bulletin->cover_image)) && !str_contains($bulletin->cover_image, 'default-')) {
                        @unlink(public_path($bulletin->cover_image));
                    }
                    $bulletin->cover_image = 'uploads/bulletins/covers/' . $extractedCoverName;
                }
            }

            if ($bulletin->file_path && file_exists(public_path($bulletin->file_path)) && $bulletin->file_path !== ('uploads/bulletins/files/' . $pdfName)) {
                @unlink(public_path($bulletin->file_path));
            }
            $bulletin->file_path = 'uploads/bulletins/files/' . $pdfName;
        }

        if (!$bulletin->cover_image) {
            $bulletin->cover_image = ($bulletin->category === 'malaria')
                ? 'images/default-malaria-bulletin-cover.svg'
                : 'images/default-bulletin-cover.svg';
        }

        $bulletin->save();

        $redirectTab = $request->input('redirect_tab') ?: ($bulletin->category === 'malaria' && $request->input('source_tab') === 'siling-malaria' ? 'siling-malaria' : 'buletin-iklim');

        return redirect()->route('admin', ['tab' => $redirectTab])->with('success', 'Data Buletin (' . $bulletin->edition . ') berhasil disimpan.');
    }

    public function destroyBulletin(ClimateBulletin $bulletin): RedirectResponse
    {
        $edition = $bulletin->edition;
        $category = $bulletin->category;

        if ($bulletin->cover_image && file_exists(public_path($bulletin->cover_image)) && !str_contains($bulletin->cover_image, 'default-')) {
            @unlink(public_path($bulletin->cover_image));
        }

        if ($bulletin->file_path && file_exists(public_path($bulletin->file_path))) {
            @unlink(public_path($bulletin->file_path));
        }

        $bulletin->delete();

        $redirectTab = request()->input('tab') ?: ($category === 'malaria' && request()->has('from_malaria') ? 'siling-malaria' : 'buletin-iklim');

        return redirect()->route('admin', ['tab' => $redirectTab])->with('success', 'Buletin ' . $edition . ' berhasil dihapus.');
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

    private function saveUploadedFile(\Illuminate\Http\UploadedFile $file, string $targetDirectory, string $filename): void
    {
        if (!is_dir($targetDirectory)) {
            @mkdir($targetDirectory, 0755, true);
        }

        $targetPath = rtrim($targetDirectory, '/\\') . DIRECTORY_SEPARATOR . $filename;

        try {
            $file->move($targetDirectory, $filename);
        } catch (\Symfony\Component\HttpFoundation\File\Exception\FileException $e) {
            if (!@copy($file->getPathname(), $targetPath)) {
                throw $e;
            }
            @unlink($file->getPathname());
        }
    }

    private function extractPdfCoverImage(string $pdfPath, string $outputPath): bool
    {
        if (!file_exists($pdfPath)) {
            return false;
        }

        $content = @file_get_contents($pdfPath);
        if (!$content) {
            return false;
        }

        $coversDir = dirname($outputPath);
        if (!is_dir($coversDir)) {
            @mkdir($coversDir, 0755, true);
        }

        $offset = 0;
        while (($pos = strpos($content, "stream", $offset)) !== false) {
            $start = strpos($content, "\n", $pos);
            if ($start === false) {
                $offset = $pos + 6;
                continue;
            }
            $start += 1;

            $end = strpos($content, "endstream", $start);
            if ($end === false) {
                $offset = $pos + 6;
                continue;
            }

            $stream = substr($content, $start, $end - $start);
            $stream = ltrim($stream, "\r\n");

            if (str_starts_with($stream, "\xFF\xD8\xFF")) {
                $jpegData = rtrim($stream, "\r\n");
                if (strlen($jpegData) > 20000) {
                    return (bool) @file_put_contents($outputPath, $jpegData);
                }
            }

            $offset = $end + 9;
        }

        return false;
    }
}
