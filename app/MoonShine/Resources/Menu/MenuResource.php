<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menu;

use App\Models\Menu;
use App\MoonShine\Resources\Menu\Pages\MenuFormPage;
use App\MoonShine\Resources\Menu\Pages\MenuIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Menu>
 */
#[Icon('bars-3')]
#[Group('Меню', 'bars-3')]
#[Order(0)]
class MenuResource extends TreeResource
{
    protected string $model = Menu::class;

    protected string $title = 'Меню стран';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            MenuIndexPage::class,
            MenuFormPage::class,
        ];
    }

    /**
     * v2: getActiveActions() возвращал create/update/delete/massDelete — без view.
     * MASS_DELETE в дереве отключён самим TreeResource.
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
        return null;
    }

    public function sortKey(): string
    {
        return 'sorting';
    }
}
