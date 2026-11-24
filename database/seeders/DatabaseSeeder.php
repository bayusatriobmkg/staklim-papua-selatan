<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $existingAdmin = \App\Models\User::where('email', 'staklim.merauke@gmail.com')->first();
        if ($existingAdmin) {
            $existingAdmin->update([
                'email' => 'staklim.merauke@bmkg.go.id',
                'name' => 'Admin Stasiun Klimatologi Papua Selatan',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            ]);
        } else {
            \App\Models\User::updateOrCreate(
                ['email' => 'staklim.merauke@bmkg.go.id'],
                [
                    'name' => 'Admin Stasiun Klimatologi Papua Selatan',
                    'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                ]
            );
        }

        \App\Models\User::updateOrCreate(
            ['email' => 'pentest@bmkg.go.id'],
            [
                'name' => 'Akun Pentest BMKG',
                'password' => \Illuminate\Support\Facades\Hash::make('pentest123!'),
            ]
        );

        \App\Models\ClimateBulletin::updateOrCreate(
            ['edition' => 'Edisi November 2026'],
            [
                'title' => 'Buletin Informasi Iklim Provinsi Papua Selatan',
                'release_date' => '2026-11-15',
                'description' => 'Publikasi resmi bulanan Stasiun Klimatologi Papua Selatan memuat analisis dinamika atmosfer (ENSO, IOD, MJO), evaluasi curah hujan dasarian dan bulanan Oktober 2026, monitoring hari tanpa hujan (HTH), prakiraan curah hujan dan sifat hujan 3 bulan ke depan (Desember 2026 - Februari 2027), serta rekomendasi iklim untuk sektor pertanian di Kabupaten Merauke, Boven Digoel, Mappi, dan Asmat.',
                'cover_image' => 'images/default-bulletin-cover.svg',
                'file_path' => null,
                'external_link' => 'https://staklim-papuaselatan.bmkg.go.id/storage/buletin-iklim-nov-2026.pdf',
                'page_count' => 28,
                'file_size' => '5.4 MB',
                'is_published' => true,
                'order' => 1,
            ]
        );

        \App\Models\ClimateBulletin::updateOrCreate(
            ['edition' => 'Edisi Oktober 2026'],
            [
                'title' => 'Buletin Informasi Iklim Provinsi Papua Selatan',
                'release_date' => '2026-10-15',
                'description' => 'Memuat evaluasi puncak kemarau, transisi awal musim hujan, analisis sifat hujan Dasarian III September 2026, dan prospek agroklimat musim tanam rendengan di Merauke.',
                'cover_image' => 'images/default-bulletin-cover.svg',
                'file_path' => null,
                'external_link' => 'https://staklim-papuaselatan.bmkg.go.id/storage/buletin-iklim-okt-2026.pdf',
                'page_count' => 24,
                'file_size' => '4.8 MB',
                'is_published' => true,
                'order' => 2,
            ]
        );
    }
}
