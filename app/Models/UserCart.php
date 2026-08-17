<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCart extends Model
{
    protected $table = 'user_carts';

    protected $fillable = [
        'title',
        'subtitle',
        'params',
        'user_id',
        'country',
        'region',
        'city',
        'url',
    ];
    protected $casts = [
        'params' => 'object',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
