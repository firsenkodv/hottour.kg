
// Гугл-переводчик. Сама библиотека лежит локально
// (public/js/language/google-translate.js) — раньше она тянулась с
// adminway.ru, а тот домен недоступен из-под VPN и висел до таймаута.
// Снаружи остаётся только element.js: он и вызывает колбэк TranslateInit,
// поэтому порядок обязателен (async = false — скрипты выполняются по очереди).
// Флаг приходит из config/external.php.
if (!window.EXTERNAL || window.EXTERNAL.translate !== false) {
    for (const js of [
        '/js/language/google-translate.js',
        '//translate.google.com/translate_a/element.js?cb=TranslateInit',
    ]) {
        const script = document.body.appendChild(document.createElement('script'));
        script.async = false;
        script.src = js;
    }
}
