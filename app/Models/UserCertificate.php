<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCertificate extends Model
{
    protected $table = 'user_certificates';

    protected $fillable = [
        'title',
        'subtitle',
        'country_from',
        'country_to',
        'price',
        'params',
        'date',
        'user_id',


    ];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'params' => 'collection',
    ];

}
