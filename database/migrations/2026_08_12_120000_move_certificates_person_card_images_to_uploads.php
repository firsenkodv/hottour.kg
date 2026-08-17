<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Картинки карточек «Кому дарят» стали загружаемыми через админку
 * (App\MoonShine\Pages\CertificatesPage), а раньше подставлялись в шаблоне
 * по порядковому номеру из public/images/landing/certificates.
 *
 * Миграция переносит те же иконки в загрузки (диск moonshine, папка
 * certificates) и прописывает пути в settings, чтобы после перехода
 * страница не осталась без картинок. Уже заполненные img не трогаются.
 */
return new class extends Migration
{
    private const DISK = 'moonshine';

    private const DIR = 'certificates';

    public function up(): void
    {
        $row = DB::table('settings')->where('group', 'certificates')->first();

        if ($row === null) {
            return;
        }

        $data = json_decode($row->data ?? '[]', true) ?: [];

        if (empty($data['person_cards']) || ! is_array($data['person_cards'])) {
            return;
        }

        $changed = false;
        $number = 0;

        foreach ($data['person_cards'] as $index => $card) {
            $number++;

            if (! empty($card['img'])) {
                continue;
            }

            $source = public_path("images/landing/certificates/3-icon{$number}.png");

            if (! is_file($source)) {
                continue;
            }

            $path = self::DIR . "/cert-person-{$number}.png";

            Storage::disk(self::DISK)->put($path, file_get_contents($source));

            $data['person_cards'][$index]['img'] = $path;
            $changed = true;
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
        // Картинки могли быть заменены в админке — откат их не удаляет
    }
};
