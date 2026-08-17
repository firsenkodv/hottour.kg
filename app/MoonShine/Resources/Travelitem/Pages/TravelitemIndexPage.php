<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelitem\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use App\MoonShine\Resources\Travelitem\TravelitemResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: TravelitemResource::indexFields() + filters().
 * В списке v2 поля «Алиас» не было — оно только в форме.
 *
 * @extends IndexPage<TravelitemResource>
 */
class TravelitemIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Image::make(__('Изображение'), 'img')
                ->disk(config('moonshine.disk', 'moonshine'))
                ->dir('travel')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg']),

            Text::make(__('Заголовок'), 'title')
                ->required(),

            BelongsTo::make(
                __('Кат.'),
                'parent',
                resource: TravelcategoryResource::class,
            ),

            Date::make(__('Дата создания'), 'created_at')
                ->format('d.m.Y')
                ->default(now()->toDateTimeString())
                ->sortable(),

            Switcher::make(__('Публикация'), 'published')->updateOnPreview(),

            Select::make(__('Шаблон'), 'template')
                ->options(ItemTemplate::toOptions())
                ->updateOnPreview(),

            Switcher::make('Desc', 'description'),

            Switcher::make('Key', 'keywords'),

            Switcher::make(__('Скрипт'), 'script_published')->updateOnPreview(),

            Number::make(__('Сорт.'), 'sorting')->sortable(),
        ];
    }

    /**
     * v2: TravelitemResource::filters().
     *
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            ID::make(),

            Text::make(__('Название'), 'title'),

            BelongsTo::make(
                __('Категория'),
                'parent',
                resource: TravelcategoryResource::class,
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
