<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CustomJsScript\Pages;

use App\MoonShine\Resources\CustomJsScript\CustomJsScriptResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: CustomJsScriptResource::indexFields().
 *
 * @extends IndexPage<CustomJsScriptResource>
 */
class CustomJsScriptIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Заголовок'), 'title'),

            Date::make(__('Дата создания'), 'created_at')
                ->format('d.m.Y'),

            Switcher::make(__('Публикация'), 'published')->updateOnPreview(),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
