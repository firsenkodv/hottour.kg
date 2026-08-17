<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLoadContact extends Model
{
    protected $table = 'change_load_contacts';
    protected $fillable = [
        'key',
        'title',
        'phone',
        'whatsapp',
        'telegram',
        'phone_mode',
        'whatsapp_mode',
        'telegram_mode',
        'phone_published',
        'whatsapp_published',
        'telegram_published',
    ];
}
