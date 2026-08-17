<div class="F_form  F_form_pick_tour" style="display: none" id="pick_tour2_responce" data-token="{{ csrf_token() }}" data-country="">
<x-forms.loader class="br_12"/>
    @include('html.modals.responce.responce')

    <div class="F_form__pick flex">
        <div class="F_form__pick_left w_53">

        </div>
        <div class="F_form__pick_right  w_47">
            <div class="F_form__body new__temp">

                <div class="new__temp_top">
                    <div class="F_form__flex">
                        <div class="F_form__left">
                            <div class="F_h1"><span>{{__('Оставить отзыв')}}</span></div>
                            <div class="F_h2"><span>{{__('Ваш отзыв будет проверен и опубликован')}}</span></div>
                        </div>
                    </div><!--.F_form__flex-->
                </div><!--.new__temp_top-->


                <div class="new__temp_middle">
                    <div class="alax_inputs">
                        <div class="text_input">
                            <x-forms.text-input_fromLabel
                                type="text"
                                name="name"
                                placeholder="Имя"
                                value="{{ old('name')?:'' }}"
                                required="true"
                                class="input name"
                            />
                            <x-forms.error class="error_name"/>


                        </div>

                        <div class="text_input">
                            <x-forms.text-input_fromLabel
                                type="text"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email')?:'' }}"
                                required="true"
                                class="input email"
                            />
                            <x-forms.error class="error_email"/>

                        </div>

                        <div class="text_input">

                            <x-forms.text-textarea
                                id="textarea_responce"
                                name="response"
                                placeholder="Ваш отзыв"
                                value="{{ old('response')?:'' }}"
                                required="true"
                                class="input responce"
                            />
                            <x-forms.error class="error_responce"/>

                        </div>
                        <x-forms.text-input
                            type="hidden"
                            name="crm"
                            value="crm"
                        />

                        <div class="text_input r_right">

                            <x-forms.trick-button class="button_normal pick_responce_js">
                                {{__('Отправить отзыв')}}
                            </x-forms.trick-button>
                        </div>
                    </div><!--.alax_inputs-->


                </div><!--.new__temp_middle-->
            </div><!--.F_form__body-->

        </div>

    </div>
</div><!--.F_form-->


