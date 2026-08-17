<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Company\CompanyResource;
use App\MoonShine\Resources\Contact\ContactResource;
use App\MoonShine\Resources\Contract\ContractResource;
use App\MoonShine\Resources\ContractFood\ContractFoodResource;
use App\MoonShine\Resources\ContractRoom\ContractRoomResource;
use App\MoonShine\Resources\CustomerHotTour\CustomerHotTourResource;
use App\MoonShine\Resources\CustomJsScript\CustomJsScriptResource;
use App\MoonShine\Resources\Dump\DumpResource;
use App\MoonShine\Resources\Dump2\Dump2Resource;
use App\MoonShine\Resources\Excursion\ExcursionResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use App\MoonShine\Resources\Info\InfoResource;
use App\MoonShine\Resources\Menu\MenuResource;
use App\MoonShine\Resources\Menudump\MenudumpResource;
use App\MoonShine\Resources\Menudump2\Menudump2Resource;
use App\MoonShine\Resources\Menuhottour\MenuhottourResource;
use App\MoonShine\Resources\Menutour\MenutourResource;
use App\MoonShine\Resources\Page\PageResource;
use App\MoonShine\Resources\Payment\PaymentResource;
use App\MoonShine\Resources\Publ\PublResource;
use App\MoonShine\Resources\Resort\ResortResource;
use App\MoonShine\Resources\Tour\TourResource;
use App\MoonShine\Resources\TourvisorCountry\TourvisorCountryResource;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use App\MoonShine\Resources\Travelitem\TravelitemResource;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Pages\AboutPage;
use App\MoonShine\Pages\CertificatesPage;
use App\MoonShine\Pages\ChangeContactPage;
use App\MoonShine\Pages\CountriesPage;
use App\MoonShine\Pages\MoonshineCalculatorCreditPage;
use App\MoonShine\Pages\MoonshineSettingPage;
use App\MoonShine\Pages\ReplacementPage;
use MoonShine\ColorManager\ColorManager;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\Laravel\Resources\MoonShineUserResource;
use MoonShine\Laravel\Resources\MoonShineUserRoleResource;
use MoonShine\MenuManager\MenuDivider;
use MoonShine\MenuManager\MenuGroup;
use MoonShine\MenuManager\MenuItem;

/**
 * Рабочий layout админки проекта.
 *
 * Дефолтный App\MoonShine\Layouts\MoonShineLayout намеренно оставлен нетронутым —
 * он служит эталоном сгенерированного MoonShine скелета.
 */
final class AxeldLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    /**
     * Меню задано явно — структура повторяет v2.
     *
     * Автосборка через $this->autoloadMenu() (по атрибутам #[Group]/#[Order]/#[Icon])
     * здесь НЕ используется: она сканирует весь classmap проекта и вызывает is_a()
     * на каждом классе. В проекте есть laravel-debugbar с Twig-мостом
     * (Barryvdh\Debugbar\Twig\Extension\Debug), а сам Twig не установлен —
     * попытка его автозагрузки роняет всю админку с 500.
     * Работает только при прогретом кеше `php artisan moonshine:optimize`,
     * что ломается на первом же `optimize:clear`.
     *
     * Подпись и иконка каждого пункта заданы здесь явно — вторым и третьим
     * аргументом MenuItem::make(). Это перекрывает $title и #[Icon] классов,
     * так что всё меню (порядок, названия, иконки) правится в одном файле.
     */
    protected function menu(): array
    {
        return [
            MenuGroup::make(
                static fn (): string => __('moonshine::ui.resource.system'),
                [
                    MenuItem::make(MoonShineUserResource::class, 'Администраторы', 'users'),
                    MenuItem::make(MoonShineUserRoleResource::class, 'Роли', 'bookmark'),
                    MenuItem::make(UserResource::class, 'Пользователи', 'user-group'),
                ],
                'users',
            ),

            MenuGroup::make('Платежи', [
                MenuItem::make(PaymentResource::class, 'Оплачено на сайте', 'currency-dollar'),
            ], 'currency-dollar'),

            MenuGroup::make('Категории', [
                // страница со списком стран: своей модели нет, данные в settings

                MenuItem::make(CertificatesPage::class, 'Сертификаты', 'check-badge'),
                MenuGroup::make(static fn() => __('Раздел страны'), [
                    MenuDivider::make(),
                    MenuItem::make(CountriesPage::class, 'Заглавная страница', 'globe-alt'),
                    MenuItem::make(HotCategoryResource::class, 'Страны', 'flag'),
                ],'flag'),
                MenuGroup::make(static fn() => __('Раздел О нас'), [
                    MenuDivider::make(),
                    MenuItem::make(AboutPage::class, 'Заглавная страница', 'building-office-2'),
                    MenuItem::make(Dump2Resource::class, 'О нас', 'rectangle-stack'),
                ], 'building-office-2'),
                MenuItem::make(TravelcategoryResource::class, 'Горящие туры', 'fire'),
                MenuItem::make(TourResource::class, 'Туры', 'list-bullet'),
                MenuItem::make(DumpResource::class, 'Полезное', 'document-text'),
            ], 'folder'),

            MenuGroup::make('Материалы', [
                MenuItem::make(ResortResource::class, 'Курорты', 'sun'),
                MenuItem::make(HotelResource::class, 'Отели', 'building-office'),
                MenuItem::make(ExcursionResource::class, 'Экскурсии', 'ticket'),
                MenuItem::make(InfoResource::class, 'Полезное', 'information-circle'),
                MenuItem::make(TravelitemResource::class, 'Горящие туры', 'fire'),
                MenuItem::make(PublResource::class, 'Статьи, Услуги', 'newspaper'),
                MenuItem::make(CompanyResource::class, 'Отзывы, О нас', 'chat-bubble-left-right'),
                MenuItem::make(PageResource::class, 'Страницы', 'document-duplicate'),
                MenuItem::make(ContactResource::class, 'Контактная информация', 'map-pin'),
            ], 'document-duplicate'),

            MenuGroup::make('Меню', [
                MenuItem::make(MenuResource::class, 'Меню стран', 'bars-3'),
                MenuItem::make(MenuhottourResource::class, 'Меню горящих туров', 'bars-3'),
                MenuItem::make(MenutourResource::class, 'Меню туров', 'bars-3'),
                MenuItem::make(MenudumpResource::class, 'Меню полезное', 'bars-3'),
                MenuItem::make(Menudump2Resource::class, 'Меню о нас', 'bars-3'),
            ], 'bars-3'),

            MenuGroup::make('Служебные', [
                // v2: вложенная группа «Договора»
                MenuGroup::make('Договора', [
                    MenuItem::make(ContractFoodResource::class, 'Питание', 'cake'),
                    MenuItem::make(ContractRoomResource::class, 'Номера', 'home'),
                    MenuItem::make(ContractResource::class, 'Договоры', 'document-text'),
                ], 'folder'),

                MenuItem::make(CustomerHotTourResource::class, 'API Горящие туры', 'fire'),
                MenuItem::make(TourvisorCountryResource::class, 'API Tourvisor', 'flag'),
                MenuItem::make(CustomJsScriptResource::class, 'Скрипты JS', 'code-bracket-square'),
                MenuItem::make(ReplacementPage::class, 'Замены', 'arrow-path'),
                MenuItem::make(MoonshineCalculatorCreditPage::class, 'Кредитный калькулятор', 'calculator'),
                MenuItem::make(MoonshineSettingPage::class, 'Настройки сайта', 'cog'),
                MenuItem::make(ChangeContactPage::class, 'Показ средств связи', 'phone-arrow-up-right'),
            ], 'wrench-screwdriver'),
        ];
    }

    /**
     * v2: Footer::make()->copyright(fn () => 'HOT TOUR')
     */
    protected function getFooterCopyright(): string
    {
        return 'HOT TOUR';
    }

    /**
     * v2: ->menu([config('app.url') => 'WebSite'])
     */
    protected function getFooterMenu(): array
    {
        return [
            (string) config('app.url') => 'WebSite',
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }
}
