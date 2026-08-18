<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Events\SystemMessageEvent;
use App\Http\Controllers\Tourvisor\Service\Tourvisor;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

/**
 * Наблюдатель за справочником городов вылета Tourvisor.
 *
 * Раз в сутки (Kernel, 05:00) сверяет живой справочник API с городами
 * сайта (модель Contact) и, если что-то изменилось, шлёт письмо админу
 * через SystemMessageEvent — тем же путём, что отчёты hottour:cron.
 *
 * Зачем: селект поиска подхватывает изменения справочника сам
 * (Tourvisor::getDeparture), но люди об этом никак не узнают. Типовой
 * сценарий — Tourvisor добавил вылеты из Оша: город появится на сайте
 * автоматически, а письмо скажет об этом явно. Обратное тоже важно:
 * если город из справочника пропал, селект молча похудеет.
 *
 * Прошлое состояние сверки хранится отдельной группой tourvisor_watch
 * в settings — НЕ в группе tourvisor: ту при каждом сохранении формы
 * «Настройки сайта» контроллер перезаписывает целиком, и состояние
 * наблюдателя затиралось бы.
 */
class TourvisorDeparturesWatch extends Command
{
    protected $signature = 'tourvisor:departures-watch
                            {--dry : показать изменения, ничего не сохраняя и не отправляя}';

    protected $description = 'Следит за появлением/пропажей городов сайта в справочнике Tourvisor';

    private const GROUP = 'tourvisor_watch';

    public function handle(): int
    {
        // сравнивать имеет смысл только свежий справочник
        Cache::forget('tourvisor_list_' . md5(json_encode(['type' => 'departure'])));

        $api = new Tourvisor();
        $catalog = $api->departureCatalog();

        if ($catalog === []) {
            // API недоступен — не считаем это «все города пропали»,
            // просто молчим до следующего запуска
            Log::warning('tourvisor:departures-watch — справочник не получен, сверка пропущена');
            $this->warn('Справочник не получен (нет сети/кэша), сверка пропущена.');

            return self::SUCCESS;
        }

        $current = [];
        $cities = Contact::query()
            ->where('published', 1)
            ->orderBy('sorting')
            ->orderBy('id')
            ->pluck('title');
        foreach ($cities as $title) {
            $title = trim((string) $title);
            if ($title === '' || isset($current[$title])) {
                continue;
            }
            $match = Tourvisor::matchDeparture($catalog, $title);
            $current[$title] = $match['id'] ?? null;
        }

        $setting = Setting::getGroup(self::GROUP);
        $previous = $setting->data['cities'] ?? null;

        $messages = [];
        if (\is_array($previous)) {
            foreach ($current as $title => $id) {
                $wasId = $previous[$title] ?? null;
                if ($id !== null && $wasId === null) {
                    $messages[] = "Город «{$title}» ПОЯВИЛСЯ в справочнике Tourvisor (id {$id}) — он уже виден в селекте «Город вылета» на сайте.";
                }
                if ($id === null && $wasId !== null) {
                    $messages[] = "Город «{$title}» ПРОПАЛ из справочника Tourvisor (был id {$wasId}) — из селекта «Город вылета» он исчез.";
                }
            }
            foreach ($previous as $title => $wasId) {
                if (! \array_key_exists($title, $current) && $wasId !== null) {
                    $messages[] = "Город «{$title}» снят с публикации в «Контактах» — из селекта «Город вылета» он исчез.";
                }
            }
        }

        foreach ($current as $title => $id) {
            $this->line(sprintf('  %-20s %s', $title, $id !== null ? "id $id" : 'нет в справочнике'));
        }

        if ($this->option('dry')) {
            $this->info($messages
                ? "Изменения (письмо НЕ отправлено, --dry):\n  " . implode("\n  ", $messages)
                : 'Изменений нет.');

            return self::SUCCESS;
        }

        $setting->data = ['cities' => $current];
        $setting->save();

        if ($messages !== []) {
            foreach ($messages as $m) {
                Log::info('tourvisor:departures-watch — ' . $m);
            }
            SystemMessageEvent::dispatch([
                'commands' => 'tourvisor:departures-watch',
                'file_commands' => 'TourvisorDeparturesWatch.php',
                'body' => $messages,
            ]);
            $this->info('Изменения найдены, письмо отправлено: ' . \count($messages) . ' шт.');
        } else {
            $this->info($previous === null
                ? 'Первый запуск: состояние сохранено, сверка начнётся со следующего раза.'
                : 'Изменений нет.');
        }

        return self::SUCCESS;
    }
}
