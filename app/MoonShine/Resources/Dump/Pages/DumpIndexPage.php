<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Dump\Pages;

use App\MoonShine\Resources\Dump\DumpResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: DumpResource::indexFields().
 *
 * @extends IndexPage<DumpResource>
 */
class DumpIndexPage extends IndexPage
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
                ->dir('dump')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg']),

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

            Switcher::make('Desc', 'description'),

            Switcher::make('Key', 'keywords'),

            Switcher::make(__('Скрипт'), 'script_published')->updateOnPreview(),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
