<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\HotCategory\Pages;

use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<HotCategoryResource>
 */
class HotCategoryIndexPage extends IndexPage
{
    /**
     * v2: HotCategoryResource::indexFields().
     * Поле created_at в v2 помечалось hideOnForm() — в v4 это не нужно,
     * поля списка и формы объявляются раздельно.
     *
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

            // шаблон здесь не выводим: список стран рисует TreeComponent,
            // колонки полей в дереве не показываются — выбор шаблона в форме

            Switcher::make(__('Публикация'), 'published')->updateOnPreview(),

            Switcher::make('Desc', 'description'),

            Switcher::make('Key', 'keywords'),

            Switcher::make(__('На главной'), 'main'),
        ];
    }

    /**
     * В v2 дерево выводила отдельная CategoryTreePage.
     * В v4 достаточно подменить компонент списка.
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
