<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\TourvisorCountry\Pages;

use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use App\MoonShine\Resources\TourvisorCountry\TourvisorCountryResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: TourvisorCountryResource::formFields().
 * Справочник стран берётся из config('tourvisor.country') — конфиг перенесён
 * из основного проекта вместе с остальными config/tourvisor/*.
 *
 * @extends FormPage<TourvisorCountryResource>
 */
class TourvisorCountryFormPage extends FormPage
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
                                Collapse::make(__('Название страны'), [
                                    Text::make(__('Заголовок'), 'name'),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Выбрать категорию'), [
                                    BelongsTo::make(
                                        __('Категория'),
                                        'parent',
                                        resource: HotCategoryResource::class,
                                    )
                                        ->nullable()
                                        ->searchable(),
                                ]),

                                Collapse::make(__('Данные для поиска'), [
                                    Select::make(__('Страна'), 'country_id')
                                        ->options(config('tourvisor.country'))
                                        ->searchable()
                                        ->required(),

                                    Text::make('Alpha2', 'flag'),

                                    Switcher::make(__('Популярные'), 'popular')->default(true),

                                    Switcher::make(__('Публикация'), 'active')->default(true),

                                    Switcher::make(__('По умолчанию'), 'default'),
                                ]),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),
                    ]),
                ]),
            ]),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [];
    }
}
