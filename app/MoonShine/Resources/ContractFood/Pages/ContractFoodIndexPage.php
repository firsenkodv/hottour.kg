<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ContractFood\Pages;

use App\MoonShine\Resources\ContractFood\ContractFoodResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContractFoodResource::fields() — общий метод для списка и формы,
 * в v4 разнесён по страницам.
 *
 * @extends IndexPage<ContractFoodResource>
 */
class ContractFoodIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Название'), 'title')->required(),
        ];
    }
}
