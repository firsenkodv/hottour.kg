<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use App\Models\UserRole;
use App\MoonShine\Resources\User\UserResource;
use Illuminate\Contracts\Database\Eloquent\Builder;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\Laravel\QueryTags\QueryTag;
use MoonShine\Support\Enums\ClickAction;
use MoonShine\UI\Components\Table\TableBuilder;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: UserResource::indexFields() + filters() + queryTags().
 *
 * @extends IndexPage<UserResource>
 */
class UserIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Image::make(__('Аватар'), 'avatar')
                ->disk('user'),

            Text::make(__('Имя'), 'name')->required(),

            Text::make(__('Email'), 'email')->required(),

            Text::make(__('Телефон'), 'phone')->required(),

            Switcher::make(__('Публикация'), 'published')->updateOnPreview(),
        ];
    }

    /**
     * v2: UserResource::filters().
     *
     * @return list<FieldContract>
     */
    protected function filters(): iterable
    {
        return [
            ID::make(),

            Text::make(__('Имя'), 'name'),

            Text::make('Email', 'email'),

            Text::make(__('Телефон'), 'phone'),
        ];
    }

    /**
     * v2: UserResource::queryTags() → addQueryTags().
     * Кнопки-фильтры строятся по ролям пользователей из таблицы user_roles.
     *
     * @return list<QueryTag>
     */
    protected function queryTags(): array
    {
        $tags = [
            QueryTag::make(
                __('Все'),
                static fn (Builder $query): Builder => $query,
            )->icon('banknotes'),
        ];

        foreach (UserRole::query()->get() as $role) {
            $tags[] = QueryTag::make(
                $role->name,
                static fn (Builder $query): Builder => $query->where('user_role_id', $role->id),
            )->icon('tag');
        }

        return $tags;
    }

    /**
     * @param  TableBuilder  $component
     */
    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return $component->clickAction(ClickAction::EDIT);
    }
}
