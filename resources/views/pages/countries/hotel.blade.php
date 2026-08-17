{{-- Страница отеля. Контент рисует шаблон, выбранный у отеля в админке
     (App\Enums\Resources\ItemTemplate, вид hotel):
     pages/countries/templates/hotel/*.blade.php

     В правой колонке здесь не меню разделов, а форма заказа тура. --}}
@extends('layouts.layout')
<x-seo.meta
    title="{{(isset($item->metatitle))?$item->metatitle:$item->title}}"
    description="{{isset($item->description)? $item->description :''}}"
    keywords="{{isset($item->keywords)? $item->keywords : ''}}"
/>
<x-seo.page-css :css="$item->custom_css ?? null" />
@section('content')

    <main class="page_site page_site_hotel background_f7f7f7">
        <div class="block countries height_100">

            <div class="page_site__flex height_100">
                <div @class(['page_site__left', 'page_site__left--wide' => $template->withoutSidebar()])>
                    @include($template->view('countries', 'hotel'))

                    @if(filled($item->html ?? null))
                        <div class="page_site__html">{!! $item->html !!}</div>
                    @endif
                </div>
                @unless($template->withoutSidebar())
                    <div class="page_site__right">

                        @include('include.search.hotel_form.order')

                    </div>
                @endunless
            </div><!--.page_site__flex-->
        </div>


    </main>


    @include('include.search.js.hotel-hotel_js')


    @if($item->coord)
        <script>
            function getYaMap() {

                var myMap = new ymaps.Map("JFormFieldMap", {
                    center: [{{$item->coord}}],
                    zoom: 16,
                    controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
                }, {searchControlProvider: 'yandex#search'});
                myPlacemark = new ymaps.Placemark([{{$item->coord}}], {balloonContent: '<h5>Отель:  {{$item->title}}</h5>'}, {
                    iconLayout: 'default#image',
                    iconImageHref: '{{ asset('/images/myIcon.svg') }}',
                    iconImageSize: [58, 55],
                    iconImageOffset: [-28, -48]
                });

                myMap.setType(`yandex#hybrid`);
                myMap.geoObjects.add(myPlacemark);
            }

            // меняем тип карты на hybrid

        </script>
    @endif
@endsection
