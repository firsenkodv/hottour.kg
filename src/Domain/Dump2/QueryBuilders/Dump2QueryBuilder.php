<?php
namespace Domain\Dump2\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class Dump2QueryBuilder extends Builder
{
    public function get_dump2s()
    {
        return $this->where('published', 1);

    }

}

