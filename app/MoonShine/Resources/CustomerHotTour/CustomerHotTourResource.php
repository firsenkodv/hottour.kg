<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CustomerHotTour;

use App\Models\CustomerHotTour;
use App\MoonShine\Resources\CustomerHotTour\Pages\CustomerHotTourFormPage;
use App\MoonShine\Resources\CustomerHotTour\Pages\CustomerHotTourIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<CustomerHotTour, CustomerHotTourIndexPage, CustomerHotTourFormPage>
 */
#[Icon('fire')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(4)]
class CustomerHotTourResource extends ModelResource
{
    protected string $model = CustomerHotTour::class;

    protected string $title = 'API Горящие туры';

    protected string $column = 'sorting';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CustomerHotTourIndexPage::class,
            CustomerHotTourFormPage::class,
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
