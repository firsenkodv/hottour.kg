<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ContractFood;

use App\Models\ContractFood;
use App\MoonShine\Resources\ContractFood\Pages\ContractFoodFormPage;
use App\MoonShine\Resources\ContractFood\Pages\ContractFoodIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<ContractFood, ContractFoodIndexPage, ContractFoodFormPage>
 */
#[Icon('cake')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(0)]
class ContractFoodResource extends ModelResource
{
    protected string $model = ContractFood::class;

    protected string $title = 'Питание';

    protected string $column = 'title';

    protected string $sortColumn = 'id';

    /**
     * v2: protected string $sortDirection = 'ASC'; — в v4 это enum.
     */
    protected SortDirection $sortDirection = SortDirection::ASC;

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ContractFoodIndexPage::class,
            ContractFoodFormPage::class,
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
