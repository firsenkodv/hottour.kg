<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomJsScript extends Model
{
   protected $table = 'custom_js_scripts';

   protected $fillable = [
       'title',
       'js',
       'published',
       'sorting',
   ];





}
