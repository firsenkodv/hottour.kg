<?php

namespace App\Models;

use App\Models\Concerns\HasCategoryTemplates;
use Domain\Dump\QueryBuilders\DumpQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dump extends Model
{
    use HasCategoryTemplates;

    // dumps
    public $table = "dumps";

    protected $fillable = [
        'list_template',
        'teaser_template',
        'title',
        'subtitle',
        'title_for_menu',
        'slug',
        'img',
        'dump_id',
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
        'temp',
        'calc',
        'script_published',
        'script',
        'tourvisor_module_id'

    ];
    protected $casts = [
        'params' => 'collection',
    ];

    public function parent():BelongsTo
    {
        return $this->belongsTo(self::class, 'dump_id');
    }

    public function publs():HasMany
    {
        return $this->hasMany(Publ::class);
    }






    /**
     * Создание метода вывода со своим DumpQueryBuilder
     */
    public function newEloquentBuilder($query):DumpQueryBuilder
    {
        return new DumpQueryBuilder($query);
    }




}
