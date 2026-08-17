/*!***************************************************
 * google-translate.js v1.0.3
 * https://Get-Web.Site/
 * author: Vitalii P.
 *****************************************************/

/*
 * Копия библиотеки из проекта generalre. Отличия от оригинала:
 *
 * 1. Файл лежит локально, а не тянется с adminway.ru — тот домен недоступен
 *    из-под VPN и держал страницу до TCP-таймаута (см. config/external.php).
 * 2. В начало встроен минимальный Cookies-шим вместо js-cookie с
 *    cdn.jsdelivr.net — по той же причине, что slick и moment лежат в public/js.
 *    API совпадает с js-cookie 2.x в объёме, который нужен библиотеке:
 *    Cookies.get(name) и Cookies.set(name, value, { domain }).
 */

if (typeof window.Cookies === 'undefined') {
    window.Cookies = {
        get: function (name) {
            var match = document.cookie.match(
                new RegExp('(?:^|; )' + name.replace(/([.*+?^${}()|[\]\\])/g, '\\$1') + '=([^;]*)')
            );
            return match ? decodeURIComponent(match[1]) : undefined;
        },
        set: function (name, value, options) {
            options = options || {};
            // js-cookie 2.x кодирует значение, но возвращает обратно часть
            // символов — в том числе «/». Это принципиально: googtrans читает
            // не только наш код, но и сам element.js, и он ждёт вида /ru/en.
            // С %2Fru%2Fen перевод не применится.
            var encoded = encodeURIComponent(String(value))
                .replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
            var cookie = name + '=' + encoded + '; path=/';
            if (options.domain) {
                cookie += '; domain=' + options.domain;
            }
            document.cookie = cookie;
        },
    };
}

const googleTranslateConfig = {
    /* Original language */
    lang: "ru",
    /* The language we translate into on the first visit*/
    // langFirstVisit: 'en',
    domain: "hottour.kg"
};

function TranslateInit() {

    if (googleTranslateConfig.langFirstVisit && !Cookies.get('googtrans')) {
        TranslateCookieHandler("/auto/" + googleTranslateConfig.langFirstVisit);
    }

    var code = TranslateGetCode();
    if (document.querySelector('[data-google-lang="' + code + '"]') !== null) {
        document.querySelector('[data-google-lang="' + code + '"]').classList.add('language__img_active');
    }

    if (code == googleTranslateConfig.lang) {
        TranslateCookieHandler(null, googleTranslateConfig.domain);
    }

    new google.translate.TranslateElement({
        pageLanguage: googleTranslateConfig.lang,
    });

    TranslateEventHandler('click', '[data-google-lang]', function (e) {
        TranslateCookieHandler("/" + googleTranslateConfig.lang + "/" + e.getAttribute("data-google-lang"), googleTranslateConfig.domain);
        window.location.reload();
    });
}

function TranslateGetCode() {
    var lang = (Cookies.get('googtrans') != undefined && Cookies.get('googtrans') != "null") ? Cookies.get('googtrans') : googleTranslateConfig.lang;
    return lang.match(/(?!^\/)[^\/]*$/gm)[0];
}

function TranslateCookieHandler(val, domain) {
    Cookies.set('googtrans', val);
    Cookies.set("googtrans", val, {
        domain: "." + document.domain,
    });

    // в оригинале здесь сравнение с литералом "undefined", из-за чего ветка
    // никогда не срабатывала и куки ставились на домен ".undefined"
    if (!domain) return;
    Cookies.set("googtrans", val, {
        domain: domain,
    });
    Cookies.set("googtrans", val, {
        domain: "." + domain,
    });
}

function TranslateEventHandler(event, selector, handler) {
    document.addEventListener(event, function (e) {
        var el = e.target.closest(selector);
        if (el) handler(el);
    });
}

// element.js вызывает TranslateInit как глобальный callback (?cb=TranslateInit),
// поэтому функции должны быть видны в window — при загрузке файла обычным
// <script> это так, но подстраховываемся на случай сборки в модуль.
window.TranslateInit = TranslateInit;
