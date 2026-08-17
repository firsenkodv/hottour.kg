<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menudump;

use App\Models\Menudump;
use App\MoonShine\Resources\Menudump\Pages\MenudumpFormPage;
use App\MoonShine\Resources\Menudump\Pages\MenudumpIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Menudump>
 */
#[Icon('bars-3')]
#[Group('Меню', 'bars-3')]
#[Order(3)]
class MenudumpResource extends TreeResource
{
    protected string $model = Menudump::class;

    protected string $title = 'Меню полезное';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            MenudumpIndexPage::class,
            MenudumpFormPage::class,
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
