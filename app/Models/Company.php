<?php

namespace App\Models;

use App\Models\Concerns\HasItemTemplate;
use Domain\Company\QueryBuilders\CompanyQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Company extends Model
{
    use HasItemTemplate;

    // companies
    public $table = "companies";

    protected $fillable = [
        'template',
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'publ_id',
        'dump2_id',
        'smalltext',
        'trip_date',
        'adults',
        'rating',
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
        'trip_date' => 'date',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(Dump2::class, 'dump2_id');
    }

    /**
     * Создание метода вывода со своим CompanyQueryBuilder
     */
    public function newEloquentBuilder($query):CompanyQueryBuilder
    {
        return new CompanyQueryBuilder($query);
    }




}
