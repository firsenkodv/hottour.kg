<?php

namespace App\View\Composers;


use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\View\View;

class CountryMenuComposer
{
    public function compose(View $view): void
    {


        $menu = MenuViewModel::make()->country_menu();

        $view->with([
            'country_menu' => $menu
        ]);

    }
}
