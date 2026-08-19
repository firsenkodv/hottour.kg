<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\HotCategory;

use App\Models\HotCategory;
use App\MoonShine\Resources\HotCategory\Pages\HotCategoryFormPage;
use App\MoonShine\Resources\HotCategory\Pages\HotCategoryIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<HotCategory>
 */
#[Icon('flag')]
#[Group('Категории', 'folder')]
#[Order(0)]
class HotCategoryResource extends TreeResource
{
    protected string $model = HotCategory::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Страны';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            HotCategoryIndexPage::class,
            HotCategoryFormPage::class,
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

    public function treeKey(): ?string
    {
        return 'hot_category_id';
    }

    public function sortKey(): string
    {
        return 'sorting';
    }
}
