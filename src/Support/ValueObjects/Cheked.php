<?php

namespace Support\ValueObjects;

use Stringable;
use Support\Traits\Makeable;

class Cheked implements Stringable
{

    use Makeable;

    public function __construct(
        private  string $value
    )
    {
    }

    public function __toString()
    {
        // переводим 1 в checked для checkbox
        return ($this->value == 1)?'checked':'';

    }
}
