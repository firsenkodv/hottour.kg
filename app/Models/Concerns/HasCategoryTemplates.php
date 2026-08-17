<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\Pages\ListTemplate;
use App\Enums\Resources\TeaserTemplate;

/**
 * Категория: свой шаблон страницы со списком (`list_template`)
 * и вид карточек её материалов (`teaser_template`).
 */
trait HasCategoryTemplates
{
    public function listTemplate(): ListTemplate
    {
        return ListTemplate::fromValue($this->getAttribute('list_template'));
    }

    public function teaserTemplate(): TeaserTemplate
    {
        return TeaserTemplate::fromValue($this->getAttribute('teaser_template'));
    }
}
