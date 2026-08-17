<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Replacement;

use App\Models\Replacement;
use App\MoonShine\Resources\Replacement\Pages\ReplacementFormPage;
use App\MoonShine\Resources\Replacement\Pages\ReplacementIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\SkipMenu;

/**
 * Хранилище пар «что меняем / на что меняем» для массовой замены текста.
 * Сама операция замены запускается со страницы «Замены» (ReplacementPage),
 * которая переносится отдельно.
 *
 * В меню v2 выводилась страница, а не этот ресурс — сохраняем поведение.
 *
 * @extends ModelResource<Replacement, ReplacementIndexPage, ReplacementFormPage>
 */
#[SkipMenu]
class ReplacementResource extends ModelResource
{
    protected string $model = Replacement::class;

    protected string $title = 'Замены';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ReplacementIndexPage::class,
            ReplacementFormPage::class,
        ];
    }
}
