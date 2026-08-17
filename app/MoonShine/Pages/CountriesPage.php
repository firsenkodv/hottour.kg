<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Setting;
use Illuminate\Http\Request;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Ace\Fields\Code;
use MoonShine\Crud\JsonResponse;
use MoonShine\Laravel\Pages\Page;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\AsyncMethod;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\ToastType;
use MoonShine\TinyMce\Fields\TinyMce;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Divider;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Components\Tabs;
use MoonShine\UI\Components\Tabs\Tab;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * Страница со списком стран (/strany) своей модели не имеет:
 * её содержимое лежит группой `countries` в таблице settings.
 *
 * Читается на фронте через Domain\Country\ViewModels\CountryViewModel::getPageData().
 */
#[Icon('globe-alt')]
#[Group('Категории', 'folder')]
#[Order(1)]
class CountriesPage extends Page
{
    public const GROUP = 'countries';

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
        return $this->title ?: 'Категории стран';
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
                        Tab::make(__('Общие настройки'), [
                            Grid::make([
                                Column::make([
                                    Box::make([
                                        Text::make(__('Заголовок'), 'title')
                                            ->unescape()
                                            ->hint('Выводится как h1 на странице /strany'),

                                        Divider::make(__('Категория страны')),

                                        TinyMce::make(__('Категория страны'), 'desc')
                                            ->hint('Описание категории под списком стран'),
                                    ]),
                                ])->columnSpan(12),
                            ]),
                        ])->icon('document-text'),

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
