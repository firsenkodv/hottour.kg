<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Menudump2;

use App\Models\Menudump2;
use App\MoonShine\Resources\Menudump2\Pages\Menudump2FormPage;
use App\MoonShine\Resources\Menudump2\Pages\Menudump2IndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Menudump2>
 */
#[Icon('bars-3')]
#[Group('Меню', 'bars-3')]
#[Order(4)]
class Menudump2Resource extends TreeResource
{
    protected string $model = Menudump2::class;

    protected string $title = 'Меню о нас';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            Menudump2IndexPage::class,
            Menudump2FormPage::class,
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
