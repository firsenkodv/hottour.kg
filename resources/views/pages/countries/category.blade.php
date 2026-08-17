{{-- Страница курортного направления внутри страны.
     Контент рисует шаблон, выбранный у направления в админке
     (App\Enums\Pages\ListTemplate): pages/countries/templates/list/*.blade.php --}}
@extends('layouts.layout')
<x-seo.meta
    title="{{(isset($hot_category->metatitle))?$hot_category->metatitle:$hot_category->title}}"
    description="{{isset($hot_category->description)? $hot_category->description :''}}"
    keywords="{{isset($hot_category->keywords)? $hot_category->keywords : ''}}"
/>
<x-seo.page-css :css="$hot_category->custom_css ?? null" />

@section('content')
    <main class="page_site background_f7f7f7">
        <div class="block countries height_100">

            <div class="page_site__flex height_100">
                <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                    @include($template->view('countries'))

                    @if(filled($hot_category->html ?? null))
                        <div class="page_site__html">{!! $hot_category->html !!}</div>
                    @endif
                </div>


                @unless($template->withoutSidebar())
                    <div class="page_site__right">
                        @include('include.menu.country_menu')
                    </div>
                @endunless
            </div><!--.page_site__flex-->
        </div>


    </main>

@endsection
