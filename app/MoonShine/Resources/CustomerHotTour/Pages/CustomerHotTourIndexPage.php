<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CustomerHotTour\Pages;

use App\MoonShine\Resources\CustomerHotTour\CustomerHotTourResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: CustomerHotTourResource::indexFields().
 *
 * @extends IndexPage<CustomerHotTourResource>
 */
class CustomerHotTourIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Image::make(__('Изображение'), 'img'),

            Text::make(__('Заголовок'), 'title'),

            Text::make(__('Вылет'), 'cityname'),

            Text::make(__('Прилет'), 'countryname'),

            Date::make(__('Дата обновления'), 'updated_at')
                ->format('H:i / d.m.Y')
                ->default(now()->toDateTimeString())
                ->sortable(),

            Switcher::make(__('Публикация'), 'published')->updateOnPreview(),

            Number::make(__('Сорт.'), 'sorting')->sortable(),

            Number::make(__('Процент'), 'procent')->buttons()->default(0),
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
