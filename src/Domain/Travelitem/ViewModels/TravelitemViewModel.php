<?php

namespace Domain\Travelitem\ViewModels;


use App\Models\Travelcategory;
use App\Models\Travelitem;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class TravelitemViewModel
{
    use Makeable;
    use MemoryCache;

    public function OneTravelitem($slug)
    {
        $item = $this->travelitems()->firstWhere('slug', $slug);
        return $item;
    }

    private function travelitems()
    {
        return $this->cache(function () {
            return Travelitem::query()
                ->get_travelitem()
                ->get();
        });
    }

}
