<?php

namespace App\View\Composers;

use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\View\View;

class TopmenutoursComposer
{
    public function compose(View $view): void
    {

        $menu = MenuViewModel::make()->top_menutours();


        //  dd($top_menu);

        $view->with([
            'top_menutours' => $menu,
        ]);

    }
}
