<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contact\Pages;

use App\MoonShine\Resources\Contact\ContactResource;
use Leeto\MoonShineTree\View\Components\TreeComponent;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;

/**
 * v2: ContactResource::indexFields().
 *
 * @extends IndexPage<ContactResource>
 */
class ContactIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Город'), 'title')->unescape(),

            Text::make(__('Приписка'), 'label'),

            Text::make(__('Адрес'), 'address'),

            Switcher::make(__('Публикация'), 'published'),

            Switcher::make(__('Карта'), 'yandex_map'),

            Number::make(__('Сорт.'), 'sorting')->sortable(),
        ];
    }

    protected function modifyListComponent(ComponentContract $component): ComponentContract
    {
        return TreeComponent::make($this->getResource());
    }
}
