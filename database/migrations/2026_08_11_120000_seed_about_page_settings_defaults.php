<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Дефолтное содержимое страницы «О нас» (админка: /admin/page/about-page,
 * App\MoonShine\Pages\AboutPage) — тексты лендинга, перенесённые из хардкода.
 *
 * Значения сняты с локальной базы (settings, group=about) и лежат в
 * database/data/about-page-defaults.json. Заполняем только пустую группу:
 * если на проде в админке уже что-то сохранили — не трогаем.
 */
return new class extends Migration
{
    public function up(): void
    {
        $defaults = json_decode(
            file_get_contents(database_path('data/about-page-defaults.json')),
            associative: true,
            flags: JSON_THROW_ON_ERROR
        );

        $row = DB::table('settings')->where('group', 'about')->first();

        if ($row === null) {
            DB::table('settings')->insert([
                'group' => 'about',
                'data' => json_encode($defaults, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return;
        }

        // Setting::getGroup создаёт пустую группу при первом открытии админки —
        // такую строку считаем незаполненной и дозаполняем
        if (empty(json_decode($row->data ?? '[]', true))) {
            DB::table('settings')->where('id', $row->id)->update([
                'data' => json_encode($defaults, JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Содержимое могло быть отредактировано в админке — откат не удаляет его
    }
};
