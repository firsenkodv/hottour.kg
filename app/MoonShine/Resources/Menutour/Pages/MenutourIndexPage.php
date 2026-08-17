<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menutour\Pages;

use App\MoonShine\Resources\Menutour\MenutourResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<MenutourResource>
 */
class MenutourIndexPage extends IndexPage
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

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
