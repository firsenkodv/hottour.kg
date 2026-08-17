<?php

namespace App\View\Composers;

use Domain\Dump\ViewModels\DumpViewModel;
use Domain\Dump2\ViewModels\Dump2ViewModel;
use Illuminate\View\View;
use Support\Traits\MemoryCache;

class OtzMainComposer
{
    use MemoryCache;

    public function compose(View $view): void
    {

        $category = Dump2ViewModel::make()->OneDump2ForId(1);
        // 1 = это отзывы // плохо, но ничего лучше не придумал

        $otz = $this->memo('main_otz', function () use ($category) {
            return (count($category->companies)) ? $category->companies()->orderBy('created_at', 'DESC')->take(40)->get() : [];
        });

        $view->with([
            'main_otz' => $otz,
            'main_category' => $category,
        ]);

    }
}
