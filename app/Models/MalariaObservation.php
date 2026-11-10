<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MalariaObservation extends Model
{
    protected $fillable = ['district', 'period', 'cases', 'humidity', 'temperature', 'rainfall'];

    protected function casts(): array
    {
        return [
            'cases' => 'integer',
            'humidity' => 'decimal:8',
            'temperature' => 'decimal:8',
            'rainfall' => 'decimal:8',
        ];
    }
}
