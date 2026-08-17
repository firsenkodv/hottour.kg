<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Блок «Вопрос/Ответ» на странице «Сертификаты» — та же структура, что в
 * лендинге «О нас» (компонент x-modules.faq, поле faq в settings).
 *
 * Заливаем стартовые вопросы, только если блок ещё не заполнен в админке.
 */
return new class extends Migration
{
    public function up(): void
    {
        $row = DB::table('settings')->where('group', 'certificates')->first();

        if ($row === null) {
            return;
        }

        $data = json_decode($row->data ?? '[]', true) ?: [];

        if (! empty($data['faq'])) {
            return;
        }

        $data['faq'] = json_decode(self::FAQ, associative: true, flags: JSON_THROW_ON_ERROR);

        DB::table('settings')->where('id', $row->id)->update([
            'data' => json_encode($data, JSON_UNESCAPED_UNICODE),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        // Вопросы могли быть отредактированы в админке — откат их не удаляет
    }

    private const FAQ = <<<'JSON'
{
    "1": {
        "title": "Часто задаваемые вопросы",
        "options": {
            "1": {
                "question": "Как получить сертификат после оплаты?",
                "answer": "<p>Сертификат приходит на указанную электронную почту в течение 5 минут после оплаты. Его можно распечатать или отправить получателю в электронном виде.</p>"
            },
            "2": {
                "question": "Сколько действует сертификат?",
                "answer": "<p>Стандартный срок действия — 12 месяцев с даты покупки. Точные условия менеджер подтвердит при оформлении.</p>"
            },
            "3": {
                "question": "Можно ли выбрать произвольную сумму?",
                "answer": "<p>Да. Помимо готовых номиналов сертификат можно оформить на любую сумму — укажите её менеджеру при оформлении заявки.</p>"
            },
            "4": {
                "question": "Что если тур дороже номинала сертификата?",
                "answer": "<p>Разницу можно доплатить любым удобным способом при бронировании тура.</p>"
            },
            "5": {
                "question": "Как оформить сертификаты для компании?",
                "answer": "<p>Юридическим лицам мы оформляем сертификаты по договору с полным пакетом закрывающих документов. Оставьте заявку — менеджер подготовит документы.</p>"
            }
        }
    }
}
JSON;
};
