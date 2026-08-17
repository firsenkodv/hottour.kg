    <div class="F_form  F_form_survey" style="display: none" id="survey" data-token="{{ csrf_token() }}">
        <x-forms.loader class="br_12"/>
        @include('html.modals.responce.responce_survey')
        <div class="F_form__body new__temp">
            <div class="new__temp_top">
                <div class="F_form__flex">
                    <div class="F_form__left">
                        <div class="F_h1"><span>{{__('Спасибо за вашу оценку!')}}</span></div>
                        <div class="F_desc F_desc_top">{{ __('Что Вам не понравилось?') }}</div>

                        <div class="survey__c_responce">
                            @if(config('surveys.survey'))
                                @foreach(config('surveys.survey') as $k => $v)
                                    <div class="survey__checkbox">
                                        <div class="survey__checkbox_checkbox">
                                            <input class="checkbox-flip checkbox_change" name="survey_checkbox" data-checkbox="{{ $k  }}" value="{{ $k  }}" type="checkbox" id="check_{{ $k }}">
                                            <label for="check_{{ $k  }}"><span></span></label>
                                        </div>
                                        <div class="survey__checkbox_text">
                                            <span>{{ $v }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div><!--.F_form__flex-->
            </div><!--.new__temp_top-->

            <div class="text_input ">
                <x-forms.trick-button class="button_normal survey_mini_js">
                    {{__('Отправить')}}
                </x-forms.trick-button>
            </div>


        </div><!--.F_form__body-->
    </div><!--.F_form-->
