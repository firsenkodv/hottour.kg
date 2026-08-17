<?php

namespace App\View\Composers;


use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\View\View;

class TopmenuComposer
{
    public function compose(View $view): void
    {

           $menu = MenuViewModel::make()->top_menu();

      //  dd($top_menu);

        $view->with([
            'top_menu' => $menu['top_menu'],
            'top_menu__left' => $menu['top_menu__left'],
            'top_menu__right' => $menu['top_menu__right'],
        ]);

    }
}
