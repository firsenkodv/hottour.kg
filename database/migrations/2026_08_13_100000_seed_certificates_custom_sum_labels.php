<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Под номиналами сертификата появилось поле произвольной суммы
 * (pages/certificates/templates/list/certificates.blade.php).
 *
 * Заливаем подписи по умолчанию для обеих вкладок — заполненные в админке
 * значения не трогаем.
 */
return new class extends Migration
{
    private const LABELS = [
        'person_custom_label' => 'Укажите сумму',
        'company_custom_label' => 'Укажите сумму',
    ];

    public function up(): void
    {
        $row = DB::table('settings')->where('group', 'certificates')->first();

        if ($row === null) {
            return;
        }

        $data = json_decode($row->data ?? '[]', true) ?: [];
        $changed = false;

        foreach (self::LABELS as $key => $value) {
            if (empty($data[$key])) {
                $data[$key] = $value;
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

    public function down(): void
    {
        // Подписи могли быть отредактированы в админке — откат их не удаляет
    }
};
