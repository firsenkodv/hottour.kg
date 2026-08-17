<?php

namespace App\View\Composers;

use App\Models\HotCategory;
use App\Models\Menu;
use Domain\Country\ViewModels\CountryViewModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class CountryMainComposer
{
    public function compose(View $view): void
    {

        $countries = CountryViewModel::make()->listCountriesForMain();


        $view->with([
            'main_countries' => $countries,
        ]);

    }
}
