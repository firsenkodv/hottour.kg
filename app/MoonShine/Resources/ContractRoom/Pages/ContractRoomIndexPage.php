<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ContractRoom\Pages;

use App\MoonShine\Resources\ContractRoom\ContractRoomResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContractRoomResource::fields() — общий метод для списка и формы,
 * в v4 разнесён по страницам.
 *
 * @extends IndexPage<ContractRoomResource>
 */
class ContractRoomIndexPage extends IndexPage
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
