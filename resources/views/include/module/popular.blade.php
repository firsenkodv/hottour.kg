@if(count($hotel_swiper)>4)


<div class="p_sw">
    <div class="p_sw__flex">

    <div class="p_sw__left">
        <h2>{{__('Популярные направления')}}</h2>
    </div>
    <div class="p_sw__right">
        <div class="p_nav">
            <button type="button" class="swiper-prev swiper-button-prev-swiper_populars click_slider_p__js"><span>‹</span></button>
            <button type="button" class="swiper-next swiper-button-next-swiper_populars click_slider_n__js"><span>›</span></button>
        </div>
    </div>
</div>

    <div class="swiper swiper_populars">
        <div class="swiper-wrapper slick_slider__popularscarusel">

            @foreach($hotel_swiper as $hotel)

                <div class="swiper-slide">
                    <div class="popular_item">
                        <div class="popular_item__top">
                           {{-- <div class="popular_item__sale div_sale_absol">-10%</div>--}}

                            {{-- remote_image: фото с static.tourvisor.ru, при выключенном
                                 сервисе (локаль под VPN) отдаёт заглушку --}}
                            <div class="popular_item__img" style="width:310px; height: 280px ;background-image: url('{{ remote_image($hotel->img) }}'); background-size: cover"></div>
                        </div>


                        <div class="popular_item__bottom">
                            <div class="popular_item__avia swiper-no-swiping"><span class="p_star">★</span><span class="p_starcount">{{ $hotel->star }}.0 • {{ $hotel->country }} • {{$hotel->mealrussian}}</span></div>

                            <div class="popular_item__title swiper-no-swiping" title="   {{ $hotel->title }}">
                                {{ $hotel->title }}
                            </div>

                            <div class="popular_item__sity">
                                Из  {{ $hotel->city }} {{$hotel->nights}} ночей
                            </div>
                            <div class="popular_item__price">
                                {{ price($hotel->price) }} {{ config('currency.currency.KZT') }}
                            </div>
                            <div class="popular_item__odred h_order">

                                <a href="#reserve_hotel" data-fancybox data-tout_data='{"price":"{{number_format($hotel->price, 0, '', ' ')}}", "dateFrom":"{{rusdate2($hotel->flydate)}}", "dateTo":"{{rusdate2(date('d.m.Y', strtotime('+'. $hotel->nights .' days', strtotime($hotel->flydate))))}}", "nights":"{{$hotel->nights}}", "room":"", "mealrussian":"", "meal":"{{ $hotel->meal }}", "adults":"{{ $hotel->adults }}", "child":"{{ $hotel->child }}", "tourname":"", "sity":"{{ $hotel->city}}","hotel":"{{ $hotel->title}}","country":"{{ $hotel->country}}","stars":"{{ $hotel->star}}","operatorname":"", "hotelregionname" : "", "currency":"{{ config('currency.currency.KZT') }}"}' class="line_info__link line_info__link--big btnPinkGradientTour button  button_green tour_button_js" data-hotelcode="" data-tourid="-"><span>Забронировать</span></a>

                            </div>
                        </div><!--.pad_16-->
                    </div>
                </div><!--.swiper-slide-->

            @endforeach



        </div>
    </div>

</div><!--.p_sw-->
@endif


