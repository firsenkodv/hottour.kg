<?php

use App\Console\Commands\KgContentCities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Перевод текстов материалов на киргизские города и страну:
 * Алматы -> Бишкек, Астана -> Ош, Казахстан -> Кыргызстан,
 * hottour.kz -> hottour.kg.
 *
 * Обёртка над командой `content:kg-cities` — вся логика замены живёт там
 * (app/Console/Commands/KgContentCities.php), миграция нужна только чтобы
 * изменение доехало до боевого сервера обычным `php artisan migrate`.
 *
 * Почему это безопасно на проде, где контент правили руками: команда несёт
 * ПРАВИЛО замены, а не готовый текст. Она ищет вхождения в тех строках,
 * которые лежат в базе, где её запустили, и меняет только сами упоминания
 * городов и страны. Локальные версии материалов на прод не переносятся.
 *
 * Материалы О Казахстане (статьи о стране, казахстанские курорты и
 * экскурсии, раздел «Казахстан») в замену не входят — список EXCLUDED_ROWS
 * в команде, задан по id. Перед выпуском миграции id сверены с боевой
 * базой: все 32 записи совпали по заголовкам.
 *
 * Идемпотентна: повторный запуск ничего не находит. Отчёт о заменах
 * команда пишет в temp/kg-cities-report.txt.
 *
 * down() пустой: восстановить прежние тексты нечем — правило замены
 * необратимо (в «Бишкеке» уже не видно, был ли там «Алматы»).
 * Откат — только из дампа базы.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! class_exists(KgContentCities::class)) {
            // команда едет тем же деплоем; если её нет — деплой неполный,
            // и молча «пропустить» миграцию хуже, чем упасть
            throw new RuntimeException(
                'Не найдена команда content:kg-cities (app/Console/Commands/KgContentCities.php). '
                . 'Выкатите код целиком и повторите миграцию.'
            );
        }

        $before = $this->countRemaining();

        Artisan::call('content:kg-cities', ['--apply' => true]);

        $after = $this->countRemaining();

        $message = sprintf(
            'kg-content-cities: упоминаний Алматы/Астаны/Казахстана в заголовках было %d, стало %d',
            $before,
            $after
        );

        Log::info($message);
        echo "  $message\n";
    }

    public function down(): void
    {
        // необратимо, см. комментарий выше
    }

    /**
     * Грубый индикатор для лога: сколько заголовков материалов ещё
     * упоминают прежнюю страну. Точный отчёт — в temp/kg-cities-report.txt.
     */
    private function countRemaining(): int
    {
        $total = 0;

        foreach (['infos', 'hot_categories', 'travelitems', 'resorts', 'publs'] as $table) {
            $total += DB::table($table)
                ->where('title', 'like', '%Алмат%')
                ->orWhere('title', 'like', '%Астан%')
                ->orWhere('title', 'like', '%азахстан%')
                ->count();
        }

        return $total;
    }
};
