<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserFavorite extends Model
{

    protected $table = 'user_favorites';

    protected $fillable = [
        'title',
        'subtitle',
        'params',
        'hotelid',
        'user_id',
        'country',
        'region',
        'city',
        'url',
        'favorite_id',
    ];
    protected $casts = [
        'params' => 'object',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
