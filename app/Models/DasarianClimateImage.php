<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DasarianClimateImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'period_label',
        'image_path',
        'description',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'analisis' => 'Analisis Curah Hujan',
            'prediksi' => 'Prediksi Curah Hujan',
            'peluang' => 'Peluang Curah Hujan',
            default => 'Informasi Dasarian',
        };
    }

    public function getCategoryColorAttribute(): string
    {
        return match ($this->category) {
            'analisis' => '#0284c7', // BMKG Blue
            'prediksi' => '#0d9488', // Teal
            'peluang' => '#d97706',  // Amber / Gold
            default => '#475569',
        };
    }
}
