<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Убирает разметку виджета из `script` у записей, где номер уже перенесён.
 *
 * Предыдущая миграция скопировала номер модуля в `tourvisor_module_id`, но
 * оставила исходную разметку на месте — чтобы ничего не сломать, пока шаблоны
 * не переключены. Теперь <x-tourvisor.script> выводит оба поля независимо
 * (заполнены оба — покажутся оба), и незачищенный `script` дал бы виджет дважды.
 *
 * Чистим осторожно, только при выполнении трёх условий:
 *   1) `tourvisor_module_id` заполнен;
 *   2) номер внутри разметки совпадает с ним — значит это та самая запись,
 *      а не другой виджет, случайно оказавшийся в поле;
 *   3) кроме разметки виджета в поле ничего нет.
 *
 * Всё остальное остаётся нетронутым: виджет круизов gocruise.ru на pages id=1
 * (у него нет номера модуля) и любые ручные вставки редакторов.
 *
 * Отдельно попадает под очистку hot_categories id=258 — та самая запись без
 * закрывающего </script>, из-за которой у страницы обрывался HTML. Номер у неё
 * совпадает, так что чинить её руками не требуется.
 */
return new class extends Migration
{
    private const TABLES = [
        'hot_categories', 'resorts', 'companies', 'excursions', 'publs',
        'dump2s', 'dumps', 'tours', 'pages', 'travelitems', 'infos',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'tourvisor_module_id')) {
                continue;
            }

            DB::table($table)
                ->whereNotNull('tourvisor_module_id')
                ->where('tourvisor_module_id', '<>', '')
                ->whereNotNull('script')
                ->where('script', '<>', '')
                ->select('id', 'tourvisor_module_id', 'script')
                ->orderBy('id')
                ->chunk(200, function ($rows) use ($table): void {
                    foreach ($rows as $row) {
                        if (! $this->isMigratedWidget((string) $row->script, (string) $row->tourvisor_module_id)) {
                            continue;
                        }

                        DB::table($table)->where('id', $row->id)->update(['script' => null]);
                    }
                });
        }
    }

    /**
     * Поле содержит только разметку виджета с тем же номером — и ничего больше.
     *
     * Хвост `<?` в конце шаблона допускает обрыв: у одной записи разметка
     * приехала обрезанной на середине закрывающего тега.
     */
    private function isMigratedWidget(string $script, string $module): bool
    {
        $pattern = '~^\s*<div class="tv-hot-tours tv-moduleid-'
            . preg_quote($module, '~')
            . '"></div>\s*<script[^>]*tourvisor\.ru/module/init\.js[^>]*>\s*(</script>)?\s*<?\s*$~i';

        return (bool) preg_match($pattern, $script);
    }

    /**
     * Возврата нет: восстановить разметку можно из `tourvisor_module_id`, но
     * делать это автоматически незачем — шаблон рисует её сам.
     */
    public function down(): void
    {
    }
};
