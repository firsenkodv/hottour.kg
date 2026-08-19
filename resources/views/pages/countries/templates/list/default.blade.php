{{-- Стандартная страница курортного направления: описание и списки материалов.
     Обёртку рисует pages/countries/category.blade.php.

     $hot_category    — подкатегория страны
     $country         — страна
     $subcountries    — соседние подкатегории для подменю
     $teaser_template — вид карточек в списке (TeaserTemplate) --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">
        {{ Breadcrumbs::render(Route::currentRouteName(), $country, $hot_category) }}

        <h1>@if($hot_category->imgflag)
                <span>
                    <img class="h1_flag"
                         src="{{asset('storage/'.$hot_category->imgflag)}}"
                         width="62"
                         height="40" loading="lazy" alt="{{$hot_category->title}}"/>
                </span>
            @endif
            {{ ($hot_category->subtitle)?: $hot_category->title }}

        </h1>
    </div>


</div>

<div class="hbox__submenu">
    <div class="view_subcategories_countries v_s_c v_s_c__no">
        <div class="flex v_s_c__flex">

            <div class="v_s_c__item"><a
                    href="{{asset(route('countries')).'/'. $country->slug}}">{{ __('О стране') }}</a>
            </div>
            @foreach($subcountries as $subcountry)
                <div
                    class="v_s_c__item {{ active_linkMenu(asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug) ) }}">
                    <a href="{{ asset(route('countries').'/'. $country->slug. '/'. $subcountry->slug) }}">{{ ($subcountry->title_for_menu)?:$subcountry->title  }}</a>
                </div>

            @endforeach

        </div>
    </div>
</div>
<div class="hbox__middle country_page ">

    @if($hot_category->smalltext)
        <div class="colorGrey smalltext desc">
            {!!  $hot_category->smalltext !!}
        </div>
    @endif

        @if($hot_category->script_published)

            <br />
            <div class="item_script">
                <x-tourvisor.script :model="$hot_category"/>
            </div>
            <br />
        @endif

    @if($hot_category->text)
        <div class="desc_text desc">
            {!!  shortcode($hot_category->text) !!}
        </div>
    @endif

    @if($hot_category->pageimg1)
        <div class="pageimg pad_t16 pad_b16">

            <img src="{{ asset(intervention('892x516', $hot_category->pageimg1)) }}" width="892" height="516" loading="lazy"
                 alt="{{$hot_category->title}}">
        </div>
    @endif

    @if($hot_category->text2)
        <div class="desc_text2 desc">
            {!!  shortcode($hot_category->text2) !!}
        </div>
    @endif

    @if($hot_category->pageimg2)
        <div class="pageimg2 pad_t16 pad_b16">
            <img src="{{ asset(intervention('892x516', $hot_category->pageimg2)) }}" width="892" height="516" loading="lazy"
                 alt="{{ ($hot_category->subtitle)?: $hot_category->title }}">
        </div>
    @endif

    @if($hot_category->text3)
        <div class="desc_text3 desc">
            {!!  shortcode($hot_category->text3) !!}
        </div>
    @endif

</div>


<div class="hbox temp_img_text">
    <div class="hrow ">

        @include($teaser_template->view('countries'))

    </div>

</div>
