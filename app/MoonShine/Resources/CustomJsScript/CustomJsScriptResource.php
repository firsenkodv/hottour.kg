<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\CustomJsScript;

use App\Models\CustomJsScript;
use App\MoonShine\Resources\CustomJsScript\Pages\CustomJsScriptFormPage;
use App\MoonShine\Resources\CustomJsScript\Pages\CustomJsScriptIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<CustomJsScript>
 */
#[Icon('code-bracket-square')]
#[Group('Служебные', 'wrench-screwdriver')]
#[Order(6)]
class CustomJsScriptResource extends TreeResource
{
    protected string $model = CustomJsScript::class;

    protected string $title = 'Скрипты JS';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CustomJsScriptIndexPage::class,
            CustomJsScriptFormPage::class,
        ];
    }

    protected function activeActions(): ListOf
    {
        return parent::activeActions()->except(Action::VIEW);
    }

    protected function search(): array
    {
        return ['id', 'title'];
    }

    public function treeKey(): ?string
    {
        return null;
    }

    public function sortKey(): string
    {
        return 'sorting';
    }
}
