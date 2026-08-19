{{-- Стандартная страница тура.
     Обёртку рисует pages/tours/item.blade.php.

     $item — тур (Tour) --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">
        {{ Breadcrumbs::render(Route::currentRouteName(), $item) }}

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
            <img src="{{ asset(intervention('892x516', $item->pageimg1)) }}" width="892"
                 height="516" loading="lazy"
                 alt="{{$item->title}}"/>
        </div>
    @endif



    @if($item->params_published)
        @if($item->params)
            <div class="pageparams pad_t16 pad_b16">
                @include('pages.tours.partial.tour', $item->params)
                @include('html.temp_forms.reserve_hotel')
            </div>
        @endif
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
