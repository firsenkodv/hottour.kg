<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractFood extends Model
{
    protected $table = 'contract_foods';

    protected $fillable = [
        'title',
    ];
}
