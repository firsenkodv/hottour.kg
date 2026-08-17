<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\UserRole\Pages;

use App\MoonShine\Resources\UserRole\UserRoleResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Text;

/**
 * v2: UserRoleResource::fields().
 *
 * @extends FormPage<UserRoleResource>
 */
class UserRoleFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Text::make('Name', 'name'),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }
}
