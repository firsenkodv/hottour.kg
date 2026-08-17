<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Travelcategory\Pages;

use App\Enums\Pages\ListTemplate;
use App\Enums\Resources\TeaserTemplate;
use App\MoonShine\Resources\Travelcategory\TravelcategoryResource;
use MoonShine\Ace\Fields\Code;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
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
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * v2: TravelcategoryResource::formFields().
 * Пустой таб «Дополнительно» из v2 не переносится — в нём не было полей.
 *
 * @extends FormPage<TravelcategoryResource>
 */
class TravelcategoryFormPage extends FormPage
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

                                Text::make(__('Подзаголовок'), 'subtitle'),

                                Text::make(__('Название для внутреннего меню'), 'title_for_menu'),

                                Image::make(__('Изображение'), 'img')
                                    ->disk(config('moonshine.disk', 'moonshine'))
                                    ->dir('travel')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                TinyMce::make(__('Краткое описание'), 'smalltext'),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Шаблон вывода'), [
                                    Select::make(__('Шаблон списка'), 'list_template')
                                        ->options(ListTemplate::toOptions())
                                        ->default(ListTemplate::Default->value),

                                    Select::make(__('Вид карточек в списке'), 'teaser_template')
                                        ->options(TeaserTemplate::toOptionsFor('hottours', 'teaser'))
                                        ->default(TeaserTemplate::Default->value),
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
                            ->dir('travel')
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
                            ->dir('travel')
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
     * v2: TravelcategoryResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'metatitle' => 'max:255',
            'description' => 'max:512',
            'keywords' => 'max:512',
        ];
    }
}
