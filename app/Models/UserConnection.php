<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserConnection extends Model
{
protected $table = 'user_connections';

protected $fillable = [
    'title',
    'phone',
    'email',
    'whatsapp',
    'telegram',
    'info',
    'params',
    'user_id',

];
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,  'user_id');
    }

    protected $casts = [
        'params' => 'collection',
    ];

}
