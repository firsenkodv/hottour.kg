
// cdn.jsdelivr.net и adminway.ru недоступны из-под VPN и висят до таймаута,
// а скрипты загружаются строго по очереди (async = false) — без первого
// не выполнится ни один. Флаг приходит из config/external.php.
if (!window.EXTERNAL || window.EXTERNAL.translate !== false) {
    for (const js of [
        'https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js',
        'https://adminway.ru/files/google-translate.js',
        '//translate.google.com/translate_a/element.js?cb=TranslateInit',
    ]) {
        const script = document.body.appendChild(document.createElement('script'));
        script.async = false;
        script.src = js;
    }
}
