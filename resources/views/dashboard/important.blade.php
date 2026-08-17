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

                            @foreach($items as $item)
                                <div class="imp_box">

                                    @if(role($user->id) == 'admin')
                                    <div class="survey__absolute">
                                        <div class="surveyMenuEdit">
                                            <div class="surveyMenuEdit__ul">
                                                <div
                                                    class="surveyMenuEdit__li">
                                                    <a href="{{ route('page.certificate') }}">{{ __('Добавление материала') }}</a></div>
                                                <div
                                                    class="surveyMenuEdit__li">
                                                    <a href="{{ route('pageupdate.important', ['id' => $item->id]) }}">{{ __('Редактирование материала') }}</a></div>
                                                    <div class="surveyMenuEdit__liForm">
                                                        <x-delete.delete-important
                                                            delete="{{__('Удалить')}}"
                                                            action="{{ route('delete.important') }}"
                                                            id="{{ $item->id }}"
                                                            method="POST"
                                                        />
                                                    </div>

                                            </div>
                                        </div>
                                        <span class="surveyJs"><img src="{{asset('/images/menu-survey.svg')}}"
                                                                    alt="menu"/></span>
                                    </div>
                                    @endif

                                    <div class="imp_title c_title">
                                        <a href="{{ route('important'). '/full/'. $item->id }}">{{ $item->title }}</a>
                                    </div>
                                    @if($item->subtitle)
                                        <div class="imp_subtitle c_subtitle">
                                            {{ $item->subtitle }}
                                        </div>
                                    @endif
                                    @if($item->short_desc)
                                        <div class="imp_subtitle desc">
                                            {!!  $item->short_desc !!}
                                        </div>
                                    @endif
                                </div>
                            @endforeach


                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection


