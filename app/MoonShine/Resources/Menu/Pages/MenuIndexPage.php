<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menu\Pages;

use App\MoonShine\Resources\Menu\MenuResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<MenuResource>
 */
class MenuIndexPage extends IndexPage
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
        ];
    }

    /**
     * В v2 дерево выводила отдельная CategoryTreePage, объявленная в pages() ресурса.
     * В v4 достаточно подменить компонент списка на TreeComponent.
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
