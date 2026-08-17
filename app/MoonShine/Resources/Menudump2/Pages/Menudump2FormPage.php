<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menudump2\Pages;

use App\MoonShine\Resources\Dump2\Dump2Resource;
use App\MoonShine\Resources\Menudump2\Menudump2Resource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * @extends FormPage<Menudump2Resource>
 */
class Menudump2FormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('Общие настройки'), [
                        Grid::make([
                            Column::make([
                                Text::make(__('Заголовок'), 'title')->required(),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Публикация'), [
                                    Switcher::make(__('Публикация'), 'published')->default(1),
                                ]),

                                Collapse::make(__('Вывод'), [
                                    BelongsTo::make(
                                        __('Категория'),
                                        'parent',
                                        resource: Dump2Resource::class,
                                    )
                                        ->nullable()
                                        ->searchable(),
                                ]),
                            ])->columnSpan(6),
                        ]),
                    ]),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }
}
