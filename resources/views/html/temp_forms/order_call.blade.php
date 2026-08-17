    <div class="F_form  F_form_order_call" style="display: none" id="top_order_call" data-token="{{ csrf_token() }}">
        <x-forms.loader class="br_12"/>
        @include('html.modals.responce.responce')
        <div class="F_form__body new__temp">
            <div class="new__temp_top">
                <div class="F_form__flex">
                    <div class="F_form__left">
                        <div class="F_h1"><span>{{ __('Заказать звонок') }}</span></div>
                        <div class="F_desc F_desc_top">{{ __('менеджер уже Вас набирает)!') }}</div>
                    </div>
                    <div class="F_form__right">
                        <svg class="svg_order_call" width="140" height="93" viewBox="0 0 140 93" fill="none"
                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <rect width="140" height="93" fill="url(#pattern0)"></rect>
                            <defs>
                                <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                    <use xlink:href="#image0_2332_28831"
                                         transform="matrix(0.00175439 0 0 0.00264101 0 -0.0622524)"></use>
                                </pattern>
                                <image id="image0_2332_28831" width="570" height="438"
                                       xlink:href="{{ asset('images/inline/html-temp-forms-order-call-1.png') }}"></image>
                            </defs>
                        </svg>
                    </div>
                </div><!--.F_form__flex-->
            </div><!--.new__temp_top-->


            <div class="new__temp_middle">
<div class="alax_inputs">
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
                    <x-forms.text-input
                        type="hidden"
                        name="crm"
                        value="crm"
                    />
                <x-forms.trick-button class="button_normal order_call_js">
                    {{__('Заказать обратный звонок')}}
                </x-forms.trick-button>
                </div>
</div><!--.alax_inputs-->


            </div><!--.new__temp_middle-->
        </div><!--.F_form__body-->
    </div><!--.F_form-->

