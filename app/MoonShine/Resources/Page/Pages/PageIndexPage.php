<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Page\PageResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: PageResource::indexFields().
 *
 * @extends IndexPage<PageResource>
 */
class PageIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Заголовок'), 'title')
                ->required(),

            Slug::make(__('Алиас'), 'slug')
                ->from('title')
                ->hint('url адрес, обязательное поле')
                ->unique(),

            Date::make(__('Дата создания'), 'created_at')
                ->format('d.m.Y')
                ->default(now()->toDateTimeString())
                ->sortable(),

            Switcher::make(__('Публикация'), 'published')->updateOnPreview(),

            Select::make(__('Шаблон'), 'template')
                ->options(ItemTemplate::toOptions())
                ->updateOnPreview(),

            Switcher::make(__('Главная'), 'add_to_main'),

            Switcher::make('Desc', 'description'),

            Switcher::make('Key', 'keywords'),

            Number::make(__('Сорт.'), 'sorting')->sortable(),

            Switcher::make(__('Скрипт'), 'script_published')->updateOnPreview(),
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
