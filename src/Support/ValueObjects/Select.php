<?php

namespace Support\ValueObjects;

use Stringable;
use Support\Traits\Makeable;

class Select implements Stringable
{

    use Makeable;



    public function __construct(   private string $value )
    {
    }

    public function value():string
    {
        return $this->value;
    }



    public function __toString()
    {


        if (is_null($this->value)) {
            return '--';
        }


        return ($this->value)?:'--';

    }
}
