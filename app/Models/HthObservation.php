<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HthObservation extends Model
{
    protected $fillable = [
        'station_name',
        'district',
        'subdistrict',
        'latitude',
        'longitude',
        'days',
        'classification',
        'updated_date',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'days' => 'integer',
        'updated_date' => 'date',
    ];

    public const CLASSIFICATIONS = [
        '0 hari' => [
            'label' => '0 hari',
            'desc' => 'Ada Hujan / 0 Hari',
            'color' => '#0e4429',
        ],
        '1–5 hari' => [
            'label' => '1–5 hari',
            'desc' => 'Sangat Pendek (1–5 hari)',
            'color' => '#22c55e',
        ],
        '6–10 hari' => [
            'label' => '6–10 hari',
            'desc' => 'Pendek (6–10 hari)',
            'color' => '#facc15',
        ],
        '11–20 hari' => [
            'label' => '11–20 hari',
            'desc' => 'Menengah (11–20 hari)',
            'color' => '#f97316',
        ],
        '21–30 hari' => [
            'label' => '21–30 hari',
            'desc' => 'Panjang (21–30 hari)',
            'color' => '#b45309',
        ],
        '31–60 hari' => [
            'label' => '31–60 hari',
            'desc' => 'Sangat Panjang (31–60 hari)',
            'color' => '#df65b0',
        ],
        '>60 hari' => [
            'label' => '>60 hari',
            'desc' => 'Kekeringan Ekstrem (>60 hari)',
            'color' => '#991b1b',
        ],
    ];

    public static function computeClassification(int $days): string
    {
        if ($days === 0) return '0 hari';
        if ($days <= 5) return '1–5 hari';
        if ($days <= 10) return '6–10 hari';
        if ($days <= 20) return '11–20 hari';
        if ($days <= 30) return '21–30 hari';
        if ($days <= 60) return '31–60 hari';
        return '>60 hari';
    }

    public function getColorAttribute(): string
    {
        return self::CLASSIFICATIONS[$this->classification]['color'] ?? '#22c55e';
    }
}
