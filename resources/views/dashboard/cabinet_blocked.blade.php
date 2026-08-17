@extends('layouts.layout_cabinet')
@section('cabinet')

    <div class="cabinet ">
        <div class="block">
            <div class="hbox__top pad_b1">
                <h1>{{__('Личный кабинет')}}</h1>
            </div>
            <div class="cabinet__flex  height_100">
                <div class="cabinet__left">
                    <div class="cl">

                        @include('dashboard.left_bar.left__blocked')

                    </div>
                </div>
                <div class="cabinet__right">
    {{--                @include('include.menu.cabinet_menu')--}}

                    <div class="cabinet_radius12_fff">

                        <div class="c__title_subtitle">
                            <h3 class="F_h1">{{ __('Аккаунт заблокирован') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Обратитесь к  вашему менеджеру или в контакты ресурса.')}}</span>
                            </div>
                        </div>

                        <div class="page_important"></div>

                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection




