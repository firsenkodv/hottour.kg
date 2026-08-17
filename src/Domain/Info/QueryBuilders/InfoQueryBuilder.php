<?php
namespace Domain\Info\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class InfoQueryBuilder extends Builder
{
    public function get_infos($slug)
    {
        return $this->where('published', 1)->where('slug', $slug);

    }
}

