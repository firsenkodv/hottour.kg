<?php
namespace Domain\Tour\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class TourQueryBuilder extends Builder
{
    public function get_tours()
    {
        return $this->where('published', 1);

    }

}


