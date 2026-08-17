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
                            <h3 class="F_h1">{{ __('Сертификаты') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Список сертификатов.')}}</span>
                            </div>
                        </div>

                        <div class="page_important page_sertificate">

                            @foreach($items as $item)
                                <div class="imp_box imp_box__sertificate">

                                    @if(role($user->id) == 'admin')
                                        <div class="survey__absolute">
                                            <div class="surveyMenuEdit">
                                                <div class="surveyMenuEdit__ul">
                                                    <div
                                                        class="surveyMenuEdit__li">
                                                        <a href="{{ route('page.certificate') }}">{{ __('Добавление материала') }}</a>
                                                    </div>
                                                    <div
                                                        class="surveyMenuEdit__li">
                                                        <a href="{{ route('pageupdate.certificate', ['id' => $item->id]) }}">{{ __('Редактирование материала') }}</a>
                                                    </div>
                                                    <div class="surveyMenuEdit__liForm">
                                                        <x-delete.delete-certificate
                                                            delete="{{__('Удалить')}}"
                                                            action="{{ route('delete.certificate') }}"
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

                                    <div class="__sertificate">

                                        <div class="__s__flex">
                                            <div class="__s__left">
                                                <img alt="logo" width="160" height="35" src="{{ asset('images/inline/components-logo-logo-footer-1.svg') }}">

                                            </div>
                                            <div class="__s__right">
                                               {{__('действителен до ') . rusdate3($item->date)}}
                                            </div>

                                        </div>
                                        <div class="__s__title">
                                            {{ $item->title }}
                                        </div>
                                        <div class="__s__flex pad_t8">
                                            <div class="__s__left">
                                              <div class="__s_box">
                                                  <span class="__s_label">{{__('Страна вылета')}}</span>
                                                  <span class="__s_string">{{ ($item->country_from)?:'' }}</span>
                                              </div>
                                            </div>
                                            <div class="__s__right">
                                                <div class="__s_box">
                                                    <span class="__s_label">{{__('Страна прилета')}}</span>
                                                    <span class="__s_string">{{ ($item->country_to)?:'' }}</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="__s__flex pad_t8">
                                            <div class="__s__left">
                                              <div class="__s_box">
                                                  <span class="__s_label">{{__('Сумма')}}</span>
                                                  <span class="__s_string">{{ ($item->price)?price($item->price).config('currency.currency.KZT'):'' }}</span>
                                              </div>
                                            </div>
                                            <div class="__s__right">
                                                <div class="__s_box">
                                                    <span class="__s_label"></span>
                                                    <span class="__s_string"></span>
                                                </div>
                                            </div>

                                        </div>



                                    </div>
                                </div>
                            @endforeach


                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection



