<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
protected $table = "rooms";

    protected $fillable = [
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'imgflag',
        'gallery',
        'smalltext',
        'text',
        'text2',
        'pageimg1',
        'text3',
        'pageimg2',
        'text',

        'stars',
        'rating',
        'placement',
        'desc',
        'imagescount',
        'regioncode',
        'build',
        'repair',
        'coord',
        'hot_category_id',
        'country_id',
        'region_id',


        'published',
        'params',
        'metatitle',
        'description',
        'keywords',
        'html',
        'custom_css',
        'sorting'
    ];


    protected $casts = [
        'params' => 'collection',
    ];
    public function parent():BelongsTo
    {
        return $this->belongsTo(HotCategory::class,  'hot_category_id');
    }


}
