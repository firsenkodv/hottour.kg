<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Resort\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use App\MoonShine\Resources\Resort\ResortResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
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
 * v2: ResortResource::indexFields() + filters().
 *
 * Не переносятся:
 * - ->useOnImport()/->showOnExport() — у ресурса import()/export() возвращали null,
 *   то есть импорт и экспорт были фактически отключены;
 * - служебное поле hot_category_id, которое в v2 скрывалось и в списке, и в форме.
 *
 * @extends IndexPage<ResortResource>
 */
class ResortIndexPage extends IndexPage
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
                ->dir('category')
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
     * v2: ResortResource::filters().
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
                resource: HotCategoryResource::class,
            )
                ->nullable()
                ->searchable(),
        ];
    }

    /**
     * v2: protected ?ClickAction $clickAction = ClickAction::EDIT;
     *
     * @param  TableBuilder  $component
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->clickAction(ClickAction::EDIT);
    }
}
