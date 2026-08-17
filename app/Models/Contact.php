<?php

namespace App\Models;

use Domain\Contact\QueryBuilders\ContactQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    public $table = "contacts";

    protected $fillable  = [
        'title',
        'label',
        'address',
        'yandex_map',
        'city_id',
        'data_phone',
        'data_email',
        'text',
        'skype',
        'email',
        'published',
        'sorting'

    ];
    protected $casts = [
        'data_phone' => 'collection',
        'data_email' => 'collection',
    ];

    /**
     * Создание метода вывода со своим ContactQueryBuilder
     */
    public function newEloquentBuilder($query):ContactQueryBuilder
    {
        return new ContactQueryBuilder($query);
    }



}
