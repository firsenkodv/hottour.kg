{{-- Стандартная страница категории раздела «Полезное» / «О нас»:
     текст категории и под ним список её материалов.
     Обёртку рисует pages/dumps/category.blade.php.

     $category        — категория (Dump или Dump2)
     $publs           — пагинированный список материалов
     $teaser_template — вид карточек в списке (TeaserTemplate)
     $top_category    — корневой url раздела --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">

        {{ Breadcrumbs::render(Route::currentRouteName(), $category) }}

        <h1>{{ ($category->subtitle)?: $category->title }}</h1>
    </div>
</div>

<div class="hbox__middle country_page pad_t1_important">
    @if($category->calc)
        <x-calc.calc :data="(isset($calc)? $calc :'')"/>
    @endif
    @if($category->smalltext)
        <div class="colorGrey smalltext desc">
            {!!  $category->smalltext !!}
        </div>
    @endif

        @if($category->script_published)

            <br />
            <div class="item_script">
                <x-tourvisor.script :model="$category"/>
            </div>
            <br />
        @endif


    @if($category->text)
        <div class="desc_text desc">
            {!!  shortcode($category->text) !!}
        </div>
    @endif

    @if($category->pageimg1)
        <div class="pageimg pad_t16 pad_b16">

            <img src="{{ asset(intervention('892x516', $category->pageimg1, 'dumps')) }}"
                 width="892" height="516" loading="lazy"
                 alt="{{$category->title}}">
        </div>
    @endif

    @if($category->text2)
        <div class="desc_text2 desc">
            {!!  shortcode($category->text2) !!}
        </div>
    @endif

    @if($category->pageimg2)
        <div class="pageimg2 pad_t16 pad_b16">
            <img src="{{ asset(intervention('892x516', $category->pageimg2, 'dumps')) }}"
                 width="892" height="516" loading="lazy"
                 alt="{{ ($category->subtitle)?: $category->title }}">
        </div>
    @endif

    @if($category->text3)
        <div class="desc_text3 desc">
            {!!  shortcode($category->text3) !!}
        </div>
    @endif

</div>

<div class="hbox temp_img_tree">

    @if(count($publs))
        @include($teaser_template->view('dumps'))
    @endif


</div>
