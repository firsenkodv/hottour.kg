<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour\Pages;

use App\Enums\Resources\ItemTemplate;
use App\MoonShine\Resources\Tour\TourResource;
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
 * v2: TourResource::formFields().
 * Пустой таб «Дополнительно» из v2 не переносится — в нём не было полей.
 *
 * @extends FormPage<TourResource>
 */
class TourFormPage extends FormPage
{
    /**
     * Города вылета — идентификаторы Tourvisor, значения перенесены из v2 без изменений.
     *
     * @return array<string, array<int, string>>
     */
    private function cityOptions(): array
    {
        return [
            'Казахстан' => [
                60 => 'Алматы',
                59 => 'Астана',
                53 => 'Абакан',
                74 => 'Актау',
                73 => 'Актобе',
            ],
            'Россия' => [
                1 => 'Москва',
                5 => 'Санкт-Петербург',
                56 => 'Сочи',
                10 => 'Казань',
                3 => 'Екатеринбург',
                17 => 'Калининград',
                12 => 'Красноярск',
                9 => 'Новосибирск',
                21 => 'Омск',
                63 => 'Анапа',
                29 => 'Архангельск',
                40 => 'Астрахань',
                25 => 'Барнаул',
                32 => 'Белгород',
                36 => 'Благовещенск',
                45 => 'Братск',
                38 => 'Брянск',
                23 => 'Владивосток',
                46 => 'Владикавказ',
                27 => 'Волгоград',
                26 => 'Воронеж',
                116 => 'Геленджик',
                124 => 'Горно-Алтайск',
                96 => 'Грозный',
                103 => 'Иваново',
                64 => 'Ижевск',
                22 => 'Иркутск',
                95 => 'Калуга',
                15 => 'Кемерово',
                104 => 'Киров',
                11 => 'Краснодар',
                119 => 'Курган',
                47 => 'Курск',
                115 => 'Липецк',
                48 => 'Магнитогорск',
                94 => 'Махачкала',
                39 => 'Мин.Воды',
                30 => 'Мурманск',
                8 => 'Н.Новгород',
                54 => 'Нальчик',
                34 => 'Нижневартовск',
                19 => 'Нижнекамск',
                16 => 'Новокузнецк',
                67 => 'Новый Уренгой',
                123 => 'Ноябрьск',
                28 => 'Оренбург',
                49 => 'Орск',
                43 => 'П.Камчатский',
                65 => 'Пенза',
                2 => 'Пермь',
                117 => 'Петрозаводск',
                118 => 'Псков',
                18 => 'Ростов-на-Дону',
                7 => 'Самара',
                101 => 'Саранск',
                31 => 'Саратов',
                55 => 'Ставрополь',
                13 => 'Сургут',
                41 => 'Сыктывкар',
                52 => 'Томск',
                14 => 'Тюмень',
                42 => 'Улан-Удэ',
                50 => 'Ульяновск',
                84 => 'Уральск',
                4 => 'Уфа',
                20 => 'Хабаровск',
                35 => 'Ханты-Мансийск',
                51 => 'Чебоксары',
                6 => 'Челябинск',
                102 => 'Череповец',
                44 => 'Чита',
                24 => 'Ю.Сахалинск',
                37 => 'Якутск',
                85 => 'Ярославль',
            ],
        ];
    }

    /**
     * Страны — идентификаторы Tourvisor, значения перенесены из v2 без изменений.
     *
     * @return array<string, array<int, string>>
     */
    private function countryOptions(): array
    {
        return [
            'Основные' => [
                1 => 'Египет',
                2 => 'Таиланд',
                4 => 'Турция',
                9 => 'ОАЭ',
                16 => 'Вьетнам',
                13 => 'Китай',
                47 => 'Россия',
            ],
            'Остальные' => [
                46 => 'Абхазия',
                31 => 'Австрия',
                55 => 'Азербайджан',
                71 => 'Албания',
                17 => 'Андорра',
                88 => 'Аргентина',
                53 => 'Армения',
                59 => 'Бахрейн',
                57 => 'Беларусь',
                74 => 'Бельгия',
                20 => 'Болгария',
                39 => 'Бразилия',
                44 => 'Великобритания',
                37 => 'Венгрия',
                90 => 'Венесуэла',
                6 => 'Греция',
                54 => 'Грузия',
                11 => 'Доминикана',
                30 => 'Израиль',
                3 => 'Индия',
                7 => 'Индонезия',
                29 => 'Иордания',
                92 => 'Иран',
                14 => 'Испания',
                24 => 'Италия',
                78 => 'Казахстан',
                40 => 'Камбоджа',
                79 => 'Катар',
                51 => 'Кения',
                15 => 'Кипр',
                60 => 'Киргизия',
                10 => 'Куба',
                80 => 'Ливан',
                27 => 'Маврикий',
                36 => 'Малайзия',
                8 => 'Мальдивы',
                50 => 'Мальта',
                23 => 'Марокко',
                18 => 'Мексика',
                81 => 'Мьянма',
                82 => 'Непал',
                45 => 'Нидерланды',
                83 => 'Норвегия',
                64 => 'Оман',
                87 => 'Панама',
                35 => 'Португалия',
                93 => 'Саудовская Аравия',
                28 => 'Сейшелы',
                58 => 'Сербия',
                25 => 'Сингапур',
                42 => 'Словакия',
                43 => 'Словения',
                41 => 'Танзания',
                5 => 'Тунис',
                56 => 'Узбекистан',
                26 => 'Филиппины',
                34 => 'Финляндия',
                32 => 'Франция',
                22 => 'Хорватия',
                21 => 'Черногория',
                19 => 'Чехия',
                52 => 'Швейцария',
                12 => 'Шри-Ланка',
                69 => 'Эстония',
                70 => 'Южная Корея',
                49 => 'Япония',
            ],
        ];
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
                                Collapse::make(__('Заголовок/Алиас'), [
                                    Text::make(__('Заголовок'), 'title')->required(),

                                    Slug::make(__('Алиас'), 'slug')
                                        ->from('title')
                                        ->unique(),
                                ]),

                                Collapse::make(__('Опции'), [
                                    Switcher::make(__('Опции'), 'params_published')->updateOnPreview(),

                                    Select::make(__('Город вылета'), 'city')
                                        ->options($this->cityOptions())
                                        ->searchable()
                                        ->required(),

                                    Select::make(__('Страна'), 'country')
                                        ->options($this->countryOptions())
                                        ->searchable()
                                        ->required(),

                                    Select::make(__('Пропуск'), 'removeitem')
                                        ->options([
                                            0 => 0,
                                            1 => 1,
                                            2 => 2,
                                            5 => 5,
                                            10 => 10,
                                            20 => 20,
                                        ])
                                        ->hint('Количество туров которые нужно пропустить'),
                                ]),

                                Text::make(__('Полный заголовок'), 'subtitle'),

                                Text::make(__('Название для внутреннего меню'), 'title_for_menu'),

                                Image::make(__('Изображение'), 'img')
                                    ->disk(config('moonshine.disk', 'moonshine'))
                                    ->dir('tour')
                                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg'])
                                    ->removable(),

                                TinyMce::make(__('Краткое описание'), 'smalltext'),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Шаблон вывода'), [
                                    Select::make(__('Шаблон страницы'), 'template')
                                        ->options(ItemTemplate::toOptions())
                                        ->default(ItemTemplate::Default->value)
                                        ->hint('Вёрстка: resources/views/pages/tours/templates/item'),
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
                            ->dir('tour')
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
                            ->dir('tour')
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
     * v2: TourResource::rules().
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
