<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menudump\Pages;

use App\MoonShine\Resources\Menudump\MenudumpResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * @extends IndexPage<MenudumpResource>
 */
class MenudumpIndexPage extends IndexPage
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
