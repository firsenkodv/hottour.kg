<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelitem;

use App\Models\Travelitem;
use App\MoonShine\Resources\Travelitem\Pages\TravelitemFormPage;
use App\MoonShine\Resources\Travelitem\Pages\TravelitemIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Travelitem, TravelitemIndexPage, TravelitemFormPage>
 */
#[Icon('fire')]
#[Group('Материалы', 'document-duplicate')]
#[Order(4)]
class TravelitemResource extends ModelResource
{
    protected string $model = Travelitem::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Горящие туры';

    protected string $column = 'sorting';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TravelitemIndexPage::class,
            TravelitemFormPage::class,
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
