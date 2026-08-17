<?php

declare(strict_types=1);

namespace App\Providers;

use App\MoonShine\Pages\AboutPage;
use App\MoonShine\Pages\CertificatesPage;
use App\MoonShine\Pages\ChangeContactPage;
use App\MoonShine\Pages\MoonshineCalculatorCreditPage;
use App\MoonShine\Pages\MoonshineSettingPage;
use App\MoonShine\Pages\CountriesPage;
use App\MoonShine\Pages\ReplacementPage;
use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\Menu\MenuResource;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use App\MoonShine\Resources\Menuhottour\MenuhottourResource;
use App\MoonShine\Resources\Menutour\MenutourResource;
use App\MoonShine\Resources\Menudump\MenudumpResource;
use App\MoonShine\Resources\Menudump2\Menudump2Resource;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use App\MoonShine\Resources\Tour\TourResource;
use App\MoonShine\Resources\Dump\DumpResource;
use App\MoonShine\Resources\Dump2\Dump2Resource;
use App\MoonShine\Resources\Resort\ResortResource;
use App\MoonShine\Resources\Excursion\ExcursionResource;
use App\MoonShine\Resources\Info\InfoResource;
use App\MoonShine\Resources\Publ\PublResource;
use App\MoonShine\Resources\Company\CompanyResource;
use App\MoonShine\Resources\Travelitem\TravelitemResource;
use App\MoonShine\Resources\ContractRoom\ContractRoomResource;
use App\MoonShine\Resources\ContractFood\ContractFoodResource;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use App\MoonShine\Resources\Replacement\ReplacementResource;
use App\MoonShine\Resources\Page\PageResource;
use App\MoonShine\Resources\Contact\ContactResource;
use App\MoonShine\Resources\CustomJsScript\CustomJsScriptResource;
use App\MoonShine\Resources\Module\ModuleResource;
use App\MoonShine\Resources\TourvisorCountry\TourvisorCountryResource;
use App\MoonShine\Resources\CustomerHotTour\CustomerHotTourResource;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Payment\PaymentResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\Room\RoomResource;
use App\MoonShine\Resources\Contract\ContractResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                MenuResource::class,
                HotCategoryResource::class,
                MenuhottourResource::class,
                MenutourResource::class,
                MenudumpResource::class,
                Menudump2Resource::class,
                TravelcategoryResource::class,
                TourResource::class,
                DumpResource::class,
                Dump2Resource::class,
                ResortResource::class,
                ExcursionResource::class,
                InfoResource::class,
                PublResource::class,
                CompanyResource::class,
                TravelitemResource::class,
                ContractRoomResource::class,
                ContractFoodResource::class,
                UserRoleResource::class,
                ReplacementResource::class,
                PageResource::class,
                ContactResource::class,
                CustomJsScriptResource::class,
                ModuleResource::class,
                TourvisorCountryResource::class,
                CustomerHotTourResource::class,
                UserResource::class,
                PaymentResource::class,
                HotelResource::class,
                RoomResource::class,
                ContractResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
                ReplacementPage::class,
                MoonshineSettingPage::class,
                MoonshineCalculatorCreditPage::class,
                ChangeContactPage::class,
                CountriesPage::class,
                AboutPage::class,
                CertificatesPage::class,
            ])
        ;
    }
}
