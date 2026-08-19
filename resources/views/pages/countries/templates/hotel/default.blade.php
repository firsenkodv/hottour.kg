{{-- Стандартная страница отеля: галерея, услуги, поиск туров, отзывы.
     Обёртку и скрипты карты рисует pages/countries/hotel.blade.php.

     $item         — отель
     $country      — страна
     $hot_category — курортное направление
     $subcountries — подкатегории страны для подменю --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">
        {{ Breadcrumbs::render(Route::currentRouteName(), $country, $hot_category, $item) }}
        <div class="h1">@if($country->imgflag)
                <span>
                    <img class="h1_flag"
                         src="{{asset('storage/'.$country->imgflag)}}"
                         width="62"
                         height="40" loading="lazy" alt="{{$country->title}}"/>
                    </span>
            @endif
            {{ ($country->title) }}

        </div>
    </div>
</div>

<div class="hbox__submenu">
    <div class="view_subcategories_countries v_s_c v_s_c__no">
        <div class="flex v_s_c__flex">

            <div class="v_s_c__item"><a
                    href="{{asset(route('countries')).'/'. $country->slug}}">{{ __('О стране') }}</a>
            </div>

            @foreach($subcountries as $subcountry)
                {{--  @dd(asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug . '/'. $item->slug))--}}
                <div class="v_s_c__item
               {{ active_linkMenu(asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug . '/'. $item->slug) ) }}">
                    <a href="{{ asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug) }}">
                        {{ ($subcountry->title_for_menu)?:$subcountry->title  }}</a>
                </div>

            @endforeach

        </div>

    </div>
</div>
<div class="hbox__middle country_page ">
    <div class="flex hotel__title">
        <h1>@if($item->imgflag)
                <span>
                    <img class="h1_flag"
                         src="{{asset('storage/'.$item->imgflag)}}"
                         width="62"
                         height="40" loading="lazy" alt="{{$item->title}}"/>
                    </span>
            @endif
            {{ ($item->subtitle)?: $item->title }}
        </h1>
        @if($item->stars)
            <div class="hotel__redstar">
                <img width="18" height="18" loading="lazy" alt="hotel__redstar"
                     src="{{ asset('images/inline/pages-countries-hotel-1.svg') }}">
                <span>{{$item->stars}}</span>.0
            </div>
        @endif
    </div>


    @if($item->params)

        <div class="swiper-container__hotelphoto">
            <div class="swiper-container gallery-thumbs">
                <div class="swiper-wrapper">

                    @foreach($item->params as $img)
                        <div class="swiper-slide" style="
                        width: 100%;
                        height: 106px;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;
                        background-image: url('{{asset($img)}}')"></div>

                    @endforeach

                </div>
            </div>

            {{--@if ($loop->first)  @endif--}}
            <div class="swiper-container gallery-top">
                <div class="swiper-wrapper">
                    @foreach($item->params as $img)

                        <a href="{{asset($img)}}" data-fancybox="{{$item->id}}" data-caption="{{$item->title}}"
                           class="swiper-slide hotel__first_photo" style="
                        width: 100%;
                        height: 560px;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;
                        background-image: url('{{asset($img)}}')">
                        </a>

                    @endforeach
                </div>
                <div class="swiper_prev_next">
                    <div class="swiper-prev swiper-button-prev-swiper_banner"><span>‹</span></div>
                    <div class="swiper-next swiper-button-next-swiper_banner"><span>›</span></div>
                </div>
            </div>

        </div>
    @endif


    @if($item->placement)
        <div class="philosopher hotel__placement desc">
            {!!  $item->placement !!}
        </div>
    @elseif($item->desc)
        <div class="philosopher hotel__placement desc">
            {!!  $item->desc !!}
        </div>
    @endif
    @if($item->coord)
        <div class="hotel__services">
            <h3>Отель на карте</h3>
        </div>
        <div id="getHotelMap" class="hotel__datamap">
            <div id="JFormFieldMap"></div>
        </div>
    @endif

    <div class="search_hotel_form__copy active">
        <x-forms.loader class="br_12"/>
    </div>

    <div class="hotel__services">
        <h3>Удобства и услуги</h3>
    </div>
    <div id="getHotelInfo" class="hotel__dataservices" data-token="{{ csrf_token() }}">
        <x-forms.loader class="br_12"/>
    </div>


    <div class="hotel__services">
        <h3>Туры</h3>
    </div>

    <div class="inputs_hotel">
        <form id="formsearch" name="formsearch">
            <div class="search_hotel">

                {{--      @include('include.search.top_form.s_sity')--}}

                <input name="departure" data-departure="{{ departureSity() }}" type="hidden"
                       value="{{ departureCode() }}"/>
                <input name="country" type="hidden" value="{{ $item->country_id }}"/>
                <input name="region[]" type="hidden" value="{{ $item->region_id }}"/>
                <input name="hotels[]" type="hidden" value="{{ $item->slug }}"/>
                <input name="daterange" type="hidden"
                       value="{{ date('d.m.Y', (strtotime('+1 days'))) }} - {{ date('d.m.Y',(strtotime('+7 days'))) }}">
                <input name="nightsfrom" type="hidden" value="6">
                <input name="nightsto" type="hidden" value="12">
                <input type="hidden" name="adults" value="2" id="adults_input">
            </div>
        </form>
    </div>

    <div id="resultHotel" class="hotel__datapopulate"></div>

    <div class="hotel__services">
        <h3>Отзывы об отеле</h3>
    </div>
    <div id="getHotelReviews" class="hotel__datareviews">
    </div>


    @if($item->smalltext)
        <div class="colorGrey smalltext desc">
            {!!  $item->smalltext !!}
        </div>
    @endif

    @if($item->script_published)

        <br />
        <div class="item_script">
            <x-tourvisor.script :model="$item"/>
        </div>
        <br />
    @endif

    @if($item->text)
        <div class="desc_text desc">
            {!!  shortcode($item->text) !!}
        </div>
    @endif

    @if($item->pageimg1)
        <div class="pageimg pad_t16 pad_b16">
            <img src="{{ asset(intervention('892x516', $item->pageimg1)) }}" width="892"
                 height="516"
                 loading="lazy"
                 alt="{{$item->title}}"/>
        </div>
    @endif

    @if($item->text2)
        <div class="desc_text2 desc">
            {!!  shortcode($item->text2) !!}
        </div>
    @endif

    @if($item->pageimg2)
        <div class="pageimg2 pad_t16 pad_b16">

            <img src="{{ asset(intervention('892x516', $item->pageimg2)) }}" width="892"
                 height="516" loading="lazy"
                 alt="{{ ($item->subtitle)?: $item->title }}"/>
        </div>
    @endif

    @if($item->text3)
        <div class="desc_text3 desc">
            {!!  shortcode($item->text3) !!}
        </div>
    @endif

</div>
