<div class="index_questions">
    <div class="index_questions__block">
        <div class="h2">{{__('Остались вопросы?')}}</div>
        <p>{{ __('Свяжитесь с нами и мы проконсультируем вас по любому вопросу') }}</p>
    </div>

    <div class="questions__wrapper">
        <div class="index_questions__flex">
            <div class="index_questions__left">
                <div class="l__title">
                    {{ __('Связь с нами в один клик') }}
                </div>
                <div class="l__phone">
                    {!! (isset($setting['phone2']))? $setting['phone2'] : ''!!}
                </div>
                <div class="l__label_addredd">
                    {{ __('Заходите к нам в гости') }}
                </div>
                <div class="l__addredd">
                    {!! (isset($setting['sityAddress']))? $setting['sityAddress'] :'' !!}
                </div>
                <div class="l__label_social">
                    {{__('или напишите нам')}}
                </div>
                <div class="l__social">
                    <div class="s__1">
                        <a target="_blank" href="{!! (isset($setting['whatsapp']))? $setting['whatsapp'] : '' !!}">
                            <img alt="whatsapp" width="20" height="21" loading="lazy"
                                 src="{{ asset('images/inline/include-module-index-questions-1.svg') }}">
                        </a>
                    </div>
                    <div class="s__2">
                        <a target="_blank" href="{!! (isset($setting['telegram']))? $setting['telegram'] : '' !!}">
                            <img alt="telegram" width="19" height="16" loading="lazy"
                                 src="{{ asset('images/inline/include-module-index-questions-2.svg') }}">
                        </a>
                    </div>
                    <div class="s__3">
                        <a target="_blank" href="mailto:{!!  (isset($setting['email']))? $setting['email'] : '' !!}">
                            <img alt="email" width="21" height="18" loading="lazy"
                                 src="{{ asset('images/inline/include-module-index-questions-3.svg') }}">
                        </a>
                    </div>
                </div>


            </div><!--.index_questions__left-->
            <div class="index_questions__right">

                @include('html.temp_forms.order_mini')


            </div>

        </div>


    </div>


</div><!--.index_questions-->
