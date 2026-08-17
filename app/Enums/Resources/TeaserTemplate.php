<?php

declare(strict_types=1);

namespace App\Enums\Resources;

use App\Enums\Concerns\ResolvesTemplateView;

/**
 * Вид карточки материала в списке категории. Задаётся у категории
 * (колонка `teaser_template`) и действует на все её записи.
 *
 * Заменил собой булев переключатель `temp` («Шаблон с изображением»)
 * у разделов «Полезное» и «О нас».
 */
enum TeaserTemplate: string
{
    use ResolvesTemplateView;

    case Default = 'default';
    case Img = 'img';

    /**
     * «Стандартный» намеренно без уточнений: в каждом разделе это свой
     * исторически сложившийся вид карточки (в «Полезном» — список,
     * в «Горящих турах» — плитка).
     */
    public function label(): string
    {
        return match ($this) {
            self::Default => 'Стандартный',
            self::Img => 'Плитка с изображениями',
        };
    }

    public function view(string $section, string $kind = 'teaser'): string
    {
        return $this->resolveView($section, $kind);
    }
}
