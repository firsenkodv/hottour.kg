<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Replacement\Pages;

use App\MoonShine\Resources\Replacement\ReplacementResource;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Laravel\Pages\Crud\IndexPage;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;

/**
 * v2: ReplacementResource::fields().
 *
 * @extends IndexPage<ReplacementResource>
 */
class ReplacementIndexPage extends IndexPage
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make()->sortable(),

            Text::make(__('Что меняем'), 'old_text'),

            Text::make(__('На что меняем'), 'new_text'),
        ];
    }
}
