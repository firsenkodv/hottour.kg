<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeStatistic extends Model
{
protected $table = 'change_statistics';

    protected $fillable = [
        'phone',
        'whatsapp',
        'telegram',
        'created_at'
    ];


}
