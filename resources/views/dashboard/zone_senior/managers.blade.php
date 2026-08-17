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
                            <div class="c__title_subtitle_flex">
                                <div class="c__title_subtitle_left">
                                    <h3 class="F_h1">{{ __('Менеджеры') }}</h3>
                                    <div class="F_h2 pad_t5"><span>{{__('Cписок Ваших закрепленных менеджеров.')}}</span>
                                    </div>
                                </div>
                                <div class="c__title_subtitle_right">
                                    <a href="{{ asset(route('page.senior_addManager')) }}"
                                       class="button button_normal pad_l16 pad_r16">{!!   __('Создать <span class="s_del">менеджера</span>') !!}</a>

                                </div>

                            </div>
                        </div>

                        @include('dashboard.zone_senior.managers.managers')
                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection
