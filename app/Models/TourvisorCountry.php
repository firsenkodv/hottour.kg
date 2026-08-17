<?php

namespace App\Models;

use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use Domain\TourvisorCountry\QueryBuilders\TourvisorCountryQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourvisorCountry extends Model
{
    protected $table = "tourvisor_countries";

    protected $fillable = [
        'name',
        'country_id',
        'active',
        'flag',
        'popular',
        'hot_category_id',
        'default',
        'sorting'
    ];


    protected $casts = [
        'popular' => 'boolean',
        'active' => 'boolean',
        'default' => 'boolean',
    ];
    public function parent():BelongsTo
    {
        return $this->belongsTo(HotCategory::class,  'hot_category_id');
    }


    /**
     * Создание метода вывода со своим TourvisorCountryQueryBuilder
     */
    public function newEloquentBuilder($query):TourvisorCountryQueryBuilder
    {
        return new TourvisorCountryQueryBuilder($query);
    }


    protected static function boot()
    {
        parent::boot();


        # Проверка данных пользователя перед сохранением
        static::saving(function ($Moonshine) {
            $country_id = $Moonshine->country_id;

            $country = config('tourvisor.country')[$country_id];

            if(!$Moonshine->name) {
                $Moonshine->name = $country;
            }

            foreach (config('tourvisor.alpha2') as $flag => $alpha2) {
                if($alpha2 == $country) {
                    $Moonshine->flag = $flag;
                }

            }

        });






    }

}
