<?php

namespace App\View\Composers;


use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\View\View;

class TopmenutravelcategoriesComposer
{
    public function compose(View $view): void
    {

   $menu = MenuViewModel::make()->top_menutravelcategories();

        $view->with([
            'top_menuhottour' => $menu,
        ]);

    }
}
