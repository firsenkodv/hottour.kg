<?php
namespace Domain\Travelitem\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class TravelitemQueryBuilder extends Builder
{
    public function get_travelitem()
    {
        return $this->where('published', 1);

    }

}


