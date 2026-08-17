<?php
namespace Domain\Company\ViewModels;
use App\Models\Company;
use Support\Traits\Makeable;
use Support\Traits\MemoryCache;

class CompanyViewModel
{
    use Makeable;
    use MemoryCache;

    public function OneCompany($slug)
    {
        $company = $this->companies()->firstWhere('slug', $slug);
        return $company;

    }

    private function companies()
    {
        return $this->cache(function () {
            return Company::query()
                ->get_companies()
                ->get();
        });
    }


}


