<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelcategory;

use App\Models\Travelcategory;
use App\MoonShine\Resources\Travelcategory\Pages\TravelcategoryFormPage;
use App\MoonShine\Resources\Travelcategory\Pages\TravelcategoryIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Travelcategory>
 */
#[Icon('fire')]
#[Group('Категории', 'folder')]
#[Order(1)]
class TravelcategoryResource extends TreeResource
{
    protected string $model = Travelcategory::class;

    protected string $title = 'Горящие туры';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TravelcategoryIndexPage::class,
            TravelcategoryFormPage::class,
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
