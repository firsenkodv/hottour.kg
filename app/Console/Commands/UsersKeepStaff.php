<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Чистка базы пользователей при клонировании сайта на новую страну.
 *
 * Оставляет только сотрудников, удаляет клиентскую базу предыдущей страны.
 * Кого считаем сотрудником:
 *   - админы            user_role_id = 2 (роль Admin);
 *   - менеджеры         user_role_id = 1 (роль Manager);
 *   - руководители ОП   senior IS NOT NULL (РОП, ср. App\Exports\RopExport).
 *
 * Условие «есть роль ИЛИ senior» намеренно шире каждого из признаков:
 * РОП в базе помечен и ролью Manager, и полем senior, но если где-то
 * заполнено только одно из двух — человек всё равно уцелеет.
 *
 * Без флага — только отчёт. С `--apply` — удаляет. Идемпотентна:
 * повторный запуск ничего не находит.
 *
 * ВАЖНО про каскады. У `users` есть самоссылки `user_id` (закреплённый
 * менеджер) и `senior_id` — обе с ON DELETE CASCADE. Если сотрудник
 * закреплён за удаляемым пользователем, база снесёт и сотрудника.
 * Команда проверяет это ДО удаления и отказывается работать, если
 * найдёт такую связь.
 *
 * Что уедет вместе с пользователями по внешним ключам (ON DELETE CASCADE):
 * payments, surveys, user_carts, user_certificates, user_connections,
 * user_favorites, user_next_tours, user_promos, user_surveys.
 * У contracts стоит ON DELETE SET NULL — договоры останутся без владельца.
 * Осиротевшие sessions и password_reset_tokens (внешних ключей нет)
 * подчищаются отдельно.
 */
class UsersKeepStaff extends Command
{
    protected $signature = 'users:keep-staff
                            {--apply : выполнить удаление (без флага — только отчёт)}
                            {--force : не спрашивать подтверждение}';

    protected $description = 'Оставить только админов, РОП и менеджеров, удалив клиентскую базу';

    public function handle(): int
    {
        $apply = (bool) $this->option('apply');

        $keep = User::query()
            ->whereNotNull('user_role_id')
            ->orWhereNotNull('senior')
            ->pluck('id')
            ->all();

        if ($keep === []) {
            $this->error('Не найдено ни одного сотрудника — удалять всех подряд команда не станет.');

            return self::FAILURE;
        }

        $total = User::query()->count();
        $toDelete = $total - \count($keep);

        $this->info("Всего пользователей: $total");
        $this->info('Остаются сотрудники (' . \count($keep) . '):');
        foreach (User::query()->whereIn('id', $keep)->orderBy('id')->get() as $u) {
            $this->line(sprintf(
                '  id=%-5d %-12s %-30s %s',
                $u->id,
                $this->role($u),
                mb_substr((string) $u->name, 0, 30),
                $u->email,
            ));
        }
        $this->warn("Под удаление попадает: $toDelete");

        if ($toDelete === 0) {
            $this->info('Удалять нечего.');

            return self::SUCCESS;
        }

        // Самоссылки с CASCADE: сотрудник, закреплённый за удаляемым,
        // будет снесён базой заодно. Проверяем до, а не после.
        $unsafe = User::query()
            ->whereIn('id', $keep)
            ->where(function ($q) use ($keep) {
                $q->where(fn ($w) => $w->whereNotNull('user_id')->whereNotIn('user_id', $keep))
                    ->orWhere(fn ($w) => $w->whereNotNull('senior_id')->whereNotIn('senior_id', $keep));
            })
            ->get(['id', 'name', 'user_id', 'senior_id']);

        if ($unsafe->isNotEmpty()) {
            $this->error('ОПАСНО: сотрудники закреплены за удаляемыми пользователями,');
            $this->error('каскад ON DELETE снесёт их вместе с клиентами:');
            foreach ($unsafe as $u) {
                $this->line("  id={$u->id} {$u->name} (user_id={$u->user_id}, senior_id={$u->senior_id})");
            }
            $this->error('Переназначьте им закреплённого менеджера и запустите снова.');

            return self::FAILURE;
        }

        $this->newLine();
        $this->info('Уедет по связям:');
        foreach ($this->relatedCounts($keep) as $table => $count) {
            $this->line(sprintf('  %-22s %d', $table, $count));
        }

        if (! $apply) {
            $this->newLine();
            $this->info('Это отчёт. Для удаления запустите с --apply.');

            return self::SUCCESS;
        }

        if (! $this->option('force') && ! $this->confirm("Удалить $toDelete пользователей? Действие необратимо", false)) {
            $this->info('Отменено.');

            return self::SUCCESS;
        }

        $deleted = 0;
        DB::transaction(function () use ($keep, &$deleted) {
            // чанками: 2686 строк с каскадами по девяти таблицам —
            // одним запросом это долгая блокировка
            do {
                $chunk = User::query()->whereNotIn('id', $keep)->limit(200)->pluck('id')->all();
                if ($chunk === []) {
                    break;
                }
                $deleted += DB::table('users')->whereIn('id', $chunk)->delete();
            } while (true);

            // внешних ключей у этих таблиц нет — чистим руками
            $emails = User::query()->pluck('email')->all();
            DB::table('password_reset_tokens')->whereNotIn('email', $emails)->delete();
            DB::table('sessions')->whereNotNull('user_id')->whereNotIn('user_id', $keep)->delete();
        });

        $this->newLine();
        $this->info("Удалено пользователей: $deleted");
        $this->info('Осталось: ' . User::query()->count());

        return self::SUCCESS;
    }

    private function role(User $user): string
    {
        $parts = [];
        if ((int) $user->user_role_id === 2) {
            $parts[] = 'админ';
        }
        if ((int) $user->user_role_id === 1) {
            $parts[] = 'менеджер';
        }
        if ($user->senior !== null) {
            $parts[] = 'РОП';
        }

        return implode('+', $parts) ?: '?';
    }

    /**
     * @param  list<int>  $keep
     * @return array<string, int>
     */
    private function relatedCounts(array $keep): array
    {
        $out = [];
        $tables = [
            'payments', 'surveys', 'user_carts', 'user_certificates',
            'user_connections', 'user_favorites', 'user_next_tours',
            'user_promos', 'user_surveys',
        ];

        foreach ($tables as $table) {
            $n = DB::table($table)->whereNotNull('user_id')->whereNotIn('user_id', $keep)->count();
            if ($n > 0) {
                $out[$table] = $n;
            }
        }

        $n = DB::table('sessions')->whereNotNull('user_id')->whereNotIn('user_id', $keep)->count();
        if ($n > 0) {
            $out['sessions'] = $n;
        }

        return $out;
    }
}
