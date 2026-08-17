{{-- Страница страны. Контент рисует шаблон, выбранный у страны в админке
     (App\Enums\Resources\ItemTemplate, вид country):
     pages/countries/templates/country/*.blade.php --}}
@extends('layouts.layout')
<x-seo.meta
title="{{(isset($country->metatitle))?$country->metatitle:$country->title}}"
description="{{isset($country->description)? $country->description :''}}"
keywords="{{isset($country->keywords)? $country->keywords : ''}}"
/>
<x-seo.page-css :css="$country->custom_css ?? null" />
@section('content')

    <main class="page_site background_f7f7f7">
        <div class="block countries height_100">

            <div class="page_site__flex height_100">
                <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                    @include($template->view('countries', 'country'))

                    @if(filled($country->html ?? null))
                        <div class="page_site__html">{!! $country->html !!}</div>
                    @endif
                </div>
                @unless($template->withoutSidebar())
                    <div class="page_site__right">@include('include.menu.country_menu')</div>
                @endunless
            </div><!--.page_site__flex-->
        </div>


    </main>


@endsection
