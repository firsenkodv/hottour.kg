<div class="h_sw">
    <div class="h_sw__flex">

        <div class="h_sw__left">
            <h1>{{__('Горящие туры')}}</h1>
            <p>{{__('лучшие цены на отдых')}}</p>
        </div>
        <div class="h_sw__right">
            <div class="h_sw__search">
                <a href="{{ asset('/find-tour') }}">{{__('Поиск туров')}}</a>
            </div>
            <div class="h_nav">
                <button type="button" class="swiper-prev click_slider_hot_p__js"><span>‹</span></button>
                <button type="button" class="swiper-next click_slider_hot_n__js"><span>›</span></button>
            </div>
        </div>

    </div>

    <div class="swiper_hottours__wrap">
        <x-forms.loader class="active"/>
        <div class="swiper swiper_hottours">

            <div class="swiper-wrapper slick_slider__carusel">
                @foreach($swiper_hot_tours as $k=>$item)
                    <div class="swiper-slide">
                        <div class="hot_item">
                            @if(isset($item->parent))
                                <a href="{{ route('hottour_item', ['slug_category' => $item->parent->parent->slug, 'slug_item' => $item->parent->slug ]) }}" class="hot_item__top">
                                    @else
                                        <div class="hot_item__top">
                                            @endif
                                            @if($item->procent)
                                                <div class="hot_item__sale div_sale_absol">-{{$item->procent}}%</div>
                                            @endif
                                            @if($item->img)
                                                <div class="hot_item__img" style="
                                            width: 285px;
                                            height: 200px;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            background-image: url('{{asset(intervention('310x200', $item->img))}}')"></div>
                                            @elseif($item->params)
                                                @if($item->params['hotelpicture'])
                                                    <div class="hot_item__img" style="
                                            width: 285px;
                                            height: 200px;
                                            background-position: center;
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            {{-- remote_image: фото с static.tourvisor.ru, при выключенном
                                                 сервисе (локаль под VPN) отдаёт заглушку --}}
                                            background-image: url('{{ remote_image(asset( $item->params['hotelpicture'])) }}')"></div>
                                    @endif
                                    @endif

                                    @if(isset($item->parent))
                                </a>
                            @else
                        </div>
                        @endif
                        <div class="hot_item__bottom">

                            <div class="hot_item__avia "><i></i>
                                <span>{{$item->subtitle}}</span></div>
                            <div class="hot_item__wrap">
                                <div class="hot_item__wrap_t">
                                    @if(isset($item->parent))
                                        <a href="{{ route('hottour_item', ['slug_category' => $item->parent->parent->slug, 'slug_item' => $item->parent->slug ]) }}" class="hot_item__title ">
                                            {{$item->title}}
                                        </a>
                                    @else
                                        <div class="hot_item__title ">
                                            {{$item->title}}
                                        </div>
                                    @endif
                                </div>
                                <div class="hot_item__wrap_b">
                                    @if($item->params['hotelname'])
                                        <div class="hot_item__hotel ">Отель:
                                            <span>{{ $item->params['hotelname'] }}</span></div>
                                    @endif
                                    <div class="hot_item__date ">
                                        {{$item->params['nights']}} ночей
                                        @if($item->params['meal'])
                                            ・{{ $item->params['meal'] }}
                                        @endif
                                        @if($item->params['flydate'])
                                            ・Вылет {{ $item->params['flydate'] }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="hot_item__odred h_order flex ">
                                <div class="hot_item__price">
                                    <div
                                        class="priceold">
                                        <span>{{ $item->params['priceold']}}</span></div>

                                    {{ price($item->params['price']) }}
                                    <span>{{ $item->customerCurrency }}</span>

                                </div>
                                <div class="hot_item__button">
                                    <a href="#reserve_hotel" data-fancybox
                                       data-tout_data='{"price":"{{number_format($item->params['price'], 0, '', ' ')}}", "dateFrom":"{{rusdate2($item->params['flydate'])}}", "dateTo":"{{rusdate2(date('d.m.Y', strtotime('+'. $item->params['nights'] .' days', strtotime($item->params['flydate']))))}}", "nights":"{{$item->params['nights']}}", "room":"", "mealrussian":"", "meal":"{{ $item->params['meal'] }}", "adults":"1", "child":"0", "tourname":"", "sity":"{{ $item->cityname}}","hotel":"{{ $item->params['hotelname']}}","country":"{{ $item->params['countryname']}}","stars":"{{ $item->params['hotelstars']}}","operatorname":"{{ $item->params['operatorname']}}", "hotelregionname" : "{{$item->params['hotelregionname']}}", "currency":"{{ currency($item->params['currency']) }}"}'
                                       class="button button_normal tour_button_js">
                                        {{__('Посмотреть')}}
                                    </a>
                                </div>
                            </div><!--.axeld_flex space_between align_items_center pad_t_10-->
                        </div><!--.pad_16-->
                    </div>
            </div><!--.swiper-slide-->
            @endforeach

        </div>
    </div>
</div><!--.swiper_hottours__wrap-->
</div><!--.h_sw-->

