import {Fancybox} from "@fancyapps/ui";



const openTModalFancySurvey = (e) => {
    Fancybox.show([{src: "#survey", type: "inline",  touch: false}]);
}

const openTModalFancyUserSurvey = (e) => {
    Fancybox.show([{src: "#survey_user", type: "inline",  touch: false}]);
}

const openTModalFancySubscription = (e) => {
    Fancybox.show([{src: "#subscription_tour", type: "inline",  touch: false}]);
}


const openTModalFancyPinktourOrdermini = (e) => {
    Fancybox.show([{src: "#pink_tour_order_mini", type: "inline",  touch: false}]);
}



function ajaxSurvey (star, params =  null) {

    var Parents = $('.F_form_survey');
    loader(Parents);


    $.ajax({
        url: "/search.survey",
        method: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            'star' : star,
            'params' : params,
            "url": url(),
        },
        success: function (response) {
            if (response.error) {
                console.log(response.error);
            } else {
                console.log(response.responce);
                console.log(response.result);
                $('._ssurvey__js').fadeOut(500, function(){ $(this).remove();});


                setTimeout(function () {
                    Parents.find('.wrapper_loader ').css('display', 'none');
                    Parents.find('.F_form__body').hide();
                    Parents.find('.F_responce').show();
                }, 1000);


            }
        }
    });
}



function ajaxSurveyUser (star, params =  null) {

    var Parents = $('.F_form_survey');
    loader(Parents);


    $.ajax({
        url: "/search.survey.user",
        method: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            'star' : star,
            'params' : params,
            "url": url(),
        },
        success: function (response) {
            if (response.error) {
                console.log(response.error);
            } else {
                console.log(response.responce);
                console.log(response.result);
                $('.survey_user_wrapp__js').fadeOut(500, function(){ $(this).remove();});


                setTimeout(function () {
                    Parents.find('.wrapper_loader ').css('display', 'none');
                    Parents.find('.F_form__body').hide();
                    Parents.find('.F_responce').show();
                }, 1000);


            }
        }
    });
}





function loader(Parents) {
    Parents.find('.wrapper_loader ').css('display', 'flex');
}

function loaderHide(Parents) {
    Parents.find('.wrapper_loader ').css('display', 'none');
}

function printErrorMsg(Parents, msg) {
    $.each(msg, function (key, value) {

        console.log(key);
        console.log(' -- ');
        console.log(msg);

        Parents.find('.error_' + key).text(value);
        Parents.find('input.' + key).addClass('_is-error');
        Parents.find('textarea.' + key).addClass('_is-error');
    });
}

function url() {
    return window.location.href;

}
function UpperFirstLetter(hotel){
    let toLowerCase =  hotel.toLowerCase();
    var textArray =  toLowerCase.split(' ');
    var UpperText = [];
    for(var i = 0; i < textArray.length; i++){
        var word = textArray[i][0].toUpperCase() + textArray[i].slice(1);
        UpperText.push(word);
    }

   return UpperText.join(" ");
}


//todo:jquery
$(document).ready(function () {

    /* cities desktop */

    $('body').on('click', '.top_sity_js', function (event) {
        $('.top_sity_active_js').slideToggle();
        $(this).toggleClass('active');

    });

    $('body').on('click', '.tps_sity_title_js', function (event) {
        let Parents = $(this).parents('.top_sity_js');
        var Text = $(this).text();
        $('.tps_sity_title_js').removeClass('active');
        $(this).addClass('active');


        $('.top_sity_active_js').slideToggle();
        var Token = $('.top_sity_js').data('token');
        $.ajax({
            url: "/set-sity/city-action",
            method: "POST",
            data: {
                "_token": Token,
                "sity": Text,
            },
            success: function (response) {
                $('.h_s_sity_js').text(response.sity);
                // console.log(response.sity);
            }
        });

    });

    /* cities desktop */

    /* order call */
    $('body').on('click', '.order_call_js', function (event) {

        var Parents = $(this).parents('.F_form');
        var Phone = Parents.find('input[name="phone"]').val();
        var Sity = Parents.find('[name="sity"]').val();
        var Crm = Parents.find('input[name="crm"]').val();
        var Token = Parents.data('token');

        loader(Parents);

        $.ajax({
            url: "/send-mail/order-call",
            method: "POST",
            data: {
                "_token": Token,
                "crm": Crm,
                "phone": Phone,
                "sity": Sity,
                "url": url(),
            },
            success: function (response) {

                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);


                } else {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__body').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
                //  console.log(response);

            }
        });

    });
    /* order call */

    /* order call  (mini форма на главной)*/
    $('body').on('click', '.order_mini_js', function (event) {

        var Parents = $(this).parents('.F_form');
        var Name = Parents.find('input[name="name"]').val();
        var Phone = Parents.find('input[name="phone"]').val();
        var Email = Parents.find('input[name="email"]').val();
        var Crm = Parents.find('input[name="crm"]').val();
        var Token = Parents.data('token');
        loader(Parents);

        $.ajax({
            url: "/send-mail/order-mini",
            method: "POST",
            data: {
                "_token": Token,
                "crm": Crm,
                "name": Name,
                "phone": Phone,
                "email": Email,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);

                } else {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__body').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
            }
        });

    });
    /* order call  (mini форма на главной)*/

    /* кредитный калькулятор*/
    $('body').on('click', '.calc_js', function (event) {

        var Parents = $(this).parents('.F_form');
        var Name = Parents.find('input[name="name"]').val();
        var Phone = Parents.find('input[name="phone"]').val();
        var Email = Parents.find('input[name="email"]').val();

        var Bank = Parents.find('input[name="bank"]').val();
        var Credit = Parents.find('input[name="credit"]').val();
        var Month = Parents.find('input[name="month"]').val();

        var Bet = Parents.find('input[name="bet"]').val();
        var Term = Parents.find('input[name="term"]').val();
        var Monthly_payment = Parents.find('input[name="monthly_payment"]').val();
        var Overpayment = Parents.find('input[name="overpayment"]').val();
        var Total_payout = Parents.find('input[name="total_payout"]').val();

        var Crm = Parents.find('input[name="crm"]').val();
        var Token = Parents.data('token');

/*        console.log(Name);
        console.log(Phone);
        console.log(Email);
        console.log(Bank);
        console.log(Credit);
        console.log(Month);

        console.log(Bet);
        console.log(Term);
        console.log(Monthly_payment);
        console.log(Overpayment);
        console.log(Total_payout);
        console.log(Crm);
        console.log(Token);
        return false;*/

        loader(Parents);

        $.ajax({
            url: "/send-mail/calc",
            method: "POST",
            data: {
                "_token": Token,
                "crm": Crm,
                "name": Name,
                "phone": Phone,
                "email": Email,
                "bank": Bank,
                "credit": Credit,
                "month": Month,
                "bet": Bet,
                "term": Term,
                "monthly_payment": Monthly_payment,
                "overpayment": Overpayment,
                "total_payout": Total_payout,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);

                } else {
                    setTimeout(function () {

                        console.log(response);
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__body').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
            }
        });

    });
    /* кредитный калькулятор*/


    /* take a tour in the holel  */
    $('body').on('click', '.tour_button_js', function (event) {



        var dataJson = $(this).data("tout_data");

       // console.log(dataJson);




        //  const jsonObject = JSON.parse(Data);
        let price = dataJson.price.toLocaleString();
        let currency = dataJson.currency;
        let dateFrom = dataJson.dateFrom;
        let dateTo = dataJson.dateTo;
        let nights = dataJson.nights;
        let room = dataJson.room;
        let mealrussian = dataJson.mealrussian;
        let meal = dataJson.meal;
        let adults = dataJson.adults;
        var childs = dataJson.child;
        var tourname = dataJson.tourname;
        let sity = dataJson.sity;
        let hotel = UpperFirstLetter(dataJson.hotel);

        let country = dataJson.country;
        let hotelregionname = dataJson.hotelregionname;
        let stars = dataJson.stars;
        let starsHtml =  '<img width="18" height="18" loading="lazy" alt="hotel__redstar" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTE3LjcxNDMgNi41ODcxOEMxNy42MTY2IDYuMjg2NzYgMTcuMzM2NiA2LjA4MzMyIDE3LjAyMDggNi4wODMzMkgxMS40Njk3TDkuNjkxMjYgMC43NDg3NDlDOS41OTIwOSAwLjQ1MTI1IDkuMzEzNTUgMC4yNSA4Ljk5OTI4IDAuMjVDOC42ODUwMSAwLjI1IDguNDA3MiAwLjQ1MDUyIDguMzA3MyAwLjc0ODc0OUw2LjUyODg3IDYuMDgzMzJIMC45NzkxOTRDMC42NjM0NjUgNi4wODMzMiAwLjM4MzQ2NiA2LjI4Njc2IDAuMjg1NzU3IDYuNTg3MThDMC4xODgwNDkgNi44ODc1OSAwLjI5NTIzNyA3LjIxNjQ0IDAuNTUwNDQ0IDcuNDAyMzhMNS4wMDkyOSAxMC42NDU3TDMuMjAzODggMTYuMDYxMkMzLjEwMzk4IDE2LjM2MDkgMy4yMDgyNSAxNi42OTA1IDMuNDYyIDE2Ljg3ODZDMy43MTY0OCAxNy4wNjY3IDQuMDYyMSAxNy4wNjg5IDQuMzE4NzcgMTYuODg1OUw4Ljk5OTI4IDEzLjU0MjdMMTMuNjc5OCAxNi44ODU5QzEzLjgwNjcgMTYuOTc2MyAxMy45NTQ3IDE3LjAyMTUgMTQuMTAzNCAxNy4wMjE1QzE0LjI1NTggMTcuMDIxNSAxNC40MDc1IDE2Ljk3NDEgMTQuNTM2NiAxNi44Nzg2QzE0Ljc5MDMgMTYuNjkxMiAxNC44OTQ2IDE2LjM2MTYgMTQuNzk0NyAxNi4wNjEyTDEyLjk4OTMgMTAuNjQ1N0wxNy40NDgxIDcuNDAyMzhDMTcuNzA0OCA3LjIxNjQ0IDE3LjgxMiA2Ljg4Njg2IDE3LjcxNDMgNi41ODcxOFoiIGZpbGw9IiNFRjUzM0YiLz4KPC9zdmc+Cg=="><span>'+ stars +'</span>.0'


        if($('.hbox__top .h1').length) {
            $('.hotel_name_js .F_country').html($('.hbox__top .h1').html());
        } else {
            $('.hotel_name_js .F_country').html(country);
        }

        $('.hotel_name_js .F_h1 .m__hotel_name').html(hotel);


        if($('.hotel__title .hotel__redstar').length) {
            $('.hotel_name_js .F_h1 .m__hotel_stars').html($('.hotel__title .hotel__redstar').html());
        } else {

            $('.hotel_name_js .F_h1 .m__hotel_stars').html(starsHtml);

        }



        if(mealrussian) {
            $('.hotel_name_js .F_h2 strong').html(meal + ' ' +mealrussian);
        } else if(meal)  {
            $('.hotel_name_js .F_h2 strong').html(meal);
        }

        $('.m__hotel_sity strong').html(sity);
        $('.m__hotel_from strong').html(dateFrom);
        $('.m__hotel_to strong').html(dateTo);
        $('.m__hotel_nights strong').html(nights);
        $('.m__hotel_adults strong').html(adults);

        if(childs) {
            $('.m__hotel_childs').html('<span>Детей:</span> <strong>' + childs + '</strong>');
            $('.m__hotel_childs').attr('data-childs', '<span>Детей:</span> <strong>' + childs + '</strong>');
        } else {
            $('.m__hotel_childs').attr('data-childs', '<span>Детей:</span> <strong>--</strong>');
        }

        if(room) {
            $('.m__hotel_room').html('<span>Номер:</span> <strong>' + room + '</strong>');
        }
        if(hotelregionname) {
            $('.m__hotel_hotelregionname').html('<span>Регион:</span> <strong>' + hotelregionname + '</strong>');
        }

        if(hotel.length<27) {
            if(tourname) {
                $('.m__hotel_tourname').html('<span>Тур:</span> <strong>' + tourname + '</strong>');
            }
        }
        $('.m__hotel_tourname').attr('data-tourname', '<span>Тур:</span> <strong>' + tourname + '</strong>');
        $('.m__hotel_price strong').html(price);
        $('.m__hotel_price .__currency').html(currency);

    });


    $('body').on('click', '.send_order_tour_js', function (event) {

        var Parents = $(this).parents('.F_form');

        var Country = Parents.find('.hotel_name_js .F_country').text();
        var Hotel = Parents.find('.hotel_name_js .F_h1 .m__hotel_name').html();
        var Mealrussian = Parents.find('.hotel_name_js .F_h2').html();
        var Sity = Parents.find('.m__hotel_sity').html();
        var From = Parents.find('.m__hotel_from').html();
        var To = Parents.find('.m__hotel_to').html();
        var Nights = Parents.find('.m__hotel_nights').html();
        var Adults = Parents.find('.m__hotel_adults').html();
        var Childs = Parents.find('.m__hotel_childs').data('childs');
        var Room = Parents.find('.m__hotel_room').html();
        var Tourname = Parents.find('.m__hotel_tourname').data('tourname');
        var Price = Parents.find('.m__hotel_price').html();

        var Name = Parents.find('input[name="name"]').val();
        var Phone = Parents.find('input[name="phone"]').val();
        var Email = Parents.find('input[name="email"]').val();


        loader(Parents);

        $.ajax({
            url: "/send-mail/send_order_tour",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "country": Country,
                "hotel": Hotel,
                "mealrussian": Mealrussian,
                "sity": Sity,
                "from": From,
                "to": To,
                "nights": Nights,
                "adults": Adults,
                "childs": Childs,
                "room": Room,
                "tourname": Tourname,
                "price": Price,

                "name": Name,
                "phone": Phone,
                "email": Email,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);

                } else {
                    setTimeout(function () {
                        console.log(response);
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__pick ').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
            }
        });

    });





    /* take a tour in the holel  */


    /* pick_tour  ( форма на главной и в модуле правый везде )*/
        $('body').on('click', '.pick_tour_button_js', function (event) {
        var Country = $(this).data('country');
        $('#pick_tour').attr('data-country',Country );
    });

    $('body').on('click', '.pick_tour_js', function (event) {
        var Date, Sity, Country, Url;
        var Parents = $(this).parents('.F_form');
        var Name = Parents.find('input[name="name"]').val();
        var Phone = Parents.find('input[name="phone"]').val();
        var Email = Parents.find('input[name="email"]').val();
        if(Parents.find('input[name="date"]').length) {
            Date = Parents.find('input[name="date"]').val();
        } else {
            Date = '-';
        }
        // город может быть не выбран (в селекте стоит подсказка) —
        // тогда в заявке прочерк, а не пустая строка
        Sity = Parents.find('[name="sity"]').val() || '-';
        // страна: выбранная в форме важнее подставленной страницей (data-country),
        // селектор без input — в форме подбора тура это <select>
        var CountryField = Parents.find('[name="country"]');

        if(CountryField.length && CountryField.val()) {
            Country = CountryField.val();

        } else if(String(Parents.data('country') || '').length) {
            Country = Parents.data('country');

        } else {
            Country = '-';

        }
        var Crm = Parents.find('input[name="crm"]').val();
        var Token = Parents.data('token');
        loader(Parents);


        /**
         * ОДИН js на два маршрута
         * 1) подбор тура
         * 2) подписаться на рассылку
         */

        if(Parents.is('[data-subscription]')) {
            Url = "/send-mail/pick_subscription";
        } else {
            Url = "/send-mail/pick_tour";
        }

        $.ajax({
            url: Url,
            method: "POST",
            data: {
                "_token": Token,
                "crm": Crm,
                "name": Name,
                "date": Date,
                "phone": Phone,
                "email": Email,
                "sity": Sity,
                "country": Country,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);

                } else {
                    setTimeout(function () {
                        console.log(response);
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__pick ').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
            }
        });

    });
    /* pick_tour  ( форма на главной)*/


    /* certificate_order ( форма покупки сертификата, страница /sertifikaty )*/

    // кнопка «Получить сертификат»: переносим в форму выбранную вкладку
    // (физическим/юридическим лицам) и отмеченный номинал
    $('body').on('click', '.certificate_order_button_js', function (event) {
        var Panel = $(this).closest('.cert__panel');
        var Audience = Panel.data('audience') || '';

        // произвольная сумма важнее готового номинала: если её ввели,
        // выбор номинала уже снят (см. certificates.js)
        var Custom = $.trim(Panel.find('.cert__custom-input').val() || '');
        var Amount = Custom !== ''
            ? Custom + ' ₸'
            : Panel.find('.cert__sum-radio:checked').next('.cert__sum').text().trim();

        var Form = $('#certificate_order');

        Form.find('.cert_order__audience').text(Audience);
        Form.find('.cert_order__amount').text(Amount);
        Form.find('input[name="audience"]').val(Audience);
        Form.find('input[name="amount"]').val(Amount);
    });

    $('body').on('click', '.certificate_order_js', function (event) {
        var Parents = $(this).parents('.F_form');
        var Name = Parents.find('input[name="name"]').val();
        var Phone = Parents.find('input[name="phone"]').val();
        var Email = Parents.find('input[name="email"]').val();
        var Audience = Parents.find('input[name="audience"]').val();
        var Amount = Parents.find('input[name="amount"]').val();
        var Crm = Parents.find('input[name="crm"]').val();
        var Token = Parents.data('token');
        loader(Parents);

        $.ajax({
            url: "/send-mail/certificate-order",
            method: "POST",
            data: {
                "_token": Token,
                "crm": Crm,
                "name": Name,
                "phone": Phone,
                "email": Email,
                "audience": Audience,
                "amount": Amount,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);

                } else {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__body').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
            }
        });

    });
    /* certificate_order */


    /* responce  ( форма на всех )*/
    $('body').on('click', '.pick_responce_js', function (event) {

        var Parents = $(this).parents('.F_form');
        var Name = Parents.find('input[name="name"]').val();
        var Email = Parents.find('input[name="email"]').val();
        var Response = Parents.find('#textarea_responce').val();
        var Crm = Parents.find('input[name="crm"]').val();
        var Token = Parents.data('token');
        loader(Parents);


        $.ajax({
            url: "/send-mail/pick_responce",
            method: "POST",
            data: {
                "_token": Token,
                "crm": Crm,
                "name": Name,
                "email": Email,
                "responce": Response,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        printErrorMsg(Parents, response.error);
                    }, 1000);

                } else {
                    setTimeout(function () {
                        console.log(response);
                        Parents.find('.wrapper_loader ').css('display', 'none');
                        Parents.find('.F_form__pick ').hide();
                        Parents.find('.F_responce').show();
                    }, 1000);
                }
            }
        });

    });
    /* pick_tour  ( форма на главнойб и в модуле правый везде )*/
    /* responce  ( форма на всех )*/

    /*   (выводим описание на странице отеля через tourvior )   */

    if ($('#getHotelInfo').length) {

        var This = $('#getHotelInfo');
        var Reviews = $('#getHotelReviews');
        var Token = $('#getHotelInfo').data('token');
        loader(This);

        $.ajax({
            url: "/get-hotel-info",
            method: "POST",
            data: {
                "_token": Token,
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    setTimeout(function () {
                        This.find('.wrapper_loader ').css('display', 'none');
                    }, 1000);

                } else {
                    console.log(response);
                    var hotel = response.hotel.data.hotel;

                    let build = '';
                    let repair = '</li>';
                    let square = '';
                    let roomtypes = '';

                    if (hotel.build) {
                        build = '<li>год строительства: ' + hotel.build;
                    }
                    if (hotel.repair) {
                        repair = ', ремонт: ' + hotel.repair + '</li>';
                    }
                    if (hotel.square) {
                        square = '<li>площадь: ' + hotel.square + '</li>';
                    }

                    This.append('<div class="servise_item hotel_build"><h4>Отель <span>' + hotel.name + '</span></h4><div class="desc"><ul>' + build + ' ' + repair + '' + square + '</ul></div></div>');

                    if (hotel.territory) {
                        This.append('<div class="servise_item hotel_territory"><h4>Территория</h4><div class="desc">' + hotel.territory + '</div></div>');
                    }
                    if (hotel.beach) {
                        This.append('<div class="servise_item hotel_beach"><h4>Пляж</h4><div class="desc">' + hotel.beach + '</div></div>');
                    }
                    if (hotel.roomtypes) {
                        This.append('<div class="servise_item hotel_roomtypes"><h4>Номер</h4><div class="desc">' + hotel.roomtypes + '</div></div>');
                    }
                    if (hotel.inroom) {

                        This.append('<div class="servise_item hotel_inroom"><h4>В номере</h4><div class="desc">' + hotel.inroom + '</div></div>');
                    }
                    if (hotel.mealtypes) {

                        This.append('<div class="servise_item hotel_mealtypes"><h4>Питание</h4><div class="desc">' + hotel.mealtypes + '</div></div>');
                    }
                    if (hotel.child) {

                        This.append('<div class="servise_item hotel_child"><h4>Для детей</h4><div class="desc">' + hotel.child + '</div></div>');
                    }

                    if (hotel.servicefree) {

                        This.append('<div class="servise_item hotel_servicefree"><h4>Бесплатно</h4><div class="desc">' + hotel.servicefree + '</div></div>');
                    }

                    if (hotel.servicepay) {

                        This.append('<div class="servise_item hotel_servicepay"><h4>Платно</h4><div class="desc">' + hotel.servicepay + '</div></div>');
                    }



                    if (hotel.reviews) {
                        Reviews.append('<div class="servise_item hotel_review"><div class="desc">');
                        // console.log(hotel.reviews.review[0]);

                        for (var key in hotel.reviews.review) {
                            if(hotel.reviews.review[key].name) {
                                let name = hotel.reviews.review[key].name;
                                let traveltime = hotel.reviews.review[key].traveltime;
                                let content = hotel.reviews.review[key].content;
                                let rate = 'Оценка' + ': <span>' + hotel.reviews.review[key].rate+ '</span>';

                                Reviews.append('<div class="review_flex flex"><div class="rev1"><div class="rev1__flex"><div class="r_user__icon"></div><div class="r_user__data"><div class="review_ review_name">' + name + '</div><div class="review_ review_traveltime">' + traveltime + '</div><div class="review_ review_rate">' + rate + '</div></div></div></div><div class="rev2"><div class="review_ review_content">' + content + '</div></div>');
                            }
                        }


                        Reviews.append('</div></div>');

                    }
                    setTimeout(function () {
                        This.find('.wrapper_loader ').css('display', 'none');
                    }, 1000);
                }
            }
        });

    } // if

    /*   (выводим описание на странице отеля через tourvior )   */
    /*  загрузка аватара */

    $('.upload_f').change(function(event){
        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            var Parent = $(this).parents('.image-upload__cabinet');
            event.preventDefault();
            let form = $(this).parents('form').get(0);
            let formData = new FormData(form);


            $.ajax({
                async: true,
                url: '/cabinet/upload-avatar',
                headers: {
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                contentType: false,
                data: formData,
                cache : false,
                processData: false,
                success: function(result)
                {
                    console.log(result);

                    if (result.success == true){

                        Parent.find('.site_avatar').css('background-image', 'url("' + result.avatar + '")');
                        $('.enter_to_website__a .site_avatar').css('background-image' , 'url("' + result.avatar + '")');

                    }
                    else {
                        console.log(result);
                        alert('Ошибка при загрузке файла');

                    }
                },
                error: function(data)
                {
                    console.log(data.err);
                    console.log(data);
                }
            });


        }
    });

    /*  загрузка аватара */

    /*  загрузка аватара для менеджера или пользователя адмном */

    $('.upload_f_admin_to_user').change(function(event){
        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            var Parent = $(this).parents('.image-upload__cabinet');
            event.preventDefault();
            let form = $(this).parents('form').get(0);
            let formData = new FormData(form);

            $.ajax({
                async: true,
                url: '/cabinet/upload-avatar-admin-to-user',
                headers: {
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                contentType: false,
                data: formData,
                cache : false,
                processData: false,
                success: function(result)
                {

                    if (result.success == true){

                        Parent.find('.site_avatar').css('background-image', 'url("' + result.avatar + '")');

                        /*      console.log(result.mess);
                              console.log(result.avatar);*/
                    }
                    else {
                        console.log(result);
                        alert('Ошибка при загрузке файла');

                    }
                },
                error: function(data)
                {
                    console.log(data.err);
                    console.log(data);
                }
            });


        }
    });

    /*  загрузка аватара для менеджера или пользователя адмном */


    /* подписание договора */

    $('body').on('click','.signature22', function(event){


        var but = $(this).toggleClass('sending').blur();
        var but2 = $(this).addClass('signature22_loader').blur();

        setTimeout(function(){
            but.removeClass('sending').blur();
            but2.removeClass('signature22_loader').blur();
        },3000);



       var Parent = $(this).parents('.crm__item');
       let Id =  $(this).parents('.t_dog').data('contract');
       var NumContract =  Parent.find('.t_dog__number').text();
       var User_id =  $(this).parents('.crm').data('user');




    $.ajax({
        url: "/cabinet/signing-the-contract",
        method: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": Id,
            "url": url(),
        },
        success: function (response) {
            if (response.error) {
                console.log(response.id);
            } else {
                console.log(response.id);
                console.log(response.responce_crm);
                Parent.find('.signature22').remove();
                Parent.find('.d_red22').text('Договор подписан');
                Parent.find('.d_red22').addClass('d_green22');

                /**
                 * ТУТ будем отправлять письмо пользователю, сообщение о подписании договора.
                 */

               $.ajax({
                    url: "/cabinet/send-signature-email",
                    method: "POST",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        'user_id': User_id,
                        'contract': NumContract,
                    },
                    success: function (response) {

                        console.log(response.data);

                    }
                });







            }
        }
    });


    });
    /* подписание договора */


    /* получение промокода */

    $('body').on('click','.m_promo__js', function(event){

       let Id =  $(this).data('user')

    $.ajax({
        url: "/cabinet/get-promo",
        method: "POST",
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": Id,
            "url": url(),
        },
        success: function (response) {
            if (response.error) {
                console.log(response.id);
                console.log(response.error);
            } else {
              //  console.log(response.id);
                console.log(response.promo_code);
                $('.promoCode__js').text(response.promo_code);

            }
        }
    });


    });

    /* получение промокода */


    /* получение туров в кабинете пользователя */

    if($('#crm').length) {

        loader($('#crm'));

        let UserId = $('.crm').data('user')

        $.ajax({
            url: "/cabinet/get-tours",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'user_id' : UserId
            },
            success: function (response) {
                if (response.error) {
                    console.log(response.error);
                } else {
                    moment.locale('ru');

                    let html = '';

                    response.tours.map((tour, i) => {
                        let info = '';
  if(tour.info) {
    let info = '<span class="textnohtml_rel textnohtml_absol"><i style="display: none;">'+tour.info+'<pr class="b__close">×</pr></i></span>';
 }

                        html +='                                <div class="crm__item t_item">\n' +
                            '                                    <div class="t_item__top flex">\n' +
                            '                                        <div class="t_item__top_left"><span class="t_country">'+tour.to+'</span>\n' + info + '</div>\n' +
                            '                                        <div class="t_item__top_right"><span\n' +
                            '                                                class="t_pay">'+tour.statusname+'</span></div>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="t_item__center flex">\n' +
                            '                                        <div class="t_item__center_left">\n' +
                            '                                            <div class="t_city"><span class="t_city__label">Город вылета:</span>\n' +
                            '                                                <span class="t_city__city">'+tour.from+'</span>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="t_dates">\n' +
                            '                                                <div class="t_from">Вылет: <span>'+moment(tour.datebeg, "YYYY-MM-DD").format('DD.MM.YYYY')+'</span>\n' +
                            '                                                </div>\n' +
                            '                                                <div class="t_to">Прилет: <span>'+moment(tour.dateend, "YYYY-MM-DD").format('DD.MM.YYYY')+'</span></div>\n' +
                            '                                                <div class="t_night">Ночей:<span>'+tour.nights+'</span></div>\n' +
                            '                                            </div>\n' +
                            '                                            <div class="t_hotel">' +
                            '<span class="t_hotel__label">Отель:</span><span class="t_hotel__mane">'+tour.hotelname+'</span></div>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="t_item__center_right">\n' +
                            '\n' +
                            '\n' +
                            '                                            <div\n' +
                            '                                                class="t_price">'+tour.price+' '+tour.currency+'</div>\n' +
                            '\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="t_item__bottom flex">\n' +
                            '                                        <div class="t_item__bottom_left">\n' +
                            '                                            <div class="t_dog" data-contract="'+tour.id+'">Договор № <span\n' +
                            '                                                    class="t_dog__number">'+tour.number+'</span> от <span\n' +
                            '                                                    class="t_dog__date">'+tour.signaturedate22+'</span>  '+tour.podpis+' ' +
                            '                                            </div>\n' +
                            '                                        </div>\n' +
                            '                                        <div class="t_item__bottom_right">\n' +
                            '                                            <div class="t_pdficon">\n' +
                            '                                                <a download="" href="/storage/images/contract/hottour.pdf">Общие условия договора</a>\n' +
                            '                                            </div>\n' +
                            '                                        </div>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="t_line_crm"></div>\n' +
                            '\n' +
                            '                                </div>\n';

                    })
                    $('#crm').html(html);

                    /* Установим сразу новые бонусы */

                    $.ajax({
                        url: "/cabinet/get-newbonus",
                        method: "POST",
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        success: function (response) {
                            $('.pd_bonus').find('span').text(response.bonus);

                        }
                    });

                    /* Установим сразу новые бонусы */
                }
                setTimeout(function () {
                    $('#crm').find('.wrapper_loader ').css('display', 'none');
                }, 1000);

            }
        });

       /* ТЕСТ отправка письма */
      /*  $('body').on('click','.t_dog__number', function(event){

            var Parent = $(this).parents('.crm__item');
            var NumContract =  Parent.find('.t_dog__number').text();
            var User_id =  $(this).parents('.crm').data('user');

            $.ajax({
                url: "/cabinet/send-signature-email",
                method: "POST",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'user_id': User_id,
                    'contract': NumContract,
                },
                success: function (response) {

                    console.log(response.data);

                }
            });


        });*/
       /* ТЕСТ отправка письма */

    }
    /* получение туров в кабинете пользователя */



    /**
     *  ///добавление отеля в избранное (простой польтзователь)
     */

    $('body').on('click', '.favourite_user__js span', function (event) {


        var Parent = $(this).parents('.search_result__tour');
        let HotelId = Parent.data('id');
        let FavoriteId = $(this).data('favoriteid');
        Parent.find('.favourite_user__js i').toggleClass('active');

        if($(this).hasClass('active')) {

            $.ajax({
                url: "/cabinet/delete-favorite",
                method: "POST",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "hotelid": HotelId,
                    'favorite_id' : FavoriteId,
                    'type' : 'delete',
                    "url": url(),
                },
                success: function (response) {
                    if (response.error) {
                        console.log(response.type);
                        console.log(response.error);
                    } else {
                        console.log(response.type);
                        console.log(response.res);

                    }
                }
            });


        } else {



            let tour_data = [];
            let object = {};
            let big_data = [];

            object.hotel = HotelId;

            Parent.find('.hotel_price__table .line_info').each(function() {

                let object_tour = {};
                object_tour.tour = $(this).find('.line_info_btn-wrap a').data('tout_data');
                tour_data.push(object_tour);
            });
            object.tours = tour_data;
            big_data.push(object);

          //  console.log(big_data);


            $.ajax({
                url: "/cabinet/insert-favorite",
                method: "POST",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "hotelid": HotelId,
                    "big_data" : big_data,
                    'favorite_id' : FavoriteId,
                    'type' : 'insert',
                    "url": url(),
                },
                success: function (response) {
                    if (response.error) {
                        console.log(response.type);
                        console.log(response.error);
                    } else {
                        console.log(response.type);
                        console.log(response.data);

                    }
                }
            });

        }

        $(this).toggleClass('active');






    });



    /**
     *  ///добавление отеля в избранное (простой польтзователь)
     */

    /**
     *  ///удаление  отеля из избранное (простой польтзователь)
     */

    $('body').on('click', '.favourite_user_deleteHotel__js', function (event) {


        let FavoriteId = $(this).data('favoriteid');
        var Parent = $(this).parents('.search_result__tour');



            $.ajax({
                url: "/cabinet/delete-favorite2",
                method: "POST",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'favorite_id' : FavoriteId,
                    'type' : 'delete',
                    "url": url(),
                },
                success: function (response) {
                    if (response.error) {
                        console.log(response.type);
                        console.log(response.error);
                    } else {
                        console.log(response.type);
                        console.log(response.res);
                        Parent.remove();

                    }
                }
            });




        $(this).toggleClass('active');

    });



    /**
     *  ///удаление  отеля из избранное (простой польтзователь)
     */


    /**
     *   оценка пользователем сайта  скрипта поиска
     */


    $('body').on('click', '.button_survey__js', function (event) {

        var Parent = $(this).parents('._ssurvey__js');
        let v = Parent.find('input[name="s_star_s"]:checked').val();
        if(v == 1) {
            openTModalFancySurvey();
            return false;
        }

        ajaxSurvey(v)


    });

    $('body').on('click', '.survey_mini_js', function (event) {

        var Parent = $(this).parents('.F_form_survey');


        let checked = [];
        Parent.find('input[name="survey_checkbox"]:checked').each(function() {
            checked.push($(this).val());
        });


        ajaxSurvey(1, checked)

    });


    /**
     *   ////оценка пользователем сайта  скрипта поиска
     */

    /**
     *   оценка пользователем сайта  всего личного кабинета
     */


    $('body').on('click', '.button_survey_user__js', function (event) {

        var Parent = $(this).parents('._ssurvey_user');
        let v = Parent.find('input[name="s_star_s"]:checked').val();
        if(v == 1) {
            openTModalFancyUserSurvey();
            return false;
        }

        ajaxSurveyUser(v)


    });

    $('body').on('click', '.survey_user_mini_js', function (event) {

        var Parent = $(this).parents('.F_form_survey');


        let checked = [];
        Parent.find('input[name="survey_checkbox"]:checked').each(function() {
            checked.push($(this).val());
        });


        ajaxSurveyUser(1, checked)

    });


    /**
     *  /////оценка пользователем сайта  всего личного кабинета
     *  */

    /**
     *  всплывает подписка на горящие туры
     *  */

    setTimeout(function(){

        $.ajax({
            url: "/get.cookie.hottour",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    console.log(response.error);

                } else {
                    console.log(response.getcookie);

                    if(response.result) {
                        console.log('хочу открыть (subscription_form2)');

                        if (!$('.fancybox__container').length > 0 )
                        {
                            openTModalFancySubscription();

                            // ecли посмотрели форму, то установим cookie

                            $.ajax({
                                url: "/set.cookie.hottour",
                                method: "POST",
                                data: {
                                    "_token": $('meta[name="csrf-token"]').attr('content'),
                                    "url": url(),
                                },
                                success: function (response) {

                                    console.log('установили для (subscription_form2)');
                                    console.log(response.setcookie);

                                }
                            });

                        }



                    }
                }
            }
        });

    }, 30000);

    /**
     *   всплывает подписка на стрнаице поиск
     *  */

    setTimeout(function(){

        $.ajax({
            url: "/get.cookie.hottour.find-tour",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "url": url(),
            },
            success: function (response) {
                if (response.error) {
                    console.log(response.error);

                } else {
                    console.log(response.getcookie);

                    if(response.result) {
                        console.log('хочу открыть (mini_form)');

                        if (!$('.fancybox__container').length > 0 )
                        {
                            openTModalFancyPinktourOrdermini();

                            // ecли посмотрели форму, то установим cookie

                            $.ajax({
                                url: "/set.cookie.hottour.find-tour",
                                method: "POST",
                                data: {
                                    "_token": $('meta[name="csrf-token"]').attr('content'),
                                    "url": url(),
                                },
                                success: function (response) {

                                    console.log('установили для (mini_form)');
                                    console.log(response.setcookie);

                                }
                            });

                        }



                    }
                }
            }
        });

    }, 120000);

    /**
     *  /////всплывает подписка на стрнаице поиск
     *  */


    /* договоры: создание и редактирование */

    function escapeAttr(value) {
        return String(value == null ? '' : value).replace(/"/g, '&quot;');
    }

    function contractAdultRow(a, index) {
        a = a || {};
        return '<div class="cf_people_row" data-role="adult-row">' +
            '<input type="text" name="people[adults][' + index + '][fio]" class="input" value="' + escapeAttr(a.fio) + '" placeholder="ФИО">' +
            '<a href="javascript:;" class="cf_remove_row">&times;</a>' +
        '</div>';
    }

    function contractChildRow(c, index) {
        c = c || {};
        return '<div class="cf_people_row cf_people_row_child" data-role="child-row">' +
            '<input type="text" name="people[children][' + index + '][fio]" class="input" value="' + escapeAttr(c.fio) + '" placeholder="ФИО">' +
            '<input type="text" name="people[children][' + index + '][age]" class="input cf_age_input" value="' + escapeAttr(c.age) + '" placeholder="Возраст">' +
            '<a href="javascript:;" class="cf_remove_row">&times;</a>' +
        '</div>';
    }

    function contractRebuildPeople($m, people) {
        people = people || {};
        var adults   = (people.adults && people.adults.length) ? people.adults : [{}];
        var children = (people.children && people.children.length) ? people.children : [{}];

        $m.find('#cf_adults_list').html(adults.map(contractAdultRow).join(''));
        $m.find('#cf_children_list').html(children.map(contractChildRow).join(''));
    }

    var CF_SELECT_FIELDS = [
        'contract_room_id', 'contract_food_id', 'transfer',
        'excursion_program', 'russian_speaking_guide', 'visa_support', 'medical_support'
    ];

    function contractSetSelect($m, field, value) {
        var $wrap = $m.find('#cf_' + field + '_wrap');
        var $item = $wrap.find('.select__item[data-option="' + (value || '') + '"]');

        $wrap.find('.select__input').val(value || '');
        $wrap.find('.select__head').removeClass('open').text($item.length ? $item.text() : '');
        $wrap.find('.select__item').removeClass('active');
        $item.addClass('active');
        $wrap.find('.select__list').hide();
    }

    function contractFormReset($m) {
        $m.find('.F_responce').hide();
        $m.find('.F_form__body').show();
        $m.find('#cf_date_dep_result, #cf_date_arr_result').text('Выбрать');
        $m.find('#cf_days').val(0);
        $m.find('#cf_days_result').text(0);
        $m.find('.ac-select__input').val('');
        $m.find('.ac-select__dropdown').html('').removeClass('open');
        $m.find('.labelInput').removeClass('show');
        $m.find('#cf_title, #cf_hotel_custom, #cf_price, #cf_price_display, #cf_passport, #cf_passport_issued_at, #cf_passport_issued_by, #cf_inn').val('');
        $m.find('#cf_framework_url').val('/o-nas/dokumenty/dogovor');
        $m.find('label[for="cf_framework_url"]').addClass('show');
        $m.find('#cf_date_dep, #cf_date_arr').val('');
        $m.find('#cf_user_id, #cf_hotel_id, #cf_city_dep, #cf_city_arr').val('');
        $m.find('#cf_contract_id').val('');
        CF_SELECT_FIELDS.forEach(function (field) { contractSetSelect($m, field, ''); });
        contractRebuildPeople($m, {});
        $m.find('#form_contract input:not([type=hidden])').prop('disabled', false);
        $m.find('.select').removeClass('_disabled');
        $m.find('._is-error').removeClass('_is-error');
        $m.find('.errorBlade').text('');
    }

    $('body').on('click', '.open_contract_create_js', function () {
        var $m = $('#m_contract_form');
        contractFormReset($m);
        $m.find('#cf_head_create').show();
        $m.find('#cf_head_edit').hide();
        $m.find('#cf_method').val('POST');
        $m.find('#cf_submit_label').text('Создать договор');
        $m.find('#cf_submit_wrap').show();
        Fancybox.show([{ src: '#m_contract_form', type: 'inline', touch: false }]);
    });

    $('body').on('click', '.contract-row-click', function () {
        var id      = $(this).data('contract-id');
        var $m      = $('#m_contract_form');
        var $loader = $m.find('.wrapper_loader');

        contractFormReset($m);
        $loader.css('display', 'flex');
        Fancybox.show([{ src: '#m_contract_form', type: 'inline', touch: false }]);

        $.ajax({
            url: '/cabinet/contracts/' + id,
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function (c) {
                $m.find('#cf_head_create').hide();
                $m.find('#cf_head_edit').show();
                $m.find('#cf_number').text(c.contract_number);
                $m.find('#cf_method').val('PUT');
                $m.find('#cf_contract_id').val(c.id);

                // Поля
                $m.find('#cf_title').val(c.title || '');
                $m.find('label[for="cf_title"]').toggleClass('show', !!c.title);

                $m.find('#cf_user_id').val(c.user_id || '');
                $m.find('#cf_user_display').val(c.user_name || '');
                $m.find('label[for="cf_user_display"]').toggleClass('show', !!c.user_name);

                ['passport', 'passport_issued_at', 'passport_issued_by', 'inn'].forEach(function (field) {
                    $m.find('#cf_' + field).val(c[field] || '');
                    $m.find('label[for="cf_' + field + '"]').toggleClass('show', !!c[field]);
                });

                $m.find('#cf_city_dep').val(c.city_departure || '');
                $m.find('#cf_city_dep_display').val(c.city_departure || '');
                $m.find('label[for="cf_city_dep_display"]').toggleClass('show', !!c.city_departure);

                $m.find('#cf_city_arr').val(c.city_arrival || '');
                $m.find('#cf_city_arr_display').val(c.city_arrival || '');
                $m.find('label[for="cf_city_arr_display"]').toggleClass('show', !!c.city_arrival);

                if (c.date_departure) {
                    $m.find('#cf_date_dep').val(c.date_departure);
                    $m.find('#cf_date_dep_result').text(moment(c.date_departure).locale('ru').format('LL'));
                }
                if (c.date_arrival) {
                    $m.find('#cf_date_arr').val(c.date_arrival);
                    $m.find('#cf_date_arr_result').text(moment(c.date_arrival).locale('ru').format('LL'));
                }

                $m.find('#cf_days').val(c.days_count || 0);
                $m.find('#cf_days_result').text(c.days_count || 0);

                $m.find('#cf_hotel_id').val(c.hotel_id || '');
                $m.find('#cf_hotel_display').val(c.hotel_name || '');
                $m.find('label[for="cf_hotel_display"]').toggleClass('show', !!c.hotel_name);

                $m.find('#cf_hotel_custom').val(c.hotel_custom || '');
                $m.find('label[for="cf_hotel_custom"]').toggleClass('show', !!c.hotel_custom);

                var rawPrice = c.tour_price ? String(c.tour_price) : '';
                $m.find('#cf_price').val(rawPrice);
                $m.find('#cf_price_display').val(rawPrice ? rawPrice.replace(/\B(?=(\d{3})+(?!\d))/g, ' ') : '');
                $m.find('label[for="cf_price_display"]').toggleClass('show', !!rawPrice);

                var frameworkUrl = c.framework_url || '/o-nas/dokumenty/dogovor';
                $m.find('#cf_framework_url').val(frameworkUrl);
                $m.find('label[for="cf_framework_url"]').addClass('show');

                contractSetSelect($m, 'contract_room_id', c.contract_room_id || '');
                contractSetSelect($m, 'contract_food_id', c.contract_food_id || '');
                contractSetSelect($m, 'transfer', c.transfer || '');
                contractSetSelect($m, 'excursion_program', c.excursion_program || '');
                contractSetSelect($m, 'russian_speaking_guide', c.russian_speaking_guide || '');
                contractSetSelect($m, 'visa_support', c.visa_support || '');
                contractSetSelect($m, 'medical_support', c.medical_support || '');
                contractRebuildPeople($m, c.people || {});

                // Статус
                $m.find('#cf_badge').html(c.is_signed
                    ? '<span class="contract-status contract-status--signed">Подписан</span>'
                    : '<span class="contract-status contract-status--pending">Ожидает подписания</span>');
                $m.find('#cf_public_link').attr('href', c.public_url);

                $m.find('#cf_submit_label').text('Сохранить');
                $m.find('#cf_submit_wrap').toggle(!c.is_signed);
                $m.find('#form_contract input:not([type=hidden])').prop('disabled', c.is_signed);
                $m.find('.select').toggleClass('_disabled', c.is_signed);

                $loader.css('display', 'none');
            },
            error: function () {
                $loader.css('display', 'none');
            }
        });
    });

    $('body').on('click', '.cf_submit_btn', function () {
        var $modal = $(this).closest('.fancybox__content');
        var id     = $modal.find('#cf_contract_id').val();
        var isEdit = !!id;
        var url    = isEdit ? '/cabinet/contracts/' + id : '/cabinet/contracts';

        $modal.find('._is-error').removeClass('_is-error');
        $modal.find('.errorBlade').text('');

        loader($modal);

        $.ajax({
            url: url,
            method: 'POST',
            data: $modal.find('#form_contract').serialize(),
            success: function (data) {
                setTimeout(function () {
                    loaderHide($modal);
                    $modal.find('.F_form__body').hide();
                    $modal.find('#cf_success_msg').text(isEdit ? 'Договор успешно обновлён.' : 'Договор успешно создан.');
                    var $copyLink = $modal.find('#cf_copy_link');
                    if (data && data.public_url) {
                        $copyLink.attr('data-url', data.public_url).show();
                    } else {
                        $copyLink.hide();
                    }
                    $modal.find('.F_responce').show();
                }, 1000);
            },
            error: function (xhr) {
                loaderHide($modal);
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    printErrorMsg($modal, xhr.responseJSON.errors);
                } else if (xhr.status === 419) {
                    alert('Сессия истекла. Пожалуйста, обновите страницу и попробуйте снова.');
                } else {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : 'Ошибка сервера (' + xhr.status + '). Попробуйте ещё раз.';
                    alert(msg);
                }
            }
        });
    });

    /* /договоры */


    /* копирование ссылки на подписание договора */

    $('body').on('click', '.contract-copy-link', function () {
        var url = $(this).data('url');
        var btn = $(this);

        navigator.clipboard.writeText(url).then(function () {
            btn.text('Скопировано!');
            setTimeout(function () { btn.text('Скопировать ссылку'); }, 2000);
        }).catch(function () {
            prompt('Скопируйте ссылку вручную:', url);
        });
    });

    /* копирование ссылки на подписание договора */


});






