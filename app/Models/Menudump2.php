<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menudump2 extends Model
{
    // menudump2s
    public $table = "menudump2s";


    protected $fillable = [
        'title',
        'published',
        'dump2_id',
        'menu_id',
        'params',
        'sorting'
    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(Dump2::class,  'dump2_id');
    }




}
