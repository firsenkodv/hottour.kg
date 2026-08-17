<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Replacement\Pages;

use App\MoonShine\Resources\Replacement\ReplacementResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Text;

/**
 * v2: ReplacementResource::fields() — две колонки по 6.
 *
 * @extends FormPage<ReplacementResource>
 */
class ReplacementFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Grid::make([
                Column::make([
                    Box::make([
                        Text::make(__('Что меняем'), 'old_text'),
                    ]),
                ])->columnSpan(6),

                Column::make([
                    Box::make([
                        Text::make(__('На что меняем'), 'new_text'),
                    ]),
                ])->columnSpan(6),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }
}
