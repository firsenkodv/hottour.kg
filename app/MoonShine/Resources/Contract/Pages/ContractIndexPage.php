<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contract\Pages;

use App\MoonShine\Resources\Contract\ContractResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContractResource::indexFields() + filters().
 *
 * @extends IndexPage<ContractResource>
 */
class ContractIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Номер'), 'contract_number'),

            Text::make(__('Заголовок'), 'title'),

            BelongsTo::make(
                __('Клиент'),
                'user',
                resource: UserResource::class,
            ),

            BelongsTo::make(
                __('Отель'),
                'hotel',
                resource: HotelResource::class,
            ),

            Date::make(__('Заезд'), 'date_departure')->format('d.m.Y'),

            Date::make(__('Выезд'), 'date_arrival')->format('d.m.Y'),

            Number::make(__('Стоимость'), 'tour_price'),

            Switcher::make(__('Подписан'), 'is_signed'),
        ];
    }

    /**
     * v2: ContractResource::filters().
     *
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            ID::make(),

            Text::make(__('Номер договора'), 'contract_number'),

            BelongsTo::make(
                __('Клиент'),
                'user',
                resource: UserResource::class,
            )
                ->nullable()
                ->searchable(),
        ];
    }

    /**
     * @param  TableBuilder  $component
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->clickAction(ClickAction::EDIT);
    }
}
