<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\ChangeContacts\ContactRotator;
use App\Http\Controllers\Controller;
use App\Models\ChangeLoadContact;
use App\Models\ChangeSaveContact;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class MoonshineChangeContactController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $key = ContactRotator::KEY;

        ChangeSaveContact::query()->updateOrCreate(
            ['key' => $key],
            [
                'key' => $key,

                'phone' => $request->input('phone'),
                'whatsapp' => $request->input('whatsapp'),
                'telegram' => $request->input('telegram'),

                'phone_mode' => $request->input('phone_mode'),
                'whatsapp_mode' => $request->input('whatsapp_mode'),
                'telegram_mode' => $request->input('telegram_mode'),

                'phone_published' => $this->isPublished($request, 'phone') ? 1 : 0,
                'whatsapp_published' => $this->isPublished($request, 'whatsapp') ? 1 : 0,
                'telegram_published' => $this->isPublished($request, 'telegram') ? 1 : 0,
            ]
        );

        ChangeLoadContact::query()->updateOrCreate(
            ['key' => $key],
            [
                'key' => $key,

                // Показ всегда начинается с первого контакта списка
                'phone' => $this->firstContact($request, 'phone'),
                'whatsapp' => $this->firstContact($request, 'whatsapp'),
                'telegram' => $this->firstContact($request, 'telegram'),

                'phone_mode' => $request->input('phone_mode'),
                'whatsapp_mode' => $request->input('whatsapp_mode'),
                'telegram_mode' => $request->input('telegram_mode'),
            ]
        );

        return back();
    }

    /**
     * Первый контакт канала или null, если публикация выключена либо
     * список пуст. Раньше здесь был current() по массиву из запроса,
     * и пустой список ронял сохранение с TypeError — причём уже после
     * записи в change_save_contacts, то есть таблицы расходились.
     */
    private function firstContact(Request $request, string $channel): ?string
    {
        if (!$this->isPublished($request, $channel)) {
            return null;
        }

        $items = $request->input($channel);

        if (!is_array($items) || $items === []) {
            return null;
        }

        foreach ($items as $item) {
            $value = is_array($item) ? ($item['p'] ?? null) : $item;

            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return null;
    }

    /**
     * Switcher при выключении может не прислать поле вовсе — как и раньше,
     * считаем такой канал опубликованным.
     */
    private function isPublished(Request $request, string $channel): bool
    {
        return (bool) $request->input($channel . '_published', 1);
    }
}
