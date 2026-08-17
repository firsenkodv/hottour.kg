<?php
namespace Domain\Dump\ViewModels;
use App\Models\Dump;
use App\Models\MoonshineCalculator;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class DumpViewModel
{
    use Makeable;
    use MemoryCache;

    public function listDumps()
    {
        return $this->cache(function () {

            return Dump::query()
                ->get_dumps()
                ->get();
        });

    }

    public function OneDump($slug)
    {
       $one_dump = $this->listDumps()->firstWhere('slug', $slug);
        return $one_dump;
    }

    public function OneDumpForId($id)
    {
        $one_dump = $this->listDumps()->firstWhere('id', $id);
        return $one_dump;
    }


    public function calc()
    {

        $calc = MoonshineCalculator::query()->first();

        return $calc;
    }



}


