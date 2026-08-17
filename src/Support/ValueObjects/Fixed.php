<?php

namespace Support\ValueObjects;

use App\Models\User;
use Stringable;
use Support\Traits\Makeable;

class Fixed implements Stringable
{

    use Makeable;

    public function __construct(
        private   $value = null
    )
    {
    }
    public function value()
    {
        return $this->value;
    }


    public function __toString()
    {
            if($this->value) {
                $user = User::query()->where('id', $this->value)->first();
                return ($user->fio) ?? $user->name;
            }
            return '';

    }

}
