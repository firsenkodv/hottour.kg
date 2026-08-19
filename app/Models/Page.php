<?php

namespace App\Models;

use App\Models\Concerns\HasItemTemplate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasItemTemplate;

    public $table = "pages";

    // pages
    protected $fillable = [
        'template',
        'title',
        'subtitle',
        'slug',
        'img',
        'add_to_main',
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
        'script',
        'tourvisor_module_id',
        'script_published',
        'script_page'
    ];

    protected $casts = [
        'params' => 'collection',
    ];






}

