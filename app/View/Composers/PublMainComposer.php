<?php

namespace App\View\Composers;

use Domain\Dump\ViewModels\DumpViewModel;
use Illuminate\View\View;
use Support\Traits\MemoryCache;

class PublMainComposer
{
    use MemoryCache;

    public function compose(View $view): void
    {

        $category = DumpViewModel::make()->OneDumpForId(1);
        // 1 = это новости // плохо, но ничего лучше не придумал

        $publs = $this->memo('main_publs', function () use ($category) {
            return (count($category->publs)) ? $category->publs()->orderBy('created_at', 'DESC')->take(4)->get() : [];
        });

        $view->with([
            'main_publs' => $publs,
            'main_category' => $category,
        ]);

    }
}
