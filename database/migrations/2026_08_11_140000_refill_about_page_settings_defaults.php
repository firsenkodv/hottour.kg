<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Повторное заполнение страницы «О нас» (/admin/page/about-page) дефолтами.
 *
 * Первая миграция (2026_08_11_120000) пропускала группу, если строка в
 * settings уже существовала с непустым data. На проде так и вышло: форму
 * в админке уже открывали и сохраняли пустой, поэтому data содержала все
 * ключи со значениями null — и дефолты не залились.
 *
 * Здесь проверка смысловая: группа считается заполненной, только если после
 * рекурсивного отсева null/пустых строк/пустых массивов остаётся хоть одно
 * значение (list_template не в счёт — его проставляет сама форма). Реально
 * введённый в админке контент миграция не перезапишет. JSON зашит в файл,
 * чтобы не зависеть от database/data на сервере.
 */
return new class extends Migration
{
    public function up(): void
    {
        $defaults = json_decode(self::DEFAULTS, associative: true, flags: JSON_THROW_ON_ERROR);

        $row = DB::table('settings')->where('group', 'about')->first();

        if ($row !== null && $this->hasMeaningfulData(json_decode($row->data ?? '[]', true) ?: [])) {
            return;
        }

        if ($row === null) {
            DB::table('settings')->insert([
                'group' => 'about',
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
    "title": "О нас -  раздел",
    "desc": "<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto magni obcaecati quos similique tempora. Aliquid autem beatae dolore dolorem eos, esse eum eveniet expedita ipsa iure odio perferendis provident quaerat quam ratione sequi unde vel? Ad ea explicabo hic impedit ipsam nobis nulla, unde! Animi, aspernatur at cumque debitis eaque facere labore nesciunt nostrum optio praesentium quas quis sed sequi soluta sunt, temporibus ullam voluptatem, voluptatibus? Aut ipsum itaque nobis officia velit.</p>\r\n<p>Adipisci commodi deserunt facere ipsa, ipsum labore laudantium maiores modi molestiae nesciunt nihil obcaecati perferendis quia ratione rerum sit tenetur unde veniam vitae, voluptatum? Accusantium, commodi enim iste nemo officia veniam. Aut dolor dolore eaque earum inventore ipsam, magni molestias officiis omnis porro qui quia quidem, recusandae suscipit, ut velit voluptatem?</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto magni obcaecati quos similique tempora. Aliquid autem beatae dolore dolorem eos, esse eum eveniet expedita ipsa iure odio perferendis provident quaerat quam ratione sequi unde vel? Ad ea explicabo hic impedit ipsam nobis nulla, unde! Animi, aspernatur at cumque debitis eaque facere labore nesciunt nostrum optio praesentium quas quis sed sequi soluta sunt, temporibus ullam voluptatem, voluptatibus? Aut ipsum itaque nobis officia velit.</p>\r\n<p>Adipisci commodi deserunt facere ipsa, ipsum labore laudantium maiores modi molestiae nesciunt nihil obcaecati perferendis quia ratione rerum sit tenetur unde veniam vitae, voluptatum? Accusantium, commodi enim iste nemo officia veniam. Aut dolor dolore eaque earum inventore ipsam, magni molestias officiis omnis porro qui quia quidem, recusandae suscipit, ut velit voluptatem?</p>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto magni obcaecati quos similique tempora. Aliquid autem beatae dolore dolorem eos, esse eum eveniet expedita ipsa iure odio perferendis provident quaerat quam ratione sequi unde vel? Ad ea explicabo hic impedit ipsam nobis nulla, unde! Animi, aspernatur at cumque debitis eaque facere labore nesciunt nostrum optio praesentium quas quis sed sequi soluta sunt, temporibus ullam voluptatem, voluptatibus? Aut ipsum itaque nobis officia velit.</p>\r\n<p>Adipisci commodi deserunt facere ipsa, ipsum labore laudantium maiores modi molestiae nesciunt nihil obcaecati perferendis quia ratione rerum sit tenetur unde veniam vitae, voluptatum? Accusantium, commodi enim iste nemo officia veniam. Aut dolor dolore eaque earum inventore ipsam, magni molestias officiis omnis porro qui quia quidem, recusandae suscipit, ut velit voluptatem?</p>",
    "list_template": "landing",
    "hero_title": "HotTour – Туристическая<br> компания вашей мечты",
    "hero_lead": "Создаём незабываемые путешествия по всему миру с 2010 года.\r\nДоверьте свой отдых профессионалам.",
    "hero_buttons": {
        "1": {
            "text": "Подобрать тур",
            "url": "#pick_tour"
        },
        "2": {
            "text": "Получить консультацию",
            "url": "/kontakty"
        }
    },
    "hero_stats": {
        "1": {
            "value": "14+",
            "label": "Лет на рынке"
        },
        "2": {
            "value": "50,000+",
            "label": "Счастливых туристов"
        },
        "3": {
            "value": "98%",
            "label": "Довольных клиентов"
        },
        "4": {
            "value": "120+",
            "label": "Стран мира"
        }
    },
    "company_title": "О компании HotTour",
    "company_text": "С 2010 года мы помогаем людям находить идеальные туры по всему миру. HotTour - это команда профессионалов, которые влюблены в путешествия и знают, как сделать ваш отдых незабываемым.",
    "company_checks": {
        "1": {
            "title": "Лицензия и сертификаты",
            "text": "Все необходимые документы и разрешения для туристической деятельности"
        },
        "2": {
            "title": "Страхование туристов",
            "text": "Полная страховая защита на всех этапах путешествия"
        },
        "3": {
            "title": "24/7 Поддержка",
            "text": "Наша команда всегда на связи во время вашего путешествия"
        }
    },
    "adv_title": "Наши преимущества",
    "adv_lead": "Почему более 50 тысяч человек выбрали HotTour\r\nдля своего путешествия",
    "adv_cards": {
        "1": {
            "title": "Лучшие цены",
            "text": "Работаем напрямую с туроператорами и гарантируем выгодные условия"
        },
        "2": {
            "title": "Надёжность",
            "text": "Полная страховка, официальные договоры и защита ваших интересов"
        },
        "3": {
            "title": "Поддержка 24/7",
            "text": "Наши менеджеры всегда на связи, даже во время вашего путешествия"
        },
        "4": {
            "title": "Опыт 14 лет",
            "text": "Глубокие знания туристического рынка и проверенные партнёры"
        },
        "5": {
            "title": "Быстрое оформление",
            "text": "Онлайн подбор, бронирование и подписание договора за 15 минут"
        },
        "6": {
            "title": "Бонусы и подарки",
            "text": "Программа лояльности, скидки постоянным клиентам"
        }
    },
    "app_title": "Мобильное приложение HotTour",
    "app_lead": "Весь мир путешествий в вашем кармане. Подбирайте туры,\r\nбронируйте отели и управляйте поездками в любое время.",
    "app_features": {
        "1": {
            "title": "Избранные туры",
            "text": "Сохраняйте интересные предложения"
        },
        "2": {
            "title": "Все документы",
            "text": "Договоры, ваучеры и билеты в одном месте"
        },
        "3": {
            "title": "Бонусная программа",
            "text": "Накапливайте баллы и получайте скидки"
        },
        "4": {
            "title": "История туров",
            "text": "Просматривайте все ваши путешествия"
        }
    },
    "online_title": "Онлайн-оформление",
    "online_lead": "Путешествие начинается с комфорта. Забудьте о поездках в офис — всё необходимое уже в вашем смартфоне.",
    "online_steps": {
        "1": {
            "label": "Получение заявки"
        },
        "2": {
            "label": "Оформление документов"
        },
        "3": {
            "label": "Безопасная оплата"
        }
    },
    "online_cards": {
        "1": {
            "title": "Без визитов в офис",
            "text": "Больше не нужно стоять в пробках и подстраиваться под график работы. Оформляйте тур из дома, кафе или прямо с рабочего места в любое удобное время."
        },
        "2": {
            "title": "Документы всегда под рукой",
            "text": "Авиабилеты, ваучеры, страховка и договор хранятся в вашем мобильном кабинете. Вам не нужно ничего распечатывать — всё доступно офлайн в один клик."
        },
        "3": {
            "title": "Мгновенная оплата",
            "text": "Оплачивайте выбранный тур картой любого банка через защищенный шлюз. Деньги поступают мгновенно, и вы сразу получаете подтверждение бронирования."
        }
    },
    "safety_title": "Путешествовать с нами безопасно!",
    "safety_lead": "Хотите быть уверены, что с вашим отдыхом будет все в порядке? Туроператор «не прогорит», отель будет соответствовать фото в рекламе, документы и вылет — в срок?",
    "safety_cards": {
        "1": {
            "title": "100% гарантия отдыха",
            "text": "Чтобы вы чувствовали себя спокойно и уверенно на отдыхе — у нас работает коллцентр, который поможет вам в любое время суток!"
        },
        "2": {
            "title": "Только хорошие отзывы",
            "text": "На сайте есть отзывы наших туристов как в аудио формате, так и текстовые, что гарантирует их достоверность."
        },
        "3": {
            "title": "Безопасность - прежде всего!",
            "text": "Наши менеджеры рассчитывают несколько оптимальных вариантов доставки"
        },
        "4": {
            "title": "Проверенные туроператоры",
            "text": "Мы сотрудничаем только с проверенными туроператорами и страховочными фирмами"
        }
    },
    "faq": {
        "1": {
            "title": "Часто задаваемые вопросы",
            "options": {
                "1": {
                    "question": "Как забронировать тур?",
                    "answer": "<p>Выберите тур на сайте или оставьте заявку — менеджер свяжется с вами, поможет с выбором и оформит все документы онлайн.</p>"
                },
                "2": {
                    "question": "Какие документы нужны для поездки?",
                    "answer": "<p>Паспорт для стран СНГ или загранпаспорт. Для некоторых стран — виза и страховка. Менеджер подскажет точный список по вашему направлению.</p>"
                },
                "3": {
                    "question": "Можно ли оплатить тур в рассрочку?",
                    "answer": "<p>Да, доступна оплата картами любого банка, а также кредит и рассрочка через банки-партнёры.</p>"
                },
                "4": {
                    "question": "Что делать, если рейс задержали?",
                    "answer": "<p>Свяжитесь с нашей службой поддержки — мы на связи 24/7 и поможем решить любой вопрос во время путешествия.</p>"
                }
            }
        }
    },
    "cta_title": "Готовы к своему следующему приключению?",
    "cta_lead": "Присоединяйтесь к 50,000+ счастливых путешественников и создайте свою историю с HotTour",
    "cta_buttons": {
        "1": {
            "text": "Подобрать тур сейчас",
            "url": "#pick_tour"
        },
        "2": {
            "text": "Получить консультацию",
            "url": "/kontakty"
        }
    },
    "cta_phone_label": "Связь с нами в один клик, звоните.",
    "cta_social_label": "свяжитесь с нами в мессенджерах",
    "metatitle": null,
    "description": null,
    "keywords": null
}
JSON;
};