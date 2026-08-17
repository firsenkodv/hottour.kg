<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contract;

use App\Models\Contract;
use App\MoonShine\Resources\Contract\Pages\ContractFormPage;
use App\MoonShine\Resources\Contract\Pages\ContractIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Contract, ContractIndexPage, ContractFormPage>
 */
#[Icon('document-text')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(2)]
class ContractResource extends ModelResource
{
    protected string $model = Contract::class;

    protected string $title = 'Договоры';

    protected string $column = 'contract_number';

    protected string $sortColumn = 'created_at';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ContractIndexPage::class,
            ContractFormPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'contract_number', 'title'];
    }
}
