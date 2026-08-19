<?php

namespace App\Models;

use App\Models\Concerns\HasItemTemplate;
use Domain\Travelitem\QueryBuilders\TravelitemQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Travelitem extends Model
{
    use HasItemTemplate;

    public $table = "travelitems";

    protected $fillable = [
        'template',
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'travelcategory_id',
        'smalltext',
        'script_published',
        'script',
        'tourvisor_module_id',
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

    ];

    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(Travelcategory::class, 'travelcategory_id');
    }
    /**
     * Создание метода вывода со своим TravelitemQueryBuilder
     */
    public function newEloquentBuilder($query):TravelitemQueryBuilder
    {
        return new TravelitemQueryBuilder($query);
    }

}
