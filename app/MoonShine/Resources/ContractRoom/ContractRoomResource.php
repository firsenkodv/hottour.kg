<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\ContractRoom;

use App\Models\ContractRoom;
use App\MoonShine\Resources\ContractRoom\Pages\ContractRoomFormPage;
use App\MoonShine\Resources\ContractRoom\Pages\ContractRoomIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\Enums\SortDirection;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<ContractRoom, ContractRoomIndexPage, ContractRoomFormPage>
 */
#[Icon('home')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(1)]
class ContractRoomResource extends ModelResource
{
    protected string $model = ContractRoom::class;

    protected string $title = 'Номера';

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
            ContractRoomIndexPage::class,
            ContractRoomFormPage::class,
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
