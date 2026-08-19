{{-- Стандартная детальная страница материала внутри страны: курорт, экскурсия,
     полезная информация. Обёртку рисует pages/countries/item.blade.php.

     $item         — Resort / Excursion / Info
     $country      — страна
     $hot_category — подкатегория страны (курортное направление)
     $subcountries — подкатегории для подменю --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">
        {{ Breadcrumbs::render(Route::currentRouteName(), $country, $hot_category, $item) }}

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
    </div>

</div>

<div class="hbox__submenu">
    <div class="view_subcategories_countries v_s_c v_s_c__no">

        <div class="flex v_s_c__flex">

            <div class="v_s_c__item"><a href="{{asset(route('countries')).'/'. $country->slug}}">{{ __('О стране') }}</a></div>

@foreach($subcountries as $subcountry)
  {{--  @dd(asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug . '/'. $item->slug))--}}
       <div class="v_s_c__item
       {{ active_linkMenu(asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug . '/'. $item->slug) ) }}">
       <a  href="{{ asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug) }}">{{ ($subcountry->title_for_menu)?:$subcountry->title  }}</a>
       </div>

 @endforeach

        </div>

    </div>
</div>
<div class="hbox__middle country_page ">

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
            <img src="{{ asset(intervention('892x516', $item->pageimg1)) }}" width="892" height="516" loading="lazy"
                 alt="{{$item->title}}" />
        </div>
    @endif

    @if($item->text2)
        <div class="desc_text2 desc">
            {!!  shortcode($item->text2) !!}
        </div>
    @endif

    @if($item->pageimg2)
        <div class="pageimg2 pad_t16 pad_b16">

            <img src="{{ asset(intervention('892x516', $item->pageimg2)) }}" width="892" height="516" loading="lazy"
                 alt="{{ ($item->subtitle)?: $item->title }}" />
        </div>
    @endif

    @if($item->text3)
        <div class="desc_text3 desc">
            {!!  shortcode($item->text3) !!}
        </div>
    @endif

</div>
