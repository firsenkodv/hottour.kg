<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menudump extends Model
{
    public $table = "menudumps";


    protected $fillable = [
        'title',
        'published',
        'dump_id',
        'menu_id',
        'params',
        'sorting'
    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(Dump::class,  'dump_id');
    }




}
