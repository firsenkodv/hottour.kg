<?php

namespace Domain\Travelcategory\ViewModels;


use App\Models\Travelcategory;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class TravelcategoryViewModel
{
    use Makeable;
    use MemoryCache;

    public function OneTravelcategory($slug)
    {
        $category = $this->travelcategories()->firstWhere('slug', $slug);
        return $category;


    }

    private function travelcategories()
    {
        return $this->cache(function () {
            return Travelcategory::query()
                ->get_travelcategory()
                ->get();
        });
    }

}
