<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\TourvisorCountry;

use App\Models\TourvisorCountry;
use App\MoonShine\Resources\TourvisorCountry\Pages\TourvisorCountryFormPage;
use App\MoonShine\Resources\TourvisorCountry\Pages\TourvisorCountryIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<TourvisorCountry>
 */
#[Icon('flag')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(5)]
class TourvisorCountryResource extends TreeResource
{
    protected string $model = TourvisorCountry::class;

    protected string $title = 'API Tourvisor';

    protected string $column = 'name';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TourvisorCountryIndexPage::class,
            TourvisorCountryFormPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'name'];
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
