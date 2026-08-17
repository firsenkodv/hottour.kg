<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ContractRoom\Pages;

use App\MoonShine\Resources\ContractRoom\ContractRoomResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContractRoomResource::fields().
 *
 * @extends FormPage<ContractRoomResource>
 */
class ContractRoomFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Text::make(__('Название'), 'title')->required(),
            ]),
        ];
    }

    /**
     * v2: ContractRoomResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'title' => 'required|max:255',
        ];
    }
}
