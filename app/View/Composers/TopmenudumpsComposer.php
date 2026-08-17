<?php

namespace App\View\Composers;



use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\View\View;

class TopmenudumpsComposer
{
    public function compose(View $view): void
    {


$menu = MenuViewModel::make()->top_menudumps();

      //  dd($top_menu);

        $view->with([
            'top_menudumps' => $menu,
        ]);

    }
}
