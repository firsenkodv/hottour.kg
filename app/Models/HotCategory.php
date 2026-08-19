<?php

namespace App\Models;

use App\Models\Concerns\HasCategoryTemplates;
use App\Models\Concerns\HasItemTemplate;
use Domain\Country\QueryBuilders\HotCategoryQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class HotCategory extends Model
{
    use HasItemTemplate;
    use HasCategoryTemplates;


    protected $fillable = [
        'template',
        'list_template',
        'teaser_template',
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'imgflag',
        'hot_category_id',
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
        'tourvisor_module_id',
    ];
    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(self::class,  'hot_category_id');
    }

    public function child():HasMany
    {
        return $this->hasMany(self::class,  'hot_category_id');
    }

    public function excursions():HasMany
    {
        return $this->hasMany(Excursion::class);
    }

    public function resorts():HasMany
    {
        return $this->hasMany(Resort::class);
    }

    public function hotels():HasMany
    {
        return $this->hasMany(Hotel::class);
    }

    public function infos():HasMany
    {
        return $this->hasMany(Info::class);
    }

    /**
     * Создание метода вывода со своим HotCategoryQueryBuilder
     */
    public function newEloquentBuilder($query):HotCategoryQueryBuilder
    {
        return new HotCategoryQueryBuilder($query);
    }



}
