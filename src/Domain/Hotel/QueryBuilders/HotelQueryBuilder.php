<?php
namespace Domain\Hotel\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class HotelQueryBuilder extends Builder
{
    public function get_hotel($slug)
    {
        return $this->where('published', 1)->where('slug', $slug);

    }
    public function get_hotels($array)
    {
        return $this->where('published', 1)
                ->whereIn('slug', $array);


    }
}
