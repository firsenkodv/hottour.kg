@extends('layouts.layout')
<x-seo.meta
    title="{{(isset($item->metatitle))?$item->metatitle:null}}"
    description="{{(isset($item->description))?$item->description:null}}"
    keywords="{{(isset($item->keywords))?$item->keywords:null}}"
/>
@section('content')
    <section class="good_summer"></section>

    <main>
        <div class="background_mobile">

            <section class="block z-index-24 pad_t16 pad_b16 ">
            @include('include.search.main.main_search')
            </section>

            <section class="block z-index-20 pad_t26 pad_b6 ">
                @include('include.quality.quality')
            </section>
            <section class="block z-index-20 pad_t16 pad_b14 ">
                <x-mobile_app.mobile_app/>
            </section>
        </div>

        <section class="z-index-23">
            @include('include.module.banner')
        </section>

        <section class="z-index-23 pad_t16 pad_b16 ">
            @include('include.module.hottours')
        </section>

        <section class="z-index-20 pad_t16 pad_b16 ">
            @include('include.module.popular')
        </section>

        <section class="z-index-20 pad_t16 pad_b16 ">
            @include('include.module.index_video')
        </section>

        <section class="z-index-20 pad_t16 pad_b16 ">
            @include('include.module.plane')
        </section>

        <section class="z-index-20 pad_t16 pad_b16 ">
            @include('include.module.popular_country')
        </section>

        <section class="z-index-20 pad_t16 pad_b16 ">
            <x-modules.responses />
        </section>

        <section class="z-index-20 pad_t16 pad_b16 ">
            @include('include.module.index_questions')
        </section>

        <section class="z-index-20 pad_t16  ">
            @include('include.module.index_news')
        </section>

        <section class="z-index-20 pad_t16  ">
            @include('include.module.index_text', $item)
        </section>

        @include('html.temp_forms.reserve_hotel')

    </main>
@endsection

