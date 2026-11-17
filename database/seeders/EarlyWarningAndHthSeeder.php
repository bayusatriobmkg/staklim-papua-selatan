<?php

namespace Database\Seeders;

use App\Models\ClimateEarlyWarning;
use App\Models\HthObservation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EarlyWarningAndHthSeeder extends Seeder
{
    public function run(): void
    {
        $period = 'Dasarian II November 2026';

        // Peringatan Dini Kekeringan
        $kekeringan = [
            [
                'category' => 'kekeringan',
                'district' => 'Merauke',
                'status' => 'waspada',
                'waspada_areas' => 'Distrik Naukenjerai, Animha, Semangga',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Potensi curah hujan sangat rendah pada dasarian berjalan.',
                'period' => $period,
            ],
            [
                'category' => 'kekeringan',
                'district' => 'Boven Digoel',
                'status' => 'tidak_ada',
                'waspada_areas' => '-',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Kondisi curah hujan masih mencukupi.',
                'period' => $period,
            ],
            [
                'category' => 'kekeringan',
                'district' => 'Mappi',
                'status' => 'tidak_ada',
                'waspada_areas' => '-',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Tidak terdapat indikasi kekeringan meteorologis.',
                'period' => $period,
            ],
            [
                'category' => 'kekeringan',
                'district' => 'Asmat',
                'status' => 'tidak_ada',
                'waspada_areas' => '-',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Curah hujan relatif basah.',
                'period' => $period,
            ],
        ];

        foreach ($kekeringan as $item) {
            ClimateEarlyWarning::updateOrCreate(
                ['category' => $item['category'], 'district' => $item['district'], 'period' => $item['period']],
                $item
            );
        }

        // Peringatan Dini Hujan Lebat
        $hujanLebat = [
            [
                'category' => 'hujan_lebat',
                'district' => 'Asmat',
                'status' => 'waspada',
                'waspada_areas' => 'Distrik Agats, Atsj, Sawa Erma',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Potensi curah hujan intensitas sedang hingga lebat.',
                'period' => $period,
            ],
            [
                'category' => 'hujan_lebat',
                'district' => 'Boven Digoel',
                'status' => 'siaga',
                'waspada_areas' => 'Distrik Mindiptana, Waropko',
                'siaga_areas' => 'Distrik Jair, Tanah Merah',
                'awas_areas' => '-',
                'description' => 'Potensi curah hujan tinggi disertai angin kencang.',
                'period' => $period,
            ],
            [
                'category' => 'hujan_lebat',
                'district' => 'Mappi',
                'status' => 'waspada',
                'waspada_areas' => 'Distrik Obaa, Edera',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Waspada potensi genangan air di wilayah dataran rendah.',
                'period' => $period,
            ],
            [
                'category' => 'hujan_lebat',
                'district' => 'Merauke',
                'status' => 'tidak_ada',
                'waspada_areas' => '-',
                'siaga_areas' => '-',
                'awas_areas' => '-',
                'description' => 'Kondisi cuaca didominasi berawan hingga hujan ringan.',
                'period' => $period,
            ],
        ];

        foreach ($hujanLebat as $item) {
            ClimateEarlyWarning::updateOrCreate(
                ['category' => $item['category'], 'district' => $item['district'], 'period' => $item['period']],
                $item
            );
        }

        // Pos Pengamatan Distribusi HTH
        $stations = [
            // Merauke
            ['station_name' => 'Staklim Tanah Miring', 'district' => 'Merauke', 'subdistrict' => 'Tanah Miring', 'latitude' => -8.298600, 'longitude' => 140.514700, 'days' => 8],
            ['station_name' => 'Pos Hujan Kurik', 'district' => 'Merauke', 'subdistrict' => 'Kurik', 'latitude' => -8.312500, 'longitude' => 140.235600, 'days' => 12],
            ['station_name' => 'Pos Hujan Muting', 'district' => 'Merauke', 'subdistrict' => 'Muting', 'latitude' => -7.567800, 'longitude' => 140.489100, 'days' => 4],
            ['station_name' => 'Pos Hujan Okaba', 'district' => 'Merauke', 'subdistrict' => 'Okaba', 'latitude' => -8.156400, 'longitude' => 139.754200, 'days' => 18],
            ['station_name' => 'Pos Hujan Semangga', 'district' => 'Merauke', 'subdistrict' => 'Semangga', 'latitude' => -8.412300, 'longitude' => 140.421500, 'days' => 7],
            ['station_name' => 'Pos Hujan Sota', 'district' => 'Merauke', 'subdistrict' => 'Sota', 'latitude' => -8.441200, 'longitude' => 141.012300, 'days' => 3],
            ['station_name' => 'Pos Hujan Naukenjerai', 'district' => 'Merauke', 'subdistrict' => 'Naukenjerai', 'latitude' => -8.621400, 'longitude' => 140.672100, 'days' => 24],
            ['station_name' => 'Pos Hujan Ilwayab', 'district' => 'Merauke', 'subdistrict' => 'Ilwayab', 'latitude' => -7.892100, 'longitude' => 139.882100, 'days' => 15],

            // Boven Digoel
            ['station_name' => 'Pos Hujan Tanah Merah', 'district' => 'Boven Digoel', 'subdistrict' => 'Mandobo', 'latitude' => -6.096400, 'longitude' => 140.301200, 'days' => 2],
            ['station_name' => 'Pos Hujan Mindiptana', 'district' => 'Boven Digoel', 'subdistrict' => 'Mindiptana', 'latitude' => -5.923400, 'longitude' => 140.712300, 'days' => 0],
            ['station_name' => 'Pos Hujan Jair', 'district' => 'Boven Digoel', 'subdistrict' => 'Jair', 'latitude' => -6.452100, 'longitude' => 140.412500, 'days' => 1],
            ['station_name' => 'Pos Hujan Waropko', 'district' => 'Boven Digoel', 'subdistrict' => 'Waropko', 'latitude' => -5.612400, 'longitude' => 140.892100, 'days' => 0],
            ['station_name' => 'Pos Hujan Kouh', 'district' => 'Boven Digoel', 'subdistrict' => 'Kouh', 'latitude' => -5.812300, 'longitude' => 140.124500, 'days' => 5],

            // Mappi
            ['station_name' => 'Pos Hujan Kepi', 'district' => 'Mappi', 'subdistrict' => 'Obaa', 'latitude' => -6.531200, 'longitude' => 139.314500, 'days' => 3],
            ['station_name' => 'Pos Hujan Edera', 'district' => 'Mappi', 'subdistrict' => 'Edera', 'latitude' => -6.642100, 'longitude' => 139.712500, 'days' => 6],
            ['station_name' => 'Pos Hujan Assue', 'district' => 'Mappi', 'subdistrict' => 'Assue', 'latitude' => -5.912400, 'longitude' => 139.542100, 'days' => 0],
            ['station_name' => 'Pos Hujan Haju', 'district' => 'Mappi', 'subdistrict' => 'Haju', 'latitude' => -6.312500, 'longitude' => 139.124500, 'days' => 2],

            // Asmat
            ['station_name' => 'Pos Hujan Agats', 'district' => 'Asmat', 'subdistrict' => 'Agats', 'latitude' => -5.541200, 'longitude' => 138.134500, 'days' => 0],
            ['station_name' => 'Pos Hujan Atsj', 'district' => 'Asmat', 'subdistrict' => 'Atsj', 'latitude' => -5.712400, 'longitude' => 138.412500, 'days' => 1],
            ['station_name' => 'Pos Hujan Sawa Erma', 'district' => 'Asmat', 'subdistrict' => 'Sawa Erma', 'latitude' => -5.234500, 'longitude' => 138.312500, 'days' => 0],
            ['station_name' => 'Pos Hujan Pantai Kasuari', 'district' => 'Asmat', 'subdistrict' => 'Pantai Kasuari', 'latitude' => -5.981200, 'longitude' => 138.712500, 'days' => 4],
        ];

        foreach ($stations as $st) {
            $days = $st['days'];
            HthObservation::updateOrCreate(
                ['station_name' => $st['station_name']],
                array_merge($st, [
                    'classification' => HthObservation::computeClassification($days),
                    'updated_date' => Carbon::now()->toDateString(),
                ])
            );
        }
    }
}
