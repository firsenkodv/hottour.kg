<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\Text;

/**
 * v2: App\MoonShine\Pages\ReplacementPage.
 * Форма отправляется на /replacement/update — контроллер перенесён
 * в App\Http\Controllers\Admin\ReplacementController.
 */
#[Icon('arrow-path')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(7)]
class ReplacementPage extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Замены';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        return [
            FormBuilder::make('/replacement/update', FormMethod::GET)
                ->fields([
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
                ])
                ->submit(label: __('Вперед'), attributes: ['class' => 'btn-primary']),
        ];
    }
}
