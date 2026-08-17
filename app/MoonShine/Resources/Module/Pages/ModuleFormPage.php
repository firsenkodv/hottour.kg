<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Module\Pages;

use App\MoonShine\Resources\Module\ModuleResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: ModuleResource::formFields().
 * Пустой таб «Дополнительно» из v2 не переносится — в нём не было полей.
 *
 * @extends FormPage<ModuleResource>
 */
class ModuleFormPage extends FormPage
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
                                Collapse::make(__('Заголовок'), [
                                    Text::make(__('Заголовок'), 'title')->required(),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Метотеги'), [
                                    Switcher::make(__('Публикация'), 'published')->default(1),
                                ]),

                                Date::make(__('Дата создания'), 'created_at')
                                    ->format('d.m.Y')
                                    ->default(now()->toDateTimeString())
                                    ->sortable(),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),

                        Grid::make([
                            Column::make([
                                // v2: у Text::make('Процент', 'jt2') был вызов ->fields([...]),
                                // которого у Text не существует ни в v2, ни в v4.
                                // В БД jt2 хранится плоской строкой, вложенности нет —
                                // вызов был мёртвым, поэтому не переносится.
                                Json::make(__('Банк'), 'data_room1')
                                    ->fields([
                                        Text::make(__('Банк'), 'jt1'),

                                        Text::make(__('Процент'), 'jt2'),
                                    ])
                                    ->vertical()
                                    ->removable(),
                            ])->columnSpan(6),

                            Column::make([
                                Json::make(__('Кредит'), 'data_room2')
                                    ->fields([
                                        Text::make(__('Набор 2'), 'jt1'),
                                    ])
                                    ->vertical()
                                    ->removable(),
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
