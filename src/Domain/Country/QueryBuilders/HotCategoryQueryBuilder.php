<?php

namespace Domain\Country\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;


class HotCategoryQueryBuilder extends Builder
{
    public function get_countries()
    {
        return $this->where('published', 1)
            ->where('hot_category_id', null)
            ->orderBy('sorting');

    }
    public function get_countries_for_main()
    {
        return $this->where('published', 1)
            // Шаблон include/module/popular_country.blade.php перебирает
            // вложенные категории каждой страны — грузим их одним запросом.
            ->with(['child' => fn ($q) => $q->orderBy('sorting')])
            ->where('hot_category_id', null)
            ->where('main', 1)
            ->orderBy('sorting');

    }
    public function get_country($slug)
    {
        return $this->where('published', 1)

            ->where('slug', $slug);

    }

    public function get_subcountry($id)
    {
        return $this->where('published', 1)
            ->where('hot_category_id', $id)
            ->orderBy('sorting');


    }

    public function get_items()
    {
        return $this->where('published', 1)
            ->with(['excursions' => function ($q) {
                return $q->where('published', true);
            }])
            ->with(['resorts' => function ($q) {
                return $q->where('published', true);
            }])
            ->with(['hotels' => function ($q) {
                return $q->where('published', true);
            }])
            ->with(['infos' => function ($q) {
                return $q->where('published', true);
            }]);

    }

    public function get_items_light()
    {
        return $this->where('published', 1);

    }
}
