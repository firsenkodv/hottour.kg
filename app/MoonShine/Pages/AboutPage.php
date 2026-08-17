<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Enums\Pages\ListTemplate;
use App\Models\Setting;
use Illuminate\Http\Request;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\ToastType;
use MoonShine\Ace\Fields\Code;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\Collapse;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * Заглавная страница раздела «О нас» (/o-nas) — устроена как CountriesPage:
 * своей модели нет, содержимое лежит группой `about` в таблице settings.
 *
 * Табы повторяют блоки лендинга (pages/about/templates/list/landing.blade.php),
 * дефолтные значения залиты в settings при переносе текстов из хардкода.
 * Видео блока «Преимущества» не редактируется — как на главной, берётся
 * из public/video/hottour.mp4 (см. include/module/index_video.blade.php).
 *
 * Иконки и картинки карточек тоже не редактируются: они лежат в
 * public/images/landing/about и подставляются по порядковому номеру карточки.
 */
#[Icon('building-office-2')]
#[Group('Категории', 'folder')]
#[Order(5)]
class AboutPage extends Page
{
    public const GROUP = 'about';

    /** Раздел вёрстки: resources/views/pages/about/templates/{kind}/{шаблон}.blade.php */
    public const SECTION = 'about';

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'О нас';
    }

    private function getSetting(): Setting
    {
        return Setting::getGroup(self::GROUP);
    }

    #[AsyncMethod]
    public function store(Request $request): JsonResponse
    {
        $setting = $this->getSetting();
        // method и _component_name — служебные параметры вызова MoonShine,
        // в настройках страницы им не место
        $setting->data = $request->except(['_token', '_method', 'method', '_component_name']);
        $setting->save();

        return JsonResponse::make()->toast(__('Сохранено'), ToastType::SUCCESS);
    }

    private function form(): FormBuilder
    {
        return FormBuilder::make()
            ->asyncMethod('store')
            ->fill($this->getSetting()->data ?? [])
            ->fields([
                Box::make([
                    Tabs::make([
                        Tab::make(__('Общие'), [
                            Grid::make([
                                Column::make([
                                    Box::make([
                                        Text::make(__('Заголовок'), 'title')
                                            ->unescape()
                                            ->hint('h1 для стандартного шаблона и запасной вариант метатега title'),

                                        Divider::make(__('Описание раздела')),

                                        TinyMce::make(__('Описание раздела'), 'desc')
                                            ->hint('В стандартном шаблоне — под заголовком, в лендинге — последним блоком, свёрнутым до первого абзаца («Читать далее»)'),
                                    ]),
                                ])->columnSpan(8),

                                Column::make([
                                    Collapse::make(__('Шаблон вывода'), [
                                        Select::make(__('Шаблон страницы'), 'list_template')
                                            ->options(ListTemplate::toOptionsFor(self::SECTION, 'list'))
                                            ->default(ListTemplate::Default->value)
                                            ->hint('Вёрстка: resources/views/pages/about/templates/list/'),
                                    ]),
                                ])->columnSpan(4),
                            ]),
                        ])->icon('document-text'),

                        Tab::make(__('Первый экран'), [
                            Text::make(__('Заголовок'), 'hero_title')
                                ->unescape()
                                ->hint('h1 лендинга; перенос строки — html-тегом br'),

                            Textarea::make(__('Подзаголовок'), 'hero_lead'),

                            Collapse::make(__('Кнопки'), [
                                Json::make('', 'hero_buttons')->fields([
                                    Text::make(__('Текст'), 'text'),
                                    Text::make(__('Ссылка'), 'url'),
                                ])->creatable(limit: 2)->removable(),
                            ]),

                            Collapse::make(__('Статистика'), [
                                Json::make('', 'hero_stats')->fields([
                                    Text::make(__('Значение'), 'value'),
                                    Text::make(__('Подпись'), 'label'),
                                ])->creatable(limit: 4)->removable()
                                    ->hint('Иконки фиксированы и подставляются по порядку карточек'),
                            ]),
                        ])->icon('star'),

                        Tab::make(__('О компании'), [
                            Text::make(__('Заголовок'), 'company_title')->unescape(),

                            Textarea::make(__('Текст'), 'company_text'),

                            Collapse::make(__('Пункты с галочками'), [
                                Json::make('', 'company_checks')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Textarea::make(__('Текст'), 'text'),
                                ])->vertical()->creatable(limit: 3)->removable(),
                            ]),
                        ])->icon('building-office'),

                        Tab::make(__('Преимущества'), [
                            Text::make(__('Заголовок'), 'adv_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'adv_lead'),

                            Divider::make(__('Видео не редактируется — то же, что на главной (public/video/hottour.mp4)')),

                            Collapse::make(__('Карточки'), [
                                Json::make('', 'adv_cards')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Textarea::make(__('Текст'), 'text'),
                                ])->vertical()->creatable(limit: 6)->removable()
                                    ->hint('Иконки фиксированы и подставляются по порядку карточек'),
                            ]),
                        ])->icon('trophy'),

                        Tab::make(__('Приложение'), [
                            Text::make(__('Заголовок'), 'app_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'app_lead'),

                            Collapse::make(__('Возможности'), [
                                Json::make('', 'app_features')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Textarea::make(__('Текст'), 'text'),
                                ])->vertical()->creatable(limit: 4)->removable()
                                    ->hint('Иконки фиксированы; скриншоты телефонов — public/images/landing/about/4-1..4-4.png'),
                            ]),
                        ])->icon('device-phone-mobile'),

                        Tab::make(__('Онлайн-оформление'), [
                            Text::make(__('Заголовок'), 'online_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'online_lead'),

                            Collapse::make(__('Шаги'), [
                                Json::make('', 'online_steps')->fields([
                                    Text::make(__('Подпись'), 'label'),
                                ])->creatable(limit: 3)->removable()
                                    ->hint('Номер шага проставляется автоматически'),
                            ]),

                            Collapse::make(__('Карточки'), [
                                Json::make('', 'online_cards')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Textarea::make(__('Текст'), 'text'),
                                ])->vertical()->creatable(limit: 3)->removable(),
                            ]),
                        ])->icon('clipboard-document-check'),

                        Tab::make(__('Безопасность'), [
                            Text::make(__('Заголовок'), 'safety_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'safety_lead'),

                            Collapse::make(__('Карточки'), [
                                Json::make('', 'safety_cards')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Textarea::make(__('Текст'), 'text'),
                                ])->vertical()->creatable(limit: 4)->removable()
                                    ->hint('3d-картинки фиксированы и подставляются по порядку карточек'),
                            ]),
                        ])->icon('shield-check'),

                        Tab::make(__('Вопрос/Ответ'), [
                            // структура один в один с generalre: x-modules.faq
                            Collapse::make(__('Вопрос/Ответ'), [
                                Json::make('', 'faq')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Json::make(__('Опции'), 'options')->fields([
                                        Textarea::make(__('Вопрос'), 'question'),
                                        TinyMce::make(__('Ответ'), 'answer'),
                                    ])->vertical()->creatable(limit: 50)->removable(),
                                ])->vertical()->creatable(limit: 1)->removable(),
                            ]),
                        ])->icon('chat-bubble-left-right'),

                        Tab::make(__('Призыв к действию'), [
                            Text::make(__('Заголовок'), 'cta_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'cta_lead'),

                            Collapse::make(__('Кнопки'), [
                                Json::make('', 'cta_buttons')->fields([
                                    Text::make(__('Текст'), 'text'),
                                    Text::make(__('Ссылка'), 'url'),
                                ])->creatable(limit: 2)->removable()
                                    ->hint('Ссылка с # открывает модалку (например #pick_tour)'),
                            ]),

                            Divider::make(__('Телефон и ссылки мессенджеров приходят из «Настроек сайта» — здесь только подписи')),

                            Text::make(__('Подпись телефона'), 'cta_phone_label'),

                            Text::make(__('Подпись мессенджеров'), 'cta_social_label'),
                        ])->icon('phone'),

                        Tab::make(__('Метотеги'), [
                            Text::make(__('Мета тэг (title)'), 'metatitle')->unescape(),

                            Text::make(__('Мета тэг (description)'), 'description')->unescape(),

                            Text::make(__('Мета тэг (keywords)'), 'keywords')->unescape(),

                            Textarea::make(__('HTML-блок'), 'html')->unescape()
                                ->hint('Произвольный HTML, выводится в контенте страницы'),

                            Code::make(__('CSS страницы'), 'custom_css')->language('css')->unescape()
                                ->hint('Стили только для этой страницы, без обёртки style — только правила CSS'),
                        ])->icon('magnifying-glass'),
                    ]),
                ]),
            ])
            ->submit(label: __('Сохранить'), attributes: ['class' => 'btn-primary']);
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        yield $this->form();
    }
}
