<?php

declare(strict_types=1);

namespace App\Tourvisor;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Throwable;

/**
 * Доступы и параметры Tourvisor из админки.
 *
 * Хранятся группой `tourvisor` в таблице settings — тем же способом, что и
 * доступы к Битрикс24 (см. App\Bitrix24\Bitrix24::GROUP). Редактируются
 * вкладкой «Турвизор» на странице «Настройки сайта».
 *
 * Значения из админки накладываются поверх config/tourvisor.php в
 * AppServiceProvider::boot(), поэтому весь остальной код продолжает читать
 * обычный config('tourvisor.*') и о существовании этого класса не знает.
 *
 * Переменные TOURVISOR_* в .env остаются запасным вариантом: они работают,
 * пока соответствующее поле в админке пустое. Так новое окружение поднимается
 * до того, как кто-то откроет админку, а на боевом можно временно вернуть
 * доступы через .env, если база недоступна.
 */
final class TourvisorSettings
{
    public const GROUP = 'tourvisor';

    private const CACHE_KEY = 'settings.tourvisor';

    /**
     * Поле в админке => ключ в config/tourvisor.php.
     */
    private const MAP = [
        'tv_login' => 'login',
        'tv_password' => 'password',
        'tv_url' => 'url',
        'tv_mode' => 'mode',
        'tv_list_ttl' => 'list_ttl',
        'tv_timeout' => 'timeout',
        'tv_module_search' => 'module_search',
        'tv_module_findtour' => 'module_findtour',
    ];

    /**
     * Поля, которые могли быть записаны в зашифрованном виде более ранней
     * версией этого класса. Читаются через reveal(), при первом сохранении
     * формы перезаписываются открытым текстом.
     */
    private const LEGACY_ENCRYPTED = ['tv_password'];

    /**
     * Поля, где пустое значение — это осознанный выбор администратора,
     * а не «взять из конфига».
     *
     * Для доступов пустота означает откат на .env, и это правильно.
     * Для номеров модулей такой откат делал поле неочищаемым: стираешь
     * номер, сохраняешь — и на его место возвращается значение из
     * config/tourvisor.php. Здесь пусто значит пусто: виджет просто
     * не выводится, пока номер не задан.
     */
    private const EXPLICIT_EMPTY = ['tv_module_search', 'tv_module_findtour'];

    /**
     * Сырые значения группы. Читается на каждый запрос, поэтому кэшируется;
     * кэш сбрасывается при сохранении формы — forget().
     *
     * @return array<string, mixed>
     */
    public static function values(): array
    {
        return Cache::rememberForever(
            self::CACHE_KEY,
            static fn (): array => Setting::query()
                ->where('group', self::GROUP)
                ->first()?->data ?? []
        );
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * ПОПУЛЯРНЫЕ города вылета: блок «Города вылета» вкладки «Турвизор».
     *
     * Запись: id (код в справочнике Tourvisor), name, namefrom («из ...»).
     * Порядок записей = порядок в верхней группе селекта; город по
     * умолчанию — первый. Остальные города в селект попадают автоматически
     * из модели Contact (города сайта) — см. Tourvisor::getDeparture().
     *
     * Источники по убыванию приоритета:
     *  1) список, сохранённый в админке;
     *  2) страновой конфиг config/tourvisor/departures.php — заготовка,
     *     на каждом сайте своя (Киргизия — Бишкек, Казахстан — Алматы
     *     и Астана). Каталог config/tourvisor закрыт в .gitignore,
     *     поэтому на новом окружении файл создаётся руками —
     *     см. docs/cloning.md, п. 6а.
     *
     * Прежний третий фолбэк — departure.json — удалён на всех сайтах:
     * он содержал казахстанский список и только маскировал бы забытый
     * страновой конфиг.
     *
     * @return list<array<string, mixed>>
     */
    public static function departures(): array
    {
        try {
            $list = self::values()['tv_departures'] ?? null;
        } catch (Throwable) {
            // база недоступна (миграции, config:cache) — работаем от конфига
            $list = null;
        }

        if (\is_array($list) && $list !== []) {
            return array_values($list);
        }

        $config = config('tourvisor.departures');
        if (\is_array($config) && $config !== []) {
            return array_values($config);
        }

        return [];
    }

    /**
     * Накладывает настройки из админки на config('tourvisor.*').
     *
     * Пустые значения пропускаются — иначе незаполненное поле затирало бы
     * .env и дефолты из config/tourvisor.php. Исключение — поля из
     * EXPLICIT_EMPTY: там пустота задаётся администратором осознанно
     * и должна доезжать до сайта как есть.
     */
    public static function apply(): void
    {
        try {
            $values = self::values();
        } catch (Throwable) {
            // база может быть недоступна: миграции на пустом окружении,
            // config:cache в деплое, упавший mysql. Молча остаёмся на .env
            return;
        }

        $overrides = [];

        foreach (self::MAP as $field => $key) {
            // поле сохраняли из формы — уважаем даже пустое значение
            if (\in_array($field, self::EXPLICIT_EMPTY, true) && \array_key_exists($field, $values)) {
                $overrides["tourvisor.$key"] = trim((string) $values[$field]);

                continue;
            }

            $value = self::reveal($field, $values[$field] ?? null);

            if ($value === null || $value === '') {
                continue;
            }

            $overrides["tourvisor.$key"] = $value;
        }

        if ($overrides !== []) {
            config($overrides);
        }
    }

    /**
     * Значение поля в пригодном для показа виде.
     *
     * Хранится всё открытым текстом — пароль в админке видно, как и вебхук
     * Битрикс24. Более ранняя версия шифровала пароль, поэтому такие записи
     * ещё могут встретиться: их расшифровываем на чтении, а при первом
     * сохранении формы они перезапишутся открытым текстом.
     */
    public static function reveal(string $field, mixed $value): ?string
    {
        if (! \is_string($value) || $value === '') {
            return null;
        }

        if (! \in_array($field, self::LEGACY_ENCRYPTED, true)) {
            return $value;
        }

        try {
            return Crypt::decryptString($value);
        } catch (Throwable) {
            // обычный пароль, а не шифротекст — так и отдаём
            return $value;
        }
    }
}
