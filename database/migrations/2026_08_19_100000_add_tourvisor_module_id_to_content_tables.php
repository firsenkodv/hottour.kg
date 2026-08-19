<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Номер модуля Tourvisor отдельным полем.
 *
 * Раньше редактор вставлял в поле `script` целиком кусок разметки виджета:
 *
 *     <div class="tv-hot-tours tv-moduleid-998028"></div>
 *     <script type="text/javascript" src="//tourvisor.ru/module/init.js"></script>
 *
 * Из 86 заполненных полей 85 отличались только числом внутри. Одна копия
 * приехала без закрывающего </script> — и браузер посчитал содержимым скрипта
 * всё, что шло дальше: подвал, подключение jQuery и весь зависящий от него JS.
 * Страница обрывалась на середине, хотя сервер отдавал корректный HTML.
 *
 * Теперь разметку рисует <x-tourvisor.script>, а в базе хранится только номер.
 * Строкой, а не числом: номера бывают разной длины (998028, 9942960, 9975938),
 * и в них могут появиться буквы.
 *
 * Поле `script` остаётся и продолжает работать — в нём живёт виджет круизов
 * gocruise.ru на странице pages id=1, который под схему «только номер» не ложится.
 */
return new class extends Migration
{
    /**
     * Все таблицы с полем `script`: безопасная альтернатива нужна везде,
     * где можно вставить разметку руками, а не только там, где это уже сделали.
     */
    private const TABLES = [
        'hot_categories', 'resorts', 'companies', 'excursions', 'publs',
        'dump2s', 'dumps', 'tours', 'pages', 'travelitems', 'infos',
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'tourvisor_module_id')) {
                continue;
            }

            Schema::table($table, function (Blueprint $t): void {
                $t->string('tourvisor_module_id', 50)->nullable()->after('script');
            });

            $this->fill($table);
        }
    }

    /**
     * Переносит номер из существующей разметки: `tv-moduleid-998028` => `998028`.
     *
     * Само поле `script` не трогаем — старые записи продолжают работать как
     * работали, пока их не откроют в админке и не переключат на новое поле.
     */
    private function fill(string $table): void
    {
        DB::table($table)
            ->whereNotNull('script')
            ->where('script', '<>', '')
            ->select('id', 'script')
            ->orderBy('id')
            ->chunk(200, function ($rows) use ($table): void {
                foreach ($rows as $row) {
                    if (! preg_match('~tv-moduleid-([0-9a-z]+)~i', (string) $row->script, $m)) {
                        continue;
                    }

                    DB::table($table)->where('id', $row->id)->update([
                        'tourvisor_module_id' => $m[1],
                    ]);
                }
            });
    }

    public function down(): void
    {
        foreach (self::TABLES as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tourvisor_module_id')) {
                Schema::table($table, function (Blueprint $t): void {
                    $t->dropColumn('tourvisor_module_id');
                });
            }
        }
    }
};
