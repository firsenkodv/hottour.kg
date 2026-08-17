<?php
namespace Domain\Travelcategory\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class TravelcategoryQueryBuilder extends Builder
{
    public function get_travelcategory()
    {
        return $this->where('published', 1);

    }

}


