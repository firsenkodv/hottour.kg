<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\User\Pages;

use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\UserRole\UserRoleResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Heading;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\PasswordRepeat;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: UserResource::formFields().
 *
 * Исправление относительно v2: связь «Роль» указывала resource: new UserResource(),
 * хотя User::parent() ведёт на App\Models\UserRole. Здесь указан UserRoleResource —
 * иначе в выпадающем списке вместо ролей подставлялись бы пользователи.
 *
 * @extends FormPage<UserResource>
 */
class UserFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                Tabs::make([
                    Tab::make(__('Общие настройки'), [
                        Grid::make([
                            Column::make([
                                Collapse::make('Username', [
                                    Text::make(__('Имя'), 'name')
                                        ->required()
                                        ->locked(),

                                    Text::make(__('Телефон'), 'phone')->locked(),
                                ]),

                                Collapse::make('Email', [
                                    Text::make('Email', 'email')->locked(),
                                ]),

                                Collapse::make(__('Паспортные данные'), [
                                    Text::make('ИНН', 'inn')->nullable(),

                                    Text::make(__('Паспорт'), 'passport')->nullable(),

                                    Text::make(__('Выдан'), 'passport_issued_at')->nullable(),

                                    Text::make(__('Кем выдан'), 'passport_issued_by')->nullable(),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Бонусы'), [
                                    Text::make(__('Бонус'), 'bonus'),

                                    Text::make(__('Балл'), 'ball'),

                                    Text::make(__('Кэшбек'), 'cashback'),

                                    Switcher::make(__('Публикация'), 'published')->default(1),
                                ]),

                                BelongsTo::make(
                                    __('Роль'),
                                    'parent',
                                    resource: UserRoleResource::class,
                                )
                                    ->nullable()
                                    ->searchable(),

                                Date::make(__('День рождения'), 'birthdate')
                                    ->format('d.m.Y')
                                    ->default(now()->toDateTimeString())
                                    ->sortable(),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),
                    ]),

                    Tab::make(__('moonshine::ui.resource.password'), [
                        Heading::make('Change password'),

                        Password::make(__('moonshine::ui.resource.password'), 'password')
                            ->customAttributes(['autocomplete' => 'new-password'])
                            ->eye(),

                        PasswordRepeat::make(__('moonshine::ui.resource.repeat_password'), 'password_repeat')
                            ->customAttributes(['autocomplete' => 'confirm-password'])
                            ->eye(),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * v2: UserResource::rules().
     * В v4 в rules() приходит обёртка, модель достаём через getOriginal().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => 'max:50',
            'email' => 'max:50',
            'password' => $item->getOriginal()?->exists
                ? 'sometimes|nullable|min:5|required_with:password_repeat|same:password_repeat'
                : 'required|min:5|required_with:password_repeat|same:password_repeat',
        ];
    }
}
