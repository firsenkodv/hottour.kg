<?php

declare(strict_types=1);

namespace App\Enums\Resources;

use App\Enums\Concerns\ResolvesTemplateView;

/**
 * Шаблон детальной страницы материала (публикация, горящий тур, курорт, отель,
 * статическая страница и т.д.). Хранится в колонке `template` записи.
 *
 * Как добавить новый шаблон:
 *   1. новый case здесь + подпись в label();
 *   2. resources/views/pages/{раздел}/templates/item/{значение}.blade.php
 *      (или pages/common/templates/item/{значение}.blade.php — на все разделы сразу).
 * В админке он появится сам — Select строится из toOptions().
 */
enum ItemTemplate: string
{
    use ResolvesTemplateView;

    case Default = 'default';
    case Wide = 'wide';

    public function label(): string
    {
        return match ($this) {
            self::Default => 'Стандартный',
            self::Wide => 'Во всю ширину (без бокового меню)',
        };
    }

    /**
     * Прячет правую колонку с меню — контент занимает всю ширину.
     * Решение принимает шаблон, а не вёрстка вокруг него.
     */
    public function withoutSidebar(): bool
    {
        return $this === self::Wide;
    }

    /**
     * @param  string  $section  раздел в resources/views/pages (dumps, hottours, countries, tours, page)
     * @param  string  $kind  вид детальной: item — обычный материал, hotel — карточка отеля,
     *                        country — страница страны
     */
    public function view(string $section, string $kind = 'item'): string
    {
        return $this->resolveView($section, $kind);
    }
}
