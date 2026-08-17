<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Dump;
use App\Models\Dump2;
use App\Models\Excursion;
use App\Models\HotCategory;
use App\Models\Hotel;
use App\Models\Info;
use App\Models\Page;
use App\Models\Publ;
use App\Models\Resort;
use App\Models\Tour;
use App\Models\Travelcategory;
use App\Models\Travelitem;
use Domain\Travelcategory\ViewModels\TravelcategoryViewModel;
use Illuminate\Support\Facades\DB;
use Storage;

class SitemapController
{

    /** Главнай sitemap.xml с разделениями, ссылками на разделы */

    public function index()
    {

        $page = Page::query()->orderBy('updated_at', 'desc')->first();
        $travel = Travelitem::query()->orderBy('updated_at', 'desc')->first();
        $tour = Tour::query()->orderBy('updated_at', 'desc')->first();
        $dump = Dump::query()->orderBy('updated_at', 'desc')->first();
        $dump2 = Dump2::query()->orderBy('updated_at', 'desc')->first();
        $country = HotCategory::query()->orderBy('updated_at', 'desc')->first();

        /**
         * отели выводим физическими файлами
         */

       $hotels = [];
       $files = Storage::disk('sitemap')->allFiles('sitemap');
       if($files) {
           $hs = array_map(function ($file) {
               return basename($file); // remove the folder name
           }, $files);
           foreach ($hs as $h) {
               $hotels[] = Storage::disk('sitemap')->url($h);
           }
       }
		//dd($hotels);


        return response()->view('sitemap.index', [
           'page' => $page,
            'travel' => $travel,
            'tour' => $tour,
            'dump' => $dump,
            'dump2' => $dump2,
            'country' => $country,
           'hotels' => $hotels,

        ])->header('Content-Type', 'text/xml');
    }

    /** Статичные страницы */

    public function pages()
    {
        $pages = Page::query()->orderBy('updated_at', 'desc')->take(1000)->get();

        return response()->view('sitemap.pages', [
            'pages' => $pages

        ])->header('Content-Type', 'text/xml');
    }

    /** Категория пункт меню  "горящие туры", с материалами  */

    public function travels()
    {

        $travelCategories = Travelcategory::query()->where('published', 1)->take(1000)->get();
        $travelItems = Travelitem::query()->where('published', 1)->take(1000)->get();

        return response()->view('sitemap.travels', [
            'travelCategories' => $travelCategories,
            'travelItems' => $travelItems
        ])->header('Content-Type', 'text/xml');

    }

    /** Список пункт меню  "туры" материалами  */

    public function tours()
    {

        $tours = Tour::query()->where('published', 1)->take(1000)->get();

        return response()->view('sitemap.tours', [
            'tours' => $tours,
        ])->header('Content-Type', 'text/xml');

    }


    /** Категория пункт меню  "полезное",  категории и материалы из модели Publ */

    public function dumps()
    {

        $dumpsCategories = Dump::query()->where('published', 1)->take(1000)->get();
        $dumpsItems = Publ::query()->where('published', 1)->take(1000)->get();


        return response()->view('sitemap.dumps', [
            'dumpsCategories' => $dumpsCategories,
            'dumpsItems' => $dumpsItems,
        ])->header('Content-Type', 'text/xml');

    }


    /** Категория пункт меню  "полезное",  категории и материалы из модели Company*/

    public function dumps2()
    {

        $dumpsCategories2 = Dump2::query()->where('published', 1)->take(1000)->get();
        $dumpsItems2 = Company::query()->where('published', 1)->take(1000)->get();

        return response()->view('sitemap.dumps2', [
            'dumpsCategories2' => $dumpsCategories2,
            'dumpsItems2' => $dumpsItems2,
        ])->header('Content-Type', 'text/xml');

    }


    /** Категория пункт меню  "страны",  категории и материалы из нескольких моделей -  */
    /** Resort */
    /** Info */
    /** Excursion */

    public function countries()
    {

        $countryCategories = HotCategory::query()->where('published', 1)->take(1000)->get();
        $infos = Info::query()->where('published', 1)->take(10000)->get();
        $resorts = Resort::query()->where('published', 1)->take(10000)->get();
        $excursions = Excursion::query()->where('published', 1)->take(10000)->get();
        // $dumpsItems2  = Company::query()->where('published', 1)->take(1000)->get();
        // dump($countryCategories);
        return response()->view('sitemap.countries', [
            'countryCategories' => $countryCategories,
            'infos' => $infos,
            'resorts' => $resorts,
            'excursions' => $excursions,
        ])->header('Content-Type', 'text/xml');

    }

    /** Категория пункт меню  "страны",  только  материалы из модели - Hotel   */
    /**
     * Отели обрабатываются отдельно cron командой
     * sitemap-hotels:cron
     */
    /**
     **/

    public function hotels()
    {

          return false;
    }


}
