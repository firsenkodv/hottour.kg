<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    // modules
    public $table = "modules";

    protected $fillable = [
        'title',
        'published',
        'params',
        'sorting',
        'data_room1',
        'data_room2',
        'data_room3',
    ];

    protected $casts = [
        'params' => 'collection',
        'data_room1' => 'collection',
        'data_room2' => 'collection',
        'data_room3' => 'collection',
    ];

/*    public function parent():BelongsTo
    {
        return $this->belongsTo(Dump::class, 'dump_id');
    }*/



}
