<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappRecipient extends Model
{
    protected $fillable = ['district', 'name', 'phone'];
}
