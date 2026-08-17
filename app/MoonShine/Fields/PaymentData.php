<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use App\Models\Payment;
use MoonShine\UI\Fields\Field;

/**
 * Показывает сырой JSON-ответ банка по платежу.
 *
 * v2: App\MoonShine\Fields\PaymentData (extends MoonShine\Fields\Field).
 * Набор трейтов из v2 (WithInputExtensions, WithMask, WithDefaultValue,
 * HasPlaceholder, UpdateOnPreview) не переносится — поле только для чтения,
 * ни один из них там не использовался.
 */
class PaymentData extends Field
{
    protected string $view = 'admin.fields.payment-data';

    /**
     * @return array<array-key, mixed>
     */
    private function paymentData(): array
    {
        $id = $this->getData()?->getKey();

        if (\is_null($id)) {
            return [];
        }

        $payment = Payment::query()->find($id);

        return (array) ($payment?->data ?? []);
    }

    protected function viewData(): array
    {
        return [
            'data' => $this->paymentData(),
        ];
    }
}
