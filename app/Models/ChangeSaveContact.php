<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeSaveContact extends Model
{
    protected $table = 'change_save_contacts';
    protected $fillable = [
        'key',
        'title',
        'phone',
        'whatsapp',
        'telegram',
        'phone_mode',
        'whatsapp_mode',
        'telegram_mode',
        'phone_published',
        'whatsapp_published',
        'telegram_published',
    ];

    protected $casts = [
        'phone' => 'collection',
        'whatsapp' => 'collection',
        'telegram' => 'collection',
    ];


    protected static function boot()
    {

        # Проверка данных пользователя перед сохранением
        static::saving(function ($Moonshine) {


            //  dd($Moonshine);


        });


        parent::boot();





    }

}
