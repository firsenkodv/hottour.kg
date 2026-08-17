<?php

declare(strict_types=1);

namespace App\Enums\Pages;

use App\Enums\Concerns\ResolvesTemplateView;

/**
 * Шаблон страницы категории — то, во что обёрнут список её материалов.
 * Хранится в колонке `list_template` категории.
 *
 * Тем же enum выбирается вёрстка заглавных страниц разделов, у которых
 * своей модели нет: там значение лежит в settings рядом с остальными
 * настройками страницы (см. App\MoonShine\Pages\AboutPage).
 *
 * За вид самих карточек в списке отвечает отдельный
 * \App\Enums\Resources\TeaserTemplate.
 */
enum ListTemplate: string
{
    use ResolvesTemplateView;

    case Default = 'default';
    case Wide = 'wide';
    case Landing = 'landing';
    case Certificates = 'certificates';

    public function label(): string
    {
        return match ($this) {
            self::Default => 'Стандартный',
            self::Wide => 'Во всю ширину (без бокового меню)',
            self::Landing => 'Лендинг (своя вёрстка, без обёртки страницы)',
            self::Certificates => 'Сертификаты',
        };
    }

    public function withoutSidebar(): bool
    {
        return $this === self::Wide || $this === self::Landing || $this === self::Certificates;
    }

    /**
     * Список для категорий. Шаблоны заглавных страниц разделов сюда не входят:
     * у категорий такой вёрстки нет. На страницах разделов список берётся
     * через toOptionsFor() — там они есть.
     *
     * @return array<string, string>
     */
    public static function toOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            if ($case->onlyForSectionPage()) {
                continue;
            }

            $options[$case->value] = $case->label();
        }

        return $options;
    }

    /**
     * Шаблон заглавной страницы раздела, а не категории.
     */
    private function onlyForSectionPage(): bool
    {
        return $this === self::Landing || $this === self::Certificates;
    }

    /**
     * Лендинг рисует страницу целиком сам: стандартная обёртка
     * (серый фон, колонки page_site) ему только мешает. То же и у
     * «Сертификатов» — там своя посекционная вёрстка во всю ширину.
     */
    public function withoutPageWrapper(): bool
    {
        return $this === self::Landing || $this === self::Certificates;
    }

    public function view(string $section, string $kind = 'list'): string
    {
        return $this->resolveView($section, $kind);
    }
}
