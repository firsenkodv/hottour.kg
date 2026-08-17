<?php

namespace Support\Module;

use Illuminate\Database\Eloquent\Model;

class Module
{
    public function get($position,  Model $model):?ModuleData
    {

        return new ModuleData(
            $position,
            $model
        );

    }
}
