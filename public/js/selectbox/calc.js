//todo:jquery
$(document).ready(function () {

    function OnlyNum(str, min, max) {

        var value = str.replace(/[^0-9]/g, '');
        if (value < min) {
            return new Intl.NumberFormat('ru-RU').format(min);
        } else if (value > max) {
            return new Intl.NumberFormat('ru-RU').format(max);
        } else {
            return new Intl.NumberFormat('ru-RU').format(value);
        }
    }

    function RemoveWhitespace(str) {

        return str.replace(/\s/g, '');

    }

    function progressbar(x, id) {

        jQuery(".mod_axeld_progressbar_"+ id).progressbar({
            value: x
        });

    }





    /**
     * input движение label
     * */

        ///////////////////////

        $('.mod_axeld_credit_192 .selectBox').selectbox();

        var Vall, min, max;

        min = $('.mod_axeld_credit_192 .mod_c_c_val').data('min');
        max = $('.mod_axeld_credit_192 .mod_c_c_val').data('max');

        $('.mod_axeld_credit_192 .mod_c_c_val').val(new Intl.NumberFormat('ru-RU').format($('.mod_axeld_credit_192 .mod_c_c_val').val())); // провебелы между цифрами




        $('.mod_axeld_credit_192 .mod_axeld_credit_calculator__slider').slider({
            min: 100000,
            max: 10000000,
            value: 300000,
            step: 25000,
            slide: function (event, ui) {
                Vall = new Intl.NumberFormat('ru-RU').format(ui.value);
                $('.mod_axeld_credit_192 .mod_c_c_val').val(Vall);
                $('.mod_axeld_credit_192 .mod_c_c_val').removeClass('mod_axeld_credit_error');

            }


        });


        $('body').on('input', '.mod_axeld_credit_192 .mod_c_c_val', function () {
            Vall = $(this).val();
            min = $(this).data('min');
            max = $(this).data('max');
            $(this).val(OnlyNum(Vall, min, max)); // только цифры
            $(this).removeClass('mod_axeld_credit_error');

            $('.mod_axeld_credit_192 .mod_axeld_credit_calculator__slider').slider("value", RemoveWhitespace($('.mod_axeld_credit_192 .mod_c_c_val').val()));

        })


        var details = JSON.parse($('.mod_axeld_credit_192').attr('data-banks'));
        // Change the price property in our variable
        // console.log(details.banks.bank1.title);


        $('body').on('click', '.mod_axeld_credit_192 .selectMenuBox_Bank li', function (event) {

            $('.mod_axeld_credit_192').find('.selectMenuBox_Month').html('');

            var label = $('.mod_axeld_credit_192').find('.valueTag_Month').data('label');
            $('.mod_axeld_credit_192').find('.valueTag_Month').text(label);

            var Bank = String($(this).data('bank'));
            var B = details.banks;
            console.log(B[Bank]);

            $.each(B[Bank].koff, function (month, koff) {
                // console.log(month + ': ' + koff);

                let arr__ = koff.split('&');

                $('.mod_axeld_credit_192').find('.selectMenuBox_Month').append('<li data-month="' + month + '" data-koff="' + arr__[0] + '" class="option">' + arr__[1] + '</li>');


            });




        });


        $('body').on('click', '.mod_axeld_credit_192 .selectMenuBox_Month li', function (event) {

            // ничего

        });

        $('body').on('click', '.mod_axeld_credit_192 .mod_axeld_credit__start', function (event) {



            $('.mod_axeld_cс__bank__js').text($('.valueTag_Bank').text());
            $('.mod_axeld_cс__country__js').text($('.valueTag_credit').text());


            let THIS_Parent = $(this).parents('.mod_axeld_credit_192');
            let BankName = THIS_Parent.find('.valueTag_Bank').text();
            let Procent;
            let Bank;
            let Credit;
            let Mouth;
            let MouthText;
            let Koff;
            let Price;
            let Error;
            let MinSum = 100000;

            ////////////////////////// bank

            $(THIS_Parent.find('.selectMenuBox_Bank li')).each(function (index) {
                if ($(this).hasClass('active')) {
                    Bank = String($(this).data('bank'));
                    Procent = String($(this).data('procent'));
                }
            });

            if (!Bank) {

                THIS_Parent.find('.valueTag_Bank').addClass('mod_axeld_credit_error');
                return false;

            }


            ////////////////////////// кредит

            $(THIS_Parent.find('.selectMenuBox_Credit li')).each(function (index) {
                if ($(this).hasClass('active')) {
                    Credit = String($(this).text());
                }
            });

            if (!Credit) {

                THIS_Parent.find('.valueTag_credit').addClass('mod_axeld_credit_error');
                return false;

            }

            ////////////////////////// срок

            $(THIS_Parent.find('.selectMenuBox_Month li')).each(function (index) {

                if ($(this).hasClass('active')) {
                    MouthText = String($(this).text());
                    Mouth = $(this).data('month');
                    Koff = $(this).data('koff');
                }
            });

            if (!MouthText) {

                THIS_Parent.find('.valueTag_Month').addClass('mod_axeld_credit_error');
                return false;
            }

            Price = RemoveWhitespace(THIS_Parent.find('.mod_c_c_val').val());
            //////////////// размер кредита
            if (Price < MinSum) {
                THIS_Parent.find('.mod_c_c_val').addClass('mod_axeld_credit_error');

                return false;
            }



            /*  console.log('Price ' + Price + '; Банк' + Bank + '; Процент ' + Procent + ' ; Кредит ' + Credit + '; Месяц ' + Mouth + '; Месяц ' + MouthText + '; Коэф. ' + Koff);*/


            let vuplata = Number((Math.round(Price * Koff) * Mouth) - Price);
            let platej = Number(Math.round(Price * Koff));
            let srok =  THIS_Parent.find('.valueTag_Month').text();



            $('.m_a_c__stavka').text(Procent + '%');
            $('.m_a_c__srok').text(srok);
            $('.m_a_c__platej').text(new Intl.NumberFormat('ru-RU').format( platej ) + ' ₸');
            $('.m_a_c__pereplata').text(new Intl.NumberFormat('ru-RU').format( vuplata ) + ' ₸');
            $('.m_a_c__vuplata').text(new Intl.NumberFormat('ru-RU').format(Math.round(Price * Koff) * Mouth) + ' ₸');
            $('.m_a_c__price').text(new Intl.NumberFormat('ru-RU').format(Price) + ' ₸'); // только для mod_axeld_form

            let Progressbar = 100 - (Math.round(Price / platej));

            progressbar(Progressbar, 192);

            THIS_Parent.find('.mod_axeld_credit_calculator__result').show();
            THIS_Parent.find('.mod_axeld_credit_calculator__form').hide();


            $('input[name="bank"]').val($('.valueTag_Bank').text());
            $('input[name="credit"]').val($('.valueTag_credit').text());
            $('input[name="month"]').val($('.valueTag_Month').text());

            $('input[name="bet"]').val(Procent + '%');
            $('input[name="term"]').val(srok);
            $('input[name="monthly_payment"]').val(new Intl.NumberFormat('ru-RU').format( platej ) + ' ₸');
            $('input[name="overpayment"]').val(new Intl.NumberFormat('ru-RU').format( vuplata ) + ' ₸');
            $('input[name="total_payout"]').val(new Intl.NumberFormat('ru-RU').format(Price) + ' ₸');




        });




    }); // end of document ready223
