<?php
namespace Domain\Dump\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class DumpQueryBuilder extends Builder
{
    public function get_dumps()
    {
        return $this->where('published', 1);

    }

}

