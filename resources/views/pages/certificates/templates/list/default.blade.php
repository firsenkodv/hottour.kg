{{-- Стандартное содержимое страницы «Сертификаты»: хлебные крошки,
     заголовок и описание. Обёртку рисует
     pages/certificates/certificates.blade.php.

     $page — настройки страницы: title, desc, метатеги
             (Domain\Certificate\ViewModels\CertificateViewModel::getPageData) --}}

<div class="hbox temp_img">
    <div class="hbox__top pad_b1">

        {{ Breadcrumbs::render(Route::currentRouteName()) }}

        <h1>{{ $page->title ?: __('Сертификаты') }}</h1>
    </div>

    @if($page->desc)
        <div class="hbox__middle country_page">
            <div class="desc_text desc">
                {!! shortcode($page->desc) !!}
            </div>
        </div>
    @endif

</div>
