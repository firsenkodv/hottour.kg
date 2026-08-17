<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menutour;

use App\Models\Menutour;
use App\MoonShine\Resources\Menutour\Pages\MenutourFormPage;
use App\MoonShine\Resources\Menutour\Pages\MenutourIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Menutour>
 */
#[Icon('bars-3')]
#[Group('Меню', 'bars-3')]
#[Order(2)]
class MenutourResource extends TreeResource
{
    protected string $model = Menutour::class;

    protected string $title = 'Меню туров';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            MenutourIndexPage::class,
            MenutourFormPage::class,
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

    public function treeKey(): ?string
    {
        return null;
    }

    public function sortKey(): string
    {
        return 'sorting';
    }
}
