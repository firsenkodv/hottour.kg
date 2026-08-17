@extends('layouts.layout')
<x-seo.meta
    title="Контакты"
    description="Контакты"
    keywords="Контакты"
/>
@section('content')

    <section class="unitedStates catalogContacts our-services pad_b1">
        <div class="block">

            <div class="hbox temp_img">
                <div class="hbox__top pad_b1">
                    {{ Breadcrumbs::render(Route::currentRouteName()) }}

                    <h1>
                        {{ __('Контакты') }}
                    </h1>
                </div>

            </div>
        </div>
        <div class="block">

            <div class="catalogContacts__tabs contactTabs">
                <div class="contactTabs__top">

                    @foreach($contacts as $k=>$contact)

                        <div data-tab="G_tab{{$k}}" class="G_tab{{$k}}
                         @if($session_sity)
                                 @if($session_sity == $contact->title)
                                 active
                                 @endif
                             @elseif($k==0)
                             active
                         @endif

                         contactTabs__tab contactTabs__tab__js">
                            <span class="nursul">{{$contact->title}}</span>
                        </div><!--.G_tab{{$k}}-->

                    @endforeach
                </div>

                <div class="contactTabs__bottom contactTabsBody contactTabsBody__js">
                    @foreach($contacts as $k=>$contact)
                        <div
                            class="G_tab{{$k}}
                              @if($session_sity)
                                 @if($session_sity == $contact->title)
                                 active
                                 @endif
                             @elseif($k==0)
                             active
                             @endif
                            contact_area contact_area__js contactTabsBody__tab">
                            <div class="contact_area__flex">
                                <div class="contact_area__left">
                                    <div class="color_grey_16 color_grey  contact_area__label">{{__('Телефон:')}} {!!  (isset($contact->label))?' / <span class="contact_label">'. $contact->label . '</span>' : '' !!}</div>
                                    @foreach($contact->data_phone as $k => $property)
                                        <div class="property">{!!  $property['jt1'] !!}</div>
                                    @endforeach
                                </div>
                                <div class="contact_area__center">
                                    @if($contact->address)
                                        <div
                                            class="color_grey_16 color_grey  contact_area__label">{{__('Адрес:')}}</div>
                                        <div class="property">{{$contact->address}}</div>
                                    @else
                                        <div
                                            class="color_grey_16 color_grey  contact_area__label">{{__('Город:')}}</div>
                                        <div class="property">{{$contact->title}}</div>
                                    @endif
                                    @if($contact->data_email)
                                        @foreach($contact->data_email as $k => $property)
                                            <div
                                                class="pad_t24_important color_grey_16 color_grey contact_area__label">{{__('E-mail:')}}</div>
                                            <div class="property">{{$property['jt1']}}</div>
                                        @endforeach
                                    @else
                                        <div
                                            class="pad_t24_important color_grey_16 color_grey contact_area__label">{{__('E-mail:')}}</div>
                                        <div class="property">{{$contact->email}}</div>
                                    @endif

                                    @if($contact->skype)
                                        <div
                                            class="pad_t24_important color_grey_16 color_grey contact_area__label">{{__('Telegram:')}}</div>
                                        <div class="property">{{$contact->skype}}</div>
                                    @endif

                                </div>
                                <div class="contact_area__right">

                                    <div class="contact_area__fsite_social fsite_social">
                                    </div>
                                </div>
                            </div>

                        </div><!--.G_tab{{$k}}-->

                    @endforeach

                </div>

            </div>
        </div>
    </section>


    @php
        foreach ($contacts as $k=>$contact)
        {
            if($session_sity == $contact->title)
                {
                    $point = $contact->yandex_map;
                }
        }
    @endphp
    <div class="JFormFieldMap_wrapper">
        <div id="loader_wrapper" class="loader_wrapper active ">
            <x-forms.loader class="br_12 active"/>
        </div>
        <div id="JFormFieldMap" class="JFormFieldMap" style="width: 100%; height: 550px"></div>
    </div>
    <script>
        var myMap;

        function getYaMap() {
            var myMap = new ymaps.Map("JFormFieldMap", {
                center: [{{(isset($point))?$point:'48.6525, 67.5158'}}],
                zoom: 5,
                controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
            }, {searchControlProvider: 'yandex#search'});


            @foreach($contacts as $k=>$contact)
                myPlacemark{{$k}} = new ymaps.Placemark([{{$contact->yandex_map}}], {balloonContent: '<h5>{{$contact->title}}</h5>@foreach($contact->data_phone as $k => $property)<p class="jt_ph ">{!!  $property['jt1']!!}</p>@endforeach @if($contact->address)<p class="jt_ph jt_ph__address">{!! $contact->address!!}</p>@endif'}, {
                iconLayout: 'default#image',
                iconImageHref: '{{ asset('/storage/contacts/myIcon.svg') }}',
                iconImageSize: [58, 55],
                iconImageOffset: [-28, -48]
            });
            @endforeach



            @foreach($contacts as $k=>$contact)
            $("body").on("click", ".contactTabs__top  .G_tab{{$k}}", function (event) {
                myMap.panTo([{{$contact->yandex_map}}], {
                    //    delay:  9000,
                    duration: 1000,
                    checkZoomRange: true
                });
                $('.contactTabs__tab__js').removeClass('active'); // remove tab
                $(this).addClass('active');// add tab
                $('.contact_area__js').removeClass('active'); // remove result
                $('.' + $(this).data('tab')).addClass('active'); // add result

            });
            @endforeach

            myMap.geoObjects
            @foreach($contacts as $k=>$contact)
                .add(myPlacemark{{$k}})
            @endforeach
            ;
        }


        {{--        {{   // вынес в отдельный файл yandex_map.js
        /*   setTimeout(function () {
                    var elem = document.createElement('script');
                    elem.type = 'text/javascript';
                    elem.src = '//api-maps.yandex.ru/2.1/?apikey=b2e3bd40-cf77-4290-9124-3f999631fbec&package.standard&lang=ru_RU&onload=getYaMap';
                    document.getElementsByTagName('body')[0].appendChild(elem);
                    document.getElementById('loader_wrapper').style.visibility = 'hidden';
                    document.querySelector(".wrapper_loader").style.display = 'none'
                }, 2000);*/
        }}--}}
    </script>

@endsection
