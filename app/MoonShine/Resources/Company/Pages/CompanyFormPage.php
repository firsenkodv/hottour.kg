<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Company\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Dump2\Dump2Resource;
use App\MoonShine\Resources\Company\CompanyResource;
use MoonShine\Ace\Fields\Code;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\TinyMce\Fields\TinyMce;
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
use MoonShine\UI\Fields\Textarea;

/**
 * v2: CompanyResource::formFields().
 * Пустой таб «Дополнительно» из v2 не переносится — в нём не было полей.
 *
 * @extends FormPage<CompanyResource>
 */
class CompanyFormPage extends FormPage
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
                                Collapse::make(__('Заголовок/Алиас'), [
                                    Text::make(__('Заголовок'), 'title')->required(),

                                    Slug::make(__('Алиас'), 'slug')
                                        ->from('title')
                                        ->unique(),
                                ]),

                                Text::make(__('Подзаголовок'), 'subtitle')->unescape(),

                                Image::make(__('Изображение'), 'img')
                                    ->disk(config('moonshine.disk', 'moonshine'))
                                    ->dir('dump')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                TinyMce::make(__('Краткое описание'), 'smalltext'),

                                Collapse::make(__('Тизер отзыва'), [
                                    Date::make(__('Дата поездки'), 'trip_date')
                                        ->format('d.m.Y')
                                        ->hint('В карточке выводится месяцем: «Январь 2024»'),

                                    Number::make(__('Количество туристов'), 'adults')
                                        ->min(1)
                                        ->max(99)
                                        ->hint('В карточке: «2 взрослых»'),

                                    Number::make(__('Оценка'), 'rating')
                                        ->min(0)
                                        ->max(5)
                                        ->step(0.1)
                                        ->hint('От 0 до 5, например 5.0 — бейдж со звездой на фото'),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Шаблон вывода'), [
                                    Select::make(__('Шаблон страницы'), 'template')
                                        ->options(ItemTemplate::toOptions())
                                        ->default(ItemTemplate::Default->value)
                                        ->hint('Вёрстка: resources/views/pages/dumps/templates/item'),
                                ]),

                                Collapse::make(__('HTML и CSS страницы'), [
                                    Textarea::make(__('HTML-блок'), 'html')->unescape()
                                        ->hint('Произвольный HTML, выводится в контенте страницы'),

                                    Code::make(__('CSS страницы'), 'custom_css')->language('css')->unescape()
                                        ->hint('Стили только для этой страницы, без обёртки style — только правила CSS'),
                                ]),

                                Collapse::make(__('Метотеги'), [
                                    Text::make(__('Мета тэг (title)'), 'metatitle')->unescape(),

                                    Text::make(__('Мета тэг (description)'), 'description')->unescape(),

                                    Text::make(__('Мета тэг (keywords)'), 'keywords')->unescape(),

                                    Switcher::make(__('Публикация'), 'published')->default(1),
                                ]),

                                Collapse::make(__('Вложенность'), [
                                    BelongsTo::make(
                                        __('Категория'),
                                        'parent',
                                        resource: Dump2Resource::class,
                                    )
                                        ->nullable()
                                        ->searchable(),
                                ]),

                                Date::make(__('Дата создания'), 'created_at')
                                    ->format('d.m.Y')
                                    ->default(now()->toDateTimeString())
                                    ->sortable(),

                                Collapse::make(__('Скрипты'), [
                                    Switcher::make(__('Скрипт'), 'script_published')->updateOnPreview(),

                                    Text::make(__('Номер модуля Tourvisor'), 'tourvisor_module_id')
                                        ->hint('Только номер из tv-moduleid-..., например 998028. Разметку добавит шаблон')
                                        ->showWhen('script_published', 1),

                                    Textarea::make(__('Cкрипт'), 'script')
                                        ->unescape()
                                        ->showWhen('script_published', 1),
                                ]),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),

                        Grid::make([
                            Column::make([
                                TinyMce::make(__('Описание'), 'text'),
                            ])->columnSpan(12),
                        ]),

                        Divider::make(__('Дополнительное изображение на страницу')),

                        Image::make(__('Изображение'), 'pageimg1')
                            ->disk(config('moonshine.disk', 'moonshine'))
                            ->dir('dump')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                            ->removable()
                            ->hint('Растягивается на 100% ширины'),

                        Divider::make(),

                        Grid::make([
                            Column::make([
                                TinyMce::make(__('Дополнительное описание'), 'text2'),
                            ])->columnSpan(12),
                        ]),

                        Image::make(__('Изображение'), 'pageimg2')
                            ->disk(config('moonshine.disk', 'moonshine'))
                            ->dir('dump')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                            ->removable()
                            ->hint('Растягивается на 100% ширины'),

                        Divider::make(),

                        Grid::make([
                            Column::make([
                                TinyMce::make(__('Дополнительное описание'), 'text3'),
                            ])->columnSpan(12),
                        ]),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * v2: CompanyResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'metatitle' => 'max:2024',
            'description' => 'max:2024',
            'keywords' => 'max:2024',
        ];
    }
}
