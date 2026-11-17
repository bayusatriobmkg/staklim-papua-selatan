<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClimateEarlyWarning extends Model
{
    protected $fillable = [
        'category',
        'district',
        'status',
        'waspada_areas',
        'siaga_areas',
        'awas_areas',
        'description',
        'period',
    ];

    public const CATEGORIES = [
        'kekeringan' => 'Kekeringan',
        'hujan_lebat' => 'Hujan Lebat',
    ];

    public const STATUSES = [
        'tidak_ada' => 'Tidak Ada Peringatan',
        'waspada' => 'Waspada',
        'siaga' => 'Siaga',
        'awas' => 'Awas',
    ];

    public const STATUS_COLORS = [
        'tidak_ada' => '#16a34a',
        'waspada' => '#eab308',
        'siaga' => '#f97316',
        'awas' => '#dc2626',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? 'Tidak Ada Peringatan';
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? '#16a34a';
    }
}
