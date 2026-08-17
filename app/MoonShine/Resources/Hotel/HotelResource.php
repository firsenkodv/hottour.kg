<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hotel;

use App\Models\Hotel;
use App\MoonShine\Resources\Hotel\Pages\HotelFormPage;
use App\MoonShine\Resources\Hotel\Pages\HotelIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Hotel, HotelIndexPage, HotelFormPage>
 */
#[Icon('building-office')]
#[Group('Материалы', 'document-duplicate')]
#[Order(1)]
class HotelResource extends ModelResource
{
    protected string $model = Hotel::class;

    protected string $title = 'Отели';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            HotelIndexPage::class,
            HotelFormPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'title', 'slug'];
    }
}
