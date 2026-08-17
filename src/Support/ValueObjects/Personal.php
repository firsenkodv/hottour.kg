<?php

namespace Support\ValueObjects;

use Stringable;
use Support\Traits\Makeable;

class Personal implements Stringable
{

    use Makeable;

    public function __construct(
        private  string $value
    )
    {
    }
    public function value(): int
    {
        return $this->value;
    }


    public function __toString()
    {
        if($this->value == 1) {
            return config('datastorage.naturalPerson');
        }

        if($this->value == 2) {
            return config('datastorage.legalEntity');
        }

        return $this->value;

    }

}
