<?php
namespace Domain\Publ\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class PublQueryBuilder extends Builder
{
    public function get_publs()
    {
        return $this->where('published', 1)
            ->orderBy('created_at');

    }

}

