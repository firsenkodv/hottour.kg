<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page;

use App\Models\Page;
use App\MoonShine\Resources\Page\Pages\PageFormPage;
use App\MoonShine\Resources\Page\Pages\PageIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Page, PageIndexPage, PageFormPage>
 */
#[Icon('bars-3')]
#[Group('Материалы', 'document-duplicate')]
#[Order(7)]
class PageResource extends ModelResource
{
    protected string $model = Page::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Страницы';

    protected string $column = 'sorting';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            PageIndexPage::class,
            PageFormPage::class,
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
