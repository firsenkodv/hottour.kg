<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hotel\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: HotelResource::fields() — единый метод для списка и формы,
 * разделение шло через hideOnForm()/hideOnIndex().
 * В v4 поля объявляются раздельно, поэтому сюда попало только то,
 * что в v2 НЕ было помечено hideOnForm().
 *
 * @extends IndexPage<HotelResource>
 */
class HotelIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('API'), 'slug'),

            Text::make(__('Заголовок'), 'title')
                ->required(),

            Switcher::make(__('Глав.'), 'index'),

            BelongsTo::make(
                __('Кат.'),
                'parent',
                resource: HotCategoryResource::class,
            ),

            Text::make(__('country id'), 'country_id'),

            Text::make(__('region id'), 'region_id'),

            Switcher::make(__('Публ.'), 'published')->updateOnPreview(),

            Select::make(__('Шаблон'), 'template')
                ->options(ItemTemplate::toOptions())
                ->updateOnPreview(),

            Switcher::make('region', 'region'),

            Switcher::make('stars', 'stars'),

            Switcher::make('rating', 'rating'),

            Switcher::make('placement', 'placement'),

            Switcher::make('desc', 'desc'),

            Switcher::make('image', 'imagescount'),

            Switcher::make('coord', 'coord'),
        ];
    }

    /**
     * v2: HotelResource::filters().
     *
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            ID::make(),

            Text::make(__('Название'), 'title'),

            Switcher::make(__('На главной'), 'index'),

            Text::make(__('ID Отеля'), 'slug'),

            BelongsTo::make(
                __('Страна'),
                'parent',
                resource: HotCategoryResource::class,
            )->nullable(),
        ];
    }

    /**
     * @param  TableBuilder  $component
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->clickAction(ClickAction::EDIT);
    }
}
