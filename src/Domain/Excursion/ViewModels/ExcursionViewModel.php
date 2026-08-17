<?php
namespace Domain\Excursion\ViewModels;

use App\Models\Excursion;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class ExcursionViewModel
{
    use Makeable;

    public function OneExcursion($slug)
    {
            $excursion =  Excursion::query()
            ->get_excursions($slug)
            ->first();

        return $excursion;

    }

}
