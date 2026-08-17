{{-- Стандартное содержимое заглавной страницы раздела «О нас»:
     хлебные крошки, заголовок и описание. Обёртку рисует
     pages/about/about.blade.php.

     $page — настройки страницы: title, desc, метатеги
             (Domain\Dump2\ViewModels\Dump2ViewModel::getPageData) --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">

        {{ Breadcrumbs::render(Route::currentRouteName()) }}

        <h1>{{ $page->title ?: __('О нас') }}</h1>
    </div>

    @if($page->desc)
        <div class="hbox__middle country_page">
            <div class="desc_text desc">
                {!! shortcode($page->desc) !!}
            </div>
        </div>
    @endif

</div>
