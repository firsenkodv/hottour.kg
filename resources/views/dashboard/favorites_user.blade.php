@extends('layouts.layout_cabinet')
@section('cabinet')

<x-yandex-map.yandex-map/>
@include('html.temp_forms.reserve_hotel')
    <div class="cabinet background_f7f7f7">
        <div class="block">
            <div class="hbox__top pad_b1">
                <h1>{{__('Личный кабинет')}}</h1>
            </div>
            <div class="cabinet__flex  height_100">
                <div class="cabinet__left">
                    <div class="cl">
                        @include('dashboard.left_bar.left')
                    </div>
                </div>
                <div class="cabinet__right">
                    @include('include.menu.cabinet_menu')

                    <div class="cabinet_radius12_fff">

                        <div class="c__title_subtitle">
                            <h3 class="F_h1">{{ __('Избранное') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Список избранных туров.')}}</span>
                            </div>
                        </div>

                        <div class="page_important page_sertificate">

                            <div class="s_page  s_page__tours" id="resultHotel">


                                @if(count($items))

                                    @include('dashboard.favorites.hotels', ['tour_data' => $tour_data, 'items' => $items])

                                @endif

                            </div>

                            {{ $items->withQueryString()->links('pagination::default') }}

                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection



