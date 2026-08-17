<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelMain extends Model
{
  protected $table = 'hotel_mains';
  protected $fillable = [
      'title',
      'slug',
      'price',
      'img',
      'star',
      'country',
      'meal',
        'nights',
        'flydate',
      'placement',
      'mealrussian',
      'city',
      'room',
      'adults',
      'child',
  ];
}
