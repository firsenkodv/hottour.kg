<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSurvey extends Model
{
    protected $table = 'user_surveys';

    protected $fillable = [

        'ip',
        'star',
        'desc',
        'params',
        'user_id',
    ];


    protected $casts = [
        'params' => 'collection',
    ];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
