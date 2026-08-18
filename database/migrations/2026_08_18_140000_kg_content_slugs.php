<?php

use App\Console\Commands\KgContentCities;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Адреса страниц (slug) на киргизские: almaty -> bishkek, astana -> osh,
 * kazahstan -> kyrgyzstan. Например /hottour/almaty -> /hottour/bishkek.
 *
 * Раньше слаги были в исключениях команды `content:kg-cities`: на живом
 * сайте менять URL нельзя — рвутся внешние ссылки и поисковый индекс.
 * Для клона на новую страну это неактуально: домен новый, старые адреса
 * нигде не проиндексированы, внешних ссылок на них нет. Проверено, что
 * и внутри текстов ссылок на старые адреса не осталось (0 совпадений).
 *
 * Материалы О Казахстане свои адреса сохраняют — тот же список
 * EXCLUDED_ROWS, что и для текстов: /hottour/kazakhstan, статьи о стране,
 * казахстанские экскурсии и курорты.
 *
 * Уникальность адресов команда проверяет до записи: если замена дала бы
 * две записи с одинаковым slug, она отказывается работать и печатает
 * конфликты — одна из страниц иначе стала бы недоступной.
 *
 * down() пустой: обратно адреса не восстановить, откат — из дампа.
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

        $code = Artisan::call('content:kg-cities', ['--apply' => true]);

        if ($code !== 0) {
            // команда вернула ошибку — почти наверняка конфликт адресов
            throw new RuntimeException(
                "Команда content:kg-cities завершилась с кодом $code. "
                . 'Запустите её вручную без --apply и посмотрите вывод: '
                . Artisan::output()
            );
        }

        $after = $this->countRemaining();

        $message = sprintf('kg-content-slugs: адресов со старыми городами было %d, стало %d', $before, $after);

        Log::info($message);
        echo "  $message\n";
    }

    public function down(): void
    {
        // необратимо
    }

    private function countRemaining(): int
    {
        $excluded = [
            'infos' => [288, 297, 298, 299, 300, 301, 302],
            'excursions' => [142, 143, 144, 145, 146, 147],
            'resorts' => [61, 62, 63, 64, 65, 66, 67, 68, 69],
            'travelitems' => [104, 105, 111],
            'hot_categories' => [16, 36, 37, 158, 160, 161],
        ];

        $total = 0;

        foreach (['travelcategories', 'travelitems', 'hot_categories', 'infos', 'excursions', 'publs', 'resorts'] as $table) {
            $query = DB::table($table)->where(function ($q) {
                foreach (['almaty', 'astana', 'astany', 'kazakhstan', 'kazahstan'] as $needle) {
                    $q->orWhere('slug', 'like', "%$needle%");
                }
            });

            if (isset($excluded[$table])) {
                $query->whereNotIn('id', $excluded[$table]);
            }

            $total += $query->count();
        }

        return $total;
    }
};
