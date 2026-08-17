<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\Resources\ItemTemplate;

/**
 * Материал, у которого можно выбрать шаблон детальной страницы (колонка `template`).
 *
 * Namespace-cast сюда намеренно не ставим: в базе лежит обычная строка,
 * а enum отдаёт метод. Так MoonShine работает с полем как со строкой,
 * а старые записи с пустым значением не роняют сайт.
 */
trait HasItemTemplate
{
    public function itemTemplate(): ItemTemplate
    {
        return ItemTemplate::fromValue($this->getAttribute('template'));
    }
}
