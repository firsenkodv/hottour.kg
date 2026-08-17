<?php

namespace App\Http\Controllers\Tourvisor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Tourvisor\Service\Ajax;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\HotCategory;
use App\Models\Hotel;
use Illuminate\Http\Request;

class TourvisorController extends Controller
{



    public function pageTours(Request $request) {

       return view('pages.find-tour');
    }



   public function pageNewTours(Request $request) {


        $daterange = ($request->daterange)?explode(' - ', $request->daterange):[date('d.m.Y',strtotime("+1 day")), date('d.m.Y',strtotime("+7 day"))];

        $nightsfrom = ($request->nightsfrom)?:6;

        $nightsto = ($request->nightsto)?:12;

        $adults = ($request->adults)?:2;

        $child = ($request->child)?:0;

        $child_value[0] = 0;
        $child_year = [];

        if($child) {
            $child_value = explode(':', $child);
            if(isset($child_value[1])) {
                $child_year = ($child_value) ? explode(',', $child_value[1]) : [];
            }
        }

            /*
                dump($child);
                dump($child_value);
                dump($child_year);
            */

        $infant = ($request->infant)?:0;
        $api = new Tourvisor();
        $departures = $api->getDeparture();
        $countries = $api->getCountry();
        $regions = $api->getRegions()->lists->regions->region;

        $hotels = [];
       // $hotels = $api->getHotels()->lists->hotels->hotel;

    //   dd($countries);

       return view('pages.find-tour-new', [
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
        ]);
    }

    public function redirtect_toHotel($slug) {

        $hotel =  Hotel::query()
            ->where('slug', $slug)->first();
        if($hotel) {
            $subcategory_id = $hotel->parent->id;
            $subcategory = HotCategory::query()
                ->where('id', $subcategory_id)->first();
            $category_id = $subcategory->parent->id;
            $category = HotCategory::query()
                ->where('id', $category_id)->first();
            $url = config('links.link.countries').'/'.$category->slug.'/'.$subcategory->slug.'/'.$slug;
        } else {

            $url=  config('links.link.countries');
        }
        return redirect($url);

    }

    public function hotTours() {
        $api = new Tourvisor();

       // dd(departure());
        return view('pages.test', [
            'departures' => countries(),
        ]);
    }

    public function pageHotels() {

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

        /*  dd($departures);  */

        return view('pages.find-hotels', [
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

        ]);

    }

    public function autocomplete(Request $request)
    {

        $search = trim($request->term);
        $result = Hotel::query()
            ->where("title", "like", "%" . $search . "%")
            ->where('published', 1)
            ->limit(15)->get()->toArray();


        header('Content-Type: application/json');
        return response()->json($result);

    }

    public function ajax(Request $request) {

        $ajax = new Ajax($request);
        $action = $ajax->input['action'];

        if($action) {
            $response = $ajax->$action();
        }

        if(!empty($response) && empty($response->error)){
            $response->success = true;
            $head = "HTTP/1.0 200 OK";

        } else {
            $response = (object)['success' => true];
            $head = "HTTP/1.0 401 fail";
        }

        header($head);
        header('Content-Type: application/json');

     //   echo json_encode($response, JSON_UNESCAPED_UNICODE);
          return response()->json( $response);

    }
}
