{{-- Стандартная страница страны («О стране»).
     Обёртку рисует pages/countries/country.blade.php.

     $country      — страна (HotCategory верхнего уровня)
     $subcountries — её подкатегории для подменю --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">
        {{ Breadcrumbs::render(Route::currentRouteName(), $country) }}

        <h1>@if($country->imgflag)
                <span>
                    <img class="h1_flag"
                         src="{{asset('storage/'.$country->imgflag)}}"
                         width="62"
                         height="40" loading="lazy" alt="{{$country->title}}"/>
                    </span>
            @endif
            {{ ($country->subtitle)?: $country->title }}

        </h1>
    </div>


</div>

<div class="hbox__submenu">
    <div class="view_subcategories_countries v_s_c v_s_c__no ">
        <div class="flex v_s_c__flex">

            <div class="v_s_c__item active"><span>{{ __('О стране') }}</span></div>
            @foreach($subcountries as $subcountry)
                <div class="v_s_c__item"><a
                        href="{{ asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug) }}">{{ ($subcountry->title_for_menu)?:$subcountry->title  }}</a>
                </div>

            @endforeach

        </div>


    </div>
</div>
<div class="hbox__middle country_page ">

    @if($country->smalltext)
        <div class="colorGrey smalltext desc">
            {!!  $country->smalltext !!}
        </div>
    @endif

        @if($country->script_published)

            <br />
            <div class="item_script">
                <x-tourvisor.script :model="$country"/>
            </div>
            <br />
        @endif

        @if($country->text)
        <div class="desc_text desc">
            {!!  shortcode($country->text) !!}
        </div>
    @endif
    @if($country->pageimg1)
        <div class="pageimg pad_t16 pad_b16">
            <img src="{{asset(intervention('892x516', $country->pageimg1)) }}" width="892" height="516" loading="lazy"
                 alt="{{$country->title}}">
        </div>
    @endif

    @if($country->text2)
        <div class="desc_text2 desc">
            {!!  shortcode($country->text2) !!}
        </div>
    @endif

    @if($country->pageimg2)

            <div class="pageimg pad_t16 pad_b16">
                <img src="{{ asset(intervention('892x516', $country->pageimg2)) }}" width="892" height="516" loading="lazy"
                     alt="{{ ($country->subtitle)?: $country->title }}" />
            </div>
    @endif

    @if($country->text3)
        <div class="desc_text3 desc">
            {!!  shortcode($country->text3) !!}
        </div>
    @endif

</div>
