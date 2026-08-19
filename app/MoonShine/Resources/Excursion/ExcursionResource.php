<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Excursion;

use App\Models\Excursion;
use App\MoonShine\Resources\Excursion\Pages\ExcursionFormPage;
use App\MoonShine\Resources\Excursion\Pages\ExcursionIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Excursion, ExcursionIndexPage, ExcursionFormPage>
 */
#[Icon('ticket')]
#[Group('Материалы', 'document-duplicate')]
#[Order(2)]
class ExcursionResource extends ModelResource
{
    protected string $model = Excursion::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Экскурсии';

    protected string $column = 'sorting';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ExcursionIndexPage::class,
            ExcursionFormPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'title'];
    }
}
