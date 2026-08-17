<?php

declare(strict_types=1);

namespace App\MoonShine\Fields;

use Carbon\Carbon;
use MoonShine\UI\Fields\Field;

/**
 * Статистика нажатий по средствам связи за период.
 *
 * v2: App\MoonShine\Fields\StatisticWeek.
 * Публичные свойства и цепочка _request()/_amount() заменены на приватные
 * массивы и один проход в device_statistics() — снаружи использовался
 * только device_statistics($model, $days), поведение сохранено.
 */
class StatisticWeek extends Field
{
    protected string $view = 'admin.fields.statistic-week';

    /** @var array<string, list<array<string, mixed>>> */
    private array $items = [
        'phone' => [],
        'whatsapp' => [],
        'telegram' => [],
    ];

    /** @var array<string, array<string, int>> */
    private array $counts = [
        'phone' => [],
        'whatsapp' => [],
        'telegram' => [],
    ];

    /**
     * @param  class-string  $model
     */
    public function device_statistics(string $model, ?int $days = null): static
    {
        $date = Carbon::now()->subDays($days ?? 7);

        foreach (array_keys($this->items) as $field) {
            $rows = app($model)->query()
                ->whereNotNull($field)
                ->where('created_at', '>=', $date)
                ->orderBy('created_at', 'desc')
                ->get()
                ->toArray();

            $this->items[$field] = $rows;
            $this->counts[$field] = array_count_values(array_column($rows, $field));
        }

        return $this;
    }

    protected function viewData(): array
    {
        return [
            'phone' => $this->items['phone'],
            'phone_result' => $this->counts['phone'],
            'whatsapp' => $this->items['whatsapp'],
            'whatsapp_result' => $this->counts['whatsapp'],
            'telegram' => $this->items['telegram'],
            'telegram_result' => $this->counts['telegram'],
        ];
    }
}
