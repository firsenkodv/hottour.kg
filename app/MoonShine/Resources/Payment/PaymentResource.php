<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Payment;

use App\Models\Payment;
use App\MoonShine\Resources\Payment\Pages\PaymentFormPage;
use App\MoonShine\Resources\Payment\Pages\PaymentIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Payment, PaymentIndexPage, PaymentFormPage>
 */
#[Icon('currency-dollar')]
#[Group('Платежи', 'currency-dollar')]
#[Order(0)]
class PaymentResource extends ModelResource
{
    protected string $model = Payment::class;

    protected string $title = 'Оплачено на сайте';

    protected string $column = 'created_at';

    protected string $sortColumn = 'created_at';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PaymentIndexPage::class,
            PaymentFormPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'order_number'];
    }
}
