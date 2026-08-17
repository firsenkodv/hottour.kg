//todo:jquery
import { export_user } from './include/user_ecxel';
import { canche_contacts } from './include/canche_contacts';
import { change_tabs } from './include/change_search_forms';
import { scroll } from './include/scroll';
import { cabinetMenuOverflow } from './include/cabinet_menu';
import { faqAccordion } from './include/site/faq';
import { descCollapse } from './include/desc-collapse';

document.addEventListener('DOMContentLoaded', function () {

    faqAccordion(); // FAQ аккордеон (x-modules.faq, перенесён из generalre)
    descCollapse(); // свернуть описание до первого абзаца (x-content.collapse, из hseipaa.kz)

    /**
     * Внедрение
     */

    class MyEl extends HTMLElement {
        constructor() {
            super();
            this.attachShadow({mode:'open'}).innerHTML = `<style>#Show_hotels {padding: 0;}#root{ padding: 15px 15px 5px !important;}</style>`;
        }
    }
   // customElements.define('tp-cascoon', MyEl);
   // setTimeout( customElements.define('tp-cascoon', MyEl) , 2000);



    if($('.slick_slider__carusel').length) {

        $('.slick_slider__carusel').slick({
            slidesToShow: 5,
            slidesToScroll: 2,
            // centerMode: true,
            swipeToSlide: true,
            variableWidth: true,
            infinite: true,
            speed: 700,
            autoplay: true,
            autoplaySpeed: 7000,
        });
    }

    if($('.slick_slider__popularscarusel').length) {

        $('.slick_slider__popularscarusel').slick({
            slidesToShow: 4,
            slidesToScroll: 3,
            // centerMode: true,
            swipeToSlide: true,
            variableWidth: true,
            infinite: true,
            speed: 700,
            autoplay: true,
            autoplaySpeed: 7000,
        });
    }

    $('body').on('click', '.h_sw .click_slider_hot_p__js', function (event) {
     $('.slick_slider__carusel  .slick-prev').trigger('click');
    });

    $('body').on('click', '.h_sw .click_slider_hot_n__js', function (event) {
     $('.slick_slider__carusel  .slick-next').trigger('click');
    });


    $('body').on('click', '.p_sw .click_slider_p__js', function (event) {
     $('.slick_slider__popularscarusel  .slick-prev').trigger('click');
    });

    $('body').on('click', '.p_sw .click_slider_n__js', function (event) {
     $('.slick_slider__popularscarusel  .slick-next').trigger('click');
    });


    // Блок отзывов (r_sw) переведён на Swiper, см. swiper.js — инициализация
    // .swiper_responce. Прежний slick висел на том же .swiper-wrapper и
    // перестраивал разметку под себя, из-за чего у Swiper обнулялся список
    // слайдов и карусель не листалась. Кнопки обслуживает navigation Swiper
    // (.swiper-button-prev/next-swiper_responce на тех же элементах).


    $('body').on('click', '.b_nav .click_slider_p__js', function (event) {
        $('.slick_slider__bannercarusel  .slick-prev').trigger('click');
    });

    $('body').on('click', '.b_nav .click_slider_n__js', function (event) {
        $('.slick_slider__bannercarusel  .slick-next').trigger('click');
    });


});

$(document).ready(function () {

    /**
     * input движение label
     * */
    var show = 'show';

    $('.inputClass').each(function (index) {
        let label = $(this).next('label');
        if ($(this).val() != '') {
            label.addClass(show);
        }
    });
    $('.inputClass').change(function () {
        let label = $(this).next('label');
        if ($(this).val() != '') {
            label.addClass(show);
        }

    });


    $('.inputClass').on('checkval', function () {
        let label = $(this).next('label');


        if ($(this).val() != '') {
            label.addClass(show);
        } else {
            label.removeClass(show);
        }


    }).on('keyup', function () {
        $(this).trigger('checkval');
    });

    /* удаление рамки при error */
    $('input[type="text"], input[type="date"], input[type="password"], input[type="email"], textarea').focus(
        function () {
            $(this).parents('.text_input').find('.errorBlade').text('');
            $(this).removeClass('_is-error');
        }
    );
    /* удаление рамки при error */

    /* управление иконками connect */
    $(document).ready(function () {
        $('body').on('click', '.connection_fixed', function (event) {
            $('.connect_send').removeClass('close');
            $('.connection_fixed').fadeOut();
            $('.connection_absol').slideUp(600);

        });
        $('body').on('click', '.connect_send', function (event) {
            $(this).toggleClass('close');

            if ($('.connect_send').hasClass('close')) {

                $('.connection_fixed').fadeIn();
                $('.connection_absol').slideDown(600);
            } else {

                $('.connection_fixed').fadeOut();
                $('.connection_absol').slideUp(600);
            }

        });

    });


    /* -- страны countrymenu -- */

    $('body').on('click', '.parent__st_after', function (event) {

        //   $('.eee__2021').removeClass('active');
        //   $('.eee__2021').find('.nav_child_st').slideUp();
        $(this).parents('.eee__2021').find('.nav_child_st').slideToggle();
        $(this).parents('.eee__2021').addClass('active');

    });


    /* -- страны countrymenu -- */

    let w_loader = $('.swiper_hottours__wrap').find('.wrapper_loader');
    setTimeout(function () {
        w_loader.removeClass('active');
    }, 1000);


    /* -- закрытие flash  -- */

    $('body').on('click', '.flashClose__js', function (event) {
        $(this).parents('.flashMassege').slideUp(100);
    });

    /* -- закрытие flash  -- */

    /* Календари (дата рождения в кабинете, даты вылета в модалках и поиске)
       инициализируются единым модулем js/datepicker.js — разметка через
       компонент <x-forms.datepicker> */

    /* -- селекты модальных форм -- */

    // селекты города и страны в форме «Подобрать тур».
    // Отдельный класс, чтобы не пересекаться с .js-chosen форм поиска,
    // где chosen инициализируется своим скриптом со своими настройками
    if ($.fn.chosen && $('.js-chosen-form').length) {
        $('.js-chosen-form').chosen({
            width: '100%',
            disable_search_threshold: 10,
            allow_single_deselect: true,
            no_results_text: 'Ничего не найдено',
        });
    }



    /* Редактирование important  */
    $('body').on('click', '.survey__absolute .surveyJs', function (event) {
        $(this).prev('.surveyMenuEdit').slideToggle();
    });


    /* Проверка перед отправкой формы */

    $('.checkbox__js form').on('submit', function () {
        const inputArray = [];

        $('.checkbox_change:checkbox:checked').each(function(){
            inputArray.push($(this).val());
        });

        $('#ids').val(inputArray);
         console.log($('#ids').val());

         return true;

    });

    /* Проверка перед отправкой формы */

    /* Открытия значка вопроса*/

    $('body').on('click','.textnohtml_rel', function(event){
        $(this).find('i').slideToggle();
    });

    /* Открытия значка вопроса*/



});

/**
 * Меню в ЛК menu_cab_m__js
 */

$('body').on('click','.menu_cab_m__js', function(event){

    $(this).parents('.v_s_c').find('.v_s_c__flex').slideToggle();


});




/**
 * Меню в ЛК menu_cab_m__js
 */

/**
 * поиск по чекбоксам
 */


$('#filter_jq').on('keyup', function () {
    var query = this.value.toUpperCase();
    $('#hotels-area .checkbox_choice__item').each(function (i, elem) {
        if ($(this).text().indexOf(query) != -1) {
            $(this).show();
            $(this).prev(':checkbox').show();
        } else {
            $(this).hide();
            $(this).prev(':checkbox').hide();
        }
    });
});


/**
 *  ///поиск по чекбоксам
 */



/**
 *  ///корзина список отелей и туров
 */

$('body').on('click', '.hotel_about__js', function (event) {

    let Parent = $(this).parents('.search_result__tour');
    Parent.find('.hotel_about').slideToggle();
    Parent.find('.hotel_map').slideUp();
    Parent.find('.hotel_price').slideUp();
});

$('body').on('click', '.hotel_map__js', function (event) {

    let Parent = $(this).parents('.search_result__tour');
    Parent.find('.hotel_map').slideToggle();
    Parent.find('.hotel_about').slideUp();
    Parent.find('.hotel_price').slideUp();
});

$('body').on('click', '.hotel_price__js', function (event) {

    let Parent = $(this).parents('.search_result__tour');
    Parent.find('.hotel_price').slideToggle();
    Parent.find('.hotel_about').slideUp();
    Parent.find('.hotel_map').slideUp();

});

$('body').on('click', '.search_result__button', function (event) {

    let Parent = $(this).parents('.search_result__tour');
    Parent.find('.hotel_price').slideToggle();
    Parent.find('.hotel_about').slideUp();
    Parent.find('.hotel_map').slideUp();

});

$('body').on('click', '#MainCart .roll_back_js', function (event) {

    let Parent = $(this).parents('.search_result__tour');
    Parent.find('.hotel_about').slideUp();
    Parent.find('.hotel_map').slideUp();
    Parent.find('.hotel_price').slideUp();

});





/**
 *  ///корзина список отелей и туров
 */


/**
 *  ///удаление отелей из корзины
 */


$('body').on('click', '.favourites2', function (event) {


    $(this).parents('.search_result__tour').remove();

    // our object array
    let big_data = [];

    $('#resultHotel .search_result__tour').each(function( index ) {

            let object = {};

            object.hotel = $(this).data('id');
            big_data.push(object);

    });


    //   console.log($(this).parents('.search_result__tour').data('id'));
    $('.tour_data').attr('value',  JSON.stringify(big_data));

});



/**
 *  ///удаление отелей из корзины
 */


/**
 *  Старый поиск
 */




$('body').on('click','.ss_tours2__js .sst_', function(event){

    $('.ss_tours2__js .sst_').removeClass('active');
    $('.s_result_2 .s_result_relative').removeClass('active');
    $(this).addClass('active');
    var Res = $(this).data('res');
    $('.s_result_2 .'+Res).addClass('active');


});

/**Старый поиск
 */


/**
 *  плавает header
 */


$(window).scroll(function () {
    if ($(window).scrollTop() > 0) {
        //$('.offset').css({position: 'fixed', top: '0px'});
        $('.background_282828').removeClass('home');

    } else {
        $('.background_282828').addClass('home');
    }
})

if ($(window).scrollTop() > 0) {
    $('.background_282828').removeClass('home');

} else {
    $('.background_282828').addClass('home');
}

/**
 * разворот
 */

$('body').on('click','.imgtemp__search__js', function(event){

    $('.shower_search__js').show();
});

/**
 * сворот
 */

$('body').on('click','.cancel-circle__js', function(event){

    $('.shower_search__js').hide();
});


/**Старый поиск
 */





export_user()          // получения списка пользоваетей в excel
canche_contacts()      // смена контактов на сайте
change_tabs()          // табы поиска на главной
scroll()               //
cabinetMenuOverflow()  // overflow-кнопка "ещё" в меню ЛК















