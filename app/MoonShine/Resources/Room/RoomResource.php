<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Room;

use App\Models\Room;
use App\MoonShine\Resources\Room\Pages\RoomFormPage;
use App\MoonShine\Resources\Room\Pages\RoomIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\SkipMenu;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * Номера отелей. В меню v2 ресурс не выводился — сохраняем поведение
 * через #[SkipMenu].
 *
 * @extends ModelResource<Room, RoomIndexPage, RoomFormPage>
 */
#[SkipMenu]
class RoomResource extends ModelResource
{
    protected string $model = Room::class;

    protected string $title = 'Номера отелей';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            RoomIndexPage::class,
            RoomFormPage::class,
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
