<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Resort;

use App\Models\Resort;
use App\MoonShine\Resources\Resort\Pages\ResortFormPage;
use App\MoonShine\Resources\Resort\Pages\ResortIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Resort, ResortIndexPage, ResortFormPage>
 */
#[Icon('sun')]
#[Group('Материалы', 'document-duplicate')]
#[Order(0)]
class ResortResource extends ModelResource
{
    protected string $model = Resort::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Курорты';

    protected string $column = 'sorting';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ResortIndexPage::class,
            ResortFormPage::class,
        ];
    }

    /**
     * v2: getActiveActions() возвращал create/update/delete/massDelete — без view.
     */
    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'title'];
    }
}
