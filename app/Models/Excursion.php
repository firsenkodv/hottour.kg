<?php

namespace App\Models;

use App\Models\Concerns\HasItemTemplate;
use Domain\Excursion\QueryBuilders\ExcursionQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Excursion extends Model
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
        'hot_category_id',
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
     * Создание метода вывода со своим ExcursionQueryBuilder
     */
    public function newEloquentBuilder($query):ExcursionQueryBuilder
    {
        return new ExcursionQueryBuilder($query);
    }


}
