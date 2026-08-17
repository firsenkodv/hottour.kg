<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Enums\Pages\ListTemplate;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * Страница «Сертификаты» (/sertifikaty) — устроена как AboutPage:
 * своей модели нет, содержимое лежит группой `certificates` в таблице settings.
 *
 * Читается на фронте через
 * Domain\Certificate\ViewModels\CertificateViewModel::getPageData().
 *
 * Вёрстка страницы пока пустая: шаблон «Сертификаты»
 * (App\Enums\Pages\ListTemplate::Certificates) содержит только заголовочный блок.
 */
#[Icon('check-badge')]
#[Group('Категории', 'folder')]
#[Order(0)]
class CertificatesPage extends Page
{
    public const GROUP = 'certificates';

    /** Раздел вёрстки: resources/views/pages/certificates/templates/{kind}/{шаблон}.blade.php */
    public const SECTION = 'certificates';

    /** Json-блоки, у карточек которых есть загружаемая картинка */
    private const IMAGE_CARDS = ['person_cards', 'company_cards'];

    /** Папка загрузки на диске moonshine */
    private const IMAGE_DIR = 'certificates';

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
        return $this->title ?: 'Сертификаты';
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
        $data = $request->except(['_token', '_method', 'method', '_component_name']);

        $setting->data = $this->applyCardImages($data, $request, $setting->data ?? []);
        $setting->save();

        return JsonResponse::make()->toast(__('Сохранено'), ToastType::SUCCESS);
    }

    /**
     * Картинки карточек «Кому дарят».
     *
     * Страница не ресурсная: данные пишутся в settings руками, поэтому поле
     * Image само файл не сохраняет — заливку и подстановку пути делаем здесь.
     *
     * Форма шлёт по картинке два поля: img — сам file-input (приходит, только
     * когда выбрали новый файл) и hidden_img — текущий путь. Кнопка удаления
     * в MoonShine вырезает из DOM весь блок картинки вместе с hidden_img
     * (`closest('.x-removeable').remove()`), поэтому отсутствие hidden_img —
     * это и есть «картинку удалили». Сам hidden_img в settings не сохраняем.
     *
     * Файлы, переставшие использоваться (заменили картинку или удалили),
     * подчищаются с диска.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed> $old
     *
     * @return array<string, mixed>
     */
    private function applyCardImages(array $data, Request $request, array $old): array
    {
        foreach (self::IMAGE_CARDS as $key) {
            if (! isset($data[$key]) || ! is_array($data[$key])) {
                continue;
            }

            foreach ($data[$key] as $index => $card) {
                $card = is_array($card) ? $card : [];

                unset($data[$key][$index]['hidden_img']);

                $file = $request->file("$key.$index.img");

                if ($file !== null) {
                    $data[$key][$index]['img'] = $file->store(
                        self::IMAGE_DIR,
                        config('moonshine.disk', 'moonshine')
                    );

                    continue;
                }

                $current = $card['hidden_img'] ?? null;

                $data[$key][$index]['img'] = is_string($current) && $current !== '' ? $current : null;
            }
        }

        $this->deleteUnusedImages($data, $old);

        return $data;
    }

    /**
     * Удаляет с диска картинки, которых не осталось в настройках после сохранения.
     *
     * @param array<string, mixed> $data
     * @param array<string, mixed> $old
     */
    private function deleteUnusedImages(array $data, array $old): void
    {
        $paths = function (array $source): array {
            $result = [];

            foreach (self::IMAGE_CARDS as $key) {
                foreach ($source[$key] ?? [] as $card) {
                    if (is_array($card) && ! empty($card['img'])) {
                        $result[] = $card['img'];
                    }
                }
            }

            return $result;
        };

        $unused = array_diff($paths($old), $paths($data));

        if ($unused === []) {
            return;
        }

        $disk = Storage::disk(config('moonshine.disk', 'moonshine'));

        foreach ($unused as $path) {
            // на всякий случай не трогаем файлы вне своей папки
            if (str_starts_with((string) $path, self::IMAGE_DIR . '/') && $disk->exists($path)) {
                $disk->delete($path);
            }
        }
    }

    private function form(): FormBuilder
    {
        return FormBuilder::make()
            ->asyncMethod('store')
            ->fill($this->getSetting()->data ?? [])
            ->fields([
                Box::make([
                    Tabs::make([
                        Tab::make(__('Общие настройки'), [
                            Grid::make([
                                Column::make([
                                    Box::make([
                                        Text::make(__('Заголовок'), 'title')
                                            ->unescape()
                                            ->hint('Запасной вариант метатега title; h1 задаётся в табе «Первый экран»'),

                                        Divider::make(__('Описание раздела')),

                                        TinyMce::make(__('Описание раздела'), 'desc')
                                            ->hint('Выводится последним блоком страницы, свёрнутым до первого абзаца («Читать далее»)'),
                                    ]),
                                ])->columnSpan(8),

                                Column::make([
                                    Collapse::make(__('Шаблон вывода'), [
                                        Select::make(__('Шаблон страницы'), 'list_template')
                                            ->options(ListTemplate::toOptionsFor(self::SECTION, 'list'))
                                            ->default(ListTemplate::Certificates->value)
                                            ->hint('Вёрстка: resources/views/pages/certificates/templates/list/'),
                                    ]),
                                ])->columnSpan(4),
                            ]),
                        ])->icon('document-text'),

                        Tab::make(__('Первый экран'), [
                            Text::make(__('Заголовок'), 'hero_title')
                                ->unescape()
                                ->hint('h1 страницы; перенос строки — html-тегом br'),

                            Textarea::make(__('Подзаголовок'), 'hero_lead'),
                        ])->icon('star'),

                        Tab::make(__('Физическим лицам'), [
                            Text::make(__('Подпись вкладки'), 'person_switch'),

                            Text::make(__('Заголовок'), 'person_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'person_lead')
                                ->hint('Перенос строки сохраняется'),

                            Collapse::make(__('Кому дарят'), [
                                Json::make('', 'person_cards')->fields([
                                    Text::make(__('Подпись'), 'label'),

                                    Image::make(__('Изображение'), 'img')
                                        ->disk(config('moonshine.disk', 'moonshine'))
                                        ->dir(self::IMAGE_DIR)
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),
                                ])->vertical()->creatable(limit: 6)->removable(),
                            ]),

                            Collapse::make(__('Номиналы'), [
                                Json::make('', 'person_sums')->fields([
                                    Text::make(__('Сумма'), 'value'),
                                ])->creatable(limit: 6)->removable()
                                    ->hint('Пишется целиком, вместе с валютой: 10 000 ₸'),
                            ]),

                            Text::make(__('Подпись поля своей суммы'), 'person_custom_label')
                                ->hint('Поле под номиналами, куда посетитель вписывает произвольную сумму'),

                            Divider::make(),

                            Text::make(__('Текст кнопки'), 'person_btn'),

                            Text::make(__('Ссылка кнопки'), 'person_btn_url')
                                ->hint('Ссылка с # открывает модалку (например #pick_tour)'),
                        ])->icon('user'),

                        Tab::make(__('Юридическим лицам'), [
                            Text::make(__('Подпись вкладки'), 'company_switch'),

                            Text::make(__('Заголовок'), 'company_title')->unescape(),

                            Textarea::make(__('Подзаголовок'), 'company_lead'),

                            Collapse::make(__('Кому дарят'), [
                                Json::make('', 'company_cards')->fields([
                                    Text::make(__('Подпись'), 'label'),

                                    Image::make(__('Изображение'), 'img')
                                        ->disk(config('moonshine.disk', 'moonshine'))
                                        ->dir(self::IMAGE_DIR)
                                        ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif', 'svg', 'webp'])
                                        ->removable(),
                                ])->vertical()->creatable(limit: 6)->removable(),
                            ]),

                            Collapse::make(__('Номиналы'), [
                                Json::make('', 'company_sums')->fields([
                                    Text::make(__('Сумма'), 'value'),
                                ])->creatable(limit: 6)->removable(),
                            ]),

                            Text::make(__('Подпись поля своей суммы'), 'company_custom_label')
                                ->hint('Поле под номиналами, куда посетитель вписывает произвольную сумму'),

                            Divider::make(),

                            Text::make(__('Текст кнопки'), 'company_btn'),

                            Text::make(__('Ссылка кнопки'), 'company_btn_url'),
                        ])->icon('building-office'),

                        Tab::make(__('Как это работает'), [
                            Text::make(__('Заголовок'), 'how_title')->unescape(),

                            Collapse::make(__('Шаги'), [
                                Json::make('', 'how_steps')->fields([
                                    Text::make(__('Заголовок'), 'title'),
                                    Textarea::make(__('Текст'), 'text'),
                                ])->vertical()->creatable(limit: 4)->removable()
                                    ->hint('Номер шага проставляется автоматически'),
                            ]),
                        ])->icon('clipboard-document-check'),

                        Tab::make(__('Поводы'), [
                            Text::make(__('Заголовок'), 'reasons_title')->unescape(),

                            Collapse::make(__('Карточки'), [
                                Json::make('', 'reasons_cards')->fields([
                                    Text::make(__('Подпись'), 'label'),
                                ])->creatable(limit: 4)->removable()
                                    ->hint('Фотографии фиксированы и подставляются по порядку карточек'),
                            ]),
                        ])->icon('gift'),

                        Tab::make(__('Вопрос/Ответ'), [
                            // структура один в один с лендингом «О нас»: x-modules.faq
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

                        Tab::make(__('Свяжитесь с нами'), [
                            Text::make(__('Заголовок'), 'contacts_title')->unescape(),

                            Divider::make(__('Телефон и ссылки мессенджеров приходят из «Настроек сайта» — здесь только подписи')),

                            Text::make(__('Подпись телефона'), 'contacts_phone_label'),

                            Text::make(__('Подпись мессенджеров'), 'contacts_social_label'),
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
