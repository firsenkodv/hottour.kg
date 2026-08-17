<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menuhottour extends Model
{

    public $table = "menuhottours";

    protected $fillable = [
        'title',
        'published',
        'travelcategory_id',
        'menu_id',
        'params',
        'sorting'
    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(Travelcategory::class, 'travelcategory_id');
    }

}
