<?php
namespace Domain\Publ\ViewModels;
use App\Models\Dump;
use App\Models\Publ;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class PublViewModel
{
    use Makeable;
    use MemoryCache;

    public function OnePubl($slug)
    {
        $publ = $this->publs()->firstWhere('slug', $slug);
        return $publ;

    }

    private function publs()
    {
        return $this->cache(function () {
            return Publ::query()
                ->get_publs()
                ->get();
        });
    }


}


