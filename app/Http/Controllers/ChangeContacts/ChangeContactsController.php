<?php

namespace App\Http\Controllers\ChangeContacts;

use App\ChangeContacts\ContactRotator;
use App\Http\Controllers\Controller;
use App\Models\ChangeStatistic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChangeContactsController extends Controller
{
    /**
     * Клик по средству связи на сайте: пишем нажатие в статистику и,
     * если канал работает в режиме 1, показываем следующий контакт.
     *
     * Раньше имя метода бралось прямо из запроса ($this->$type(...)),
     * поэтому любой POST с произвольным type отдавал 500.
     */
    public function canche_contacts(Request $request): JsonResponse
    {
        $channel = $request->input('type');
        $value = $request->input('object');

        if (!ContactRotator::isChannel($channel) || !is_string($value) || $value === '') {
            return response()->json(['error' => 'unknown type'], 422);
        }

        $this->statistic($channel, $value);

        ContactRotator::rotate($channel, ContactRotator::MODE_ON_CLICK, $value);

        return response()->json([
            'object' => 'ok',
        ]);
    }

    private function statistic(string $channel, string $value): void
    {
        ChangeStatistic::create([
            $channel => $value,
        ]);
    }
}
