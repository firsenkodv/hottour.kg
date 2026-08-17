<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User;

use App\Models\User;
use App\MoonShine\Resources\User\Pages\UserFormPage;
use App\MoonShine\Resources\User\Pages\UserIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<User, UserIndexPage, UserFormPage>
 */
#[Icon('flag')]
#[Group('moonshine::ui.resource.system', 'users', translatable: true)]
#[Order(2)]
class UserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Пользователи';

    protected string $column = 'name';

    protected string $sortColumn = 'name';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            UserIndexPage::class,
            UserFormPage::class,
        ];
    }

    /**
     * v2: getActiveActions() возвращал только update/delete/massDelete —
     * создание пользователя из админки было отключено.
     */
    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::CREATE, Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'name', 'email', 'phone'];
    }
}
