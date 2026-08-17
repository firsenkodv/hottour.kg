<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Payment\Pages;

use App\MoonShine\Resources\Payment\PaymentResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * v2: PaymentResource::indexFields().
 *
 * @extends IndexPage<PaymentResource>
 */
class PaymentIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Номер'), 'order_number'),

            BelongsTo::make(
                __('Пользователь'),
                'user',
                resource: UserResource::class,
            ),

            Text::make(__('Сумма'), 'amount'),

            Text::make(__('Статус'), 'order_status'),

            Date::make(__('Дата создания'), 'created_at')
                ->format('d.m.Y H:i:s'),
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
