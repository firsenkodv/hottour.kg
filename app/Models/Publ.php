<?php

namespace App\Models;

use App\Models\Concerns\HasItemTemplate;
use Domain\Publ\QueryBuilders\PublQueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Support\Module\Module;

class Publ extends Model
{
    use HasItemTemplate;

    // dumps
    public $table = "publs";

    protected $fillable = [
        'template',
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'publ_id',
        'dump_id',
        'smalltext',
        'text',
        'text2',
        'pageimg1',
        'text3',
        'pageimg2',
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
        return $this->belongsTo(Dump::class, 'dump_id');
    }

    /**
     * Создание метода вывода со своим PublQueryBuilder
     */
    public function newEloquentBuilder($query):PublQueryBuilder
    {
        return new PublQueryBuilder($query);
    }




}
