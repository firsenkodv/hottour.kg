<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Заполнение страницы «Сертификаты» (/admin/page/certificates-page) дефолтами —
 * тексты перенесены из хардкода шаблона
 * (resources/views/pages/certificates/templates/list/certificates.blade.php).
 *
 * Проверка смысловая, как в миграции раздела «О нас»: группа считается
 * заполненной, только если после рекурсивного отсева null/пустых строк/пустых
 * массивов остаётся хоть одно значение (list_template не в счёт — его
 * проставляет сама форма). Реально введённый в админке контент не перезаписывается.
 */
return new class extends Migration
{
    public function up(): void
    {
        $defaults = json_decode(self::DEFAULTS, associative: true, flags: JSON_THROW_ON_ERROR);

        $row = DB::table('settings')->where('group', 'certificates')->first();

        if ($row !== null && $this->hasMeaningfulData(json_decode($row->data ?? '[]', true) ?: [])) {
            return;
        }

        if ($row === null) {
            DB::table('settings')->insert([
                'group' => 'certificates',
                'data' => json_encode($defaults, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
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

    /**
     * @param array<mixed> $data
     */
    private function hasMeaningfulData(array $data): bool
    {
        unset($data['list_template']);

        return $this->clean($data) !== null;
    }

    /** Убирает null, пустые строки и пустые массивы на любой глубине */
    private function clean(mixed $value): mixed
    {
        if (is_array($value)) {
            $value = array_filter(
                array_map(fn ($v) => $this->clean($v), $value),
                fn ($v) => $v !== null
            );

            return $value === [] ? null : $value;
        }

        if (is_string($value) && trim($value) === '') {
            return null;
        }

        return $value;
    }

    private const DEFAULTS = <<<'JSON'
{
    "title": "Сертификаты",
    "desc": "<p>Подарочный сертификат HOT TOUR — это возможность подарить близким не вещь, а впечатление. Получатель сам выбирает направление, отель и даты вылета: сертификат действует на любой тур с нашего сайта.</p>\r\n<p>Сертификат можно оформить на любую сумму — как из предложенных номиналов, так и произвольную. После оплаты он приходит на электронную почту в течение пяти минут, поэтому подарок можно оформить даже в день праздника.</p>\r\n<p>Юридическим лицам мы оформляем сертификаты по договору с полным пакетом закрывающих документов — это удобный вариант для корпоративных подарков сотрудникам и партнёрам.</p>",
    "list_template": "certificates",
    "hero_title": "Подарочные сертификаты",
    "hero_lead": "Подарите мечту о путешествии! Сертификаты на любую сумму для физических и юридических лиц",
    "person_switch": "Физическим лицам",
    "person_title": "Сертификаты для физических лиц",
    "person_lead": "Подарите своим близким возможность выбрать отдых мечты.\r\nНаш подарочный сертификат - это универсальный подарок на любой праздник!",
    "person_cards": {
        "1": {
            "label": "Для родителей"
        },
        "2": {
            "label": "Для вашей половинки"
        },
        "3": {
            "label": "Для друзей"
        }
    },
    "person_sums": {
        "1": {
            "value": "10 000 ₸"
        },
        "2": {
            "value": "20 000 ₸"
        },
        "3": {
            "value": "50 000 ₸"
        },
        "4": {
            "value": "100 000 ₸"
        }
    },
    "person_btn": "Получить сертификат",
    "person_btn_url": "#pick_tour",
    "company_switch": "Юридическим лицам",
    "company_title": "Сертификаты для юридических лиц",
    "company_lead": "Поощряйте сотрудников и партнёров впечатлениями.\r\nОформляем сертификаты по договору с полным пакетом документов.",
    "company_sums": {
        "1": {
            "value": "50 000 ₸"
        },
        "2": {
            "value": "100 000 ₸"
        },
        "3": {
            "value": "200 000 ₸"
        },
        "4": {
            "value": "500 000 ₸"
        }
    },
    "company_btn": "Получить сертификат",
    "company_btn_url": "#pick_tour",
    "how_title": "Как это работает",
    "how_steps": {
        "1": {
            "title": "Выберите номинал",
            "text": "Укажите сумму сертификата или выберите из предложенных"
        },
        "2": {
            "title": "Оплатите онлайн",
            "text": "Безопасная оплата картой через защищённое соединение"
        },
        "3": {
            "title": "Получите сертификат",
            "text": "Сертификат придёт на email в течение 5 минут"
        },
        "4": {
            "title": "Дарите и путешествуйте",
            "text": "Используйте сертификат для любых туров на сайте"
        }
    },
    "reasons_title": "Поводы на которые чаще дарят путешествие",
    "reasons_cards": {
        "1": {
            "label": "Новый год"
        },
        "2": {
            "label": "Свадьба"
        },
        "3": {
            "label": "Годовщина"
        },
        "4": {
            "label": "14 февраля"
        }
    },
    "contacts_title": "Или свяжитесь с нами напрямую",
    "contacts_phone_label": "Связь с нами в один клик, звоните.",
    "contacts_social_label": "свяжитесь с нами в мессенджерах",
    "metatitle": null,
    "description": null,
    "keywords": null
}
JSON;
};
