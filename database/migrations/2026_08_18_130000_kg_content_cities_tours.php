<?php

use App\Console\Commands\KgContentCities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Догоняющая замена: таблицы `tours` и `customer_hot_tours`.
 *
 * В первой версии команды `content:kg-cities` эти две таблицы были
 * исключены целиком — из-за колонок `city` и `cityname`, где лежит город
 * ВЫЛЕТА (механика поиска, а не текст). Вместе с ними под исключение
 * попал и обычный контент этих таблиц: subtitle, smalltext, metatitle,
 * description, keywords у `tours` и title/subtitle у `customer_hot_tours`.
 * Из-за этого страницы вида /tours/na-maldivy остались с «из Алматы
 * и Астаны».
 *
 * Теперь таблицы включены в обработку, а `city` и `cityname` вынесены
 * в EXCLUDED_COLUMNS — на уровне колонок, а не таблиц.
 *
 * Миграция просто вызывает команду ещё раз: она идемпотентна, уже
 * заменённые тексты не трогает, поэтому повторный прогон затронет
 * только эти две таблицы.
 *
 * ВАЖНО про несогласованность, которая появится до п. 6а из
 * docs/cloning.md: `customer_hot_tours.subtitle` станет «Вылет из
 * Бишкека», тогда как `city` = 60 (Алматы) и `cityname` = «Алматы».
 * Подпись опередит данные. Выровняется, когда появится своя учётка
 * Tourvisor и город вылета будет переведён на Бишкек (id 80).
 *
 * down() пустой: замена необратима, откат — только из дампа.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! class_exists(KgContentCities::class)) {
            throw new RuntimeException(
                'Не найдена команда content:kg-cities. Выкатите код целиком и повторите миграцию.'
            );
        }

        $before = $this->countRemaining();

        Artisan::call('content:kg-cities', ['--apply' => true]);

        $after = $this->countRemaining();

        $message = sprintf(
            'kg-content-cities (tours): упоминаний в tours/customer_hot_tours было %d, стало %d',
            $before,
            $after
        );

        Log::info($message);
        echo "  $message\n";
    }

    public function down(): void
    {
        // необратимо
    }

    private function countRemaining(): int
    {
        $total = 0;

        foreach (['tours' => ['subtitle', 'metatitle', 'description', 'keywords', 'smalltext'],
                  'customer_hot_tours' => ['title', 'subtitle']] as $table => $columns) {
            foreach ($columns as $column) {
                $total += DB::table($table)
                    ->where($column, 'like', '%Алмат%')
                    ->orWhere($column, 'like', '%Астан%')
                    ->orWhere($column, 'like', '%азахстан%')
                    ->count();
            }
        }

        return $total;
    }
};
