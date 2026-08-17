@section('tourvisor')

    @if(cart())
        @php
            $isGood = true;
        @endphp
    @endif

    @if(favorite_user())
        @php
            $isFavoriteUser = true;
        @endphp
    @endif
    {{-- daterangepicker.css, moment.js и сам плагин подключены глобально в layouts/layout --}}
    @include('html.temp_forms.reserve_hotel')

    <script>
        function currency(c) {
            var currencies = {
                @foreach(config('currency.currency') as $k => $currency){{ $k }}: "{{ $currency }}"
                @if (!$loop->last){{ ',' }}@endif @endforeach
            };
            for (var k in currencies) {
                if (c == k) {
                    return currencies[k];
                }
            }
        }

        function loader(Parents) {
            Parents.find('.wrapper_loader ').css('display', 'flex');
        }

        function loaderHide(Parents) {
            Parents.find('.wrapper_loader ').css('display', 'none');
        }


        let hotels = [];

        loader($('#hotels-area'));
        $.ajax({
            url: "/get-array-hotels",
            method: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                'cоuntry': $('.js-country-select').val()
            },
            success: function (response) {
                if (response.error) {
                    loaderHide($('#hotels-area'))
                } else {
                    let array_hotels = response.array_hotels.lists.hotels.hotel;
                    hotels = array_hotels;

                    //  console.log(array_hotels);

                    setTimeout(function () {

                        /*  console.log(hotels);*/
                        let html = "";
                        // 👉
                        for (let i in hotels) {
                            html += renderHotels(array_hotels[i])
                        }
                        $('#hotels-area').html(html);
                        loaderHide($('#hotels-area'))
                    }, 1000);
                }
            }
        });


        const numberRangePicker = {
            rangeInstallation: function (t) {
                var o = $(t.target),
                    e = o.closest('.number_range_picker__body'),
                    i = e.closest('.number_range_picker'),
                    r = e.find('.number_range_picker__item'),
                    s = r.filter('.start_range'),
                    a = r.filter('.end_range');
                if (
                    o.hasClass('number_range_picker__item') ||
                    (o = o.closest('.number_range_picker__item')),
                    0 === s.length
                ) r.removeClass('range_hover'),
                    o.addClass('start_range'),
                    r.on(
                        'mouseover.range_hover',
                        function (t) {
                            r.removeClass('range_hover');
                            var e = $(t.target);
                            e.hasClass('number_range_picker__item') ||
                            (e = e.closest('.number_range_picker__item'));
                            var i = o.index(),
                                s = e.index();
                            if (s < i) {
                                14 < i - s &&
                                (s += i - s - 14);
                                for (var a = i; s <= a; a--) r.eq(a).addClass('range_hover')
                            } else if (i < s) {
                                14 < s - i &&
                                (s -= s - i - 14);
                                for (var n = i + 1; n <= s; n++) r.eq(n).addClass('range_hover')
                            }
                        }
                    );
                else if (0 === a.length) {
                    var n = s.index(),
                        l = o.index(),
                        c = 0,
                        h = 0;
                    if (l < n) {
                        14 < n - l &&
                        (l += n - l - 14);
                        for (var d = n; l < d; d--) r.eq(d).addClass('range_hover');
                        c = r.eq(l).data('val'),
                            h = r.eq(n).data('val')
                    } else if (n < l) {
                        14 < l - n &&
                        (l -= l - n - 14);
                        for (var u = n + 1; u < l; u++) r.eq(u).addClass('range_hover');
                        c = r.eq(n).data('val'),
                            h = r.eq(l).data('val')
                    } else c = h = r.eq(n).data('val');
                    e.closest('.number_range_picker').find('.number_range_picker__input').val(c + ' - ' + h),
                        r.eq(l).addClass('end_range'),
                        i.removeClass('open');
                    var p = i.data();
                    i.find(p.target_from).val(c),
                        i.find(p.target_to).val(h),
                        r.off('mouseover.range_hover')
                } else r.removeClass('start_range end_range range_hover'),
                    numberRangePicker.rangeInstallation(t)
            }
        }

        const childAgeAdd = function () {
            var e,
                i,
                s;
            $('.children').each(
                function () {
                    if (
                        e = $(this).find('.child_age'),
                            i = $(this).find('a.active').text(),
                        e.length > i
                    ) if (0 == i) e.remove();
                    else if (3 === e.length && 2 == i) e.eq(i).remove();
                    else for (var t = s = e.length - i; 0 < t; t--) e.eq(t).remove();
                    else if (e.length < i) {
                        s = i - e.length;
                        for (t = 0; t < s; t++) $(this).append(
                            '<div class="child_age"><button type="button" class="child_age__button child_age__button-minus">-</button><input type="text" readonly value="2 года" class="child_age__input"><button type="button" class="child_age__button child_age__button-plus">+</button></div>'
                        )
                    }
                }
            )
            $('.child_age').each(function () {
                childAge($(this).find('.child_age__button-minus'), parseInt($(this).find('input.child_age__input').val(), 10))
            })
        }

        const renderHotels = (h) => {
            return `<label class="checkbox_choice__item"><input class="hotel_checkbox" name="hotels[]" type="checkbox" data-title="${h.name}" value="${h.id}"><span>${h.name} ${h.stars}*</span></label>`;
        }

        /*        const loadArrayHolels = () => {

                    $.ajax({
                        url: "/get-array-hotels",
                        method: "POST",
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            'cоuntry': $('.s_sity select').val()

                        },
                        success: function (response) {
                            if (response.error) {

                            } else {
                                let array_hotels = response.array_hotels.lists.hotels.hotel;
                                setTimeout(function () {
                                    return JSON.stringify(array_hotels);
                                }, 1000);
                            }
                        }
                    });
                }*/

        const setHotelsArea = () => {


            let regions = [];
            $('.region_checkbox:checked').each(function () {
                regions.push(this.value)
            })

           // console.log(regions);
            /*  console.log('hotels ' + hotels);*/


            let html = "";
            if (regions.length == 0) {
                document.querySelector('#any-region').checked = true
                for (let i in hotels) {
                    html += renderHotels(hotels[i])
                }
            } else {
                document.querySelector('#any-region').checked = false;


                for (let i in hotels) {

                    /*   console.log('вроде есть все отели');
                       console.log(hotels[i].name);*/

                    if (hotels[i].subregion != 0) {

                        //есть subregion и регион
                        if ($.inArray(hotels[i].region, regions) !== -1 || $.inArray(hotels[i].subregion, regions) !== -1) {
                            html += renderHotels(hotels[i]);
                            /*            console.log('есть subregion и регион');
                                        console.log(hotels[i].name);*/

                        }

                    } else {
                        //есть только  регион

                        if ($.inArray(hotels[i].region, regions) !== -1) {
                            html += renderHotels(hotels[i])
                    /*        console.log('есть тольko регион');
                            console.log(hotels[i].name);
*/
                        }

                    }
                }
            }

            $('#hotels-area').html(html)
        }

        const setRegionCheckbox = (e) => {

            if (e.target.checked) {
                $('.region_checkbox:checked').each(function () {
                    this.checked = false
                })
                setHotelsArea()
            }

        }

        const getRegion = async (e) => {
            if (e.target.value > 0) {
                let data = {country_id: e.target.value, action: 'getRegion'};

               // console.log(data);
                let result = await api(data);
                $('#regions-area').html(result.regions);
                hotels = result.lists.hotels.hotel;
                setHotelsArea();
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
       /*         console.log('функция api');
                  console.log(res);*/
                return await res.json()
            }
        }

        let requestId = 0;
        let intervalId;

        const renderResultHotels = (h, con, next_page) => {

            let html = '';
            h.map((v, i) => {


                let FavoriteId =  new Date().getTime()+'-'+v.hotelcode;
                let img;
                if (v.hotels_info.images) {
                    if (v.hotels_info.images.image[0]) {
                        img = v.hotels_info.images.image[0];
                    } else {
                        img = v.picturelink;
                    }
                } else {
                    img = v.picturelink;
                }

           //    console.log(v.hotels_info.images);

                let s = parseInt(v.price_for_site = (+v.price_for_site || 0).toFixed()) + "", j, km, kw;
                if ((j = s.length) > 3) {
                    j = j % 3;
                } else {
                    j = 0;
                }

                //  let  sityDeparture = $('select[name="departure"]').val();
                let sityDeparture = $('select[name="departure"] option:selected').text();
                let hotelName = v.hotelname;
                let countryName = v.countryname;
                let hotelStars = v.hotelstars;


                km = (j ? s.substr(0, j) + " " : "");
                kw = s.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + " ");
                km += kw;
                html += `<div id="hotel-${v.hotelcode}" class="search_result__tour search_tabs_switch" data-id="${v.hotelcode}" data-key="${i}" data-rating="${v.hotels_info.rating}" data-cost="${v.price_for_site}"><div class="search_result__flex"><a rel="nofollow" href="/go-to-the-hotel's-page/` + v.hotelcode + `" target="_blank"><div class="search_result__photo" style="background:url(${img});">`;
                html += getStarHtml(v.hotelstars) + getRatingHtml(v.hotels_info.rating)
                html += `</div></a><div class="search_result__info-wrap"><div class="search_result__info"><div class="search_result__hotel">`;
                html += `<h3 class="hotel_name"><a rel="nofollow" href="/go-to-the-hotel's-page/` + v.hotelcode + `" target="_blank">${v.hotelname}</a></h3></div><div class="search_result__city"><span class="search_result__city-name">${v.countryname}`
                if (v.regionname != "") {
                    html += `, ` + v.regionname;
                }
                if (v.subregionname != "") {
                    html += `, ` + v.subregionname;
                }
                html += `</span></div>`;
                html += getTabResultHotelHtml(v);
                html += `<div class="search_result__text">${v.hoteldescription}</div></div><div class="search_result__price"><div class="search_result__coast">от <span>`;
                html += km;
                html += `</span> <span class="c__currency">` + currency(v.currency) + `</span> </div><div class="wrap_button"><button type="button" data-target="hotel_price" class="search_result__button button  search_result__tour_button btnPinkGradient DetailedTourGTM isClick">Подробнее</button></div>@if(isset($isGood))<div class="favourites"><i></i><span></span></div>@endif @if(isset($isFavoriteUser))<div class="favourite_user favourite_user__js"><i><a target="_blank" href="{{ route('favorites_user') }}">Избранное</a></i><span data-favoriteid="${FavoriteId}"></span></div>@endif</div></div></div><div class="search_result__switch search_choose_switch">`;
                if ($('#hotel-' + v.hotelcode + ' .hotel_about.active').length) html += `<div class="hotel_about active">`;
                else html += `<div class="hotel_about">`;

                html += `<div class="hotel_about__photo"><div class="photo_collage">`;

                if (typeof v.hotels_info.images == 'object') {
                    v.hotels_info.images.image.map(
                        (im, p) => {
                            html += `<a href="${im}"  data-fancybox="gallery-` + v.hotelcode + `" class="photo_collage__link"><div class="photo_collage__img" style="background-image: url(${im})"></div></a>`
                        })
                }


                /*console.log(v.hotels_info);*/
                html += `</div></div><div class="hotel_about__text desc">`;
                if (typeof v.hotels_info.placement !== 'undefined') {
                    html += `<p><span class="span_block">Расположение:</span>${v.hotels_info.placement}</p>`;
                }
                if (typeof v.hotels_info.territory !== 'undefined') {
                    html += `<p><span>Территория отеля:</span></p>${v.hotels_info.territory}`;
                }
                if (typeof v.hotels_info.meallist !== 'undefined') {
                    html += `<p><span>Питание:</span></p>${v.hotels_info.meallist}`;
                }
                if (typeof v.hotels_info.inroom !== 'undefined') {
                    html += `<p><span>В номерах:</span></p>${v.hotels_info.inroom}`;
                }

                /*           if (typeof v.hotels_info.roomtypes !== 'undefined') {
                               html += `<p><span>Типы номеров:</span></p>${v.hotels_info.roomtypes}`;
                           }
                               if (typeof v.hotels_info.servicefree !== 'undefined') {
                               html += `<p><span>Бесплатные услуги:</span></p>${v.hotels_info.servicefree}`;
                           }
                           if (typeof v.hotels_info.child  !== "undefined") {
                               html += `<p><span>Для детей:</span></p>${v.hotels_info.child}`;
                           }
                            */

                if (typeof v.hotels_info.beach !== 'undefined') {
                    html += `<p><span>Пляж:</span></p>${v.hotels_info.beach}`
                }

                html += `<div class="hotel_about__bottom"><a rel="nofollow" href="/go-to-the-hotel's-page/` + v.hotelcode + `" target="_blank" class="hotel_about__link">Подробнее об отеле</a></div></div></div>`
                if (searchComplete) {
                    html += `<div class="hotel_map"><div class="hotel_map__item" id="yandexmap-${v.hotelcode}" style="height: 400px;width: 100%;"></div></div>`;
                }
                if ($('#hotel-' + v.hotelcode + ' .hotel_price.active').length) html += `<div class="hotel_price active">`;
                else html += `<div class="hotel_price">`
                html += `<div class="hotel_price__top"><div class="hotel_price__title"></div></div>`;
                html += `<div class="hotel_price__table" data-page="0">`;
                v.tours.tour.map((t, p) => {
                    html += `<div class="line_info"><div class="line_info_plane"><div class="line_info_plane__item line_info_plane__item__up">`;
                    html += `<p><span class="line_info_plane__day">` + moment(t.flydate, "DD.MM.YYYY").format('DD MMM (dd)') + `</span></p></div><div class="line_info_plane__sep">-</div><div class="line_info_plane__nights">${t.nights} ночей</div><div class="line_info_plane__item line_info_plane__item__down">`;
                    html += `<p><span class="line_info_plane__day">` + moment(t.flydate, "DD.MM.YYYY").add(t.nights, 'days').format('DD MMM (dd)') + `</p></div></div>`;
                    html += `<div class="line_info_row"><div class="line_info_ticket"><p class="line_info_ticket__class">${t.room}</p><p>${t.mealrussian}</p><p>${t.placement}</p></div>`;

                    let ob = {
                        'price': t.price,
                        'dateFrom': moment(t.flydate, "DD.MM.YYYY").format('DD MMM (dd)'),
                        'dateTo': moment(t.flydate, "DD.MM.YYYY").add(t.nights, 'days').format('DD MMM (dd)'),
                        'nights': t.nights,
                        'room': t.room,
                        'mealrussian': t.mealrussian,
                        'meal': t.meal,
                        'adults': t.adults,
                        'child': t.child,
                        'tourname': t.tourname,
                        'sity': sityDeparture,
                        'hotel': hotelName,
                        'country': countryName,
                        'stars': hotelStars,
                        'operatorname': t.operatorname,
                        'currency': currency(t.currency)
                    };

                    let obString = JSON.stringify(ob);


                    html += `<div class="line_info_flight"></div></div><div class="line_info_btn-wrap"><a href="#reserve_hotel"  data-fancybox data-tout_data='${obString}'  class="line_info__link line_info__link--big button button_big btnPinkGradientTour tour_button_js" data-hotelcode="${v.hotelcode}" data-tourid="${t.tourid}"><span>${t.price.toLocaleString()}</span> ` + currency(t.currency) + ` </a></div></div>`;


                })
                html += `</div><div class="roll_back roll_back_js"><span>Свернуть</span></div></div></div></div>`
            })
            if (next_page == 'add') {
                $(con).append(html);
            } else {
                $(con).html(html); // #resultHotel
            }

            if (searchComplete == true) {
                $('.addsearch').each(function () {
                    $(this).remove()
                });


/*
                console.log('page');
                console.log(page);
                console.log('countPage');
                console.log(countPage);*/

                if (con == '#resultHotel' && page <= countPage) {
                    $(con).after('<div id="page-2" class="s_page s_page2"><button style="margin:23px auto" class="s_button_normal addsearch" onclick="continueSearch(event)">Найти еще</button></div>')
                } else if (next_page > 0 && page <= countPage) {
                    $(con).after('<div id="page-' + next_page + '" class="s_page"><button style="margin:23px auto" class="s_button_normal addsearch" onclick="continueSearch(event)">Найти еще</button></div>')

                }
                $(con).after($('.search_loader'))
            }

        }

        async function initMap(params, id, s) {
            if ($('#' + id).find('ymaps').length == 0) {
                ymaps.ready(() => {
                    console.log(params)
                    const map = new ymaps.Map(id, params);
                    const baloon = new ymaps.Placemark(
                        s,
                        {preset: 'islands#redIcon'}
                    );
                    map.geoObjects.add(baloon)
                });
            }
        }

        const getTabResultHotelHtml = (v) => {
            let html = `<ul class="search_result__tabs"><li class="hotel_about__li" data-target="hotel_about" >Об отеле</li>`;
            if (typeof v.hotels_info.coord1 == 'string' && v.hotels_info.coord1 != "" && searchComplete) {
                html += `<li class="hotel_map__js" data-target="hotel_map" data-id="${v.hotelcode}" data-coord_x="${v.hotels_info.coord1}" data-coord_y="${v.hotels_info.coord2}">На карте</li>`;
            }
            html += `<li class="hotel_price__js" data-target="hotel_price">Цены</li></ul>`;
            return html;

        }

        const getRatingHtml = (r) => {
            let addClass = 'normal';
            if (r < 3) {
                addClass = 'bad';
            } else if (r > 3.9) {
                addClass = 'good';
            }
            return `<div class="search_result__rating ${addClass}">${r}</div>`
        }

        const getStarHtml = (s) => {
/*            `<ul class="hotel_star search_result__hotel_star"><li><i class="star"></i></li><li><i class="star"></i></li><li><i class="star"></i></li><li><i class=""></i></li><li><i class=""></i></li></ul>`*/
            let html = `<ul class="hotel_star search_result__hotel_star">`
            for (let i = 0; i < 5; i++) {
                if (i < s) {
                    html += `<li><i class="star">★</i></li>`
                } else {
                    html += `<li><i>★</i></li>`
                }
            }
            html += `</ul>`;
            return html;
        }


        let searchComplete = true;
        let searchPage = 1;
        let page = 1;
        let count = 1;
        let countPage = 0;

        const continueSearch = async (e) => {
            $('.addsearch').each(function () {
                $(this).remove()
            });
            searchComplete = false;
            $('#search_loader').addClass('active');
            let containerTour = '#resultHotel';
            if (searchPage > 1) {
                containerTour = '#page-' + page;
            }
            if (page > countPage) {

                let form = new FormData()
                form.append('continue', requestId)
                form.append('action', 'continueSearchTour')
                const data = new URLSearchParams(form);


                let opts = {
                    method: "POST",
                    headers: {
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                    },
                    body: data,
                };

                const res = await fetch('/tourvisor/ajax', opts)

                if (!res.ok || res.redirected) {
                    console.error(`Error: ${res.statusText}`);
                    return;

                } else {
                    let result = await res.json();
                    console.log('продолжение поиска continueSearch');
                    console.log(result);

                    if (typeof result.result == "object") {
                        searchPage = result.result.page
                        if (searchPage > 1) {
                            $('.s_progress .progress').text('0%');
                          //  intervalId = setInterval(await getResultSearch, 3000);
                            setTimeout(await getResultSearch, 3000);

                        }


                    }
                }
            } else {

                let data = {'action': 'searchTourResult', 'requestid': requestId, page: page};
                let result = await api(data);
                if (typeof result.data == "object") {


                    if (typeof result.data.status == 'object') {

                        if (result.data.status.progress > 0) {
                            if (result.data.result.hotel.length > 0) {
                                searchComplete = true;
                                page++;
                                $('#search_loader').removeClass('active');
                                renderResultHotels(result.data.result.hotel, containerTour, 'add')
                            }

                        }


                    }
                }
            }

        }

        const getResultSearch = async () => {

            searchComplete = false;
            let data = {'action': 'searchTourResult', 'requestid': requestId, page: page};
            let result = await api(data);

            console.log('функция getResultSearch');
            console.log(result);

            let containerTour = '#resultHotel';
            if (searchPage > 1) {
                containerTour = '#page-' + page;
            }


            if (typeof result.data == "object") {

                if (typeof result.data.status == 'object') {
                    if (result.data.status.progress > 0) {

                        searchComplete = true;
                        count = result.data.status.hotelsfound
                        countPage = (count / 25).toFixed(0);
                    /*    console.log(count);
                          console.log(countPage);*/
                       // clearInterval(intervalId)
                        /* конец поиска */

                     //   console.log('конец типа 100%');
                        $('#search_loader').removeClass('active');
                        $('.s_progress .progress').text('');
                        $('#search-button').attr('disabled', false);
                        $('#search-button').removeClass('s_disabled');
                        page = 2;


                    } else {
                        $('.s_progress .progress').text(result.data.status.progress + '%');
                    }
                }



                if (typeof result.data.result == 'object') {


                    if (result.data.result.hotel.length > 0) {
                        renderResultHotels(result.data.result.hotel, containerTour, searchPage * 1 + 1)
                    } else  {

                        $(containerTour).html('<h2 class="no__result" style="text-align: center">Нет результатов</h2>');
                    }
                } else {

                    $(containerTour).html('<h2 class="no__result" style="text-align: center">Нет результатов</h2>');
                }

            }
        }

        const MyscrollTop = async () => {
          //  alert('sss');


            var elementClick = $('#search_loader');
            var destination = $(elementClick).offset().top;
            $("html, body").animate({ scrollTop: destination }, 1100); //1100 - скорость прокрутки

            return false;


        }
        const search = async () => {
            page = 1;
            $('#search-button').attr('disabled', true);
            $('#search-button').addClass('s_disabled');
            $('.addsearch').each(function () {
                $(this).remove()
            });

            $('#resultHotel').html("");
            $('#resultHotel').before($('.search_loader'));
            $('#search_loader').addClass('active');

            // let data = {};
            let form = new FormData(document.querySelector('#formsearch'))
            form.append('hotelrating', $('.s_rating__label.active').data('hotelrating'))
            form.append('action', 'searchTour')


            const data = new URLSearchParams(form);

            let opts = {
                method: "POST",
                headers: {
                    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                },
                body: data,
            };

            const res = await fetch('/tourvisor/ajax', opts)

            if (!res.ok || res.redirected) {
                console.error(`Error: ${res.statusText}`);
                return;

            } else {
                let result = await res.json();
                console.log('функция search');
              //  console.log(result);

                if (typeof result.result == "object") {
                    requestId = result.result.requestid

                /*  console.log('requestId');*/

                    if (requestId > 0) {
                        $('.s_progress .progress').text('0%');
                       // intervalId = setInterval(await getResultSearch, 3000);

                        setTimeout(await getResultSearch, 3000);

                        /*              console.log('intervalId');
                                        console.log(intervalId);         */

                    }

                }
            }
        }

        const peopleSum = () => {
            let e = 0,
                i = $('.full_people'),
                s = '';
            let a = parseInt(i.find('.adult').children('a.active').text());
            switch (
                i.find('.child').children('a.active').each(function () {
                    e += parseInt($(this).text())
                }),
                    !0
                ) {
                case 0 === e &&
                1 < a:
                    s = a + ' взрослых';
                    break;
                case 0 === e &&
                1 === a:
                    s = a + ' взрослый';
                    break;
                default:
                    s = a + ' взр. ' + e + ' реб.'
            }
            i.siblings('p').text(s)
        }

        const childAge = function (t, e) {
            var i = e + ' лет',
                s = t.siblings('input'),
                a = s.closest('.children');
            2 <= e &&
            e <= 4 &&
            (i = e + ' года'),
                s.val(i),
                i = a.find('.quantity.child a.active').text() + ':',
                a.find('input.child_age__input').each(function (t, e) {
                    i += $(e).val() + ','
                }),
                a.children('input').val(i)
        }

        const openTabSearch = (e) => {

            let Parents = $(e.target).parents('.search_tabs_switch');
            let hotel_target = e.target.dataset.target;
           // console.log(hotel_target);


            if (hotel_target == 'hotel_about') {
                Parents.find('.hotel_about').toggleClass('active');
                Parents.find('.hotel_price').removeClass('active');
                Parents.find('.hotel_map').removeClass('active');
            }
            if (hotel_target == 'hotel_price') {
                Parents.find('.hotel_price').toggleClass('active');
                Parents.find('.hotel_about').removeClass('active');
                Parents.find('.hotel_map').removeClass('active');
            }

            if (hotel_target == 'hotel_map') {

                let t = $(e.target).data('id')
                let s = [
                    $(e.target).data('coord_x'),
                    $(e.target).data('coord_y'),

                ]
                t = 'yandexmap-' + t;
                let params = {
                    center: s,
                    zoom: 14,
                    type: 'yandex#hybrid',
                    controls: []
                }

                initMap(params, t, s)
                Parents.find('.hotel_map').toggleClass('active');
                Parents.find('.hotel_about').removeClass('active');
                Parents.find('.hotel_price').removeClass('active');
            }
        }

        $(document).ready(function () {

            moment.locale('ru');

            $('.js-chosen').chosen({
                width: '100%',
                no_results_text: 'Совпадений не найдено',
                placeholder_text_single: 'Выберите город'
            });

            $('body').on('click', '.s_rating__label', function (event) {
                $('.s_rating__label').removeClass('active');
                $(this).addClass('active');
            });


            $('.js-chosen').trigger("chosen:updated");

            let rangeMin = 100;
            const range = document.querySelector(".range-selected");
            const rangeInput = document.querySelectorAll(".range-input input");
            const rangePrice = document.querySelectorAll(".range-price input");




            rangeInput.forEach((input) => {
                input.addEventListener("input", (e) => {
                    let minRange = parseInt(rangeInput[0].value);
                    let maxRange = parseInt(rangeInput[1].value);



                    let rangeInput_0, rangeInput_1;

              /*       console.log(minRange);
                       console.log(maxRange);
*/

                    if (maxRange - minRange < rangeMin) {
                        if (e.target.className === "min") {
                            rangeInput[0].value = maxRange - rangeMin;


                        } else {
                            rangeInput[0].value = minRange + rangeMin;
                        }
                    } else {
                        rangePrice[0].value = minRange.toLocaleString();
                        console.log(rangePrice[0].value);

                        rangePrice[1].value = maxRange.toLocaleString();
                        range.style.left = (minRange / rangeInput[0].max) * 100 + "%";
                        range.style.right = 100 - (maxRange / rangeInput[1].max) * 100 + "%";
                    }
                });
            });

            // .toLocaleString()

            rangePrice.forEach((input) => {
                input.addEventListener("input", (e) => {
                    let minPrice = rangePrice[0].value;
                    let maxPrice = rangePrice[1].value;
                    if (maxPrice - minPrice >= rangeMin && maxPrice <= rangeInput[1].max) {
                        if (e.target.className === "min") {
                            rangeInput[0].value = minPrice;
                            range.style.left = (minPrice / rangeInput[0].max) * 100 + "%";
                        } else {
                            rangeInput[1].value = maxPrice;
                            range.style.right = 100 - (maxPrice / rangeInput[1].max) * 100 + "%";
                        }
                    }
                });
            });

            /* календарь дат вылета инициализирует единый модуль js/datepicker.js
               (разметка — компонент x-forms.datepicker в s_date.blade.php) */
            $('body').on(
                'click',
                '.number_range_picker input',
                function (e) {
                    e.preventDefault(),
                        $(this).closest('.input_item').toggleClass('open')
                }
            )
            $('body').on(
                'click',
                '.number_range_picker__item',
                numberRangePicker.rangeInstallation
            )

            let child_age, i, s, t;
            $('.children').each(
                function () {
                    if (
                        child_age = $(this).find('.child_age'),
                            i = $(this).find('a.active').text(),
                        child_age.length > i
                    ) if (0 == i) child_age.remove();
                    else if (3 === child_age.length && 2 == i) child_age.eq(i).remove();
                    else for (t = s = child_age.length - i; 0 < t; t--) child_age.eq(t).remove();
                    else if (child_age.length < i) {
                        s = i - child_age.length;
                        for (t = 0; t < s; t++) $(this).append(
                            '<div class="child_age"><button type="button" class="child_age__button child_age__button-minus">-</button><input type="text" readonly value="2 года" class="child_age__input"><button type="button" class="child_age__button child_age__button-plus">+</button></div>'
                        )
                    }
                }
            )

            $('body').on(
                'click',
                '.input_item.dropdown',
                function () {
                    $('.number_people').removeClass('open').children('.number_people_drop').removeClass('open'),
                        $(this).toggleClass('open').children('.form_dropdown').toggleClass('open'),
                        y.customScroll.formDropdown(),
                        $('.input_item.dropdown').not(this).removeClass('open').children('.form_dropdown').removeClass('open')
                }
            ).on(
                'click',
                '.input_item .form_dropdown a',
                function (t) {
                    t.preventDefault();
                    var e = $(this).html(),
                        i = $(this).attr('data-value');
                    $(this).closest('.form_dropdown').siblings('p').html(e),
                    i &&
                    $(this).closest('.form_dropdown').siblings('p').attr('data-value', i)
                }
            )

            $('body').on(
                'click',
                '.input_item.dropdown',
                function () {
                    $(this).toggleClass('open').children('.form_dropdown_comp').toggleClass('open'),
                        $('.input_item.dropdown').not(this).removeClass('open').children('.form_dropdown_comp').removeClass('open')
                }
            )


            $('body').on(
                'click',
                '.number_people',
                function (t) {
                    t.target !== this &&
                    'P' !== t.target.nodeName ||
                    (
                        $(this).toggleClass('open').children('.number_people_drop').toggleClass('open'),
                            $('.number_people').not(this).removeClass('open').children('.number_people_drop').removeClass('open'),
                            $('.input_item.dropdown').removeClass('open').children('.form_dropdown').removeClass('open')
                    )
                }
            )


            /////////////////////////


            $('body').on(
                'click',
                '.full_people .quantity a:not(.active)',
                function (t) {
                    t.preventDefault();
                    var e = 0,
                        i = $(this).closest('.full_people'),
                        s = '';
                    $(this).addClass('active').siblings().removeClass('active');
                    var a = parseInt(i.find('.adult').children('a.active').text());
                    switch (
                        i.find('.child').children('a.active').each(function () {
                            e += parseInt($(this).text())
                        }),
                            !0
                        ) {
                        case 0 === e &&
                        1 < a:
                            s = a + ' взрослых';
                            break;
                        case 0 === e &&
                        1 === a:
                            s = a + ' взрослый';
                            break;
                        default:
                            s = a + ' взр. ' + e + ' реб.'
                    }
                    return i.siblings('p').text(s),
                        e
                }
            ),
                $('.only_child .quantity').on(
                    'click',
                    'a',
                    function (t) {
                        t.preventDefault();
                        var e = 0,
                            i = $(this).closest('.only_child');
                        return $(this).addClass('active').siblings().removeClass('active'),
                            i.find('.quantity').children('a.active').each(function () {
                                e += parseInt($(this).text())
                            }),
                            i.siblings('p').text(0 === e ? 'Не выбрано' : e + ' реб.'),
                            e
                    }
                ),
                $('body').on(
                    'click',
                    '.children .quantity a:not(.active)',
                    function (t) {
                        childAgeAdd()
                    }
                )
            $('body').on(
                'click',
                '.quantity.child a:not(.active)',
                function (t) {
                    var e = $(t.target).closest('.how_people'),
                        i = 0,
                        s = 0;
                    e.hasClass('children') ? (
                        i = Number($(t.target).text()),
                            s = Number($('#infatn_list').find('.active').text())
                    ) : (
                        s = Number($(t.target).text()),
                            i = Number($('#child_list').find('.active').text())
                    ),
                        $('#infatn_list').find('a').each(
                            function () {
                                3 < Number($(this).text()) + i ? $(this).addClass('disable') : $(this).removeClass('disable')
                            }
                        ),
                        $('#child_list').find('a').each(
                            function () {
                                3 < Number($(this).text()) + s ? $(this).addClass('disable') : $(this).removeClass('disable')
                            }
                        )
                }
            )

            $('body').on(
                'click',
                '.quantity a',
                function () {
                    var t = $(this).data('input'),
                        e = $(this).html();
                    void 0 !== t &&
                    $('#' + t).val(e)
                }
            )
            $('body').on(
                'click',
                '.child_age__button-minus',
                function () {
                    var t = $(this).siblings('input'),
                        e = parseInt(t.val(), 10);
                    return 2 < e &&
                    (e--, childAge($(this), e)),
                        !1
                }
            ).on(
                'click',
                '.child_age__button-plus',
                function () {
                    var t = $(this).siblings('input'),
                        e = parseInt(t.val(), 10);
                    return e < 14 &&
                    (e++, childAge($(this), e)),
                        !1
                }
            )


            /////////////////////////


            $('body').on('click', '.region_checkbox', setHotelsArea)

            $('#any-region').on('click', setRegionCheckbox)

            $('.js-country-select').on('change', getRegion)

            $('body').on('click', '.search_result__tabs li', openTabSearch)

            $('body').on('click', '.search_result__tour_button', openTabSearch)

            $('body').on('click', '.roll_back_js', function () {

                let Parents = $(this).parents('.search_tabs_switch');
                Parents.find('.hotel_price').removeClass('active');
            })


            $('#search-button').on('click', function (e) {
                e.preventDefault();
                search()
                MyscrollTop()
            })
            childAgeAdd()
            peopleSum()
            let detUrl = new URL(window.location.href);
            if (detUrl.searchParams.has('_token')) {
                /*     console.log(detUrl);*/
                search()
                MyscrollTop()

            }

            @external('yandex_maps')
            setTimeout(function () {
                var elem = document.createElement('script');
                elem.type = 'text/javascript';
                elem.src = '//api-maps.yandex.ru/2.1/?apikey=43db27ba-be61-4e84-b139-ff37ad4802b8&package.standard&lang=ru_RU';
                document.getElementsByTagName('body')[0].appendChild(elem);

            }, 2000);
            @endexternal


            /*   search();*/

            /* дописка */

            $('body').on('click', '.fancy_buttons__cancel', function (event) {
                $('.form_modal input:checkbox').prop('checked', false);
            });


            $('body').on('click', '.favourites', function (event) {

                $(this).find('i').toggleClass('active');

                // our object array
                let big_data = [];



                        $('#resultHotel .search_result__tour').each(function( index ) {

                             if($(this).find('.favourites i').hasClass('active')) {
                                 let tour_data = [];
                                 let object = {};

                                 object.hotel = $(this).data('id');

                                 $(this).find('.hotel_price__table .line_info').each(function() {

                                     let object_tour = {};
                                     object_tour.tour = $(this).find('.line_info_btn-wrap a').data('tout_data');
                                     tour_data.push(object_tour);
                                 });
                                 object.tours = tour_data;
                                 big_data.push(object);

                             }

                         });

              //   console.log(big_data);

                 //   console.log($(this).parents('.search_result__tour').data('id'));
                  $('.tour_data').attr('value',  JSON.stringify(big_data));

            });


        });
    </script>
@endsection

