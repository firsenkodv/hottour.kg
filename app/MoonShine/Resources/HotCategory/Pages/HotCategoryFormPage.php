<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\HotCategory\Pages;

use App\Enums\Pages\ListTemplate;
use App\Enums\Resources\ItemTemplate;
use App\Enums\Resources\TeaserTemplate;
use App\MoonShine\Resources\HotCategory\HotCategoryResource;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Fields\Slug;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Ace\Fields\Code;
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
 * v2: HotCategoryResource::formFields().
 *
 * Отличия от v2, сделанные намеренно:
 * - Block::make() → Box::make() (переименование в v4);
 * - одиночные Column для TinyMce обёрнуты в Grid — в v4 Column
 *   существует только внутри Grid, иначе едет вёрстка;
 * - ->showOnExport() у изображений убран: import/export у ресурса отключены,
 *   а в v4 поля экспорта задаются отдельным exportFields().
 *
 * @extends FormPage<HotCategoryResource>
 */
class HotCategoryFormPage extends FormPage
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
                                    ->dir('category')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                TinyMce::make(__('Краткое описание'), 'smalltext'),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Шаблон вывода'), [
                                    // страна выводится как отдельная страница,
                                    // а курортное направление внутри неё — как список материалов,
                                    // поэтому здесь оба набора настроек
                                    Select::make(__('Шаблон страницы страны'), 'template')
                                        ->options(ItemTemplate::toOptions())
                                        ->default(ItemTemplate::Default->value)
                                        ->hint('Вёрстка: resources/views/pages/countries/templates/country'),

                                    Select::make(__('Шаблон списка (для направления)'), 'list_template')
                                        ->options(ListTemplate::toOptions())
                                        ->default(ListTemplate::Default->value),

                                    Select::make(__('Вид карточек в списке'), 'teaser_template')
                                        ->options(TeaserTemplate::toOptionsFor('countries', 'teaser'))
                                        ->default(TeaserTemplate::Default->value),
                                ]),

                                Collapse::make(__('HTML и CSS страницы'), [
                                    Textarea::make(__('HTML-блок'), 'html')->unescape()
                                        ->hint('Произвольный HTML, выводится в контенте страницы'),

                                    Code::make(__('CSS страницы'), 'custom_css')->language('css')->unescape()
                                        ->hint('Стили только для этой страницы, без обёртки style — только правила CSS'),
                                ]),

                                Collapse::make(__('Метатеги'), [
                                    Text::make(__('Мета тэг (title)'), 'metatitle')->unescape(),

                                    Text::make(__('Мета тэг (description)'), 'description')->unescape(),

                                    Text::make(__('Мета тэг (keywords)'), 'keywords')->unescape(),

                                    Switcher::make(__('Публикация'), 'published')->default(1),

                                    Switcher::make(__('На главной'), 'main')->default(0),
                                ]),

                                Collapse::make(__('Вложенность'), [
                                    BelongsTo::make(
                                        __('Категория'),
                                        'parent',
                                        resource: HotCategoryResource::class,
                                    )
                                        ->nullable()
                                        ->searchable(),
                                ]),

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
                            ->dir('category')
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
                            ->dir('category')
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

                    Tab::make(__('Страны'), [
                        Image::make(__('Флаг'), 'imgflag')
                            ->disk(config('moonshine.disk', 'moonshine'))
                            ->dir('flag')
                            ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                            ->removable()
                            ->hint('Необходим svg формат изображения'),
                    ]),
                ]),
            ]),
        ];
    }

    /**
     * v2: HotCategoryResource::rules().
     */
    protected function rules(DataWrapperContract $item): array
    {
        return [
            'metatitle' => 'max:1024',
            'description' => 'max:1024',
            'keywords' => 'max:1024',
        ];
    }
}
