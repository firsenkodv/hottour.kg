//todo:jquery

/**
 * Календари сайта — единая инициализация.
 *
 * Разметка — компонент <x-forms.datepicker>
 * (resources/views/components/forms/datepicker.blade.php), внешний вид —
 * resources/css/forms/datepicker.scss. Плагин jquery-date-range-picker и
 * moment.js подключены в лейаутах (layout, layout_cabinet) обычными скриптами.
 *
 * Раньше инициализация была размножена по пяти местам (три копии в
 * include/search/js/*, две в script.js) — теперь только здесь.
 */

jQuery(($) => {
    if (!$.fn.dateRangePicker || typeof moment === 'undefined') {
        return;
    }

    // крестик очистки floating-поля виден, только когда даты выбраны
    var toggleClear = function ($wrap, filled) {
        $wrap.toggleClass('is-filled', filled);
    };

    /**
     * Позиционирование: плагин всегда рисует календарь под полем.
     * direction=auto переворачивает его вверх, когда внизу не хватает
     * места (а вверху хватает); direction=up — принудительно вверх.
     */
    var place = function ($input, $picker, direction) {
        if (!$picker || !$picker.length || direction === 'down') {
            return;
        }

        var rect = $input[0].getBoundingClientRect();
        var pickerH = $picker.outerHeight();

        if (direction === 'auto') {
            var fitsBelow = rect.bottom + pickerH + 16 <= window.innerHeight;
            var fitsAbove = rect.top - pickerH - 16 >= 0;

            if (fitsBelow || !fitsAbove) {
                return; // остаётся там, куда поставил плагин
            }
        }

        var parentTop = $picker.offsetParent().offset().top;
        $picker.css('top', Math.max($input.offset().top - parentTop - pickerH - 8, 0) + 'px');
    };

    /**
     * Показ календаря: плагин сначала запускает анимацию раскрытия и только
     * потом ставит позицию, поэтому при коррекции по datepicker-opened
     * календарь успевал мелькнуть внизу и «перепрыгивал» вверх.
     *
     * customOpenAnimation вызывается вместо slideDown, пока календарь ещё
     * скрыт: раскладываем его невидимым (display нужен, иначе высота 0,
     * visibility прячет от глаз), затем микротаском — к этому моменту плагин
     * уже проставил свою позицию — правим её и только теперь проявляем.
     */
    var openAnimation = function ($input, direction) {
        return function (done) {
            var $picker = $(this);

            $picker.stop(true, true).css({ visibility: 'hidden', opacity: 0, display: 'block' });

            // микротаском, а не requestAnimationFrame: rAF не выполняется в
            // неактивной вкладке, и календарь остался бы скрытым навсегда
            Promise.resolve().then(function () {
                place($input, $picker, direction);

                $picker.css({ visibility: '' }).animate({ opacity: 1 }, 120, done);
            });
        };
    };

    $('[data-datepicker]').each(function () {
        var $wrap = $(this);
        var kind = $wrap.data('datepicker');
        var direction = $wrap.data('direction') || 'auto';
        var $container = $wrap.data('container') ? $wrap.closest($wrap.data('container')) : $();

        /* одна дата с выбором месяца/года (кабинет) */
        if (kind === 'birthdate') {
            var $birth = $wrap.find('.datepicker-birthdate');

            $birth.dateRangePicker({
                autoClose: true,
                singleDate: true,
                showShortcuts: false,
                singleMonth: true,
                language: 'ru',
                monthSelect: true,
                startOfWeek: 'monday',
                yearSelect: [$wrap.data('years-from') || 1952, moment().get('year')],
                customOpenAnimation: openAnimation($birth, direction),
            }).bind('datepicker-change', function (event, obj) {
                $(this).next('.datepicker-birthdate_result').text(moment(obj.value).locale('ru').format('LL'));
            });

            return;
        }

        /* интервал дат: пара полей (поиск) или одно floating-поле (модалки) */
        var $hidden = $wrap.find('.datepicker-hidden');
        var $visible = $wrap.find('.datepicker-range');
        var $input = $hidden.length ? $hidden : $wrap.find('.datepicker-input');
        var isFloating = !$hidden.length;

        if (!$input.length) {
            return;
        }

        $input.dateRangePicker({
            format: 'DD.MM.YYYY',
            separator: ' - ',
            startOfWeek: 'monday',
            startDate: moment().format('DD.MM.YYYY'),
            language: 'ru',
            autoClose: isFloating,
            container: $container.length ? $container : 'body',
            // позицию отмеряем от видимого поля: в поиске скрытое лежит
            // оверлеем поверх него, координаты совпадают
            customOpenAnimation: openAnimation($visible.length ? $visible : $input, direction),
        }).bind('datepicker-change', function (event, obj) {
            // сам плагин поля не заполняет — значения проставляются здесь
            if (isFloating) {
                $input.val(moment(obj.date1).format('DD.MM.YYYY') + ' - ' + moment(obj.date2).format('DD.MM.YYYY'));
                // плавающая подпись поля реагирует на change (см. script.js)
                $input.trigger('change');
                toggleClear($wrap, true);
            } else {
                $visible.val(moment(obj.date1).format('DD MMM') + ' - ' + moment(obj.date2).format('DD MMM'));
                // одиночное D — как в прежней инициализации форм поиска
                $input.val(moment(obj.date1).format('D.MM.YYYY') + ' - ' + moment(obj.date2).format('D.MM.YYYY'));
            }
        });

        if (isFloating) {
            toggleClear($wrap, $input.val() !== '');
        }
    });

    /* крестик очистки: чистим и поле, и выбор в самом календаре */
    $('body').on('click', '.datepicker-clear', function (event) {
        event.preventDefault();

        var $wrap = $(this).closest('[data-datepicker]');
        var $input = $wrap.find('.datepicker-input');
        var picker = $input.data('dateRangePicker');

        if (picker && typeof picker.clear === 'function') {
            picker.clear();
        }

        // checkval убирает поднятую плавающую подпись (см. script.js)
        $input.val('').trigger('checkval');
        toggleClear($wrap, false);
    });
});
