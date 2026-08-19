<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Page\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Page\PageResource;
use Illuminate\Validation\Rule;
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
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * v2: PageResource::formFields().
 * Пустой таб «Дополнительно» из v2 не переносится — в нём не было полей.
 *
 * @extends FormPage<PageResource>
 */
class PageFormPage extends FormPage
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
                                        ->unique()
                                        ->hint('Для главной обязательно home'),
                                ]),

                                Text::make(__('Подзаголовок'), 'subtitle'),

                                TinyMce::make(__('Краткое описание'), 'smalltext'),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Шаблон вывода'), [
                                    Select::make(__('Шаблон страницы'), 'template')
                                        ->options(ItemTemplate::toOptions())
                                        ->default(ItemTemplate::Default->value)
                                        ->hint('Вёрстка: resources/views/pages/page/templates/item'),
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


                                    Switcher::make(__('Главная'), 'add_to_main')->default(0),

                                    Number::make(__('Сортировка'), 'sorting')
                                        ->buttons()
                                        ->default(0),
                                ]),

                                Collapse::make(__('Скрипты'), [
                                    Switcher::make(__('Скрипт'), 'script_published')->updateOnPreview(),

                                    Textarea::make(__('Cкрипт'), 'script_page'),
                                ]),
                            ])->columnSpan(6),
                        ]),

                        Divider::make(),

                        Grid::make([
                            Column::make([
                                Text::make(__('Номер модуля Tourvisor'), 'tourvisor_module_id')
                                    ->hint('Только номер из tv-moduleid-..., например 998028. Разметку добавит шаблон')
                                    ->showWhen('script_published', 1),

                                Textarea::make(__('Скрипт js'), 'script')
                                    ->unescape()
                                    ->showWhen('script_published', 1),
                            ])->columnSpan(12),
                        ]),

                        Grid::make([
                            Column::make([
                                TinyMce::make(__('Описание'), 'text'),
                            ])->columnSpan(12),
                        ]),

                        Divider::make(__('Дополнительное изображение на страницу')),

                        Image::make(__('Изображение'), 'pageimg1')
                            ->disk(config('moonshine.disk', 'moonshine'))
                            ->dir('page')
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
                            ->dir('page')
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
     * v2: PageResource::rules().
     *
     * Правило add_to_main гарантирует, что «главной» помечена только одна страница.
     * В v4 в rules() приходит обёртка данных, поэтому модель достаём через getOriginal().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'metatitle' => 'max:255',
            'description' => 'max:512',
            'keywords' => 'max:512',
            'add_to_main' => [
                Rule::unique('pages')->ignoreModel($item->getOriginal()),
            ],
        ];
    }
}
