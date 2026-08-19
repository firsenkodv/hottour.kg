<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour;

use App\Models\Tour;
use App\MoonShine\Resources\Tour\Pages\TourFormPage;
use App\MoonShine\Resources\Tour\Pages\TourIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Tour, TourIndexPage, TourFormPage>
 */
#[Icon('list-bullet')]
#[Group('Категории', 'folder')]
#[Order(2)]
class TourResource extends ModelResource
{
    protected string $model = Tour::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Туры';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TourIndexPage::class,
            TourFormPage::class,
        ];
    }

    /**
     * v2: getActiveActions() возвращал create/update/delete/massDelete — без view.
     * Детальные страницы в проекте не используются.
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
