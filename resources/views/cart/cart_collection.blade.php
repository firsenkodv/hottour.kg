@extends('layouts.layout')
<x-seo.meta
    title="{{__('Подборка туров')}}"
    description="{{__('Подборка туров')}}"
    keywords="{{__('Подборка туров')}}"
/>
@section('content')
    <x-yandex-map.yandex-map/>
    @include('html.temp_forms.reserve_hotel')
    <main class="pad_t46 pad_b46" id="MainCart">

            <div class="s_page  s_page__tours" id="resultHotel">
                @if($tour_data)
                    @include('cart.partial.hotels', ['tour_data' =>  $tour_data->params, 'favourites' => ''])
                @endif
            </div>
    </main>
@endsection




