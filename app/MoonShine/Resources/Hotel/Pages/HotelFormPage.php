<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hotel\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use MoonShine\Ace\Fields\Code;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * v2: HotelResource::fields() — сюда попало то, что НЕ было помечено hideOnIndex().
 *
 * Не переносится:
 * - служебное hot_category_id (в v2 скрыто и в списке, и в форме — только для импорта);
 * - дубль Textarea «Территория» (в v2 объявлен дважды подряд с одним и тем же полем).
 *
 * @extends FormPage<HotelResource>
 */
class HotelFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('Общие настройки'), [
                        Grid::make([
                            Column::make([
                                Image::make(__('Изображение'), 'img')
                                    ->disk(config('moonshine.disk', 'moonshine'))
                                    ->dir('hotel')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                Text::make(__('Заголовок'), 'title')->required(),

                                Slug::make(__('Алиас'), 'slug')
                                    ->from('title')
                                    ->hint('url адрес, обязательное поле')
                                    ->unique(),

                                Text::make(__('Подзаголовок'), 'subtitle'),

                                TinyMce::make(__('Краткое описание'), 'smalltext'),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Шаблон вывода'), [
                                    Select::make(__('Шаблон страницы'), 'template')
                                        ->options(ItemTemplate::toOptions())
                                        ->default(ItemTemplate::Default->value)
                                        ->hint('Вёрстка: resources/views/pages/countries/templates/hotel'),
                                ]),

                                Collapse::make(__('HTML и CSS страницы'), [
                                    Textarea::make(__('HTML-блок'), 'html')->unescape()
                                        ->hint('Произвольный HTML, выводится в контенте страницы'),

                                    Code::make(__('CSS страницы'), 'custom_css')->language('css')->unescape()
                                        ->hint('Стили только для этой страницы, без обёртки style — только правила CSS'),
                                ]),

                                Collapse::make(__('Метотеги'), [
                                    Text::make(__('Мета тэг (title)'), 'metatitle')->unescape(),

                                    Text::make(__('Мета тэг (description)'), 'description')->unescape(),

                                    Text::make(__('Мета тэг (keywords)'), 'keywords')->unescape(),

                                    Switcher::make(__('Публикация'), 'published')->default(1),


                                    Switcher::make(__('На главной'), 'index')->default(0),

                                    Select::make(__('Город вылета'), 'city')
                                        ->options([
                                            'Казахстан' => config('tourvisor.city_kz'),
                                            'Россия' => config('tourvisor.city_rus'),
                                        ])
                                        ->searchable(),
                                ]),

                                Collapse::make(__('Вложенность'), [
                                    BelongsTo::make(
                                        __('Категория'),
                                        'parent',
                                        resource: HotCategoryResource::class,
                                    )
                                        ->nullable()
                                        ->searchable(),

                                    Text::make('country Id', 'country_id')
                                        ->hint('обязательно для поиска'),

                                    Text::make('region Id', 'region_id')
                                        ->hint('обязательно для поиска'),
                                ]),
                            ])->columnSpan(6),
                        ]),
                    ]),

                    Tab::make(__('Дополнительно'), [
                        Grid::make([
                            Column::make([
                                TinyMce::make(__('Описание'), 'text'),
                            ])->columnSpan(12),
                        ]),

                        Divider::make(__('Дополнительное изображение на страницу')),

                        Image::make(__('Изображение'), 'pageimg1')
                            ->disk(config('moonshine.disk', 'moonshine'))
                            ->dir('hotel')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                            ->removable()
                            ->hint('Растягивается на 100% ширины'),
                    ]),

                    Tab::make(__('Изображения'), [
                        Divider::make(__('Изображения по ссылке')),

                        Json::make(__('Фото от Tourvisor'), 'params')
                            ->onlyValue()
                            ->creatable(
                                button: ActionButton::make('New', '#')->primary(),
                            ),
                    ]),

                    Tab::make(__('Данные отеля API'), [
                        Text::make(__('Регион'), 'region'),

                        Text::make(__('Звезды'), 'stars'),

                        Text::make(__('Рейтинг'), 'rating'),

                        Textarea::make(__('Размещение'), 'placement'),

                        Textarea::make(__('Описание'), 'desc'),

                        Text::make(__('Количество фото'), 'imagescount'),

                        Text::make(__('Постройка'), 'build'),

                        Text::make(__('Ремонт'), 'repair'),

                        Text::make(__('Площадь'), 'square'),

                        Textarea::make(__('Список еды'), 'meallist'),

                        Textarea::make(__('Территория'), 'territory'),

                        Textarea::make(__('В номере'), 'inroom'),

                        Textarea::make(__('Инфо о номерах'), 'roomtypes'),

                        Textarea::make(__('Пляж'), 'beach'),

                        Textarea::make(__('Анимация'), 'animation'),

                        Textarea::make(__('Детям'), 'child'),

                        Textarea::make(__('Бесплатно'), 'servicefree'),

                        Textarea::make(__('Платно'), 'servicepay'),

                        Text::make(__('Координаты'), 'coord'),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * v2: HotelResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'metatitle' => 'max:255',
            'description' => 'max:255',
            'keywords' => 'max:512',
        ];
    }
}
