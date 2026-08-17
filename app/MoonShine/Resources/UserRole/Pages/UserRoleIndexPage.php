<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\UserRole\Pages;

use App\MoonShine\Resources\UserRole\UserRoleResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * v2: UserRoleResource::fields().
 *
 * @extends IndexPage<UserRoleResource>
 */
class UserRoleIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make('Name', 'name'),
        ];
    }
}
