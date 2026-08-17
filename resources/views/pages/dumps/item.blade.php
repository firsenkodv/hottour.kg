{{-- Детальная страница материала «Полезное» / «О нас».
     Сам контент рисует шаблон, выбранный у материала в админке
     (App\Enums\Resources\ItemTemplate): pages/dumps/templates/item/*.blade.php --}}
@extends('layouts.layout')
<x-seo.meta
    title="{{(isset($item->metatitle))?$item->metatitle:$item->title}}"
    description="{{isset($item->description)? $item->description :''}}"
    keywords="{{isset($item->keywords)? $item->keywords : ''}}"
/>
<x-seo.page-css :css="$item->custom_css ?? null" />
@section('content')

    <main class="page_site background_f7f7f7">
        <div class="block countries height_100">

            <div class="page_site__flex height_100">
                <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                    @include($template->view('dumps'))

                    @if(filled($item->html ?? null))
                        <div class="page_site__html">{!! $item->html !!}</div>
                    @endif
                </div>
                @unless($template->withoutSidebar())
                    <div class="page_site__right">@include('include.menu.country_menu')</div>
                @endunless
            </div><!--.page_site__flex-->
        </div>

    </main>

@endsection
