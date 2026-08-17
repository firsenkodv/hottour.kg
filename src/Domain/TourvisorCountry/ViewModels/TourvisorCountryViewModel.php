<?php

namespace Domain\TourvisorCountry\ViewModels;

use App\Models\TourvisorCountry;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class TourvisorCountryViewModel
{
    use Makeable;
    use MemoryCache;


    /**
     * Tourvisor дёргает справочник в getCountry/getCountries/getCountriesId/
     * getCountryName — за один запрос это было до четырёх одинаковых выборок.
     */
    public function Countries()
    {
        return $this->cache(function () {
            return TourvisorCountry::query()
                ->get_toutvisorcountries()
                ->get()->toArray();
        });
    }

}
