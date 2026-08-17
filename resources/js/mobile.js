//todo:jquery
$(document).ready(function () {

    /**
     *
     * */
    $('.mobile_version__logo').html($('.header_bottom .logo').html());
    $('.mobile_version__social').html($('.header_top .top_social').html());


    $('body').on('click', 'div.m_f', function (event) {

        let mf = $(this).data('mf');

        if ($(this).hasClass('active')) {

            $('.tab_plane').hide();
            $('.mob_menu_content').fadeOut();
            $(this).removeClass('active');

        } else {

            $('.tab_plane').hide();

            $('.mob_menu_content_absol .tab_plane').each(function (index) {
                if ($(this).data('mf') == mf) {
                    $(this).show();
                }
            });

            $('.mob_menu_content').fadeIn();
            $('.m_f').removeClass('active');
            $(this).addClass('active');
        }
    });


    $('body').on('click', '.m_m_top_close', function (event) {

        $('.mob_menu_content').fadeOut();
        $('.m_f').removeClass('active');

    });

    $('body').on('click', '.m_click__js', function (event) {
        // заголовок раздела может быть ссылкой (например «О нас») —
        // тогда клик по нему ведёт на страницу, а подменю раскрывается
        // только стрелкой справа (.parent__st_after)
        if ($(event.target).closest('a').length) return;

        let nextDiv =  $(this).next();

        $(this).find('.parent__st_after ').toggleClass('up');
        nextDiv.slideToggle();
    });


    let route = $('.content_').data('route-name');

    $.ajax({
        url: "/mobile.menu",
        method: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            'route' : route,
        },
        success: function (response) {
            if (response.error) {
                console.log(response.error);
            } else {
                if (response.menu) {

                   /** переделал третий раз **/
                 /*   let menu = $('.fMenu');
                    menu.append(response.menu);


                        $('body').on('click', '.m_click__js', function (event) {
                           let nextDiv =  $(this).next();

                            $(this).find('.parent__st_after ').toggleClass('up');
                            nextDiv.slideToggle();
                        });*/


                }

            }
        }
    });




    /* добавляем в мобильное меню пункты у который есть class="add__mobile_menu"  */
    /** изменил все это **/

/*    $('.add__mobile_menu').each(function (index) {
        let active;
        if ($(this).hasClass('active')) {
            active = 'active';
        } else {
            active = '';
        }

        let menu = $('.fMenu');
        let arrow = '';
        let before_div = '';
        let after_div = '';

        if ($(this).hasClass('add_arrow')) {
            arrow = '<span class="parent__st_after mactive"></span>';
        }
        if ($(this).hasClass('add_before_div')) {
            before_div = '<p class="' + index + '">';
        }

        if ($(this).hasClass('add_after_div')) {
            after_div = '</p>';
        }

        console.log('before - ')
        console.log(before_div)
        console.log('after - ')
        console.log(after_div)

        menu.append(before_div + '<span class="__li"><a class="' + active + '" href="' + $(this).attr('href') + '">' + $(this).text().trim() + '</a>' + arrow + '</span>' + after_div);


    });*/

    /* добавляем в мобильное меню пункты у который есть class="add__mobile_menu"  */

});
