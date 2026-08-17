<?php

namespace App\View\Composers;

use App\Models\Menudump2;
use Domain\Menu\ViewModels\MenuViewModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class Topmenudump2sComposer
{
    public function compose(View $view): void
    {

$menu = MenuViewModel::make()->top_menudump2s();


        $view->with([
            'top_menudump2s' => $menu,
        ]);

    }
}
