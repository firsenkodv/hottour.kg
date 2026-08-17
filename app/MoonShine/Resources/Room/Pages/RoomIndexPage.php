<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Room\Pages;

use App\MoonShine\Resources\Room\RoomResource;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: RoomResource::fields() — единый метод для списка и формы,
 * разделение шло через hideOnForm()/hideOnIndex().
 * В v4 поля объявляются раздельно, поэтому сюда попало только то,
 * что в v2 НЕ было помечено hideOnForm().
 *
 * @extends IndexPage<RoomResource>
 */
class RoomIndexPage extends IndexPage
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

            BelongsTo::make(
                __('Кат.'),
                'parent',
                resource: HotCategoryResource::class,
            ),

            Text::make(__('country id'), 'country_id'),

            Text::make(__('region id'), 'region_id'),

            Switcher::make(__('Публ.'), 'published')->updateOnPreview(),

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
     * v2: RoomResource::filters().
     *
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            ID::make(),

            Text::make(__('Название'), 'title'),

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
