<?php

namespace Domain\Resort\ViewModels;

use App\Models\HotCategory;
use App\Models\Resort;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class ResortViewModel
{
    use Makeable;


    public function OneResort($slug)
    {
            $resort =  Resort::query()
                ->get_resorts($slug)
                ->first();

        return $resort;


    }

}
