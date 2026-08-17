/**
 * Сворачивание длинного описания до первого абзаца.
 * Разметка — компонент <x-content.collapse>. Перенесено из hseipaa.kz.
 *
 * Без JS текст виден целиком (кнопка скрыта атрибутом hidden),
 * поэтому на SEO и на пользователей с отключённым JS свёртка не влияет.
 */

// Минимальная высота свёрнутого состояния: если первый абзац короче —
// добавляем следующие элементы, пока не наберётся столько пикселей
const MIN_HEIGHT = 140;

// Если скрытый «хвост» меньше этого — сворачивать нет смысла
const MIN_TAIL = 80;

export function descCollapse() {
    document.querySelectorAll('[data-desc-collapse]').forEach(setup);
}

function setup(root) {
    const body = root.querySelector('[data-desc-collapse-body]');
    const btn  = root.querySelector('[data-desc-collapse-btn]');

    if (!body || !btn) return;

    const label     = btn.querySelector('[data-desc-collapse-label]') ?? btn;
    const labelMore = root.dataset.labelMore || 'Читать далее';
    const labelLess = root.dataset.labelLess || 'Свернуть';

    let expanded = false;
    let cut      = 0;

    const measure = () => {
        // Меряем всегда в развёрнутом виде
        body.style.transition = 'none';
        body.style.maxHeight  = '';
        root.classList.remove('is-collapsed');

        cut = collapsedHeight(body);
        const full = body.scrollHeight;

        if (!cut || full - cut < MIN_TAIL) {
            // Текст короткий — свёртка не нужна
            btn.hidden = true;
            expanded   = true;
            body.style.transition = '';
            return;
        }

        btn.hidden = false;

        if (expanded) {
            body.style.maxHeight = '';
        } else {
            body.style.maxHeight = cut + 'px';
            root.classList.add('is-collapsed');
        }

        // Возвращаем анимацию на следующем кадре, чтобы замер её не запустил
        requestAnimationFrame(() => { body.style.transition = ''; });
    };

    const expand = () => {
        expanded = true;
        root.classList.remove('is-collapsed');
        body.style.maxHeight = body.scrollHeight + 'px';

        onTransitionEnd(body, () => {
            if (expanded) body.style.maxHeight = '';
        });

        setLabel(labelLess, true);
    };

    const collapse = () => {
        expanded = false;
        // От текущей фактической высоты — иначе анимации не будет
        body.style.maxHeight = body.scrollHeight + 'px';
        void body.offsetHeight;

        root.classList.add('is-collapsed');
        body.style.maxHeight = cut + 'px';

        setLabel(labelMore, false);
    };

    const setLabel = (text, isExpanded) => {
        label.textContent = text;
        btn.setAttribute('aria-expanded', String(isExpanded));
    };

    btn.addEventListener('click', () => {
        if (expanded) {
            collapse();
            // Если верх блока ушёл за экран — возвращаем к нему
            const top = root.getBoundingClientRect().top;
            if (top < 0) root.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            expand();
        }
    });

    measure();

    // Пересчёт при смене ширины окна и при загрузке картинок/шрифтов
    let timer = null;
    window.addEventListener('resize', () => {
        clearTimeout(timer);
        timer = setTimeout(measure, 150);
    });
    window.addEventListener('load', measure);
}

// Контейнеры, в которые нужно заглядывать: текст часто завёрнут
// в <article>/<div> целиком, и тогда «первый абзац» не найти на верхнем уровне
const WRAPPERS = new Set(['DIV', 'ARTICLE', 'SECTION', 'MAIN', 'BLOCKQUOTE']);

// Глубже спускаться незачем — дальше идёт разметка внутри абзацев
const MAX_DEPTH = 3;

/**
 * Плоский список блоков в порядке потока: контейнеры-обёртки заменяются
 * на своё содержимое, чтобы до абзацев можно было добраться.
 */
function flatBlocks(root, depth = 0) {
    const out = [];

    for (const el of root.children) {
        if (el.getBoundingClientRect().height <= 0) continue;

        if (depth < MAX_DEPTH && WRAPPERS.has(el.tagName) && el.children.length) {
            out.push(...flatBlocks(el, depth + 1));
        } else {
            out.push(el);
        }
    }

    return out;
}

/**
 * Высота свёрнутого состояния — по нижней границе первого абзаца.
 * Всё, что идёт до него (заголовок, картинка), тоже остаётся видимым.
 */
function collapsedHeight(body) {
    const content = body.querySelector('.content_page__desc') ?? body;
    const kids    = flatBlocks(content);

    if (!kids.length) return 0;

    const top = body.getBoundingClientRect().top;
    let fallback = 0;

    for (const el of kids) {
        const bottom = Math.ceil(el.getBoundingClientRect().bottom - top);

        if (!fallback && bottom >= MIN_HEIGHT) {
            fallback = bottom;
        }

        const isParagraph = el.tagName === 'P' && el.textContent.trim() !== '';

        if (isParagraph && bottom >= MIN_HEIGHT) {
            return bottom;
        }
    }

    return fallback || Math.ceil(kids[0].getBoundingClientRect().bottom - top);
}

function onTransitionEnd(el, cb) {
    const handler = (e) => {
        if (e.target !== el || e.propertyName !== 'max-height') return;
        el.removeEventListener('transitionend', handler);
        cb();
    };
    el.addEventListener('transitionend', handler);
}
