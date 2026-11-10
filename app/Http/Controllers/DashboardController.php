<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\ClimateSuitability;
use App\Models\MalariaObservation;
use App\Models\SystemSetting;
use App\Models\WhatsappRecipient;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    private const DISTRICTS = ['Asmat', 'Boven Digoel', 'Mappi', 'Merauke'];
    private const DEFAULT_WHATSAPP_TEMPLATE = "Peringatan Dini Malaria\nYth. {{recipient}}\nPeriode : {{period}}\nKabupaten : {{district}}\nStatus : {{status}} (AI {{incidence}}/100.000 penduduk)\nRekomendasi : {{recommendation}}\nDikirim dari Dashboard SILING MALARIA - BMKG x Dinkes Papua Selatan";

    public function index(): View
    {
        $periodOptions = $this->forecastPeriods();
        $period = request()->query('period', array_key_first($periodOptions));
        if (! array_key_exists($period, $periodOptions)) $period = array_key_first($periodOptions);

        return view('welcome', [
            'period' => $period,
            'periodLabel' => $this->periodLabel($period),
            'periodOptions' => $periodOptions,
            'records' => Incident::where('period', $period)->orderBy('district')->get(),
            'climateSuitabilities' => ClimateSuitability::where('period', $period)->orderBy('district')->get(),
            'malariaHistory' => MalariaObservation::orderBy('period')->orderBy('district')->get(),
        ]);
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
        ]);
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
