<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoonshineCalculator extends Model
{
    protected $table = 'moonshine_calculators';

    protected $fillable = [
        'key',
        'banks',
        'countries'
    ];
    protected $casts = [
        'banks' => 'collection',
        'countries' => 'collection'
    ];

}
