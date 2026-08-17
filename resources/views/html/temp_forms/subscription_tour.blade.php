<div class="F_form  F_form_pick_tour" style="display: none" id="subscription_tour" data-token="{{ csrf_token() }}" data-country="" data-subscription="subscription">
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
                            <div class="F_h1"><span>{{__('Подпишись на рассылку')}}</span></div>
                            <div class="F_h2"><span>{{__(' горящих туров и получи скидку до 45%')}}</span></div>
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
                                name="phone"
                                placeholder="Телефон"
                                value="{{ old('phone')?:'' }}"
                                required="true"
                                class="input phone"
                            />
                            <x-forms.error class="error_phone"/>

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

                            <x-forms.select
                                name="sity"
                                value="{{ (old('sity')?:'almaty') }}"
                                text="{{ old('sity')?:__('Алматы') }}"
                                placeholder=""
                            >
                                <ul class="select__list scroll-block" style="display: none;">
                                    <x-forms.selectdata.select_sity/>
                                </ul>
                            </x-forms.select>
                            <x-forms.error class="error_sity"/>
                        </div>
                        <div class="text_input">

                            <x-forms.text-input_fromLabel
                                id="pick_country"
                                type="text"
                                name="country"
                                placeholder="Страна прибывания"
                                value="{{ old('country')?:'' }}"
                                required="true"
                                class="input country"
                            />
                        </div>
                        <x-forms.text-input
                            type="hidden"
                            name="crm"
                            value="crm"
                        />

                        <div class="text_input r_right">

                            <x-forms.trick-button class="button_normal pick_tour_js">
                                {{__('Отправить заявку')}}
                            </x-forms.trick-button>
                        </div>
                    </div><!--.alax_inputs-->


                </div><!--.new__temp_middle-->
            </div><!--.F_form__body-->

        </div>

    </div>
</div><!--.F_form-->



