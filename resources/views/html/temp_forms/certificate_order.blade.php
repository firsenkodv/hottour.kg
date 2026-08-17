{{-- Заявка на покупку подарочного сертификата (страница /sertifikaty).

     Кому сертификат (физическим/юридическим лицам) и выбранный номинал
     подставляет js при открытии формы — он читает их из активной вкладки
     страницы (см. certificate_order_button_js в ajax.js). --}}

<div class="F_form F_form_order_call F_form_certificate" style="display: none" id="certificate_order" data-token="{{ csrf_token() }}">
    <x-forms.loader class="br_12"/>
    @include('html.modals.responce.responce')

    <div class="F_form__body new__temp">

        <div class="new__temp_top">
            <div class="F_form__flex">
                <div class="F_form__left">
                    <div class="F_h1"><span>{{ __('Приобретение сертификата') }}</span></div>
                    <div class="F_h2"><span>{{ __('Заполните свои данные и наш менеджер свяжется с вами.') }}</span></div>
                </div>
            </div><!--.F_form__flex-->
        </div><!--.new__temp_top-->

        <div class="new__temp_middle">
            <div class="alax_inputs">

                {{-- что именно заказывают: тип сертификата и номинал --}}
                <div class="cert_order__summary">
                    <div class="cert_order__row">
                        <span class="cert_order__label">{{ __('Сертификат') }}</span>
                        <span class="cert_order__value cert_order__audience"></span>
                    </div>
                    <div class="cert_order__row">
                        <span class="cert_order__label">{{ __('Номинал') }}</span>
                        <span class="cert_order__value cert_order__amount"></span>
                    </div>
                </div>

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

                <x-forms.text-input type="hidden" name="audience" value=""/>
                <x-forms.text-input type="hidden" name="amount" value=""/>
                <x-forms.text-input type="hidden" name="crm" value="crm"/>

                <div class="text_input r_right">
                    <x-forms.trick-button class="button_normal certificate_order_js">
                        {{ __('Отправить заявку') }}
                    </x-forms.trick-button>
                </div>

            </div><!--.alax_inputs-->
        </div><!--.new__temp_middle-->

    </div><!--.F_form__body-->
</div><!--.F_form-->
