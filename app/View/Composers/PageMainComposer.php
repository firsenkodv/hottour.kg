<?php

namespace App\View\Composers;

use App\Models\HotCategory;
use App\Models\Menu;
use App\Models\Page;
use Domain\Country\ViewModels\CountryViewModel;
use Illuminate\View\View;
use Support\Traits\MemoryCache;

class PageMainComposer
{
    use MemoryCache;

    public function compose(View $view): void
    {
        $main_page = $this->memo('add_to_main', function () {

            return Page::query()->where('add_to_main', 1)->first();
        });

        $view->with([
            'main_page' => $main_page,
        ]);

    }
}
