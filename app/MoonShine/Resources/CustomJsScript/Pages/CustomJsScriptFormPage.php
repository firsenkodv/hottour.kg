<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CustomJsScript\Pages;

use App\MoonShine\Resources\CustomJsScript\CustomJsScriptResource;
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
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;

/**
 * v2: CustomJsScriptResource::formFields().
 *
 * @extends FormPage<CustomJsScriptResource>
 */
class CustomJsScriptFormPage extends FormPage
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
                                Collapse::make(__('Заголовок'), [
                                    Text::make(__('Заголовок'), 'title')->required(),
                                ]),

                                Collapse::make(__('Скрипт'), [
                                    Textarea::make('', 'js')->hint('JS скрипт'),
                                ]),
                            ])->columnSpan(6),

                            Column::make([
                                Collapse::make(__('Публикация'), [
                                    Switcher::make(__('Публикация'), 'published')->default(1),
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
