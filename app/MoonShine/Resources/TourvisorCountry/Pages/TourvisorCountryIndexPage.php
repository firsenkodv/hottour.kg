<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\TourvisorCountry\Pages;

use App\MoonShine\Resources\TourvisorCountry\TourvisorCountryResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * v2: TourvisorCountryResource::indexFields().
 *
 * @extends IndexPage<TourvisorCountryResource>
 */
class TourvisorCountryIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Страна'), 'name'),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
