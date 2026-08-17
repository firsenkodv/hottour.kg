{{-- Страница категории горящих туров.
     Контент рисует шаблон, выбранный у категории в админке
     (App\Enums\Pages\ListTemplate): pages/hottours/templates/list/*.blade.php --}}
@extends('layouts.layout')
<x-seo.meta
    title="{{(isset($category->metatitle))?$category->metatitle:$category->title}}"
    description="{{isset($category->description)? $category->description :''}}"
    keywords="{{isset($category->keywords)? $category->keywords : ''}}"
/>
<x-seo.page-css :css="$category->custom_css ?? null" />
@section('content')

    <main class="page_site background_f7f7f7">
        <div class="block travelcategory height_100">

            <div class="page_site__flex height_100">
                <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                    @include($template->view('hottours'))

                    @if(filled($category->html ?? null))
                        <div class="page_site__html">{!! $category->html !!}</div>
                    @endif
                </div>
                @unless($template->withoutSidebar())
                    <div class="page_site__right">@include('include.menu.country_menu')</div>
                @endunless
            </div><!--.page_site__flex-->
        </div>
    </main>

@endsection
