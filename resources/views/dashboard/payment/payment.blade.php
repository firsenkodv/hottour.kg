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
                            <h3 class="F_h1">{{ __('Оплата') }}</h3>
                            <div class="F_h2 pad_t5"><span>{{__('Оплатите тур онлайн введите стоимость оплаты из договора.')}}</span></div>
                        </div>

                        <!--bereke-->
                        <div class="form">
                            <x-forms.form

                                action="{{ route('cabinet_custom_amount') }}"
                                method="GET"
                            >

                                <div class="text_input">
                                    <x-forms.text-input_fromLabel
                                        type="number"
                                        id="registerAmount"
                                        name="amount"
                                        placeholder="Сумма в тенге"
                                        value="{{ (old('amount')) }}"
                                        class="input amount"
                                    />
                                    <x-forms.error class="error_amount"/>

                                </div>

                                <div class="text_input">
                                    <x-forms.text-input_fromLabel
                                        id="registerPaymentDesc"
                                        type="text"
                                        name="payment_desc"
                                        placeholder="Введите номер и дату договора"
                                        value="{{ (old('payment_desc')) }}"
                                        class="input payment_desc"
                                        :isError="$errors->has('payment_desc')"
                                    />
                                    <x-forms.error class="error_payment_desc"/>

                                </div>

                                <div class="payment_info"><span><b>Пример:</b> № 02/05 от 07.11.2025г.</span></div>
                                <div class="slotButtons slotButtons__right pad_t15">
                                    <div class=" text_input w_30">
                                        <x-forms.primary-button>
                                            {{ __('Оплатить') }}
                                        </x-forms.primary-button>
                                    </div>
                                </div>

                            </x-forms.form>
                        </div>


                        @include('dashboard.payment.partial._payments')

                    </div>


                </div>
            </div>

        </div>
    </div><!--.cabinet-->

@endsection


