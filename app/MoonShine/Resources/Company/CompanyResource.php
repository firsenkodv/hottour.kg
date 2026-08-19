<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Company;

use App\Models\Company;
use App\MoonShine\Resources\Company\Pages\CompanyFormPage;
use App\MoonShine\Resources\Company\Pages\CompanyIndexPage;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends ModelResource<Company, CompanyIndexPage, CompanyFormPage>
 */
#[Icon('newspaper')]
#[Group('Материалы', 'document-duplicate')]
#[Order(6)]
class CompanyResource extends ModelResource
{
    protected string $model = Company::class;

    /**
     * Скрытые через showWhen поля всё равно отправляются на сервер.
     *
     * Иначе выключенный тумблер «Скрипт» затирал бы при сохранении и номер
     * модуля, и сам скрипт: MoonShine убирает у скрытого поля атрибут name.
     */
    protected bool $submitShowWhen = true;

    protected string $title = 'Отзывы, О нас';

    protected string $sortColumn = 'created_at';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            CompanyIndexPage::class,
            CompanyFormPage::class,
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
}
