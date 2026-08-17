(function ($) {
    $.fn.selectbox = function () {

        // начальные параметры
        // задаем стандартную высоту div'a.
        var selectDefaultHeight = $('.selectBox').height();
        // угол поворота изображения в div'e
        var rotateDefault = "rotate(0deg)";

        var Items, Zindex;

        $.each($('.selectMenuBox'), function (k, v) {

            Zindex = 100 - k;
            $(this).parents('.selectBox').css('z-index', Zindex);

            Items = Number($(this).find('li').length);

            if(Items) {
                $(this).height(Items * 44 + "px");
            } else {
                $(this).height("222px");
           }
        });


        // после нажатия кнопки срабатывает функция, в которой
        // вычисляется исходная высота нашего div'a.
        // очень удобно для сравнения с входящими параметрами (то, что задается в начале скрипта)
        $('body').on('click', '.selectBox > p.valueTag', function (event) {

            $(this).text($(this).data('label'));
            $(this).removeClass('mod_axeld_credit_error');

            var THIS = $(this).parents('.selectBox');
            // вычисление высоты объекта методом height()
            var currentHeight = THIS.height();
            // проверка условия на совпадение/не совпадение с заданной высотой вначале,
            // чтобы понять. что делать дальше.
            if (currentHeight < 100 || currentHeight == selectDefaultHeight) {
                // если высота блока не менялась и равна высоте, заданной по умолчанию,
                // тогда мы открываем список и выбираем нужный элемент.


                    Items = (Number(THIS.find('li').length * 44)) + 50;
                    THIS.height(Items + "px");




                // здесь стилизуем нашу стрелку и делаем анимацию средствами CSS3
                THIS.find('img.arrow').css({borderRadius: "1000px", transition: ".2s", transform: "rotate(180deg)"});
            }


            // иначе если список развернут (высота больше или равна 250 пикселям),
            // то при нажатии на абзац с классом valueTag, сворачиваем наш список и
            // и присваиваем блоку первоначальную высоту + поворот стрелки в начальное положение
            if (currentHeight > 50) {
                THIS.height(selectDefaultHeight);
                THIS.find('img.arrow').css({transform: rotateDefault});
                THIS.find('li').removeClass('active');

            }
        });

        // так же сворачиваем список при выборе нужного элемента
        // и меняем текст абзаца на текст элемента в списке
        $('body').on('click', 'li.option', function (event) {

            var THIS = $(this).parents('.selectBox');

            THIS.find('li').removeClass('active');
            $(this).addClass('active');

            THIS.height(selectDefaultHeight);
            THIS.find('img.arrow').css({transform: rotateDefault});
            THIS.find('p.valueTag').text($(this).text());
        });
    };
})(jQuery);
