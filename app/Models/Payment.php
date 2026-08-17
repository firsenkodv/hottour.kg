<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_number',
        'amount',
        'desc',
        'params',
        'user_id',
        'order_id',
        'currency',
        'order_status',
        'lang',
        'data'
    ];

    protected $casts = [
        'params' => 'collection',
        'data' => 'collection',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function getStatusAttribute()
    {
       if($this->order_status == 2) {
           return 'Оплачено';
       }

       return 'Не оплачено';

    }



}
