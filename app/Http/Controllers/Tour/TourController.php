<?php

namespace App\Http\Controllers\Tour;

use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\HotCategory;
use Domain\Country\ViewModels\CountryViewModel;
use Domain\Excursion\ViewModels\ExcursionViewModel;
use Domain\Hotel\ViewModels\HotelViewModel;
use Domain\Info\ViewModels\InfoViewModel;
use Domain\Resort\ViewModels\ResortViewModel;
use Domain\Tour\ViewModels\TourViewModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class TourController extends Controller
{




    public function page($slug)
    {
        /**
         * Страница вывода страны
         **/

        $item = TourViewModel::make()->OneTour($slug);

        return view('pages.tours.item', [
            'item' => $item,
            'template' => $item->itemTemplate(),

        ]);

    }




}
