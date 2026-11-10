<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClimateSuitability extends Model
{
    protected $fillable = ['district', 'period', 'probability', 'humidity', 'confidence'];

    protected function casts(): array
    {
        return ['probability' => 'float', 'humidity' => 'float'];
    }
}
