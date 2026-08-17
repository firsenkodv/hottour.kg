<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CustomerHotTour\Pages;

use App\Models\Travelitem;
use App\MoonShine\Resources\CustomerHotTour\CustomerHotTourResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: CustomerHotTourResource::formFields().
 * Справочники городов и стран берутся из config('tourvisor.*') — конфиги перенесены.
 *
 * @extends FormPage<CustomerHotTourResource>
 */
class CustomerHotTourFormPage extends FormPage
{
    /**
     * v2: CustomerHotTourResource::getShowPage().
     * Список опубликованных «горящих туров» для выбора страницы перехода.
     * Нулевой пункт — заглушка, отсекается правилом doesnt_start_with:0.
     *
     * @return array<int, string>
     */
    private function getShowPage(): array
    {
        $items = Travelitem::query()
            ->select('id', 'title', 'travelcategory_id')
            ->where('published', 1)
            ->get();

        $options = [0 => 'Обязательно к заполнению'];

        foreach ($items as $item) {
            $options[$item->id] = $item->title . ' | ' . $item->parent->title;
        }

        return $options;
    }

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
                                Collapse::make(__('Заголовок'), [
                                    Text::make(__('Заголовок'), 'title')->required(),

                                    Text::make(__('Вылет из...'), 'subtitle'),

                                    Image::make(__('Изображение'), 'img')
                                        ->disk(config('moonshine.disk', 'moonshine'))
                                        ->dir('category')
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                        ->removable(),
                                ]),

                                Number::make(__('Процент'), 'procent')
                                    ->buttons()
                                    ->default(0),

                                Collapse::make(__('Опции'), [
                                    Select::make(__('Город вылета'), 'city')
                                        ->options([
                                            'Казахстан' => config('tourvisor.city_kz'),
                                            'Россия' => config('tourvisor.city_rus'),
                                        ])
                                        ->searchable()
                                        ->required(),

                                    Select::make(__('Страна'), 'country')
                                        ->options(config('tourvisor.country'))
                                        ->searchable()
                                        ->required(),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Публикация'), [
                                    Switcher::make(__('Публикация'), 'published')->default(1),

                                    Number::make(__('Сортировка'), 'sorting')
                                        ->buttons()
                                        ->default(0),
                                ]),

                                Collapse::make('', [
                                    Date::make(__('Дата обновления'), 'updated_at')
                                        ->format('H:i / d.m.Y')
                                        ->default(now()->toDateTimeString())
                                        ->sortable(),
                                ]),

                                Collapse::make(__('Ссылка'), [
                                    Select::make(__('Страница перехода'), 'travelitem_id')
                                        ->options($this->getShowPage())
                                        ->searchable()
                                        ->required(),
                                ]),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * v2: CustomerHotTourResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'travelitem_id' => 'doesnt_start_with:0',
        ];
    }
}
