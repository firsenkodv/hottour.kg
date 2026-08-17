<?php
namespace Domain\TourvisorCountry\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;
class TourvisorCountryQueryBuilder extends Builder
{

    public function get_toutvisorcountries() {
        return $this->where('active', 1)
            ->orderBy('sorting');

    }
}
