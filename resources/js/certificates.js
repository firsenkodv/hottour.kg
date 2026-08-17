//todo:jquery

/**
 * Страница «Сертификаты» (/sertifikaty): поле произвольной суммы.
 *
 * Разметка — pages/certificates/templates/list/certificates.blade.php,
 * стили — css/pages/certificates/certificates.scss.
 *
 * Вводить можно только цифры, они на лету разбиваются по три (10 000 000).
 * Произвольная сумма и готовые номиналы взаимоисключающие: при вводе снимается
 * выбор номинала, при выборе номинала поле очищается. В заявку сумма уходит
 * из ajax.js (обработчик .certificate_order_button_js).
 */

jQuery(($) => {
    var $inputs = $('.cert__custom-input');

    if (!$inputs.length) {
        return;
    }

    /** «10000000» → «10 000 000» */
    var format = function (value) {
        var digits = String(value).replace(/\D/g, '').replace(/^0+(?=\d)/, '');

        return digits === '' ? '' : digits.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    };

    var markFilled = function ($input) {
        $input.closest('.cert__custom-field').toggleClass('is-filled', $input.val() !== '');
    };

    $('body').on('input', '.cert__custom-input', function () {
        var $input = $(this);
        var before = this.value;
        var caret = this.selectionStart;
        var formatted = format(before);

        this.value = formatted;

        // курсор держим на месте: считаем цифры слева от него и находим
        // ту же позицию в отформатированной строке
        if (caret !== null && document.activeElement === this) {
            var digitsBefore = before.slice(0, caret).replace(/\D/g, '').length;
            var position = 0;
            var seen = 0;

            while (position < formatted.length && seen < digitsBefore) {
                if (/\d/.test(formatted[position])) {
                    seen++;
                }
                position++;
            }

            this.setSelectionRange(position, position);
        }

        markFilled($input);

        // своя сумма отменяет выбранный номинал
        if (formatted !== '') {
            $input.closest('.cert__panel').find('.cert__sum-radio').prop('checked', false);
        }
    });

    // и наоборот: выбрали номинал — своя сумма больше не нужна
    $('body').on('change', '.cert__sum-radio', function () {
        var $input = $(this).closest('.cert__panel').find('.cert__custom-input');

        $input.val('');
        markFilled($input);
    });

    $inputs.each(function () {
        var $input = $(this);

        $input.val(format($input.val()));
        markFilled($input);
    });
});
