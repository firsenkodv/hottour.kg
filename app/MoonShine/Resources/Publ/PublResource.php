<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Publ;

use App\Models\Publ;
use App\MoonShine\Resources\Publ\Pages\PublFormPage;
use App\MoonShine\Resources\Publ\Pages\PublIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Publ, PublIndexPage, PublFormPage>
 */
#[Icon('newspaper')]
#[Group('Материалы', 'document-duplicate')]
#[Order(5)]
class PublResource extends ModelResource
{
    protected string $model = Publ::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Статьи, Услуги';

    protected string $sortColumn = 'created_at';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PublIndexPage::class,
            PublFormPage::class,
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
