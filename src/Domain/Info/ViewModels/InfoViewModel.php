<?php
namespace Domain\Info\ViewModels;

use App\Models\Info;
use Illuminate\Support\Facades\Cache;
use Support\Traits\Makeable;

class InfoViewModel
{
    use Makeable;

    public function OneInfo($slug)
    {

            $info =  Info::query()
                ->get_infos($slug)
                ->first();


        return $info;

    }



}
