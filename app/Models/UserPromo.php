<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPromo extends Model
{
    protected $table = 'user_promos';
    protected $fillable = [
        'code',
        'user_id',
    ];

}
