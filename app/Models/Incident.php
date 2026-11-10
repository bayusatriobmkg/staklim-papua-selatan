<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = ['district', 'period', 'incidence'];

    protected function casts(): array
    {
        return ['incidence' => 'decimal:2'];
    }
}
