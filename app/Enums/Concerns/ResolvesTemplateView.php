<?php

declare(strict_types=1);

namespace App\Enums\Concerns;

/**
 * Общий поиск blade-файла для enum'ов шаблонов.
 *
 * Шаблоны раздела лежат в resources/views/pages/{section}/templates/{kind}/{value}.blade.php,
 * где kind — что именно рисуем: item (детальная), list (список категории),
 * teaser (карточка записи в списке) и т.д.
 */
trait ResolvesTemplateView
{
    /**
     * Ищем шаблон по цепочке: свой у раздела → общий → default раздела → общий default.
     *
     * Последние два шага нужны, чтобы страница не падала, если в базе осталось
     * значение, для которого в этом разделе вёрстку ещё не сделали.
     */
    protected function resolveView(string $section, string $kind): string
    {
        $fallback = self::Default->value;

        $candidates = [
            "pages.{$section}.templates.{$kind}.{$this->value}",
            "pages.common.templates.{$kind}.{$this->value}",
            "pages.{$section}.templates.{$kind}.{$fallback}",
        ];

        foreach ($candidates as $view) {
            if (view()->exists($view)) {
                return $view;
            }
        }

        return "pages.common.templates.{$kind}.{$fallback}";
    }

    /**
     * Список для Select в MoonShine: ['default' => 'Стандартный', ...].
     *
     * @return array<string, string>
     */
    public static function toOptions(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    /**
     * То же для конкретного раздела, но без вариантов, вёрстки для которых там нет.
     * Нужно, чтобы в админке не висели пункты, которые ничего не меняют.
     *
     * @return array<string, string>
     */
    public static function toOptionsFor(string $section, string $kind): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $exists = $case === self::Default
                || view()->exists("pages.{$section}.templates.{$kind}.{$case->value}")
                || view()->exists("pages.common.templates.{$kind}.{$case->value}");

            if ($exists) {
                $options[$case->value] = $case->label();
            }
        }

        return $options;
    }

    /**
     * Значение из базы в enum. Пустое или неизвестное (шаблон убрали из кода,
     * а в записях он остался) отдаём как Default, а не роняем страницу.
     */
    public static function fromValue(mixed $value): self
    {
        return self::tryFrom((string) $value) ?? self::Default;
    }
}
