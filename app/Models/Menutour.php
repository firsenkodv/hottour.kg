<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menutour extends Model
{

    public $table = "menutours";


    protected $fillable = [
        'title',
        'published',
        'tour_id',
        'menu_id',
        'params',
        'sorting'
    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(Tour::class,  'tour_id');
    }
    public function menu():BelongsTo
    {
        return $this->belongsTo(self::class, 'menu_id');
    }




}
