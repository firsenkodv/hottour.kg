<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menuhottour;

use App\Models\Menuhottour;
use App\MoonShine\Resources\Menuhottour\Pages\MenuhottourFormPage;
use App\MoonShine\Resources\Menuhottour\Pages\MenuhottourIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Menuhottour>
 */
#[Icon('bars-3')]
#[Group('Меню', 'bars-3')]
#[Order(1)]
class MenuhottourResource extends TreeResource
{
    protected string $model = Menuhottour::class;

    protected string $title = 'Меню горящих туров';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            MenuhottourIndexPage::class,
            MenuhottourFormPage::class,
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
