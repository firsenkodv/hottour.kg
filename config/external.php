<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Внешние (сторонние) подключения
    |--------------------------------------------------------------------------
    |
    | Общий рубильник для всего, что уходит на чужие домены: счётчики,
    | CDN, карты, виджеты, CRM. Нужен прежде всего для локальной разработки
    | под VPN — часть доменов оттуда недоступна, браузер ждёт их до
    | TCP-таймаута и страница «висит» десятками секунд.
    |
    | По умолчанию true, поэтому на сервере, где EXTERNAL_SERVICES не задан,
    | поведение остаётся прежним. Выключается в .env одной строкой:
    |
    |     EXTERNAL_SERVICES=false
    |
    | Проверка в коде — хелпер external('gtm'), в шаблонах — директива
    | @external('gtm') ... @endexternal.
    |
    */

    'enabled' => env('EXTERNAL_SERVICES', true),

    /*
    |--------------------------------------------------------------------------
    | Отдельные сервисы
    |--------------------------------------------------------------------------
    |
    | null — наследует общий рубильник 'enabled' (обычное значение).
    | true — сервис работает всегда, даже при EXTERNAL_SERVICES=false.
    | false — сервис выключен всегда, даже на проде.
    |
    | Так можно точечно вернуть нужное на локале: например, оставить
    | редактор TinyMCE, отключив всё остальное.
    |
    | Домены, недоступные из-под VPN (проверено 10.08.2026): cdn.jsdelivr.net,
    | tourvisor.ru, api-maps.yandex.ru, connect.facebook.net (грузится через
    | GTM), analytics.tiktok.com (через GTM).
    |
    */

    'services' => [

        // Google Tag Manager, config/google/google_tag.php.
        // Через него на сайт приходят пиксели Facebook и TikTok.
        'gtm' => env('EXTERNAL_GTM'),

        // Яндекс.Карты (api-maps.yandex.ru): контакты, карточка отеля, поиск.
        // При выключении на месте карты выводится плашка-заглушка.
        'yandex_maps' => env('EXTERNAL_YANDEX_MAPS'),

        // Модуль поиска Tourvisor на фронте (//tourvisor.ru/module/init.js).
        // Серверный API Tourvisor этим флагом НЕ управляется — у него свои
        // режимы, см. config/tourvisor.php (TOURVISOR_MODE).
        'tourvisor_js' => env('EXTERNAL_TOURVISOR_JS'),

        // Виджет авиабилетов Travelpayouts (tp.media).
        'travelpayouts' => env('EXTERNAL_TRAVELPAYOUTS'),

        // Фотографии отелей с static.tourvisor.ru: приходят в данных API
        // (поля hotelpicture, picturelink). Домен тоже недоступен из-под VPN,
        // при выключении вместо фото подставляется серая заглушка,
        // см. хелпер remote_image().
        'tourvisor_images' => env('EXTERNAL_TOURVISOR_IMAGES'),

        // Гугл-переводчик (translate.google.com). Сама библиотека лежит
        // локально в public/js/language/google-translate.js, снаружи
        // подгружается только element.js.
        'translate' => env('EXTERNAL_TRANSLATE'),

        // Редактор TinyMCE с cdn.tiny.cloud. Домен из-под VPN доступен,
        // а без него в админке пропадает визуальный редактор, поэтому
        // по умолчанию оставлен включённым независимо от рубильника.
        'tinymce' => env('EXTERNAL_TINYMCE', true),

        // Отправка заявок в CRM и Bitrix24 (app/Crm, app/Bitrix24).
        // Выключение защищает боевую CRM от тестовых заявок с локалки.
        'crm' => env('EXTERNAL_CRM'),

    ],

];
