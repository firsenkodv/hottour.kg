{{-- Детальная страница курорта / экскурсии / полезной информации.
     Контент рисует шаблон, выбранный у материала в админке
     (App\Enums\Resources\ItemTemplate): pages/countries/templates/item/*.blade.php --}}
@extends('layouts.layout')
<x-seo.meta
    title="{{(isset($item->metatitle))?$item->metatitle:null}}"
    description="{{(isset($item->description))?$item->description:null}}"
    keywords="{{(isset($item->keywords))?$item->keywords:null}}"
/>
<x-seo.page-css :css="$item->custom_css ?? null" />
@section('content')

    <main class="page_site background_f7f7f7">
        <div class="block countries height_100">

            <div class="page_site__flex height_100">
                <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                    @include($template->view('countries'))

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
