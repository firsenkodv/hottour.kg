<?php

namespace App\Models;

use App\Models\Concerns\HasCategoryTemplates;
use Domain\Travelcategory\QueryBuilders\TravelcategoryQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travelcategory extends Model
{
    use HasCategoryTemplates;

    public $table = "travelcategories";

    protected $fillable = [
        'list_template',
        'teaser_template',
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'smalltext',
        'travelcategory_id',
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
        'sorting'
    ];

    protected $casts = [
        'params' => 'collection',
    ];


    /**
     * Создание метода вывода со своим TravelcategoryQueryBuilder
     */
    public function newEloquentBuilder($query):TravelcategoryQueryBuilder
    {
        return new TravelcategoryQueryBuilder($query);
    }

    public function travelitems():HasMany
    {
        return $this->hasMany(Travelitem::class);
    }



}
