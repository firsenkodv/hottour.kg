<?php
namespace Domain\Resort\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class ResortQueryBuilder extends Builder
{
/*    public function get_resorts($id)
    {
        return $this->where('published', 1)
            ->where('hot_category_id', $id)
            ->orderBy('sorting');

    }*/
    public function get_resorts($slug)
    {
        return $this->where('published', 1)->where('slug', $slug);

    }
}
