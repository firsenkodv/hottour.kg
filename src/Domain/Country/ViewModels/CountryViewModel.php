<?php

namespace Domain\Country\ViewModels;

use App\Models\HotCategory;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Fluent;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class CountryViewModel
{
    use Makeable;
    use MemoryCache;

    /**
     * Содержимое страницы со списком стран: заголовок, описание категории
     * и метатеги. Своей модели у этой страницы нет — данные лежат в settings,
     * редактируются страницей «Страны» в админке.
     */
    public function getPageData(): Fluent
    {
        return $this->cache(fn () => new Fluent(Setting::getGroup('countries')->data ?? []));
    }

    public function listCountries()
    {
        $countries =  HotCategory::query()
            ->get_countries()
            ->paginate(20);

        return $countries;

    }

    public function listCountriesForMain()
    {
        return $this->cache(function () {

            return HotCategory::query()
                ->get_countries_for_main()
                ->get();
        });

    }

    public function OneCountry($slug)
    {
        $one_country = $this->allCountries()->firstWhere('slug', $slug);
        return $one_country;


    }

    private function allCountries()
    {
        return $this->cache(function () {
            return HotCategory::query()
                ->get_countries()
                ->get();
        });
    }

    public function HotCategoryRelation($slug)
    {
        $hot_category_relation = $this->itemsLight()->firstWhere('slug', $slug);
        return $hot_category_relation;


    }

    private function itemsLight()
    {
        return $this->cache(function () {
            return HotCategory::query()
                ->get_items_light();
        });
    }

    public function SubCountries($slug)
    {
        $id = ($this->OneCountry($slug))?$this->OneCountry($slug)->id:null;
        if (!is_null($id)) {
            return HotCategory::query()
                ->get_subcountry($id)
                ->get();

        }
        return false;
    }

}
