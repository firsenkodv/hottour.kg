<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Перевод раздела «Контакты» (/kontakty) с казахстанских городов на киргизские.
 *
 * Сайт клонирован с hottour.kz, поэтому в таблице contacts лежат 11 городов
 * Казахстана. Оставляем четыре крупнейших города Кыргызстана.
 *
 * Телефоны, e-mail, skype и label НЕ трогаем — по договорённости они пока
 * остаются теми же: каждый киргизский город наследует набор средств связи
 * от соответствующей по порядку казахстанской записи (id 1..4 сохраняются,
 * чтобы не поехали ссылки и сортировка в админке).
 *
 * Адрес обнуляется: физические адреса в Алматы/Астане под названием «Бишкек»
 * были бы прямой дезинформацией. Шаблон в этом случае показывает строку
 * «Город: {название}» (resources/views/pages/contacts.blade.php).
 *
 * Лишние казахстанские записи снимаются с публикации, а не удаляются —
 * удаление на проде необратимо, а снятая с публикации запись не попадает
 * на сайт (ContactQueryBuilder::get_contacts фильтрует по published)
 * и остаётся видна в админке.
 *
 * Миграция идемпотентна: повторный запуск только обновит координаты
 * и сортировку уже существующих киргизских городов.
 */
return new class extends Migration
{
    /**
     * Координаты — для меток и панорамирования Яндекс.Карты на странице
     * контактов, формат строки «широта, долгота» как в остальных записях.
     *
     * @var list<array{title: string, yandex_map: string, sorting: int}>
     */
    private const CITIES = [
        ['title' => 'Бишкек', 'yandex_map' => '42.874621, 74.569762', 'sorting' => 10],
        ['title' => 'Ош', 'yandex_map' => '40.528325, 72.798320', 'sorting' => 20],
        ['title' => 'Джалал-Абад', 'yandex_map' => '40.933333, 72.983333', 'sorting' => 30],
        ['title' => 'Каракол', 'yandex_map' => '42.490779, 78.393604', 'sorting' => 40],
    ];

    public function up(): void
    {
        $titles = array_column(self::CITIES, 'title');

        // Записи-доноры: всё, что ещё не переименовано в киргизский город.
        // Порядок тот же, что на сайте, — первым идёт главный офис.
        $donors = DB::table('contacts')
            ->whereNotIn('title', $titles)
            ->orderBy('sorting')
            ->orderBy('id')
            ->pluck('id')
            ->all();

        foreach (self::CITIES as $city) {
            $existing = DB::table('contacts')->where('title', $city['title'])->first();

            if ($existing !== null) {
                DB::table('contacts')->where('id', $existing->id)->update([
                    'yandex_map' => $city['yandex_map'],
                    'sorting' => $city['sorting'],
                    'published' => '1',
                    'updated_at' => now(),
                ]);

                continue;
            }

            $donorId = array_shift($donors);

            if ($donorId !== null) {
                DB::table('contacts')->where('id', $donorId)->update([
                    'title' => $city['title'],
                    'address' => null,
                    'yandex_map' => $city['yandex_map'],
                    'sorting' => $city['sorting'],
                    'published' => '1',
                    'updated_at' => now(),
                ]);

                continue;
            }

            // Донор не нашёлся (на проде записей меньше четырёх) — создаём
            // город с нуля, средства связи копируем с первого города списка.
            $source = DB::table('contacts')->where('title', $titles[0])->first();

            DB::table('contacts')->insert([
                'title' => $city['title'],
                'label' => 'Только он-лайн',
                'address' => null,
                'email' => $source->email ?? null,
                'skype' => $source->skype ?? null,
                'yandex_map' => $city['yandex_map'],
                'data_phone' => $source->data_phone ?? null,
                'data_email' => $source->data_email ?? null,
                'published' => '1',
                'sorting' => $city['sorting'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::table('contacts')
            ->whereNotIn('title', $titles)
            ->update([
                'published' => '0',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        // Откат не предусмотрен: исходные названия и адреса казахстанских
        // городов восстановить неоткуда, а содержимое могло быть отредактировано
        // в админке после накатывания миграции.
    }
};
