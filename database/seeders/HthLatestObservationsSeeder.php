<?php

namespace Database\Seeders;

use App\Models\HthObservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HthLatestObservationsSeeder extends Seeder
{
    public function run(): void
    {
        $observations = [
            ['station_name' => 'Sukamaju', 'district' => 'Merauke', 'subdistrict' => 'Malind', 'longitude' => 140.1944, 'latitude' => -8.24417, 'days' => 6],
            ['station_name' => 'Amun Kay', 'district' => 'Merauke', 'subdistrict' => 'Merauke', 'longitude' => 140.469, 'latitude' => -8.40997, 'days' => 5],
            ['station_name' => 'Kumbe', 'district' => 'Merauke', 'subdistrict' => 'Malind', 'longitude' => 140.2566, 'latitude' => -8.3485, 'days' => 5],
            ['station_name' => 'Okaba', 'district' => 'Merauke', 'subdistrict' => 'Okaba', 'longitude' => 139.7158, 'latitude' => -8.08853, 'days' => 4],
            ['station_name' => 'Wonorejo', 'district' => 'Merauke', 'subdistrict' => 'Kurik', 'longitude' => 140.2679, 'latitude' => -8.243, 'days' => 4],
            ['station_name' => 'Tubang', 'district' => 'Merauke', 'subdistrict' => 'Tubang', 'longitude' => 139.1091, 'latitude' => -8.12539, 'days' => 3],
            ['station_name' => 'Sota', 'district' => 'Merauke', 'subdistrict' => 'Sota', 'longitude' => 140.998, 'latitude' => -8.42867, 'days' => 3],
            ['station_name' => 'Kimaam', 'district' => 'Merauke', 'subdistrict' => 'Kimaam', 'longitude' => 138.8646, 'latitude' => -7.98631, 'days' => 3],
            ['station_name' => 'Salor Indah', 'district' => 'Merauke', 'subdistrict' => 'Kurik', 'longitude' => 140.3602, 'latitude' => -8.2455, 'days' => 3],
            ['station_name' => 'Asikie', 'district' => 'Boven Digoel', 'subdistrict' => 'Jair', 'longitude' => 140.4232, 'latitude' => -6.642, 'days' => 2],
            ['station_name' => 'OBAA_MAPPI', 'district' => 'Mappi', 'subdistrict' => 'Obaa', 'longitude' => 139.31, 'latitude' => -6.528, 'days' => 2],
            ['station_name' => 'Mimibaru', 'district' => 'Merauke', 'subdistrict' => 'Jagebob', 'longitude' => 140.8015, 'latitude' => -8.18719, 'days' => 2],
            ['station_name' => 'Meteorologi Timika', 'district' => 'Timika', 'subdistrict' => 'Mimika Baru', 'longitude' => 136.55, 'latitude' => -4.75, 'days' => 2],
            ['station_name' => 'IWAKA_2', 'district' => 'Timika', 'subdistrict' => 'Iwaka_2', 'longitude' => 136.6891, 'latitude' => -4.36289, 'days' => 2],
            ['station_name' => 'Meteorologi Tanah Merah', 'district' => 'Boven Digoel', 'subdistrict' => 'Mandobo', 'longitude' => 140.3, 'latitude' => -6.09997, 'days' => 1],
            ['station_name' => 'ASSUE_MAPPI', 'district' => 'Mappi', 'subdistrict' => 'Assue', 'longitude' => 139.14, 'latitude' => -6.125, 'days' => 1],
            ['station_name' => 'JAGEBOB 11', 'district' => 'Merauke', 'subdistrict' => 'Jagebob', 'longitude' => 140.74, 'latitude' => -7.828, 'days' => 1],
            ['station_name' => 'JAGEBOB', 'district' => 'Merauke', 'subdistrict' => 'Jagebob', 'longitude' => 140.7587, 'latitude' => -8.05508, 'days' => 1],
            ['station_name' => 'ULILIN', 'district' => 'Merauke', 'subdistrict' => 'Ulilin', 'longitude' => 140.6627, 'latitude' => -7.32528, 'days' => 1],
            ['station_name' => 'Meteorologi Merauke', 'district' => 'Merauke', 'subdistrict' => 'Merauke', 'longitude' => 140.37, 'latitude' => -8.47, 'days' => 1],
            ['station_name' => 'Wayauw', 'district' => 'Merauke', 'subdistrict' => 'Animha', 'longitude' => 140.4541, 'latitude' => -7.97411, 'days' => 1],
            ['station_name' => 'Onggaya', 'district' => 'Merauke', 'subdistrict' => 'Naukenjerai', 'longitude' => 140.5628, 'latitude' => -8.69872, 'days' => 1],
            ['station_name' => 'Alfasera 2', 'district' => 'Merauke', 'subdistrict' => 'Muting', 'longitude' => 140.5921, 'latitude' => -7.40594, 'days' => 1],
            ['station_name' => 'Semangga', 'district' => 'Merauke', 'subdistrict' => 'Semangga', 'longitude' => 140.4687, 'latitude' => -8.40978, 'days' => 1],
            ['station_name' => 'Klimatologi Tanah Miring-Merauke', 'district' => 'Merauke', 'subdistrict' => 'Tanah Miring', 'longitude' => 140.5017, 'latitude' => -8.36889, 'days' => 1],
            ['station_name' => 'IWAKA', 'district' => 'Timika', 'subdistrict' => 'Iwaka', 'longitude' => 136.6316, 'latitude' => -4.45022, 'days' => 1],
            ['station_name' => 'AGATS', 'district' => 'Asmat', 'subdistrict' => 'Agats', 'longitude' => 138.429, 'latitude' => -6.00617, 'days' => 0],
            ['station_name' => 'ATSJ', 'district' => 'Asmat', 'subdistrict' => 'Atsj', 'longitude' => 138.6422, 'latitude' => -5.8225, 'days' => 0],
            // Nama pos tidak tercantum di baris sumber; pakai kode lokasi sebagai nama pos.
            ['station_name' => 'MINDIPTANA_BARU', 'district' => 'Boven Digoel', 'subdistrict' => 'Mindiptana Baru', 'longitude' => 140.7021, 'latitude' => -5.87528, 'days' => 0],
            ['station_name' => 'MANDOBO', 'district' => 'Boven Digoel', 'subdistrict' => 'Mandobo', 'longitude' => 140.3053, 'latitude' => -6.08667, 'days' => 0],
            ['station_name' => 'WAPEKO', 'district' => 'Merauke', 'subdistrict' => 'Kurik', 'longitude' => 140.3752, 'latitude' => -8.25856, 'days' => 0],
            ['station_name' => 'BUPUL', 'district' => 'Merauke', 'subdistrict' => 'Ulilin', 'longitude' => 140.7877, 'latitude' => -7.48547, 'days' => 0],
        ];

        // One coordinate represents one current reading; duplicate coordinates collapse to the last row.
        $latestByPoint = [];
        foreach ($observations as $observation) {
            $key = sprintf('%.6f:%.6f', $observation['latitude'], $observation['longitude']);
            $latestByPoint[$key] = $observation;
        }

        DB::transaction(function () use ($latestByPoint): void {
            HthObservation::query()->delete();

            foreach ($latestByPoint as $observation) {
                $days = (int) $observation['days'];
                HthObservation::create(array_merge($observation, [
                    'classification' => HthObservation::computeClassification($days),
                    'updated_date' => now()->toDateString(),
                ]));
            }
        });
    }
}
