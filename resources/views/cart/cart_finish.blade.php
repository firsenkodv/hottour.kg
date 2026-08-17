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
                        <h3 class="F_h1">{{ __('Подборка туров') }}</h3>
                        <div class="F_h2 pad_t5">
                            <span>{{ __('Туры, которые вы сохранили. Пока туры находятся в списке, ссылка на них работает.') }}</span>
                        </div>
                    </div>

                    <div class="u_orders pad_t30">

                        @foreach($orders as $order)

                            <div class="u_order">

                                <x-forms.form-cart
                                    action="{{route('cart_form_clear')}}"
                                    >
                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                    <input type="submit" class="delete_collection" value="x">

                                </x-forms.form-cart>


                                @if(isset($order->params))
                                    @foreach($order->params as $item)


                                        <div class="u_order__item">
                                            <div class="u_order__img">
                                                @if(isset($item->site_hotel->params[0]))
                                                    <div class="u_order__imgSrc"
                                                         style="background-image: url('{{ asset($item->site_hotel->params[0])  }}')">

                                                    </div>
                                                @else
                                                    <div class="u_order__imgSrc samolet_"></div>
                                                @endif
                                            </div>

                                            <div class="u_order__title">
                                                <span class="u___title">@if(isset($item->site_hotel->title))
                                                        {{ $item->site_hotel->title }}
                                                    @endif</span>
                                                <span class="u___touts">
                                                    {{__('Количество туров')}} : <b>{{ count($item->tours) }}</b>
                                                </span>
                                            </div>

                                        </div><!--.u_order__item-->

                                    @endforeach
                                @endif
                                <div class="u___url">
                                    @if(isset($order->url ))
                                        Ссылка : <i><a
                                                href="{{ env('APP_URL') }}/collection/{{ $order->url }}">{{ env('APP_URL') }}
                                                /collection/{{ $order->url }}</a></i>
                                    @endif
                                </div>
                            </div>

                        @endforeach


                    </div>


                </div>


                {{-- @dump($orders)--}}

            </div>

        @endif
    </main>

@endsection




