<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoonshineSetting extends Model
{
    protected $table = 'moonshine_settings';

    protected $fillable = [

        'key',
        'bonus',
        'ball',
        'cashback',
        'fullAddress',
        'address',
        'country',
        'sityAddress',
        'idn',
        'phone1',
        'phone2',
        'whatsapp',
        'telegram',
        'facebook',
        'instagram',
        'youtube',
        'company_name',
        'bin'
    ];
}
