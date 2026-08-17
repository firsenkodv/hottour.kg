<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserImportant extends Model
{

    protected $table = 'user_importants';

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'short_desc',
        'text',
        'img',
        'params',
        'sorting'
    ];








}
