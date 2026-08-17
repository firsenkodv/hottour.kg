<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Bitrix24\Bitrix24;
use App\Models\MoonshineSetting;
use App\Models\Setting;
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
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * v2: App\MoonShine\Pages\MoonshineSettingPage.
 * Форма отправляется на /moonshine/setting-website — контроллер перенесён
 * в App\Http\Controllers\Admin\MoonshineSettingController.
 *
 * Значения подставляются по ключу, который берётся из последнего сегмента URL
 * (хелпер проекта url2()) — так же, как в v2.
 */
#[Icon('cog')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(8)]
class MoonshineSettingPage extends Page
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
        return $this->title ?: 'Настройки сайта';
    }

    /**
     * v2: MoonshineSettingPage::setting().
     *
     * @return array<string, mixed>
     */
    private function setting(): array
    {
        $segments = explode('/', url2());
        $key = array_pop($segments);

        $result = MoonshineSetting::query()->where('key', $key)->first();

        return $result?->toArray() ?? [];
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        $setting = $this->setting();

        $value = static fn (string $name): string => (string) ($setting[$name] ?? '');

        // Доступы к Битрикс24 хранятся отдельно, группой в settings:
        // moonshine_settings — таблица с фиксированными колонками
        $bitrix = Setting::getGroup(Bitrix24::GROUP)->data ?? [];

        return [
            FormBuilder::make('/moonshine/setting-website', FormMethod::POST)
                ->fields([
                    Tabs::make([
                        Tab::make(__('Общие настройки'), [
                            Grid::make([
                                Column::make([
                                    Divider::make(__('Общие константы')),

                                    Box::make([
                                        Textarea::make(__('Бонусы'), 'bonus')->default($value('bonus')),

                                        Textarea::make(__('Баллы'), 'ball')->default($value('ball')),

                                        Textarea::make(__('Кешбэк'), 'cashback')->default($value('cashback')),
                                    ]),
                                ])->columnSpan(6),

                                Column::make([
                                    Divider::make(__('Контакты')),

                                    Box::make([
                                        Text::make(__('Полный адрес'), 'fullAddress')
                                            ->default($value('fullAddress'))
                                            ->unescape(),

                                        Text::make(__('Адрес'), 'address')
                                            ->default($value('address'))
                                            ->unescape(),

                                        Text::make(__('Страна'), 'country')
                                            ->default($value('country'))
                                            ->unescape(),

                                        Text::make(__('Адрес с городом'), 'sityAddress')
                                            ->default($value('sityAddress'))
                                            ->unescape(),

                                        Text::make(__('ИДН'), 'idn')->default($value('idn')),

                                        Text::make(__('Телефон'), 'phone1')->default($value('phone1')),

                                        Text::make(__('Телефон2'), 'phone2')->default($value('phone2')),

                                        Text::make(__('Название компании'), 'company_name')
                                            ->default($value('company_name'))
                                            ->unescape(),

                                        Text::make(__('БИН'), 'bin')->default($value('bin')),
                                    ]),

                                    Divider::make(__('Сети')),

                                    Box::make([
                                        Text::make('WhatsApp', 'whatsapp')->default($value('whatsapp')),

                                        Text::make('Telegram', 'telegram')->default($value('telegram')),

                                        Text::make('Facebook', 'facebook')->default($value('facebook')),

                                        Text::make('Instagram', 'instagram')->default($value('instagram')),

                                        Text::make('Youtube', 'youtube')->default($value('youtube')),
                                    ]),
                                ])->columnSpan(6),
                            ]),
                        ]),

                        Tab::make(__('Битрикс24'), [
                            Grid::make([
                                Column::make([
                                    Divider::make(__('Заявки с форм сайта')),

                                    Box::make([
                                        Switcher::make(__('Отправлять заявки в Битрикс24'), 'bx_enabled')
                                            ->default((bool) ($bitrix['bx_enabled'] ?? false))
                                            ->hint(__('Работает только если заполнены оба поля ниже. Письма на почту уходят в любом случае')),

                                        Text::make(__('Вебхук'), 'bx_webhook')
                                            ->default((string) ($bitrix['bx_webhook'] ?? ''))
                                            ->hint(__('Обязательно. Адрес портала: https://ваш-портал.bitrix24.kz/rest/1/токен/')),

                                        Text::make(__('ID ответственного'), 'bx_resp_id')
                                            ->default((string) ($bitrix['bx_resp_id'] ?? ''))
                                            ->hint(__('Обязательно. ID сотрудника Битрикс24, на которого назначаются сделки')),

                                        Text::make(__('E-mail для уведомлений'), 'bx_email_to')
                                            ->default((string) ($bitrix['bx_email_to'] ?? '')),
                                    ]),
                                ])->columnSpan(8),
                            ]),
                        ])->icon('bell-snooze'),
                    ]),
                ])
                ->submit(label: __('Сохранить'), attributes: ['class' => 'btn-primary']),
        ];
    }
}
