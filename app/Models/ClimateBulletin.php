<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClimateBulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'edition',
        'release_date',
        'description',
        'cover_image',
        'file_path',
        'external_link',
        'page_count',
        'file_size',
        'is_published',
        'order',
    ];

    protected $casts = [
        'release_date' => 'date',
        'is_published' => 'boolean',
        'page_count' => 'integer',
        'order' => 'integer',
    ];

    public function getFormattedDateAttribute(): string
    {
        if (!$this->release_date) {
            return '-';
        }

        return Carbon::parse($this->release_date)->locale('id')->isoFormat('D MMMM Y');
    }

    public function getDownloadUrlAttribute(): ?string
    {
        if ($this->file_path && file_exists(public_path($this->file_path))) {
            return asset($this->file_path);
        }

        if ($this->external_link) {
            return $this->external_link;
        }

        return null;
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->cover_image && file_exists(public_path($this->cover_image))) {
            return asset($this->cover_image);
        }

        return asset('images/default-bulletin-cover.svg');
    }
}
