<?php

namespace App\Models;

use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerHotTour extends Model
{
    public $table = "customer_hot_tours";

    protected $fillable = [
        'cityname',
        'countryname',
        'params',
        'published',
        'travelitem_id',
        'img',
        'title',
        'subtitle',
        'procent',
        'sorting',

    ];
    protected $casts = [
        'params' => 'collection',
    ];


    public function parent():BelongsTo
    {
        return $this->belongsTo(Travelitem::class,  'travelitem_id');
    }



/*    public function getCustomerCurrencyAttribute()
    {
        foreach (config('currency.currency') as $k => $currency) {
            if ($k == $this->params['currency']) {
                return customer_currency($currency);
            }
        }

    }*/

    public function customerCurrency():Attribute
    {
        return Attribute::make(
            function() {

                foreach (config('currency.currency') as $k => $currency) {
                    if ($k == $this->params['currency']) {
                        return $currency;
                    }
                }
                return '';

            }
        );
    }

    protected static function boot()
    {
        parent::boot();

        # Проверка данных пользователя перед сохранением
        static::saving(function ($Moonshine) {
            $city = $Moonshine->getOriginal('city');
            $country = $Moonshine->getOriginal('country');
            $Moonshine->cityname = getDepartureName($city);
            $Moonshine->countryname = getCountryName($country);



            $api = new Tourvisor();
            $result_api = ($api->getHotTours($city, $country))?:[];

            if(!empty($result_api)) {
                if((int)$result_api->hottours->hotcount > 0) {
                    // $tours =  $result_api->hottours->tour;
                    $first = current($result_api->hottours->tour);
                    // $last = end($result_api->hottours->tour);


                    $Moonshine->params = $first;

                    //  dd($result_api->hotcount);


                    $price = round($first->price);
                    $priceold = round($first->priceold);

                    // dd(number_format(($priceold - $price) * 100/ $price));
                    $pr = number_format(($priceold - $price) * 100 / $price);
                    if ($pr == abs($pr)) {
                        $Moonshine->procent = $pr; // Число положительное
                    }

                    if ($pr != abs($pr)) {
                        $Moonshine->procent = 0; // Число отрицательное
                    }
                } else {
                    $Moonshine->params = [];
                    $Moonshine->procent = 0;
                    $Moonshine->published = 0;
                }
            } else {
                $Moonshine->params = [];
                $Moonshine->procent = 0;
                $Moonshine->published = 0;
            }

         //   dump($Moonshine->travelitem_id);

        });






    }


}
