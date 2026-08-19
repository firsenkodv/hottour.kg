{{-- Стандартная детальная страница горящего тура.
     Обёртку рисует pages/hottours/item.blade.php.

     $item     — материал (Travelitem)
     $category — категория горящих туров --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">
        {{ Breadcrumbs::render(Route::currentRouteName(), $category, $item) }}

        <h1>{{ ($item->subtitle)?: $item->title }}</h1>
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
            <img src="{{ asset(intervention('892x516', $item->pageimg1, 'travels')) }}" width="892" height="516" loading="lazy"
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

            <img src="{{ asset(intervention('892x516', $item->pageimg2, 'travels')) }}" width="892" height="516" loading="lazy"
                 alt="{{ ($item->subtitle)?: $item->title }}" />
        </div>
    @endif

    @if($item->text3)
        <div class="desc_text3 desc">
            {!!  shortcode($item->text3) !!}
        </div>
    @endif

</div>
