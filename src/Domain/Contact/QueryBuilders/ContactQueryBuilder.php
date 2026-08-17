<?php

namespace Domain\Contact\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;


class ContactQueryBuilder extends Builder
{
    public function get_contacts()
    {
        return $this->where('published', true);


    }

}
