<div class="dashboardBox dashboardBox__a_user ">

    {{--    {{ /* данные просматриваемого юзера */ }}--}}

    @include('dashboard.users.user_mini_data')

    {{--    {{ /* меню для  просматриваемого юзера */ }}--}}
    @include('include.menu.cabinet_zone_admin_menu')

    <div class="c__title_subtitle">
        <h3 class="F_h1">{{ __('Сертификаты') }}</h3>
        <div class="F_h2 pad_t5"><span>{{__('Список сертификатов.')}}</span>
        </div>
    </div>

    <div class="page_important page_sertificate">
       @if(count($certificates))
        @foreach($certificates as $certificate)
            <div class="imp_box imp_box__sertificate">

                @if(role($user->id) == 'admin')
                    <div class="survey__absolute">
                        <div class="surveyMenuEdit">
                            <div class="surveyMenuEdit__ul">
                                <div
                                    class="surveyMenuEdit__li">
                                    <a href="{{ route('update.certificate.user', ['id' => $item->id]) }}">{{ __('Добавление материала') }}</a>
                                </div>
                                <div
                                    class="surveyMenuEdit__li">
                                    <a href="{{ route('update.certificates.user', ['id' => $item->id, 'certificate_id' => $certificate->id]) }}">{{ __('Редактирование материала') }}</a>
                                </div>
                                <div class="surveyMenuEdit__liForm">
                                    <x-delete.delete-certificate
                                        delete="{{__('Удалить')}}"
                                        action="{{ route('delete.certificate') }}"
                                        id="{{ $certificate->id }}"
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
                            {{__('действителен до ') . rusdate3($certificate->date)}}
                        </div>

                    </div>
                    <div class="__s__title">
                        {{ $certificate->title }}
                    </div>
                    <div class="__s__flex pad_t8">
                        <div class="__s__left">
                            <div class="__s_box">
                                <span class="__s_label">{{__('Страна вылета')}}</span>
                                <span class="__s_string">{{ ($certificate->country_from)?:'' }}</span>
                            </div>
                        </div>
                        <div class="__s__right">
                            <div class="__s_box">
                                <span class="__s_label">{{__('Страна прилета')}}</span>
                                <span class="__s_string">{{ ($certificate->country_to)?:'' }}</span>
                            </div>
                        </div>

                    </div>

                    <div class="__s__flex pad_t8">
                        <div class="__s__left">
                            <div class="__s_box">
                                <span class="__s_label">{{__('Сумма')}}</span>
                                <span class="__s_string">{{ ($certificate->price)?price($certificate->price).config('currency.currency.KZT'):'' }}</span>
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
        @else
            <a href="{{  route('update.certificate.user', ['id' => $item->id]) }}">{{ __('+ Добавить') }}</a>
        @endif

    </div>




</div>


