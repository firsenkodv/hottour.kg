@foreach($tour_data as $hotel)

    @if($hotel->site_hotel)


        <div id="hotel-{{ $hotel->site_hotel->slug }}" class="search_result__tour search_tabs_switch"
             style="background-color: #fff" data-id="{{ $hotel->site_hotel->slug }}" data-key="0"
             data-rating="{{ $hotel->site_hotel->rating }}" data-cost="{{(isset($hotel->tours[0]->tour))? (price($hotel->tours[0]->tour->price)): ''}}">
            <div class="search_result__flex"><a rel="nofollow"
                                                href="/go-to-the-hotel's-page/{{ $hotel->site_hotel->slug }}"
                                                target="_blank">
                    <div class="search_result__photo search_result__photo2"

                         @if(isset($hotel->site_hotel->params))
                             style="background:url({{ $hotel->site_hotel->params['0']}});"
                        @endif
                    >
                        <ul class="hotel_star search_result__hotel_star">
                            @for($i=1;$i<=5;$i++)
                                @if($hotel->site_hotel->stars < $i )
                                    <li>★</li>
                                @else
                                    <li><i class="star">★</i></li>
                                @endif
                            @endfor
                        </ul>
                        <div class="search_result__rating good">{{ $hotel->site_hotel->rating }}</div>
                    </div>
                </a>
                <div class="search_result__info-wrap">
                    <div class="search_result__info">
                        <div class="search_result__hotel"><h3 class="hotel_name"
                                                              style="text-transform: uppercase"><a rel="nofollow"
                                                                                                   href="/go-to-the-hotel's-page/{{ $hotel->site_hotel->slug }}"
                                                                                                   target="_blank">{{ $hotel->site_hotel->title }}</a></h3>
                        </div>
                        <div class="search_result__city"><span class="search_result__city-name">{{ getCountryName($hotel->site_hotel->country_id) }}, {{ $hotel->site_hotel->region  }}</span>
                        </div>
                        <ul class="search_result__tabs">
                            <li class="hotel_about__li hotel_about__js"
                                data-target="hotel_about">{{ __('Об отеле') }}</li>
                            <li class="hotel_map__js" data-target="hotel_map"
                                data-id="{{ $hotel->site_hotel->slug }}"
                                @php
                                    settype($data_coord, "string");
                                    $c = ($hotel->site_hotel->coord) ?:'';
                                    if($c) {
                                    $coord = (explode( ",", $c));
                                    $data_coord = 'data-coord_x="'. $coord[0] .'" data-coord_y="'. $coord[1] .'"';
                                      }
                                @endphp
                                {{ $data_coord }}>{{ __('На карте') }}
                            </li>
                            <li class="hotel_price__js" data-target="hotel_price">{{ __('Цены') }}</li>
                        </ul>
                        <div class="search_result__moreInfo">
                            <div class="search_result__fly"><div class="fly_"></div><span>Вылет: </span> {{(isset($hotel->tours[0]->tour))? ($hotel->tours[0]->tour->sity): ''}}</div>

                            <div class="search_result__adults"><span>Взрослых: </span> {{(isset($hotel->tours[0]->tour))? ($hotel->tours[0]->tour->adults): ' - '}}</div>

                            <div class="search_result__child"><span>Детей: </span> {{(isset($hotel->tours[0]->tour))? ($hotel->tours[0]->tour->child): ' - '}}</div>

                        </div>
                    </div>
                    <div class="search_result__price">
                        <div class="search_result__coast">от <span>{{(isset($hotel->tours[0]->tour))? (price($hotel->tours[0]->tour->price)): '- '}}</span> <span
                                class="c__currency">{{ config('currency.currency.KZT') }}</span></div>
                        <div class="wrap_button">
                            <button type="button" data-target="hotel_price"
                                    class="search_result__button button  search_result__tour_button btnPinkGradient DetailedTourGTM isClick">
                                {{ __('Подробнее') }}
                            </button>
                        </div>

                        @if($favourites)
                        <div class="favourites2"><i></i><span></span></div>
                        @endif

                    </div>
                </div>
            </div>
            <div class="search_result__switch search_choose_switch">
                <div class="hotel_about ">
                    <div class="hotel_about__flex flex">
                    <div class="hotel_about__photo">
                        <div class="photo_collage">
                            @if($hotel->site_hotel->params)
                                @foreach($hotel->site_hotel->params as $img)
                                    <a
                                        href="{{ $img }}"
                                        data-fancybox="gallery-{{ $hotel->site_hotel->slug }}"
                                        class="photo_collage__link">
                                        <div class="photo_collage__img"
                                             style="background-image: url({{ $img }})"></div>
                                    </a>
                                @endforeach
                            @endif


                        </div>
                    </div>
                    <div class="hotel_about__text hotel_about__text2 desc">

                        @include('cart.partial.hotel_desc', ['hotel' => $hotel->site_hotel])

                        <div class="hotel_about__bottom">
                            <a rel="nofollow"   href="/go-to-the-hotel's-page/{{ $hotel->site_hotel->slug }}"    target="_blank" class="hotel_about__link">{{ __('Подробнее об отеле') }}
                            </a></div>
                    </div>
                    </div>
                </div>
                <div class="hotel_map">
                    <div class="hotel_map__item" id="yandexmap-{{ $hotel->site_hotel->slug }}"
                         style="height: 400px;width: 100%;"></div>
                    @if($hotel->site_hotel->coord)
                        <script>
                            ymaps.ready(function () {
                                var map = new ymaps.Map('yandexmap-{{ $hotel->site_hotel->slug }}', {
                                    center: [{{$hotel->site_hotel->coord}}],
                                    zoom: 14,
                                    controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
                                }, {
                                    searchControlProvider: 'yandex#search'
                                });

                                myPlacemark_{{ $hotel->site_hotel->slug }} = new ymaps.Placemark([{{$hotel->site_hotel->coord}}], {balloonContent: '<h5><span>Отель:</span>  {{$hotel->site_hotel->title}}</h5>'}, {
                                    iconLayout: 'default#image',
                                    iconImageHref: '{{ asset('/images/myIcon.svg') }}',
                                    iconImageSize: [58, 55],
                                    iconImageOffset: [-28, -48]
                                });

                                map.setType(`yandex#hybrid`);
                                map.geoObjects.add(myPlacemark_{{ $hotel->site_hotel->slug }});

                                // меняем тип карты на hybrid

                            });

                        </script>
                    @endif


                </div>
                <div class="hotel_price">
                    <div class="hotel_price__top">
                        <div class="hotel_price__title"></div>
                    </div>
                    <div class="hotel_price__table" data-page="0">


                        @foreach($hotel->tours as $tour)

                            <div class="line_info">
                                <div class="line_info_plane">
                                    <div class="line_info_plane__item line_info_plane__item__up"><p><span
                                                class="line_info_plane__day">{{ $tour->tour->dateFrom }}</span></p></div>
                                    <div class="line_info_plane__sep">-</div>
                                    <div class="line_info_plane__nights">{{ $tour->tour->nights }} ночей</div>
                                    <div class="line_info_plane__item line_info_plane__item__down"><p><span
                                                class="line_info_plane__day">{{ $tour->tour->dateTo }}</span></p></div>
                                </div>
                                <div class="line_info_row">
                                    <div class="line_info_ticket"><p class="line_info_ticket__class">
                                            standard</p>
                                        <p>{{ $tour->tour->mealrussian }}</p>
                                        <p>{{ $tour->tour->meal }}</p></div>
                                    <div class="line_info_flight"></div>
                                </div>
                                <div class="line_info_btn-wrap">
                                    <a href="#reserve_hotel" data-fancybox=""
                                       data-tout_data='{"price":{{ $tour->tour->price }},"dateFrom":"{{ $tour->tour->dateFrom }}","dateTo":"{{ $tour->tour->dateTo }}","nights":{{ $tour->tour->nights }},"room":"{{ $tour->tour->room }}","mealrussian":"{{ $tour->tour->mealrussian }}","meal":"{{ $tour->tour->meal }}","adults":{{ $tour->tour->adults }},"child":{{ $tour->tour->child }},"tourname":"{{ $tour->tour->tourname }}","sity":"{{ trim($tour->tour->sity) }}","hotel":"{{ $tour->tour->hotel }}","country":"{{ $tour->tour->country }}","stars":{{ $tour->tour->stars }},"operatorname":"{{ $tour->tour->operatorname }}","currency":"{{ $tour->tour->currency }}"}'
                                       class="line_info__link line_info__link--big button button_big btnPinkGradientTour tour_button_js"
                                       data-hotelcode="{{  $hotel->site_hotel->slug }}"
                                    ><span>{{ price($tour->tour->price) }}</span>
                                        {{ config('currency.currency.KZT') }} </a></div>
                            </div><!--.line_info-->

                        @endforeach

                    </div>
                    <div class="roll_back roll_back_js"><span>{{ __('Свернуть') }}</span></div>
                </div>
            </div>
        </div>

    @else



    @endif

@endforeach
