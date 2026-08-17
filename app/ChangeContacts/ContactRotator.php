<?php

declare(strict_types=1);

namespace App\ChangeContacts;

use App\Models\ChangeLoadContact;
use App\Models\ChangeSaveContact;

/**
 * Смена показываемого средства связи по кругу.
 *
 * Раньше эта логика была скопирована шесть раз: по методу на каждый канал
 * в ChangeContactsController и такие же три блока в ChangeContactsCron.
 *
 * Режимы (см. подсказку на странице настроек):
 *   1 — контакт меняется после клика по нему;
 *   2 — все контакты меняются раз в сутки кроном;
 *   3 — показывается выставленный контакт, ротации нет.
 */
final class ContactRotator
{
    /** Каналы, для которых работает ротация. Одновременно белый список для запросов с фронта. */
    public const CHANNELS = ['phone', 'whatsapp', 'telegram'];

    public const MODE_ON_CLICK = 1;
    public const MODE_DAILY = 2;

    /**
     * Ключ записи настроек.
     *
     * Раньше вычислялся из последнего сегмента HTTP_REFERER, из-за чего
     * при открытии страницы с query-параметром получался ключ вида
     * «change-contact-page?tab=1» и заводилась вторая запись настроек.
     */
    public const KEY = 'change-contact-page';

    public static function isChannel(?string $channel): bool
    {
        return $channel !== null && in_array($channel, self::CHANNELS, true);
    }

    public static function settings(): ?ChangeSaveContact
    {
        return ChangeSaveContact::query()->where('key', self::KEY)->first()
            ?? ChangeSaveContact::query()->first();
    }

    public static function state(): ?ChangeLoadContact
    {
        return ChangeLoadContact::query()->where('key', self::KEY)->first()
            ?? ChangeLoadContact::query()->first();
    }

    /**
     * Переключает канал на следующий контакт из списка.
     *
     * @param  string  $channel  phone|whatsapp|telegram
     * @param  int  $mode  режим, в котором ротация разрешена
     * @param  string|null  $current  контакт, по которому кликнули; null — берём текущий показываемый
     * @return bool сменился ли контакт
     */
    public static function rotate(string $channel, int $mode, ?string $current = null): bool
    {
        if (!self::isChannel($channel)) {
            return false;
        }

        $state = self::state();
        $settings = self::settings();

        // Настройки ещё ни разу не сохраняли — ротировать нечего
        if ($state === null || $settings === null) {
            return false;
        }

        if ((int) $state->{$channel . '_mode'} !== $mode) {
            return false;
        }

        $contacts = self::contacts($settings, $channel);

        if (count($contacts) < 2) {
            return false;
        }

        $current ??= $state->{$channel};

        $position = array_search($current, $contacts, true);

        // Показываемого контакта в списке нет (админ его удалил или изменил) —
        // начинаем список сначала, иначе канал залипнет навсегда
        $next = $position === false
            ? $contacts[0]
            : $contacts[($position + 1) % count($contacts)];

        if ($next === $state->{$channel}) {
            return false;
        }

        $state->{$channel} = $next;
        $state->save();

        return true;
    }

    /**
     * Плоский список контактов канала.
     *
     * MoonShine нумерует элементы Json-поля с единицы, поэтому ключи не
     * используем — берём только значения.
     *
     * @return list<string>
     */
    private static function contacts(ChangeSaveContact $settings, string $channel): array
    {
        $raw = $settings->{$channel};

        if ($raw === null) {
            return [];
        }

        $items = $raw instanceof \Illuminate\Support\Collection ? $raw->all() : (array) $raw;

        $result = [];

        foreach ($items as $item) {
            $value = is_array($item) ? ($item['p'] ?? null) : $item;

            if (is_string($value) && $value !== '') {
                $result[] = $value;
            }
        }

        return array_values($result);
    }
}
