<?php

namespace Support\ValueObjects;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Stringable;
use Support\Traits\Makeable;

class Name implements Stringable
{
/*
 * методы не используются
 * */
    use Makeable;

    public function __construct(
        private  string $value,
        private  Model $model,
        private  array $attributes,
        private  string $key,
    )
    {
    }

    public function value():string
    {
        return $this->value;
    }

    public function model():Model
    {
        return $this->model;
    }
    public function attributes():array
    {
        return $this->attributes;
    }

    public function fio():string
    {
        return ($this->model()->fio)??"";
    }

    public function company():string
    {
       $user =  User::query()->where('id', $this->model()->id)->first();
          return ($user->legalEntities->company)??"";
    }

    public function __toString()
    {

/*        if((int)$this->model()->personal->value() == 2) {
            // юр. лицо

            if($this->company()) {
                // организация заполнена

                return $this->company();
                    }

        }
        if($fio = $this->fio()) {
            return $fio;
        }*/
        return $this->value();
    }

}
