<?php

namespace App\Models;

use App\Models\Concerns\HasItemTemplate;
use Domain\Info\QueryBuilders\InfoQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Info extends Model
{
    use HasItemTemplate;


    protected $fillable = [
        'template',
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
        'published',
        'params',
        'metatitle',
        'description',
        'keywords',
        'html',
        'custom_css',
        'sorting',
        'script_published',
        'script',
        'tourvisor_module_id'

    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(HotCategory::class,  'hot_category_id');
    }

    /**
     * Создание метода вывода со своим InfoQueryBuilder
     */
    public function newEloquentBuilder($query):InfoQueryBuilder
    {
        return new InfoQueryBuilder($query);
    }


}
