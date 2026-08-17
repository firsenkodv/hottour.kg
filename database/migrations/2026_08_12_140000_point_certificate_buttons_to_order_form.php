<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Кнопки «Получить сертификат» открывали общую форму подбора тура (#pick_tour).
 * Теперь у страницы своя форма заявки — #certificate_order, в неё передаётся
 * тип сертификата и выбранный номинал (html/temp_forms/certificate_order).
 *
 * Меняем ссылки только там, где осталось прежнее значение: если адрес
 * поменяли в админке вручную, миграция его не трогает.
 */
return new class extends Migration
{
    private const OLD = '#pick_tour';

    private const NEW = '#certificate_order';

    public function up(): void
    {
        $this->replace(self::OLD, self::NEW);
    }

    public function down(): void
    {
        $this->replace(self::NEW, self::OLD);
    }

    private function replace(string $from, string $to): void
    {
        $row = DB::table('settings')->where('group', 'certificates')->first();

        if ($row === null) {
            return;
        }

        $data = json_decode($row->data ?? '[]', true) ?: [];
        $changed = false;

        foreach (['person_btn_url', 'company_btn_url'] as $key) {
            if (($data[$key] ?? null) === $from) {
                $data[$key] = $to;
                $changed = true;
            }
        }

        if (! $changed) {
            return;
        }

        DB::table('settings')->where('id', $row->id)->update([
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'updated_at' => now(),
        ]);
    }
};
