<?php

namespace App\View\Composers;

use App\Models\CustomerHotTour;
use Illuminate\View\View;
use Support\Traits\MemoryCache;

class HotToursSwiperComposer
{
    use MemoryCache;

    public function compose(View $view): void
    {

        $swiper_hot_tours = $this->memo('swiper_hot_tour', function () {
        return  CustomerHotTour::query()
            // Шаблон include/module/hottours.blade.php строит ссылку через
            // $item->parent->parent->slug (тур → категория горящих туров).
            // Без eager loading это давало по 2 запроса на каждую карточку.
            ->with(['parent.parent'])
            ->where('published', true)
            ->take(100)
            ->orderBy('sorting')
            ->get();

          });


        $view->with([
            'swiper_hot_tours' => $swiper_hot_tours,
        ]);

    }
}
