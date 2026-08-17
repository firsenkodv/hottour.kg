@section('tourvisor')
    {{-- daterangepicker.css, moment.js и сам плагин подключены глобально в layouts/layout --}}
    @include('html.temp_forms.reserve_hotel')

    <script>
        $('.search_hotel_form').find('.wrapper_loader ').css('display', 'flex');
        $('.search_hotel_form__copy').find('.wrapper_loader ').css('display', 'flex');

        function currency(c) {
            var currencies =  {@foreach(config('currency.currency') as $k => $currency){{ $k }}:"{{ $currency }}"@if (!$loop->last){{ ',' }}@endif @endforeach};
                for (var k in currencies) {
                    if(c==k) {
                        return currencies[k];
                    }
                }
        }

        const renderResultOneOperator = (t, hotelsfound) => {

            if(hotelsfound) {
                Object.entries(t.data.result.hotel).forEach((entry) => {
                    const [key, hotel] = entry;

                    let price = hotel.tours.tour[0].price.toLocaleString();
                    let c = currency(hotel.tours.tour[0].currency);
                    let hotelname = hotel.hotelname;
                    let flydate = hotel.tours.tour[0].flydate;
                    let nights = hotel.tours.tour[0].nights;
                    let meal = hotel.tours.tour[0].meal;
                    let mealrussian = hotel.tours.tour[0].mealrussian;
                    let sityDeparture = $('input[name="departure"]').data('departure');

                    let room = hotel.tours.tour[0].room;
                    let adults = hotel.tours.tour[0].adults;
                    let child = hotel.tours.tour[0].child;
                    let tourname = hotel.tours.tour[0].tourname;
                    let operatorname = hotel.tours.tour[0].operatorname;

                    let countryname = hotel.tours.tour[0].countryname;
                    let hotelstars = hotel.tours.tour[0].hotelstars;

                    $('.__price_js').text(price);
                    $('.__currency_js').text(c);
                    $('.__sity_js').text(sityDeparture);
                    $('.__hotel_js').text(hotelname);
                    $('.__flydate_js').text(flydate);
                    $('.__nights_js').text(nights);

                    if (meal) {
                        $('.__meal_js').text(meal);
                    }

                    if (mealrussian) {
                        $('.__mealrussian_js').text(mealrussian);
                    }

                    let ob = {
                        'price': price,
                        'dateFrom': moment(flydate, "DD.MM.YYYY").format('DD MMM (dd)'),
                        'dateTo': moment(flydate, "DD.MM.YYYY").add(nights, 'days').format('DD MMM (dd)'),
                        'nights': nights,
                        'room': room,
                        'mealrussian': mealrussian,
                        'meal': meal,
                        'adults': adults,
                        'child': child,
                        'tourname': tourname,
                        'sity': sityDeparture,
                        'hotel': hotelname,
                        'country': countryname,
                        'stars': hotelstars,
                        'operatorname': operatorname,
                        'currency': c
                    };
                    let obString = JSON.stringify(ob);
                    $('.search_hotel_form').find('.tour_button_js').attr('data-tout_data', obString);

                    $('.search_hotel_form').find('.wrapper_loader ').css('display', 'none');
                    $('.search_hotel_form__form').addClass('active');
                    $('.search_hotel_form__copy').removeClass('active');
                    $('.search_hotel_form__copy').html('<div class="search_hotel_form F_form">' + $('.search_hotel_form').html() + '</div>');
                    console.log(hotel);
                })
            } else {
                $('.search_hotel_form').find('.wrapper_loader ').css('display', 'none');
                $('.search_hotel_form__form').addClass('active');
                $('.search_hotel_form__form').addClass('samolet');
                $('.search_hotel_form__form').empty();
                $('.search_hotel_form__copy').empty();
                $('.search_hotel_form__copy').hide();


            }

        }

        const api = async (data) => {
            let opts = {
                method: "POST",
                cache: "no-cache",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')

                },
                referrerPolicy: "no-referrer",
                body: JSON.stringify(data),
            };

            const res = await fetch('/tourvisor/ajax', opts)

            if (!res.ok || res.redirected) {
                console.error(`Error: ${res.statusText}`);
                return;
            } else {
                console.log('функция api = ' + res.ok);
                return await res.json()
            }
        }

        let searchComplete = true;

        let intervalId = true;

        const getResultSearch = async () => {
            searchComplete = false;
            let data = {'action': 'searchTourResult', 'requestid': requestId};
            let result = await api(data);

            console.log('result.data.status.progress = ' + result.data.status.progress);
            console.log('typeof result.data.status = ' + typeof result.data.status);
            console.log('result.data.status.hotelsfound = ' + result.data.status.hotelsfound);

            if (typeof result.data.status == 'object') {

                if (result.data.status.progress == 100) {
                    searchComplete = true;
                    clearInterval(intervalId)
                }
                if(result.data.status.hotelsfound > 0) {
                    renderResultOneOperator(result, 1); // renderResultOneOperator есть переменная (result), и  есть туры в отель (1)
                    renderResultOperators(result);
                    searchComplete = true;
                    clearInterval(intervalId)
                } else {
                    searchComplete = true;
                    clearInterval(intervalId)
                    renderResultOneOperator(result, 0); // renderResultOneOperator нет переменной  (result), и  нет туров в отель (0)
                    $('#resultHotel').html('<h2 class="no__result" style="text-align: center">Нет результатов</h2>');
                }
/*                if (result.data.status.hotelsfound > 0) {

                    console.log('Количество туров = ' + result.data.result.hotel[0].tours.tour.length);
                    renderResultOneOperator(result.data.result.hotel[0].tours.tour);
                    renderResultOperators(result.data.result.hotel);

                } else if (result.data.status.progress == 100) {

                    $('#resultHotel').html('<h2 class="no__result" style="text-align: center">Нет результатов</h2>');
                }*/
            }

     /*       if (result.data.status.progress == 100 && result.data.status.hotelsfound == 0) {

                $('#resultHotel').html('<h2 class="no__result" style="text-align: center">Нет результатов</h2>');
            }*/

        }

        const search = async () => {

            let form = new FormData(document.querySelector('#formsearch'))

            form.append('action', 'searchTour')


            console.log(form);

            const data = new URLSearchParams(form);

            let opts = {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                },
                body: data,
            };

            console.log('запуск function  search');

            $('#resultHotel').html("");

            const res = await fetch('/tourvisor/ajax', opts)

            if (!res.ok || res.redirected) {

            } else {
                let result = await res.json()
                if (typeof result.result == "object") {
                    requestId = result.result.requestid
                    if (requestId > 0) {
                        $('#search_loader').addClass('active');
                        $('#loader .progress').text('0%');
                        intervalId = setInterval(await getResultSearch, 1000);
                    }
                }
            }
        }

        const renderResultOperators = (h) => {
            console.log(h.data.result.hotel);
            let  sityDeparture = $('input').data('departure');
            let  hotelName = h.data.result.hotel[0]['hotelname'];
            let  countryName = h.data.result.hotel[0]['countryname'];
            let  hotelStars = h.data.result.hotel[0]['hotelstars'];

            let operators = {};
            h.data.result.hotel.map((v, i) => {
                //  v.tours.tour.splice(20)
                v.tours.tour.map((t, p) => {
                    //   console.log(t.operatorcode);
                    if (typeof operators[t.operatorcode] !== 'object') {
                        operators[t.operatorcode] = [];
                        operators[t.operatorcode].push(t)
                    } else {
                        operators[t.operatorcode].push(t)
                    }
                    operators[t.operatorcode].splice(1)

                })

            })

            // console.log(operators);
            let html = "";
            Object.entries(operators).forEach((entry) => {
                const [key, value] = entry;
                //   console.log(value);

                Object.entries(value).forEach((e) => {
                    const [k, v] = e;
                    let ob = {'price': v.price, 'dateFrom': moment(v.flydate, "DD.MM.YYYY").format('DD MMM (dd)'), 'dateTo' : moment(v.flydate, "DD.MM.YYYY").add(v.nights, 'days').format('DD MMM (dd)'), 'nights' : v.nights, 'room' : v.room , 'mealrussian' : v.mealrussian, 'meal' : v.meal, 'adults' : v.adults, 'child' : v.child , 'tourname' : v.tourname, 'sity' : sityDeparture, 'hotel' : hotelName,  'country' : countryName, 'stars' : hotelStars, 'operatorname' : v.operatorname};
                    let obString = JSON.stringify(ob);

                    let super_wrapper_start = '<div class="search_result__tour"><div class="search_result__switch"><div class="hotel_price" style="display: block"><div class="hotel__datapopulate"><div class="hotel_price__table">';
                    let wrapper_info_1 = '<div class="line_info">';
                    let plane_1 = '<div class="line_info_plane">';
                    let up = '<div class="line_info_plane__item line_info_plane__item__up"><p><span class="line_info_plane__day">'+ moment(v.flydate, "DD.MM.YYYY").format('DD MMM (dd)')+'</span></p></div>';
                    let nights = '<div class="line_info_plane__sep">-</div><div class="line_info_plane__nights">'+ v.nights+'  ночей</div>';
                    let down = '<div class="line_info_plane__item line_info_plane__item__down"><p><span class="line_info_plane__day">'+ moment(v.flydate, "DD.MM.YYYY").add(v.nights, 'days').format('DD MMM (dd)') +'</span></p></div>';

                    let plane_2 = '</div>';
                    let line_info_1 = '<div class="line_info_row">';
                    let standard = '<div class="line_info_ticket"><p class="line_info_ticket__class">'+ v.room +'</p><p>'+ v.mealrussian +'</p><p>'+ v.meal+'</p></div>';
                    let line_info_flight = '<div class="line_info_flight"></div>';
                    let line_info_2 = '</div>';
   let btn_wrap = '<div class="line_info_btn-wrap"><a href="#reserve_hotel"  data-fancybox data-tout_data=\''+ obString +'\' class="line_info__link line_info__link--big btnPinkGradientTour button button_big tour_button_js" data-hotelcode="'+ v.hotelcode +'" data-tourid="-"><span>' + v.price.toLocaleString() + '</span> <span class="c__currency">' + currency(v.currency) + '</span></a></div>';
                    let wrapper_info_2 = '</div>';
                    let super_wrapper_finish = '</div></div></div></div></div>';

                    html += super_wrapper_start + wrapper_info_1 + plane_1 + up + nights + down + plane_2 + line_info_1 + standard + line_info_flight + line_info_2 + btn_wrap + wrapper_info_2 + super_wrapper_finish;
                });

            });

            $('#resultHotel').html(html);

        }

        function print_r(arr, level) {
            var print_red_text = "";
            if (!level) level = 0;
            var level_padding = "";
            for (var j = 0; j < level + 1; j++)
                level_padding += "    ";
            if (typeof (arr) == 'object') {
                for (var item in arr) {
                    var value = arr[item];
                    if (typeof (value) == 'object') {
                        print_red_text += level_padding + "'" + item + "' :\n";
                        print_red_text += print_r(value, level + 1);
                    } else
                        print_red_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                }
            } else print_red_text = "===>" + arr + "<===(" + typeof (arr) + ")";
            return print_red_text;
        }

        $(document).ready(function () {
            moment.locale('ru');
            search()
        });
    </script>
@endsection
