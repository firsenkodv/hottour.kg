<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Tour\TourResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: TourResource::indexFields().
 *
 * @extends IndexPage<TourResource>
 */
class TourIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Заголовок'), 'title'),

            Text::make(__('Пропущено'), 'removeitem'),

            Slug::make(__('Алиас'), 'slug'),

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

            Switcher::make(__('Опции'), 'params_published')->updateOnPreview(),
        ];
    }

    /**
     * v2: protected ?ClickAction $clickAction = ClickAction::EDIT;
     * В v4 свойство удалено — поведение задаётся на компоненте списка.
     *
     * @param  TableBuilder  $component
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->clickAction(ClickAction::EDIT);
    }
}
