    <div class="F_form  F_form_order_mini"  data-token="{{ csrf_token() }}">
        <x-forms.loader class="br_12"/>
        @include('html.modals.responce.responce')
        <div class="F_form__body new__temp">
            <div class="new__temp_top">
                <div class="F_form__flex">
                    <div class="F_form__left">
                        <div class="F_h1"><span>{{__('Оставьте ваши данные и мы Вам перезвоним')}}</span></div>
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

                <div class="text_input ">
                    <x-forms.text-input
                        type="hidden"
                        name="crm"
                        value="crm"
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="bet"
                        value=""
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="bank"
                        value=""
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="credit"
                        value=""
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="month"
                        value=""
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="term"
                        value=""
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="monthly_payment"
                        value=""
                    />
                    <x-forms.text-input
                        type="hidden"
                        name="overpayment"
                        value=""
                    />

                    <x-forms.text-input
                        type="hidden"
                        name="total_payout"
                        value=""
                    />
                    <br>
                <x-forms.trick-button class="button_normal calc_js">
                    {{__('Отправить расчет')}}
                </x-forms.trick-button>
                </div>
</div><!--.alax_inputs-->


            </div><!--.new__temp_middle-->
        </div><!--.F_form__body-->
    </div><!--.F_form-->

