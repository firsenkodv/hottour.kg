<?php

namespace Domain\Tour\ViewModels;

use App\Models\HotCategory;
use App\Models\Tour;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class TourViewModel
{
    use Makeable;
    use MemoryCache;


    public function OneTour($slug)
    {
        $resort = $this->tours()->firstWhere('slug', $slug);
        return $resort;


    }

    private function tours()
    {
        return $this->cache(function () {
            return Tour::query()
                ->get_tours()
                ->get();
        });
    }

}
