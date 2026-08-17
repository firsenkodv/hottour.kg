# План обновления Laravel 10 → 13

Подготовлено 07.08.2026. Ничего не установлено — это чек-лист для ручного прогона.

## Исходные данные

| | Сейчас | Цель |
|---|---|---|
| laravel/framework | 10.50.2 | 13.24.0 (вышел 04.08.2026) |
| PHP | 8.3.14 | требуется `^8.3` — **подходит** |
| moonshine/moonshine | 4.18.1 | без изменений, уже объявляет `illuminate/* ^10\|^11\|^12\|^13` |

MoonShine апгрейд **не блокирует** — он и был причиной, по которой проект стоял на Laravel 10.
Блокеры — только сторонние пакеты, под каждый есть подходящая версия.

Оценка Laravel: 10→11 — 15 минут, 11→12 — 5 минут, 12→13 — 10 минут (по официальным upgrade guide).
Реально закладывать день с учётом ручной проверки страниц: тестов в проекте нет (только `tests/*/ExampleTest.php`).

## 0. Перед стартом

1. Закоммитить текущую ветку `feature/moonshine-v4` (сейчас 252 несохранённых изменения) — иначе нет точки отката.
2. Сделать дамп БД.
3. Скопировать `vendor/` и `composer.lock` или убедиться, что откат делается через `git checkout composer.lock && composer install`.

## 1. Патч composer.json

```json
"require": {
    "php": "^8.3",
    "ext-curl": "*",
    "diglactic/laravel-breadcrumbs": "^10.1",
    "guzzlehttp/guzzle": "^7.8.1",
    "intervention/image": "^4.2",
    "intervention/image-laravel": "^4.1",
    "laravel/framework": "^13.0",
    "laravel/sanctum": "^4.3.3",
    "laravel/tinker": "^3.0",
    "lee-to/moonshine-tree-resource": "^4.0",
    "maatwebsite/excel": "^3.1.69",
    "moonshine/apexcharts": "^3.1",
    "moonshine/import-export": "^2.1",
    "moonshine/moonshine": "^4.18",
    "moonshine/tinymce": "^2.0",
    "rap2hpoutre/fast-excel": "^5.14",
    "spatie/laravel-backup": "^10.3.1",
    "spatie/laravel-honeypot": "^4.7.2",
    "yurizoom/moonshine-media-manager": "^4.6"
},
"require-dev": {
    "barryvdh/laravel-debugbar": "^4.4.1",
    "fakerphp/faker": "^1.23",
    "laravel/pint": "^1.18",
    "laravel/sail": "^1.41",
    "mockery/mockery": "^1.6",
    "nunomaduro/collision": "^8.9.5",
    "phpunit/phpunit": "^12.0",
    "spatie/laravel-ignition": "^2.12"
}
```

`laravel/prompts`, `brick/math`, `nesbot/carbon`, `laravel/serializable-closure`,
`symfony/polyfill-php85` подтянутся сами как зависимости фреймворка.

## 2. Порядок прогона

Идти поэтапно, а не одним прыжком: после каждого шага прогоняется сайт и админка,
и сразу видно, какой мажор что сломал.

Две особенности, из-за которых обычный `composer require ... --update-with-all-dependencies`
не проходит:

1. **Кавычки обязательны.** В `cmd.exe` символ `^` — экранирующий, и `^11.0` без кавычек
   превращается в жёсткое требование ровно `11.0.0`. Composer тогда ругается на
   неразрешимый набор пакетов. В PowerShell `^` безопасен, но кавычки работают в обеих оболочках.
2. **Констрейнты сначала пишем, ставим потом.** `nunomaduro/collision` 7.x тянет
   `termwind ^1.15` и конфликтует с framework ≥ 11, а `require` для prod- и dev-зависимостей
   выполняется разными командами. Пока они идут по очереди, composer не может разрешить
   связку целиком — поэтому `--no-update`, а установка одним общим `update`.

```bash
# шаг 1: Laravel 11
composer require --no-update "laravel/framework:^11.0" "laravel/sanctum:^4.0"
composer require --dev --no-update "nunomaduro/collision:^8.1"
composer update --with-all-dependencies
php artisan vendor:publish --tag=sanctum-migrations
# прогнать сайт + админку

# шаг 2: Laravel 12
composer require --no-update "laravel/framework:^12.0" "spatie/laravel-backup:^10.0"
composer require --dev --no-update "phpunit/phpunit:^11.0" "barryvdh/laravel-debugbar:^3.15"
composer update --with-all-dependencies
# прогнать сайт + админку

# шаг 3: Laravel 13
composer require --no-update "laravel/framework:^13.0" "laravel/tinker:^3.0"
composer require --dev --no-update "phpunit/phpunit:^12.0"
composer update --with-all-dependencies
# прогнать сайт + админку

php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

Если composer на каком-то шаге сообщит о конфликте — добавить проблемный пакет
в ту же пару команд `--no-update` с целевой версией из таблицы в разделе 1.

Альтернатива: отредактировать блоки `require` / `require-dev` в `composer.json`
готовыми значениями из раздела 1 и выполнить один `composer update --with-all-dependencies`.
Быстрее, но при поломке непонятно, какой из трёх мажоров виноват.

При неудаче composer сам откатывает `composer.json` и `composer.lock` — состояние проекта
не портится. Если composer не запускается из-за незаданного `COMPOSER_HOME`, вызывать напрямую:
`php C:\OSPanel\data\PHP-7.2\default\composer\composer.phar <команда>`.

## 3. Правки в коде

### Обязательные

**`src/Support/Helpers/helpers.php` — Intervention Image v2 → v4.**
Пакет v2 заброшен с 2022, фасада `Intervention\Image\Facades\Image` в новых версиях нет —
он переехал в отдельный пакет `intervention/image-laravel`.

Затрагивает хелпер `intervention()` (строки 586–634), который вызывается примерно
из 15 blade-шаблонов (карточки стран, отелей, курортов, новостей, отзывов, горящих туров).

```php
// было
use Intervention\Image\Facades\Image;

$image = Image::make($storage->path($realPath));
$image->{$method}($w, $h);          // $method по умолчанию 'fit'
$image->save($storage->path($resultPaht));

// стало
use Intervention\Image\Laravel\Facades\Image;

$image = Image::read($storage->path($realPath));
$image->{$method}($w, $h);          // 'fit' в v3/v4 переименован в 'cover'
$image->save($storage->path($resultPaht));
```

Важно: `$method` участвует в пути кеша миниатюр (`$dir/$method/$size`). Если просто
заменить значение по умолчанию на `cover`, все уже сгенерированные миниатюры в
`storage/.../fit/...` перестанут использоваться и создадутся заново — это допустимо,
но каталог `fit` потом можно удалить вручную.

Подробности: https://image.intervention.io/v3/introduction/upgrade

**CSRF-middleware переименован (L13, high impact).**
`VerifyCsrfToken` → `Illuminate\Foundation\Http\Middleware\PreventRequestForgery`.
Старое имя оставлено как deprecated-алиас, то есть сразу не сломается, но обновить нужно:
- `app/Http/Middleware/VerifyCsrfToken.php` — базовый класс
- `app/Http/Kernel.php:43`
- `config/moonshine.php:8,63`

Новый middleware дополнительно проверяет заголовок `Sec-Fetch-Site` — после апгрейда
обязательно проверить отправку форм с фронта (заявки, обратный звонок, honeypot-формы).

### Проверить, но скорее всего не тронет

| Изменение | Статус в проекте |
|---|---|
| Структура приложения L11 (`bootstrap/app.php`) | **менять не нужно** — Laravel 11+ официально поддерживает старую структуру L10 с `app/Http/Kernel.php`, гайд прямо не рекомендует миграцию |
| Carbon 2 → 3 (`diffIn*` возвращают float) | `diffIn` в коде не используется |
| `array_first()` / `array_last()` из symfony/polyfill-php85 | своих функций с такими именами нет |
| `HasUuids` → UUIDv7 | трейт не используется |
| Изменение колонок в миграциях (нужны все модификаторы) | единственная миграция с `->change()` (`2026_07_01_000001_make_title_nullable_in_contracts_table.php`) уже написана в новом стиле |
| `float`/`double` в миграциях | не используются |
| `Storage::disk('local')` → `storage/app/private` | диск `local` явно описан в `config/filesystems.php`, дефолт не применяется |
| Валидация `image` больше не пропускает SVG | единственное правило (`MoonShineUserFormPage.php:103`) и так ограничено `mimes:jpeg,jpg,png,gif` |
| Префиксы кеша/сессий с дефисами (L13) | `config/cache.php:109` задаёт `prefix` явно, дефолт не применяется |
| `CACHE_DRIVER` в `.env` | в новом скелете переменная называется `CACHE_STORE`, но наш `config/cache.php` читает `CACHE_DRIVER` — работает как есть |

### Отдельно: `serializable_classes` (L13, medium impact)

В скелете L13 у `config/cache.php` появилась опция `'serializable_classes' => false` —
запрет на десериализацию произвольных PHP-объектов из кеша (защита от gadget chain при утечке `APP_KEY`).

Наш `config/cache.php` — старый, этой опции нет, поведение не изменится. Но если решите
синхронизировать конфиг со скелетом L13, надо учесть, что в кеше лежат Eloquent-объекты:

```php
'serializable_classes' => [
    App\Models\Seo::class,   // SeoMiddleware кеширует найденную запись на 6 часов
],
```

Кеш Tourvisor (`tourvisor_list_*`) хранит сырые строки JSON — под ограничение не попадает.

## 4. Что проверить после апгрейда

- главная: подтягиваются города вылета/страны/регионы Tourvisor (кеш `tourvisor_list_*`), форма поиска;
- страница тура, страны, отеля, «Полезное», «О нас», отзывы;
- SEO-метатеги (`SeoMiddleware`) на нескольких URL;
- отправка форм: заявка, обратный звонок, honeypot — из-за нового CSRF-middleware;
- админка MoonShine: вход, список и форма любого ресурса, загрузка изображений (Intervention), импорт/экспорт Excel;
- крон-команды: `mainhotels:cron`, `tourvisorhotel` (используют `Tourvisor::_getHotel`/`getRequestid`);
- `spatie/laravel-backup` — прогнать `php artisan backup:run` вручную, у пакета мажорный скачок 9 → 10.

## 5. Полезные ссылки

- https://laravel.com/docs/11.x/upgrade
- https://laravel.com/docs/12.x/upgrade
- https://laravel.com/docs/13.x/upgrade
- https://image.intervention.io/v3/introduction/upgrade
- https://github.com/spatie/laravel-backup/blob/main/UPGRADING.md
