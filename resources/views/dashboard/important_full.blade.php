@extends('layouts.layout_cabinet')
@section('cabinet')

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
                            <h3 class="F_h1">{{ __('Сообщения для пользователей') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Список сообщений от администратора сайта.')}}</span>
                            </div>
                        </div>

                        <div class="page_important">

                                <div class="imp_box">
                                    <div class="imp_title c_title">
                                        {{ $item->title }}
                                    </div>
                                    @if($item->subtitle)
                                        <div class="imp_subtitle c_subtitle">
                                            {{ $item->subtitle }}
                                        </div>
                                    @endif
                                    @if($item->text)
                                        <div class="imp_subtitle desc">
                                            {!!  $item->text !!}
                                        </div>
                                    @endif
                                </div>


                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection



