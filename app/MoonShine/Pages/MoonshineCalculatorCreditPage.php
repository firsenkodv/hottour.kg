<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\MoonshineCalculator;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Text;

/**
 * v2: App\MoonShine\Pages\MoonshineCalculatorCreditPage.
 * Форма отправляется на /moonshine/calculator-credit — контроллер перенесён
 * в App\Http\Controllers\Admin\MoonshineCalculatorCreditController.
 */
#[Icon('calculator')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(9)]
class MoonshineCalculatorCreditPage extends Page
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
        return $this->title ?: 'Кредитный калькулятор';
    }

    /**
     * v2: MoonshineCalculatorCreditPage::setting().
     *
     * @return array<string, mixed>
     */
    private function setting(): array
    {
        $segments = explode('/', url2());
        $key = array_pop($segments);

        $result = MoonshineCalculator::query()->where('key', $key)->first();

        return $result?->toArray() ?? [];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        $setting = $this->setting();

        return [
            FormBuilder::make('/moonshine/calculator-credit', FormMethod::POST)
                ->fields([
                    Tabs::make([
                        Tab::make(__('Общие настройки'), [
                            Grid::make([
                                Column::make([
                                    Divider::make(__('Банки')),

                                    Box::make([
                                        Json::make(__('Банки'), 'banks')
                                            ->fields([
                                                Position::make(),

                                                Text::make(__('Название'), 'title'),

                                                Text::make(__('Процент'), 'procent'),

                                                Json::make(__('Ставки'), 'koff')
                                                    ->fields([
                                                        Text::make(__('Месяц'), 'month'),

                                                        Text::make(__('Процент'), 'procent'),

                                                        Text::make(__('Месяц по русски'), 'month_rus'),
                                                    ])
                                                    ->creatable(limit: 15)
                                                    ->removable(),
                                            ])
                                            ->vertical()
                                            ->creatable()
                                            ->removable()
                                            ->default($setting['banks'] ?? ''),
                                    ]),
                                ])->columnSpan(6),

                                Column::make([
                                    Divider::make(__('Страны')),

                                    Box::make([
                                        Json::make(__('Страны'), 'countries')
                                            ->fields([
                                                Position::make(),

                                                Text::make(__('Название'), 'title'),
                                            ])
                                            ->creatable(limit: 15)
                                            ->removable()
                                            ->default($setting['countries'] ?? ''),
                                    ]),
                                ])->columnSpan(6),
                            ]),
                        ]),
                    ]),
                ])
                ->submit(label: __('Сохранить'), attributes: ['class' => 'btn-primary']),
        ];
    }
}
