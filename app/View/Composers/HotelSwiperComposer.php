<?php

namespace App\View\Composers;

use App\Models\HotelMain;
use Illuminate\View\View;
use Support\Traits\MemoryCache;

class HotelSwiperComposer
{
    use MemoryCache;

    public function compose(View $view): void
    {
        $view->with([
            'hotel_swiper' => $this->hotels(),
        ]);
    }

    /**
     * Таблица hotel_mains перезаписывается кроном mainhotels:cron,
     * поэтому долгий кеш здесь не ставим — достаточно мемоизации
     * в пределах запроса (композер вызывается на каждый @include).
     */
    private function hotels()
    {
        return $this->cache(fn () => HotelMain::query()
            ->take(30)
            ->get());
    }
}
