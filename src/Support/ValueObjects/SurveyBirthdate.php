<?php

namespace Support\ValueObjects;

use Stringable;
use Support\Traits\Makeable;

class SurveyBirthdate implements Stringable
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
        $value = explode(":", $this->value);
        if($value) {
            $result = "От $value[0] ";
            $result .= "до $value[1] лет";
            return $result;

        }

        return $this->value;

    }
}
