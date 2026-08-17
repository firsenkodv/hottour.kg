<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityAirport extends Model
{
    protected $table = 'cities_airports';

    public $timestamps = false;

    protected $fillable = [
        'city_ru',
        'city_en',
        'country_ru',
        'country_code',
        'population',
        'latitude',
        'longitude',
    ];
}
