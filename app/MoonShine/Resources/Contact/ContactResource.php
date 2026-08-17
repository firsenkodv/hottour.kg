<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Contact;

use App\Models\Contact;
use App\MoonShine\Resources\Contact\Pages\ContactFormPage;
use App\MoonShine\Resources\Contact\Pages\ContactIndexPage;
use Leeto\MoonShineTree\Resources\TreeResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\MenuManager\Attributes\Group;
use MoonShine\MenuManager\Attributes\Order;
use MoonShine\Support\Attributes\Icon;
use MoonShine\Support\Enums\Action;
use MoonShine\Support\ListOf;

/**
 * @extends TreeResource<Contact>
 */
#[Icon('map-pin')]
#[Group('Материалы', 'document-duplicate')]
#[Order(8)]
class ContactResource extends TreeResource
{
    protected string $model = Contact::class;

    protected string $title = 'Контактная информация';

    protected string $column = 'title';

    protected string $sortColumn = 'sorting';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            ContactIndexPage::class,
            ContactFormPage::class,
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
