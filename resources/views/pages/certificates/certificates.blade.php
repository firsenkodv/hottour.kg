{{-- Страница «Сертификаты» (/sertifikaty).

     Своей модели у страницы нет: заголовок, описание и метатеги приходят
     из настроек (админка: «Категории» → «Сертификаты»),
     см. Domain\Certificate\ViewModels\CertificateViewModel::getPageData().

     Содержимое рисует шаблон, выбранный через App\Enums\Pages\ListTemplate:
     pages/certificates/templates/list/*.blade.php --}}
@extends('layouts.layout')
<x-seo.meta
    title="{{ $page->metatitle ?: ($page->title ?: __('Сертификаты')) }}"
    description="{{ $page->description }}"
    keywords="{{ $page->keywords }}"
/>
<x-seo.page-css :css="$page->custom_css ?? null" />
@section('content')

    @if($template->withoutPageWrapper())

        {{-- лендинг рисует страницу целиком сам --}}
        <main class="page_landing">
            @include($template->view('certificates'))

            @if(filled($page->html ?? null))
                <div class="page_site__html">{!! $page->html !!}</div>
            @endif
        </main>

    @else

        <main class="page_site background_f7f7f7">
            <div class="block certificates height_100">

                <div class="page_site__flex height_100">
                    <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                        @include($template->view('certificates'))

                        @if(filled($page->html ?? null))
                            <div class="page_site__html">{!! $page->html !!}</div>
                        @endif
                    </div>

                    @unless($template->withoutSidebar())
                        <div class="page_site__right">@include('include.menu.country_menu')</div>
                    @endunless
                </div><!--.page_site__flex-->
            </div>
        </main>

    @endif

@endsection
