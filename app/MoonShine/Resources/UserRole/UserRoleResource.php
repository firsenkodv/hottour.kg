<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\UserRole;

use App\Models\UserRole;
use App\MoonShine\Resources\UserRole\Pages\UserRoleFormPage;
use App\MoonShine\Resources\UserRole\Pages\UserRoleIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\SkipMenu;

/**
 * Роли пользователей сайта (App\Models\UserRole), не путать с ролями
 * администраторов панели (MoonShineUserRoleResource).
 *
 * В меню v2 этот ресурс не выводился — сохраняем поведение через #[SkipMenu].
 *
 * @extends ModelResource<UserRole, UserRoleIndexPage, UserRoleFormPage>
 */
#[SkipMenu]
class UserRoleResource extends ModelResource
{
    protected string $model = UserRole::class;

    protected string $title = 'Роли пользователей';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            UserRoleIndexPage::class,
            UserRoleFormPage::class,
        ];
    }
}
