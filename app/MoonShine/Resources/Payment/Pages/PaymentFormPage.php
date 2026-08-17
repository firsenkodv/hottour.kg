<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Payment\Pages;

use App\MoonShine\Fields\PaymentData;
use App\MoonShine\Resources\Payment\PaymentResource;
use App\MoonShine\Resources\User\UserResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * v2: PaymentResource::formFields().
 *
 * @extends FormPage<PaymentResource>
 */
class PaymentFormPage extends FormPage
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
                                Collapse::make(__('Наши данные'), [
                                    Text::make(__('Номер'), 'order_number')
                                        ->locked()
                                        ->hint('Номер сформирован на нашей стороне'),

                                    BelongsTo::make(
                                        __('Пользователь'),
                                        'user',
                                        resource: UserResource::class,
                                    )
                                        ->nullable()
                                        ->searchable(),

                                    Text::make(__('Время записи результата'), 'created_at')
                                        ->locked()
                                        ->hint('Это время не оплаты, а время записи платежа в базу данных. Время оплаты может незначительно отличаться'),

                                    Text::make(__('Сумма'), 'amount')
                                        ->locked()
                                        ->hint('Сумма оплаченная пользователем'),

                                    Text::make(__('Статус'), 'order_status')
                                        ->locked()
                                        ->hint('<br> 0 - заказ зарегистрирован, но не оплачен;
                                                <br> 1 - заказ только авторизован и еще не завершен (для двухстадийных платежей);
                                                <br> 2 - заказ авторизован и завершен;
                                                <br> 3 - авторизация отменена;
                                                <br> 4 - по транзакции была проведена операция возврата;
                                                <br> 5 - инициирована авторизация через ACS банка-эмитента;
                                                <br> 6 - авторизация отклонена;
                                                <br> 7 - ожидание оплаты заказы;
                                                <br> 8 - промежуточное завершение для многократного частичного завершения.'),
                                ]),

                                Textarea::make(__('Описание платежа'), 'desc'),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Данные от банка'), [
                                    Text::make('order_id')->locked(),

                                    Text::make('language', 'lang')->locked(),

                                    Text::make('currency')
                                        ->locked()
                                        ->hint('Изменение валюты происходит в личном кабинете банка'),

                                    PaymentData::make(__('Данные Json (ответ)')),
                                ]),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),
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
