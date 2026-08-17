<?php

namespace App\Http\Controllers;

use App\Events\OrderCallEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\HotCategory;
use App\Models\MoonshineSetting;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {


        $item = (Page::query()->where('slug', 'home')->first()) ?: [];

        $api = new Tourvisor();
        $departures = $api->getDeparture();
        $countries = $api->getCountry();

        $regions = $api->getRegions()->lists->regions->region;
        $hotels = [];

        $daterange = [date('d.m.Y', strtotime("+1 day")), date('d.m.Y', strtotime("+7 day"))];

        $nightsfrom = 6; /* мин ночей (количество) строка  */
        $nightsto = 12; /* макс ночей (количество) строка  */
        $adults = 2; /* взрослые (количество) строка  */
        $child = 0; /* сколько детей (количество) строка  */
        $child_value[0] = 0; /* сколько детей (количество) массив */
        $child_year = []; /* сколько лет детям  массив */
        $infant = 0; /* дети до двух лет строка */

        $hot_counrty = HotCategory::find(1);



        return view('home', [
            'hot_country' => $hot_counrty,
            'departures' => $departures,
            'countries' => $countries,
            'regions' => $regions,
            'hotels' => $hotels,
            'api' => $api,
            'daterange' => $daterange,
            'nightsfrom' => $nightsfrom,
            'nightsto' => $nightsto,
            'adults' => $adults,
            'child' => $child,
            'child_value' => $child_value,
            'child_year' => $child_year,
            'infant' => $infant,
            'item' => $item,
        ]);
    }


}
