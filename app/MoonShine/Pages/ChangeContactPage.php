<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\ChangeSaveContact;
use App\Models\ChangeStatistic;
use App\MoonShine\Fields\Node;
use App\MoonShine\Fields\StatisticWeek;
use Illuminate\Http\Request;
use MoonShine\Apexcharts\Components\DonutChartMetric;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\FormMethod;
use MoonShine\Support\Enums\ToastType;
use MoonShine\UI\Components\ActionButton;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Flex;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: App\MoonShine\Pages\ChangeContactPage.
 * Форма отправляется на /moonshine/change-contacts — контроллер перенесён
 * в App\Http\Controllers\Admin\MoonshineChangeContactController.
 *
 * DonutChartMetric в v4 живёт в пакете moonshine/apexcharts.
 */
#[Icon('cog')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(10)]
class ChangeContactPage extends Page
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
        return $this->title ?: 'Настройки режимов показа средств связи';
    }

    /**
     * v2: ChangeContactPage::setting().
     *
     * @return array<string, mixed>
     */
    private function setting(): array
    {
        $segments = explode('/', url2());
        $key = array_pop($segments);

        $result = ChangeSaveContact::query()->where('key', $key)->first();

        return $result?->toArray() ?? [];
    }

    /**
     * v2: ChangeContactPage::statistic() — количество нажатий по каждому каналу.
     *
     * @return array<string, int>
     */
    private function statistic(): array
    {
        $items = ChangeStatistic::query()
            ->select('phone', 'whatsapp', 'telegram')
            ->get();

        $result = [];

        foreach (['Телефон' => 'phone', 'WhatsApp' => 'whatsapp', 'Telegram' => 'telegram'] as $label => $field) {
            $count = $items->whereNotNull($field)->count();

            if ($count > 0) {
                $result[$label] = $count;
            }
        }

        return $result;
    }

    /**
     * Один из трёх одинаковых блоков «режим + список контактов + публикация».
     *
     * @param  array<string, mixed>  $setting
     * @return list<ComponentContract>
     */
    private function channelBlock(array $setting, string $divider, string $modeLabel, string $field, string $jsonLabel): array
    {
        return [
            Divider::make($divider),

            Box::make([
                Select::make($modeLabel, $field . '_mode')
                    ->options([
                        1 => 'Режим 1',
                        2 => 'Режим 2',
                        3 => 'Режим 3',
                    ])
                    ->default($setting[$field . '_mode'] ?? ''),

                Json::make($jsonLabel, $field)
                    ->fields([
                        Text::make('', 'p'),
                    ])
                    ->vertical()
                    ->creatable(limit: 30)
                    ->removable()
                    ->default($setting[$field] ?? ''),

                Switcher::make(__('Публикация'), $field . '_published')
                    ->default($setting[$field . '_published'] ?? 1),
            ]),
        ];
    }

    /**
     * Кнопка «Очистить статистику» под диаграммой: таблица нажатий
     * ничем не ограничена и со временем разрастается.
     */
    #[AsyncMethod]
    public function clearStatistic(Request $request): JsonResponse
    {
        $deleted = ChangeStatistic::query()->delete();

        return JsonResponse::make()
            ->toast(__('Удалено записей: ') . $deleted, ToastType::SUCCESS)
            ->redirect($this->getUrl());
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        $setting = $this->setting();

        return [
            FormBuilder::make('/moonshine/change-contacts', FormMethod::POST)
                ->fields([
                    Grid::make([
                        Column::make(
                            $this->channelBlock($setting, '1', __('Режим показа для телефона'), 'phone', __('Телефон')),
                        )->columnSpan(4),

                        Column::make(
                            $this->channelBlock($setting, '2', __('Режим показа для whatsapp'), 'whatsapp', 'WhatsApp'),
                        )->columnSpan(4),

                        Column::make(
                            $this->channelBlock($setting, '3', __('Режим показа для telegram'), 'telegram', 'Telegram'),
                        )->columnSpan(4),
                    ]),

                    Divider::make(__('Режимы показа')),

                    Grid::make([
                        Column::make([
                            Node::make('', 'node'),
                        ])->columnSpan(12),
                    ]),

                    Divider::make(__('Статистика')),

                    Grid::make([
                        Column::make([
                            DonutChartMetric::make(__('Статистика'))
                                ->values($this->statistic())
                                ->colors(['#EF533F', '#00a356', '#27a3e3']),

                            Flex::make([
                                ActionButton::make(__('Очистить статистику'))
                                    // page обязателен: маршрут moonshine.method строится по pageUri
                                    ->method('clearStatistic', page: $this)
                                    ->withConfirm(
                                        title: __('Очистить статистику'),
                                        content: __('Все записи о нажатиях будут удалены без возможности восстановления. Продолжить?'),
                                        button: __('Удалить'),
                                    )
                                    ->error()
                                    ->icon('trash'),
                            ])->justifyAlign('end'),
                        ])->columnSpan(12),
                    ]),

                    Grid::make([
                        Column::make([
                            Tabs::make([
                                Tab::make(__('Неделя'), [
                                    StatisticWeek::make('', 'statistic')
                                        ->device_statistics(ChangeStatistic::class, 7),
                                ]),

                                Tab::make(__('Месяц'), [
                                    StatisticWeek::make('', 'statistic')
                                        ->device_statistics(ChangeStatistic::class, 30),
                                ]),

                                Tab::make(__('Год'), [
                                    StatisticWeek::make('', 'statistic')
                                        ->device_statistics(ChangeStatistic::class, 365),
                                ]),
                            ]),
                        ])->columnSpan(12),
                    ]),
                ])
                ->submit(label: __('Сохранить'), attributes: ['class' => 'btn-primary']),
        ];
    }
}
