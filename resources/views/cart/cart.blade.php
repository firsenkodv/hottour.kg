@extends('layouts.layout')
<x-seo.meta
    title="{{__('Корзина')}}"
    description="{{__('Корзина')}}"
    keywords="{{__('Корзина')}}"
/>
@section('content')
    <x-yandex-map.yandex-map/>
    @include('html.temp_forms.reserve_hotel')
    <main class="pad_t46 pad_b46" id="MainCart">

        @if(cart())
        <div class="block__800">

            <div class="cabinet_radius12_fff">
                <div class="c__title_subtitle pad_b1">
                    <h3 class="F_h1">{{ __('Корзина туров') }}</h3>
                    <div class="F_h2 pad_t5">
                        <span>{{ __('Отели еще не сохранены, при обновлении страницы они удалятся из корзины') }}</span></div>
                </div>
            </div>
        </div>
        <br>
        <br>

        <div class="s_page  s_page__tours" id="resultHotel">

            @if($tour_data)


                 @include('cart.partial.hotels', ['tour_data' => $tour_data, 'favourites' => 'ok'])

                    <x-forms.form-cart
                        action="{{ route('cart_form_step2') }}"
                        method="POST"
                    >
                        <div class="slotButtons slotButtons__right pad_t15">
                            <div class=" text_input w_30">
                                <input type="hidden" value="" class="tour_data" name="tour_data">
                                <button type="submit" class="button button_normal">
                                    {{__('Сохранить подборку')}}
                                </button>
                            </div>

                        </div>

                    </x-forms.form-cart>

            @endif

        </div>
        @endif
    </main>


@endsection




