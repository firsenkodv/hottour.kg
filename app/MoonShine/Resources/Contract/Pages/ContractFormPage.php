<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contract\Pages;

use App\MoonShine\Resources\Contract\ContractResource;
use App\MoonShine\Resources\ContractFood\ContractFoodResource;
use App\MoonShine\Resources\ContractRoom\ContractRoomResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContractResource::formFields().
 * Самый связанный ресурс проекта: тянет User, Hotel, ContractRoom и ContractFood.
 *
 * @extends FormPage<ContractResource>
 */
class ContractFormPage extends FormPage
{
    /**
     * @return array<string, string>
     */
    private function yesNoOptions(): array
    {
        return ['yes' => 'Да', 'no' => 'Нет'];
    }

    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('Общее'), [
                        Grid::make([
                            Column::make([
                                Text::make(__('Номер договора'), 'contract_number')->disabled(),

                                Text::make(__('Заголовок'), 'title')->nullable(),

                                BelongsTo::make(
                                    __('Клиент'),
                                    'user',
                                    resource: UserResource::class,
                                )->searchable(),

                                Text::make(__('Город вылета'), 'city_departure')->nullable(),

                                Text::make(__('Город прилёта'), 'city_arrival')->nullable(),

                                Date::make(__('Дата вылета'), 'date_departure')->format('d.m.Y'),

                                Date::make(__('Дата прилёта'), 'date_arrival')->format('d.m.Y'),

                                Number::make(__('Количество дней'), 'days_count')->nullable(),
                            ])->columnSpan(6),

                            Column::make([
                                BelongsTo::make(
                                    __('Отель'),
                                    'hotel',
                                    resource: HotelResource::class,
                                )
                                    ->nullable()
                                    ->asyncSearch('title'),

                                Text::make(__('Отель (вручную)'), 'hotel_custom')->nullable(),

                                BelongsTo::make(
                                    __('Номер'),
                                    'room',
                                    resource: ContractRoomResource::class,
                                )
                                    ->nullable()
                                    ->searchable(),

                                BelongsTo::make(
                                    __('Питание'),
                                    'food',
                                    resource: ContractFoodResource::class,
                                )
                                    ->nullable()
                                    ->searchable(),

                                Number::make(__('Стоимость тура'), 'tour_price'),

                                Text::make(__('Рамочный договор (ссылка)'), 'framework_url')->nullable(),

                                Switcher::make(__('Подписан'), 'is_signed'),
                            ])->columnSpan(6),
                        ]),
                    ]),

                    Tab::make(__('Услуги'), [
                        Grid::make([
                            Column::make([
                                Select::make(__('Трансфер'), 'transfer')
                                    ->options($this->yesNoOptions())
                                    ->nullable(),

                                Select::make(__('Экскурсионная программа'), 'excursion_program')
                                    ->options($this->yesNoOptions())
                                    ->nullable(),

                                Select::make(__('Русскоговорящий гид'), 'russian_speaking_guide')
                                    ->options($this->yesNoOptions())
                                    ->nullable(),
                            ])->columnSpan(6),

                            Column::make([
                                Select::make(__('Визовая поддержка'), 'visa_support')
                                    ->options($this->yesNoOptions())
                                    ->nullable(),

                                Select::make(__('Медицинская поддержка'), 'medical_support')
                                    ->options($this->yesNoOptions())
                                    ->nullable(),
                            ])->columnSpan(6),
                        ]),
                    ]),

                    Tab::make(__('Люди'), [
                        Json::make(__('Взрослые'), 'people.adults')
                            ->fields([
                                Text::make(__('ФИО'), 'fio'),
                            ])
                            ->vertical()
                            ->creatable()
                            ->removable(),

                        Json::make(__('Дети'), 'people.children')
                            ->fields([
                                Text::make(__('ФИО'), 'fio'),

                                Text::make(__('Возраст'), 'age'),
                            ])
                            ->vertical()
                            ->creatable()
                            ->removable(),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * v2: ContractResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}
