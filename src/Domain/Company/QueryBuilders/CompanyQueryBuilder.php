<?php
namespace Domain\Company\QueryBuilders;
use Illuminate\Database\Eloquent\Builder;

class CompanyQueryBuilder extends Builder
{
    public function get_companies()
    {
        return $this->where('published', 1)
            ->orderBy('created_at');

    }

}

