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
                            <h3 class="F_h1">{{ __('Редактирование') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Добавление сертификатов и статей для пользователей сайта.')}}</span></div>
                        </div>


                        {{--    {{ /* меню для разделенния доваблений на сайт статей и сертификатов*/ }}--}}
                        @include('include.menu.cabinet_zone_admin_puiblmenu')


                        <div class="c__title_subtitle">
                            <h3 class="F_h1">{{ __('Важное') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Добавить новое сообщение для пользоватей.')}}</span></div>
                        </div>


                        @include('dashboard.forms.add_important')




                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection



