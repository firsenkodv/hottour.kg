<?php
namespace Domain\Hotel\ViewModels;

use App\Models\Hotel;
use Support\Traits\Makeable;

class HotelViewModel
{
    use Makeable;

    public function OneHotel($slug)
    {
        $hotel =  Hotel::query()
                ->get_hotel($slug)
                ->first();
        return $hotel;

    }

    public function Hotels($array)
    {
        $hotels =  Hotel::query()
                ->get_hotels($array)
                ->get()
                ->keyBy('slug')
                ->toArray();

        return $hotels;

    }



}
