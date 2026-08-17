<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractRoom extends Model
{
    protected $table = 'contract_rooms';

    protected $fillable = [
        'title',
    ];
}
