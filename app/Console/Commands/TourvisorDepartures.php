<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\Contact;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

/**
 * Сверка городов вылета со справочником Tourvisor.
 *
 * Показывает три вещи:
 *  1) живой справочник городов вылета API (list.php?type=departure) —
 *     именно он, а не какие-либо файлы в проекте, решает, какие города
 *     доступны; обновляется каждые list_ttl (6 часов);
 *  2) города сайта (модель Contact) — у кого нашёлся id, кто в справочнике
 *     отсутствует и потому в селект поиска не попадает;
 *  3) итоговый селект, как его увидит посетитель.
 *
 * --fresh сбрасывает кэш справочника и ходит в API напрямую — так можно
 * убедиться, что смотрим не на протухший снимок (локально под VPN сеть
 * до tourvisor.ru закрыта, там флаг не поможет).
 */
class TourvisorDepartures extends Command
{
    protected $signature = 'tourvisor:departures
                            {--fresh : сбросить кэш справочника и спросить API заново}';

    protected $description = 'Справочник городов вылета Tourvisor и сверка с городами сайта';

    public function handle(): int
    {
        if ($this->option('fresh')) {
            Cache::forget('tourvisor_list_' . md5(json_encode(['type' => 'departure'])));
            config(['tourvisor.mode' => 'live']);
            $this->line('Кэш справочника сброшен, запрос уходит в API напрямую.');
        }

        $api = new Tourvisor();
        $catalog = $api->departureCatalog();

        if ($catalog === []) {
            $this->error('Справочник не получен: API недоступен и кэша нет.');
            $this->line('Локально сеть до tourvisor.ru закрыта — запускать на сервере.');

            return self::FAILURE;
        }

        $this->info('Справочник Tourvisor (города вылета, доступные учётке):');
        foreach ($catalog as $d) {
            $this->line(sprintf('  %-5s %s', $d['id'], $d['name']));
        }

        $this->newLine();
        $this->info('Города сайта (Контакты, опубликованные):');
        $cities = Contact::query()
            ->where('published', 1)
            ->orderBy('sorting')
            ->orderBy('id')
            ->pluck('title');
        foreach ($cities as $title) {
            $match = Tourvisor::matchDeparture($catalog, (string) $title);
            $note = null;
            if ($match !== null) {
                $note = 'id ' . $match['id'];
                if (mb_strtolower($match['name']) !== mb_strtolower(trim((string) $title))) {
                    $note .= ' (по основе имени: ' . $match['name'] . ')';
                }
            }

            $this->line(sprintf(
                '  %-20s %s',
                $title,
                $note ?? 'НЕТ В СПРАВОЧНИКЕ — в селект поиска не попадает',
            ));
        }

        $this->newLine();
        $this->info('Итоговый селект «Город вылета»:');
        $list = $api->getDeparture();
        foreach (['popular' => 'Популярные', 'other' => 'Остальные'] as $key => $label) {
            $items = array_map(
                fn ($d) => $d['name'] . (! empty($d['default']) ? ' (по умолчанию)' : ''),
                $list[$key],
            );
            $this->line("  $label: " . ($items ? implode(', ', $items) : '(пусто)'));
        }

        return self::SUCCESS;
    }
}
