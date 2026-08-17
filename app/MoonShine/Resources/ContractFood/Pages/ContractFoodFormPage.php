<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ContractFood\Pages;

use App\MoonShine\Resources\ContractFood\ContractFoodResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContractFoodResource::fields().
 *
 * @extends FormPage<ContractFoodResource>
 */
class ContractFoodFormPage extends FormPage
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
     * v2: ContractFoodResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'title' => 'required|max:255',
        ];
    }
}
