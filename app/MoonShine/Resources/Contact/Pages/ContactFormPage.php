<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contact\Pages;

use App\MoonShine\Resources\Contact\ContactResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContactResource::formFields().
 *
 * @extends FormPage<ContactResource>
 */
class ContactFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('Контакт'), [
                        Grid::make([
                            Column::make([
                                ID::make()->sortable(),

                                Collapse::make(__('Город'), [
                                    Text::make(__('Заголовок'), 'title')->required(),

                                    Text::make(__('Только он-лайн'), 'label')
                                        ->hint('Приписка к Телефону'),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Дополнительно'), [
                                    Switcher::make(__('Публикация'), 'published')->default(1),

                                    Number::make(__('Сортировка'), 'sorting')
                                        ->buttons()
                                        ->default(0),
                                ]),
                            ])->columnSpan(6),
                        ]),

                        Grid::make([
                            Column::make([
                                Text::make(__('Адрес'), 'address'),

                                Text::make(__('Карта'), 'yandex_map'),

                                Text::make('Email', 'email'),

                                Text::make('Telegram', 'skype'),

                                TinyMce::make(__('Описание'), 'text'),
                            ])->columnSpan(12),
                        ]),

                        Grid::make([
                            Column::make([
                                Json::make(__('Телефоны'), 'data_phone')
                                    ->fields([
                                        Text::make(__('Номер'), 'jt1'),
                                    ])
                                    ->vertical()
                                    ->removable(),
                            ])->columnSpan(6),

                            Column::make([
                                Json::make(__('Эл. почта'), 'data_email')
                                    ->fields([
                                        Text::make('Email', 'jt1'),
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
