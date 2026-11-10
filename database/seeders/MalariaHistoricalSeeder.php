<?php

namespace Database\Seeders;

use App\Models\MalariaObservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MalariaHistoricalSeeder extends Seeder
{
    public function run(): void
    {
        $file = database_path('seeders/data/malaria_historical.tsv');
        $handle = fopen($file, 'r');

        if ($handle === false) {
            throw new \RuntimeException('Data historis malaria tidak dapat dibaca.');
        }

        DB::transaction(function () use ($handle): void {
            while (($columns = fgetcsv($handle, 0, "\t")) !== false) {
                if (count($columns) !== 8) {
                    continue;
                }

                [$district, , $year, $month, $cases, $humidity, $temperature, $rainfall] = $columns;
                $period = sprintf('%04d-%02d', (int) $year, (int) $month);

                MalariaObservation::updateOrCreate(
                    ['district' => trim($district), 'period' => $period],
                    [
                        'cases' => (int) $cases,
                        'humidity' => trim($humidity),
                        'temperature' => trim($temperature),
                        'rainfall' => trim($rainfall),
                    ],
                );
            }
        });

        fclose($handle);
    }
}
